<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Meta;

use App\Page;
use App\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
        if(Schema::hasTable('metas')) {
            $metas = Meta::all();
            if(count($metas) < 2) {
                View::share('meta_emails_received', env('STATS_RECEIVED', 0));
                View::share('meta_emails_created', env('STATS_EMAIL', 0));
            }
            foreach($metas as $meta) {
                View::share('meta_'.$meta->key, $meta->value);
            }
        } else {
            View::share('meta_emails_received', env('STATS_RECEIVED', 0));
            View::share('meta_emails_created', env('STATS_EMAIL', 0));
        }
    }

    public function configuration() {
        if(!env('UPDATE_AVAILABLE')) {
            $this->checkUpdate();
        }
        $env = array();
        $env["APP_NAME"] = env('APP_NAME');
        $env["APP_FORCE_HTTPS"] = env('APP_FORCE_HTTPS');
        $env["APP_URL"] = env('APP_URL');
        $env["API_KEY"] = env('API_KEY');
        $env["APP_TIMEZONE"] = env('APP_TIMEZONE');
        //IMAP Configuration
        $env["IMAP_HOST"] = env('IMAP_HOST');
        $env["IMAP_PORT"] = env('IMAP_PORT');
        $env["IMAP_ENCRYPTION"] = env('IMAP_ENCRYPTION');
        $env["IMAP_VALIDATE_CERT"] = env('IMAP_VALIDATE_CERT');
        $env["IMAP_USERNAME"] = env('IMAP_USERNAME');
        $env["IMAP_PASSWORD"] = env('IMAP_PASSWORD');
        $env["IMAP_DEFAULT_ACCOUNT"] = env('IMAP_DEFAULT_ACCOUNT');
        $env["IMAP_PROTOCOL"] = env('IMAP_PROTOCOL');
        //TMail Options
        $env["TM_DOMAINS"] = env('TM_DOMAINS');
        $env["TM_HOMEPAGE"] = env('TM_HOMEPAGE');
        $env["FORBIDDEN_IDS"] = env('FORBIDDEN_IDS');
        $env["DEFAULT_LANGUAGE"] = env('DEFAULT_LANGUAGE');
        $env["DELETE_AFTER_KEY"] = env('DELETE_AFTER_KEY', 'd');
        $env["DELETE_AFTER_VALUE"] = env('DELETE_AFTER_VALUE', 1);
        $env["TM_FETCH_SECONDS"] = env('TM_FETCH_SECONDS');
        $env["TM_COLOR_PRIMARY"] = env('TM_COLOR_PRIMARY');
        $env["TM_COLOR_SECONDARY"] = env('TM_COLOR_SECONDARY');
        $env["TM_COLOR_TERTIARY"] = env('TM_COLOR_TERTIARY');
        //DB Connection
        $env["DB_HOST"] = env('DB_HOST');
        $env["DB_PORT"] = env('DB_PORT');
        $env["DB_DATABASE"] = env('DB_DATABASE');
        $env["DB_USERNAME"] = env('DB_USERNAME');
        $env["DB_PASSWORD"] = env('DB_PASSWORD');
        //Social Networks
        $env["FACEBOOK_URL"] = env('FACEBOOK_URL');
        $env["TWITTER_URL"] = env('TWITTER_URL');
        $env["YOUTUBE_URL"] = env('YOUTUBE_URL');
        //Other Options
        $env["CC_CHECK"] = env('CC_CHECK', false);
        $env["CRON_PASSWORD"] = env('CRON_PASSWORD', '');
        //Ad Spaces & Custom JS, CSS & Header
        $options = Option::get();
        foreach($options as $option) {
            $env[$option->key] = $option->value;
        }
        if(!isset($env['AD_SPACE_4'])) {
            $env['AD_SPACE_4'] = "";
        }
        $pages = Page::select('slug', 'title')->get();
        return view('admin.configuration')
            ->with('page_title', "Configuration")
            ->with('pages', $pages)
            ->with('env', $env);
    }

    public function configurationSubmit(Request $request) {
        $request->validate([
            'APP_NAME' => 'required',
            'APP_FORCE_HTTPS' => 'required',
            'APP_URL' => 'required',
            'IMAP_HOST' => 'required',
            'IMAP_PORT' => 'required',
            'IMAP_ENCRYPTION' => 'required',
            'IMAP_VALIDATE_CERT' => 'required',
            'IMAP_USERNAME' => 'required',
            'IMAP_PASSWORD' => 'required',
            'TM_FETCH_SECONDS' => 'required',
            'TM_COLOR_PRIMARY' => 'required',
            'TM_COLOR_SECONDARY' => 'required',
            'TM_COLOR_TERTIARY' => 'required',
            'DB_HOST' => 'required',
            'DB_PORT' => 'required',
            'DB_DATABASE' => 'required',
            'DB_USERNAME' => 'required',
            'logo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $new_array = array();
        foreach($request->all() as $key => $value) {
            if((\strpos($key, 'AD_SPACE') !== false) || \strpos($key, 'CUSTOM') !== false) {
                $option = Option::where('key', $key)->first();
                if($option) {
                    if($value) {
                        $option->value = $value;
                    } else {
                        $option->value = " ";
                    }
                    $option->save();
                } else {
                    $option = new Option;
                    $option->key = $key;
                    if(!$value) {
                        $value = " ";
                    }
                    $option->value = $value;
                    $option->save();
                }
            } else if($key == 'domain') {
                $new_array['TM_DOMAINS'] = implode(",", array_filter($value));
            } else if($key == 'api') {
                $new_array['API_KEY'] = implode(",", array_filter($value));
            } else if($key == 'forbidden') {
                $new_array['FORBIDDEN_IDS'] = implode(",", array_filter($value));
            } else {
                $new_array[$key] = addslashes(preg_replace( "/\r|\n/", "", $value));
            }
        }
        $file = $request->file('logo');
        if($file)
        $file->move(public_path().'/images/', "custom-logo.png");
        $env_update = $this->changeEnv($new_array);
        if($env_update){
            return redirect()->route('AdminConfiguration')->with('success', "Configuration changed Successfully");
        } else {
            return redirect()->route('AdminConfiguration')->with('error', "Looks like there is some error. Please try again");
        }
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

    public function pages() {
        $pages = Page::get();
        return view('admin.pages')->with('pages', $pages);
    }

    public function pageAdd(Request $request) {
        $page = new Page;
        $page->title = $request->title;
        $page->content = $request->content;
        $page->custom_header = $request->custom_header;
        $page->slug = $request->slug;
        $page->save();
        $menu = new Menu;
        $menu->name = $request->title;
        $menu->link = env('APP_URL')."/".$request->slug;
        $menu->new_tab = false;
        $menu->save();
        return \Redirect::back()->with('success', 'Page added successfully');
    }

    public function pageDelete(Request $request) {
        if ($request->has('id')) {
            $id = $request->input('id');
            $page = Page::where('id', $id)->first();
            $page->delete();
            return redirect()->route('AdminPages');
        } else {
            return redirect()->route('Admin');
        }
    }

    public function pageEdit(Request $request) {
        if ($request->has('id')) {
            $id = $request->input('id');
            $page = Page::where('id', $id)->first();
            return view('admin.page')->with('page', $page);
        } else {
            return redirect()->route('Admin');
        }
    }

    public function pageEditSubmit(Request $request) {
        if ($request->has('id')) {
            $id = $request->input('id');
            $page = Page::where('id', $id)->first();
            $page->title = $request->title;
            $page->content = $request->content;
            $page->custom_header = $request->custom_header;
            $page->slug = $request->slug;
            $page->save();
            return \Redirect::back()->with('success', 'Page edited successfully');
        } else {
            return redirect()->route('Admin');
        }
    }

    public function menu() {
        $menu = Menu::where('menu_no', 1)->get();
        return view('admin.menu')
            ->with('menu', $menu)
            ->with('id', 0)
            ->with('menu_links', array());
    }

    public function menuSubmit(Request $request) {
        Menu::query()->truncate();
        $menu = json_decode($request->input('menu'));
        foreach($menu as $item) {
            $new = new Menu;
            $new->name = $item->name;
            $new->link = $item->link;
            if(isset($item->type) && $item->type == 3)
            $new->new_tab = true;
            else
            $new->new_tab = false;
            $new->status = $item->status;
            $new->save();
        }
        return "done";
    }

    public function checkUpdate() {
        $url = "https://envato.harshitpeer.com/tmail/update/check/?code=".env('LICENSE_KEY');
        $result = file_get_contents($url);
        if(trim($result) == env('APP_VERSION')) {
            return false;
        } else {
            if(trim($result) == "INVALID") {
                return false;
            }
            if(!env('UPDATE_AVAILABLE')) {
                $update_env = array();
                $update_env["UPDATE_AVAILABLE"] = "true";
                $this->changeEnv($update_env);
            }
            return true;
        }
    }

    public function update() {
        return view('admin.update')->with('update', $this->checkUpdate());
    }

    public function manualUpdate(Request $request) {
        $file = $request->file('update');
        if($file) {
            $file->move(public_path(), "files.zip");
            \Zipper::make('files.zip')->extractTo(base_path());
            \Zipper::close();
            unlink("files.zip");
            return view('admin.update')
                ->with('update', $this->checkUpdate())
                ->with('manual', true);
        }
        return view('admin.update')->with('update', $this->checkUpdate());
    }

    public function applyUpdate(Request $request) {
        $step = intval($request->input('step'));
        if($step == 1) {
            try {
                $url = "https://envato.harshitpeer.com/tmail/update/get/?code=".env('LICENSE_KEY');
                file_put_contents("files.zip", fopen($url, 'r'));
                $zip = new \ZipArchive;
                if ($zip->open('files.zip') === TRUE) {
                    $zip->extractTo(base_path());
                    $zip->close();
                }
                unlink("files.zip");
                return "SUCCESS";
            } catch(\Exception $e) { 
                return "FAILED - ".$e->getMessage();
            }
        } else if ($step == 2) {
            try {
                Artisan::call('migrate', ["--force"=> true]);
                if(file_exists(base_path() . '/seeds.txt')) {
                    $seeds = file_get_contents(base_path() . '/seeds.txt');
                    $seeds = explode("\n", $seeds);
                    foreach($seeds as $seed) {
                        Artisan::call('db:seed', ['--class' => $seed, '--force' => true]);
                    }
                    unlink(base_path() . '/seeds.txt');
                }
                return "SUCCESS";
            } catch(\Exception $e) { 
                Artisan::call('migrate:rollback', ["--step"=> 1]);
                return "FAILED - ".$e->getMessage();
            }
        } else if ($step == 3) {
            try {
                if(file_exists(base_path() . '/vendor_new')) {
                    File::deleteDirectory(base_path('vendor'));
                    rename(base_path('vendor_new'), base_path('vendor'));
                }
                $new_version = trim(file_get_contents("https://envato.harshitpeer.com/tmail/update/check/?code=".env('LICENSE_KEY')));
                $new_array = array(
                    "APP_VERSION" => $new_version,
                    "UPDATE_AVAILABLE" => "false"
                );
                $this->changeEnv($new_array);
                return "SUCCESS";
            } catch (\Exception $e) {
                return "FAILED - ".$e->getMessage();
            }
        }
    }

}
