<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

use App\User;

class InstallController extends Controller {
    
    public function __construct() {
        $this->middleware(function ($request, $next) {
            if(file_exists(storage_path('installed'))) {
                return redirect()->route('home'); 
            }
            return $next($request);
        });
        
    }

    public function install() {
        Artisan::call('key:generate', ["--force"=> true]);
        return view('installer.install');
    }

    public function licenseDetail() {
        return view('installer.license');
    }

    public function licenseDetailSubmit(Request $request) {
        $code = $request->input('code');
        $url = "https://envato.harshitpeer.com/tmail/verify/?code=".$code;
        $result = file_get_contents($url);
        if ($result != $code) {
            $new_array = array(
                "LICENSE_KEY" => $code
            );
            $env_update = $this->changeEnv($new_array);
            return redirect()->route("InstallApp")->with("message", "Your License Code is Valid. Please proceed further with Website Details");
        } else {
            return redirect()->back()->withInput()->withErrors(["Your License Code is Invalid. Please contact envato@harshitpeer.com"]);
        }
    }

    public function appDetail() {
        return view('installer.app');
    }

    public function appDetailSubmit(Request $request) {
        $request->validate([
            'APP_NAME' => 'required',
            'APP_URL' => 'required'
        ],[
            'APP_NAME.required' => 'Website Name is required field',
            'APP_URL.required' => 'Website URL is required field'
        ]);
        $new_array = array();
        foreach($request->all() as $key => $value) {
            $new_array[$key] = $value;
        }
        $env_update = $this->changeEnv($new_array);
        if($env_update){
            return redirect()->route("InstallDatabase");
        } else {
            return redirect()->back()->withInput()->withErrors(["Looks like there is some error. Please try again"]);
        }
    }

    public function databaseDetail() {
        return view('installer.database');
    }

    public function databaseDetailSubmit(Request $request) {
        $request->validate([
            'DB_HOST' => 'required',
            'DB_PORT' => 'required',
            'DB_DATABASE' => 'required',
            'DB_USERNAME' => 'required',
            'DB_PASSWORD' => 'required'
        ]);
        $new_array = array();
        foreach($request->all() as $key => $value) {
            $new_array[$key] = $value;
        }
        $env_update = $this->changeEnv($new_array);
        if($env_update){
            return redirect()->route('InstallDatabaseRun');
        } else {
            return redirect()->back()->withInput()->withErrors(["Looks like there is some error. Please try again"]);
        }
    }

    public function databaseRun() {
        try {
            Artisan::call('migrate', ["--force"=> true]);
            Artisan::call('db:seed', ['--force' => true]);
            return redirect()->route('InstallMail');
        } catch(\Exception $e) {
            return redirect()->route('InstallDatabase')->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function mailDetail() {
        return view('installer.mail');
    }

    public function mailDetailSubmit(Request $request) {
        $request->validate([
            'IMAP_HOST' => 'required',
            'IMAP_PORT' => 'required',
            'IMAP_ENCRYPTION' => 'required',
            'IMAP_VALIDATE_CERT' => 'required',
            'IMAP_USERNAME' => 'required',
            'IMAP_PASSWORD' => 'required',
            'domain' => 'required'
        ]);
        $new_array = array();
        foreach($request->all() as $key => $value) {
            if($key == 'domain') {
                $new_array['TM_DOMAINS'] = implode(",", $value);
            } else {
                $new_array[strtoupper($key)] = $value;
            }
        }
        $env_update = $this->changeEnv($new_array);
        if($env_update){
            return redirect()->route('InstallAdmin');
        } else {
            return redirect()->back()->withInput()->withErrors(["Looks like there is some error. Please try again"]);
        }
    }

    public function adminDetail() {
        return view('installer.admin');
    }

    public function adminDetailSubmit(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        try {
            $new_user = new User;
            $new_user->name = $request->input('name');
            $new_user->email = $request->input('email');
            $new_user->type = 7;
            $new_user->password = Hash::make($request->input('password'));
            $new_user->save();
            return redirect()->route('InstallFinal');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }

    }

    public function final() {
        $new_array = array(
            "APP_ENV" => "production",
            "APP_DEBUG" => "false"
        );
        $env_update = $this->changeEnv($new_array);
        file_put_contents(storage_path('installed'), "TMail successfully installed on ".date("Y/m/d h:i:sa"));
        return view('installer.final');
    }

    protected function changeEnv($data = array()){
        if(count($data) > 0){
            $env = file_get_contents(base_path() . '/.env');
            $env = explode("\n", $env);
            foreach((array)$data as $key => $value) {
                if($key == "_token") {
                    continue;
                }
                $notfound = true;
                foreach($env as $env_key => $env_value) {
                    $entry = explode("=", $env_value, 2);
                    if($entry[0] == $key){
                        $env[$env_key] = $key . "=\"" . $value."\"";
                        $notfound = false;
                    } else {
                        $env[$env_key] = $env_value;
                    }
                }
                if($notfound) {
                    $env[$env_key + 1] = "\n".$key . "=\"" . $value."\"";
                }
            }
            $env = implode("\n", $env);
            file_put_contents(base_path() . '/.env', $env);
            return true;
        } else {
            return false;
        }
    }

}
