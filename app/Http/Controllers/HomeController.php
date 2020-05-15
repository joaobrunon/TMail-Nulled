<?php

namespace App\Http\Controllers;

use App;
use Auth;

use Cookie;
use App\Menu;
use App\Page;
use App\User;
use DateTime;
use App\Option;
use App\Meta;

use DateTimeZone;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Webklex\IMAP\Query\WhereQuery;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function __construct() { }

    public function index() {
        if (!file_exists(storage_path('installed'))) {
            return redirect()->route('Install');
        }
        if(env('TM_HOMEPAGE', 'mailbox') == 'mailbox') {
            return $this->app();
        }
        return $this->page(env('TM_HOMEPAGE', 'mailbox'), false);
    }

    public function app($address = "") {
        if (session('locale')) {
            app()->setLocale(session('locale'));
        } else {
            app()->setLocale(env('DEFAULT_LANGUAGE', 'en'));
        }
        $this->checkCookie();
        if ($address) {
            $checkAddress = $this->checkAddress($address);
            if($checkAddress != $address) {
                return redirect()->route('App', ['m' => $checkAddress]);
            }
            $tm_mails = session('tm_mails');
            if (!$tm_mails) {
                $tm_mails = array();
            }
            if (!in_array($address, $tm_mails)) {
                array_push($tm_mails, $address);
                session(['tm_mails' => $tm_mails]);
            }
            session(['tm_current_mail' => $address]);
            $domains = explode(',', env('TM_DOMAINS'));
            if (empty($domains)) {
                return redirect()->route('login');
            }
            return view('app')->with('domains', $domains);
        } else {
            if (session('tm_current_mail')) {
                return redirect()->route('App', ['m' => session('tm_current_mail')]);
            }
            $this->updateStats('emails_created');
            $email_address = $this->generateRandomWord() . "@" . $this->generateRandomDomain();
            file_put_contents(storage_path('tmail_logs'), request()->ip() . " " . date("Y/m/d h:i:sa") . " " . $email_address . PHP_EOL, FILE_APPEND);
            return redirect()->route('App', ['m' => $email_address]);
        }
    }

    public function page($slug = null, $flag = true) {
        if (session('locale')) {
            app()->setLocale(session('locale'));
        } else {
            app()->setLocale(env('DEFAULT_LANGUAGE', 'en'));
        }
        $this->checkCookie();
        $slug = str_replace(app()->getLocale() . '/', '', $slug);
        if($flag && $slug == env('TM_HOMEPAGE', 'mailbox')) {
            return redirect()->route('home');
        }
        $page = Page::where('slug', $slug)->first();
        $domains = explode(',', env('TM_DOMAINS'));
        if (empty($domains)) {
            return redirect()->route('login');
        }
        if (!$page) {
            $page = new \stdClass;
            $page->title = '404 Not Found';
            $page->custom_header = '';
            $page->content = '<a href="/"><button class="go_to-home blue-purple-bg" type="button">Go to Home</button></a>';
        }
        return view('page')
            ->with('page_title', $page->title)
            ->with('page_content', $page->content)
            ->with('page_custom_header', $page->custom_header)
            ->with('domains', $domains);
    }

    public function createMailID(Request $request) {
        $email = $domain = null;
        $domainList = explode(',', env('TM_DOMAINS'));
        if ($request->has('email')) {
            $email = $request->input('email');
            if (in_array(strtolower($email), explode(',', env('FORBIDDEN_IDS')))) {
                $email = $this->generateRandomWord();
            }
        }
        if ($request->has('domain')) {
            $domain = $request->input('domain');
            if (!in_array($domain, $domainList)) {
                $domain = null;
            }
        }
        $email = preg_replace('/[^A-Za-z0-9_.+-]/', "", $email);
        $api = false;
        if (\Request::is('api/*')) {
            if ($request->has('key')) {
                if (in_array($request->input('key'), explode(',', env('API_KEY')))) {
                    $api = true;
                } else {
                    return response()->make('Unauthorized Access. Please enter correct API Key', 401);
                }
            } else {
                return response()->make('Unauthorized Access. Please enter correct API Key', 401);
            }
        }
        if ($email && $domain) {
            return $this->generateAddress($email, $domain, $api);
        } else if ($email) {
            return $this->generateAddress($email, $this->generateRandomDomain(), $api);
        } else if ($domain) {
            return $this->generateAddress($this->generateRandomWord(), $domain, $api);
        } else {
            return $this->generateAddress($this->generateRandomWord(), $this->generateRandomDomain(), $api);
        }
    }

    public function deleteMailID($id = null) {
        $tm_current_mail = session('tm_current_mail');
        if($id) {
            $tm_current_mail = $id;
        }
        $tm_mails = session('tm_mails');
        if (($key = array_search($tm_current_mail, $tm_mails)) !== false) {
            unset($tm_mails[$key]);
        }
        $tm_mails = array_values($tm_mails);
        session(['tm_mails' => $tm_mails]);
        Cookie::forever('tm_mails', json_encode($tm_mails));
        if (empty($tm_mails)) {
            session()->forget('tm_current_mail');
            return response("")->withCookie(cookie()->forever('tm_mails', json_encode($tm_mails)));
        } else {
            session(['tm_current_mail' => $tm_mails[0]]);
            return response($tm_mails[0])->withCookie(cookie()->forever('tm_mails', json_encode($tm_mails)));
        }
    }

    public function getDomains(Request $request) {
        if (\Request::is('api/*')) {
            if ($request->has('key')) {
                if (!in_array($request->input('key'), explode(',', env('API_KEY')))) {
                    return response()->make('Unauthorized Access. Please enter correct API Key', 401);
                }
            } else {
                return response()->make('Unauthorized Access. Please enter correct API Key', 401);
            }
        }
        return explode(',', env('TM_DOMAINS'));
    }

    public function fetchMails(Request $request) {
        if (\Request::is('api/*')) {
            if ($request->has('key')) {
                if (!in_array($request->input('key'), explode(',', env('API_KEY')))) {
                    return response()->make('Unauthorized Access. Please enter correct API Key', 401);
                }
            } else {
                return response()->make('Unauthorized Access. Please enter correct API Key', 401);
            }
        }
        $tm_current_mail = session('tm_current_mail');
        if (\Request::is('api/*') && $request->has('email')) {
            $tm_current_mail = $request->input('email');
        }
        if (!$tm_current_mail) {
            return redirect()->route('home');
        }
        $cc_messages = [];
        $client = Client::account('default');
        $client->connect();
        $inbox = $client->getFolder('INBOX');
        if (\Request::is('api/*') && $request->has('all')) {
            $messages = $inbox->query()->to($tm_current_mail)->get();
            if(env('CC_CHECK')) {
                $cc_messages = $inbox->query()->cc($tm_current_mail)->get();
            }
        } else if ($request->has('new') || \Request::is('api/*')) {
            $messages = $inbox->query()->to($tm_current_mail)->unseen()->get();
            if(env('CC_CHECK')) {
                $cc_messages = $inbox->query()->cc($tm_current_mail)->unseen()->get();
            }
        } else {
            $messages = $inbox->query()->to($tm_current_mail)->seen()->get();
            if(env('CC_CHECK')) {
                $cc_messages = $inbox->query()->cc($tm_current_mail)->seen()->get();
            }
        }
        $return = array();
        $length = 0;
        foreach ($messages as $message) {
            $mail = array();
            $date = new DateTime();
            $sender = $message->getFrom();
            $date->setTimezone(new DateTimeZone('UTC'));
            $date->setTimestamp($message->getHeaderInfo()->udate);
            $interval = date_diff(date_create(null, new DateTimeZone('UTC')), date_create($date->format('Y-m-d')));
            $date->setTimezone(new DateTimeZone(env('APP_TIMEZONE', 'Asia/Kolkata')));
            if ($interval->format('%a') == 0) {
                $mail["short_time"] = $date->format('H:i A');
            } else {
                $mail["short_time"] = $date->format('M d');
            }
            $uid = $message->getUid();
            $mail["sender_name"] = $sender[0]->personal;
            $mail["sender_email"] = $sender[0]->mail;
            $mail["time"] = $date->format('d M Y h:i A');
            $mail["subject"] = mb_convert_encoding($message->getSubject(), 'UTF-8', 'UTF-8');
            $mail["text"] = $message->getTextBody();
            if (!$mail["text"]) {
                $mail["text"] = "";
            }
            $mail["text"] = str_replace(array("\r\n","\n"), '<br/>', $mail["text"]);
            $mail["html"] = $message->getHTMLBody(true);
            if (!$mail["html"]) {
                $mail["html"] = $mail["text"];
            }
            $mail["attachments"] = array();
            if ($message->hasAttachments()) {
                $attachments = $message->getAttachments();
                foreach ($attachments as $attachment) {
                    $path = public_path() . "/attachments/" . $uid;
                    if (!is_dir($path)) {
                        mkdir($path);
                    }
                    $attachment->save($path);
                    $item = array();
                    $item["name"] = $attachment->getName();
                    $item["path"] = url('/') . "/attachments/" . $uid . "/" . $item["name"];
                    array_push($mail["attachments"], $item);
                }
            }
            //Saving
            $return[$uid] = $mail;
            $length++;
        }
        if(env('CC_CHECK')) {
            foreach ($cc_messages as $cc_message) {
                $mail = array();
                $date = new DateTime();
                $sender = $cc_message->getFrom();
                $date->setTimezone(new DateTimeZone('UTC'));
                $date->setTimestamp($cc_message->getHeaderInfo()->udate);
                $interval = date_diff(date_create(null, new DateTimeZone('UTC')), date_create($date->format('Y-m-d')));
                $date->setTimezone(new DateTimeZone(env('APP_TIMEZONE', 'Asia/Kolkata')));
                if ($interval->format('%a') == 0) {
                    $mail["short_time"] = $date->format('H:i A');
                } else {
                    $mail["short_time"] = $date->format('M d');
                }
                $uid = $cc_message->getUid();
                $mail["sender_name"] = $sender[0]->personal;
                $mail["sender_email"] = $sender[0]->mail;
                $mail["time"] = $date->format('d M Y h:i A');
                $mail["subject"] = mb_convert_encoding($cc_message->getSubject(), 'UTF-8', 'UTF-8');
                $mail["text"] = $cc_message->getTextBody();
                if (!$mail["text"]) {
                    $mail["text"] = "";
                }
                $mail["text"] = str_replace(array("\r\n","\n"), '<br/>', $mail["text"]);
                $mail["html"] = $cc_message->getHTMLBody(true);
                if (!$mail["html"]) {
                    $mail["html"] = $mail["text"];
                }
                $mail["attachments"] = array();
                if ($cc_message->hasAttachments()) {
                    $attachments = $cc_message->getAttachments();
                    foreach ($attachments as $attachment) {
                        $path = public_path() . "/attachments/" . $uid;
                        if (!is_dir($path)) {
                            mkdir($path);
                        }
                        $attachment->save($path);
                        $item = array();
                        $item["name"] = $attachment->getName();
                        $item["path"] = url('/') . "/attachments/" . $uid . "/" . $item["name"];
                        array_push($mail["attachments"], $item);
                    }
                }
                //Saving
                $return[$uid] = $mail;
                $length++;
            }
        }
        if(count($messages) || count($cc_messages)) {
            krsort($return);
        }
        $return["length"] = $length;
        if ($request->has('new') && $return["length"] > 0) {
            $this->updateStats('emails_received');
        } else {
            $this->deleteOldMails();
        }
        return $return;
    }

    public function deleteMail(Request $request) {
        if ($request->has('uid')) {
            $uid = intval($request->input('uid'));
            $client = Client::account('default');
            $client->connect();
            $inbox = $client->getFolder('INBOX');
            $message = $inbox->getMessage($uid);
            if ($message) {
                $message->delete();
                $path = public_path() . "/attachments/" . $uid;
                $this->rrmdir($path);
                return $uid;
            }
        }
    }

    protected function generateAddress($email = null, $domain = null, $api = false) {
        if ($email && $domain) {
            $tm_mails = session('tm_mails');
            if (!$tm_mails) {
                $tm_mails = array();
            }
            if (!in_array($email . "@" . $domain, $tm_mails)) {
                array_push($tm_mails, $email . "@" . $domain);
            }
            session(['tm_mails' => $tm_mails]);
            $this->updateStats('emails_created');
            file_put_contents(storage_path('tmail_logs'), request()->ip() . " " . date("Y/m/d h:i:sa") . " " . $email . "@" . $domain . PHP_EOL, FILE_APPEND);
            if ($api) {
                session(['tm_current_mail' => $email . "@" . $domain]);
                return $email . "@" . $domain;
            }
            return redirect()->route('App', ['m' => $email . "@" . $domain])->withCookie(cookie()->forever('tm_mails', json_encode($tm_mails)));
        } else {
            return redirect()->route('home');
        }
    }

    protected function checkAddress($address = null) {
        if ($address) {
            $emaildomain = explode("@", $address);
            $domainList = explode(',', env('TM_DOMAINS'));
            $emaildomain[0] = preg_replace('/[^A-Za-z0-9_.+-]/', "", $emaildomain[0]);
            if (!in_array($emaildomain[1], $domainList)) {
                $this->deleteMailID($address);
                $emaildomain[1] = $this->generateRandomDomain();
            }
            if (!in_array($emaildomain[0], explode(',', env('FORBIDDEN_IDS')))) {
                return $emaildomain[0] . "@" . $emaildomain[1];
            } else {
                return $this->generateRandomWord() . "@" . $emaildomain[1];
            }
        } else {
            return $this->generateRandomWord() . "@" . $this->generateRandomDomain();
        }
    }

    protected function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object))
                        rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            rmdir($dir);
        }
    }

    protected function generateRandomWord() {
        $c  = 'bcdfghjklmnprstvwz'; //consonants except hard to speak ones
        $v  = 'aeiou';              //vowels
        $a  = $c . $v;                //both
        $random = '';
        for ($j = 0; $j < 2; $j++) {
            $random .= $c[rand(0, strlen($c) - 1)];
            $random .= $v[rand(0, strlen($v) - 1)];
            $random .= $a[rand(0, strlen($a) - 1)];
        }
        return $random;
    }

    protected function generateRandomDomain() {
        $domainList = explode(',', env('TM_DOMAINS'));
        $count = count($domainList);
        $selectedDomain = rand(1, $count) - 1;
        return $domainList[$selectedDomain];
    }

    protected function checkCookie() {
        if (!session('tm_current_mail')) {
            $tm_mails = json_decode(Cookie::get('tm_mails'));
            session(['tm_mails' => $tm_mails]);
            if (isset($tm_mails[0])) {
                session(['tm_current_mail' => $tm_mails[0]]);
            }
        }
    }

    protected function changeEnv($data = array()) {
        if (count($data) > 0) {
            $env = file_get_contents(base_path() . '/.env');
            $env = explode("\n", $env);
            foreach ((array) $data as $key => $value) {
                if ($key == "_token") {
                    continue;
                }
                $notfound = true;
                foreach ($env as $env_key => $env_value) {
                    $entry = explode("=", $env_value, 2);
                    if ($entry[0] == $key) {
                        $env[$env_key] = $key . "=\"" . $value . "\"";
                        $notfound = false;
                    } else {
                        $env[$env_key] = $env_value;
                    }
                }
                if ($notfound) {
                    $env[$env_key + 1] = "\n" . $key . "=\"" . $value . "\"";
                }
            }
            $env = implode("\n", $env);
            file_put_contents(base_path() . '/.env', $env);
            return true;
        } else {
            return false;
        }
    }

    protected function deleteOldMails() {
        if (env('DELETE_AFTER_VALUE', 0) || env('DELETE_AFTER_DAYS', 0)) {
            $client = Client::account('default');
            $client->connect();
            $inbox = $client->getFolder('INBOX');
            $messages = [];
            if(env('DELETE_AFTER_KEY', 'd') == "d") {
                $messages = $inbox->query()->before(now()->subDays(env('DELETE_AFTER_VALUE')))->limit(5, 1)->get();
            } else if(env('DELETE_AFTER_KEY', 'd') == "m") {
                $messages = $inbox->query()->before(now()->subMonths(env('DELETE_AFTER_VALUE')))->limit(5, 1)->get();
            } 
            foreach ($messages as $message) {
                $uid = $message->getUid();
                $this->rrmdir(public_path() . "/attachments/" . $uid);
                $message->delete();
            }
        }
    }

    public function customCss() {
        $primary = env('TM_COLOR_PRIMARY', '#673AE2');
        $secondary = env('TM_COLOR_SECONDARY', '#8fcb21');
        $tertiary = env('TM_COLOR_TERTIARY', '#de881e');
        $return = "
        header .tm-menu nav ul li a:hover {
            color: " . $primary . ";
        }
        main .tm-message .mail-delete i {
            color: " . $primary . ";
        }
        main .tm-message .subject {
            color: " . $primary . ";
        }
        .primary-color {
            color: " . $primary . ";
        }
        main .tm-message .attachments a {
            border: 1px solid " . $primary . ";
        }
        header .tm-menu nav.main ul li a:hover {
            border-bottom: 2px solid " . $primary . " !important;
        }
        main .tm-message .attachments a:hover {
            background: " . $primary . ";
        }
        main .tm-sidebar .tm-create input[action=Create][type=submit] {
            background: " . $secondary . ";
        }
        main .tm-sidebar .tm-create input[action=Random][type=submit] {
            background: " . $tertiary . ";
        }
        .primary-background {
            background: " . $primary . ";
        }
        header .tm-mobile-menu {
            background: " . $primary . ";
        }
        main .tm-sidebar {
            background: " . $primary . ";
        }
        header .tm-logo {
            background: " . $primary . ";
        }
        main .tm-message .close-mail-content {
            background: " . $primary . ";
        }
        ";
        return response($return, 200)->header('Content-Type', 'text/css');
    }

    public function changeLocale(Request $request) {
        if ($request->has('locale')) {
            $locale = $request->input('locale');
            if (in_array($locale, config('app.locales'))) {
                session(['locale' => $locale]);
                app()->setLocale($locale);
                return "done";
            }
        }
    }

    public function passwordReset(Request $request) {
        try {
            $email = $request->input('email');
            if($request->input('license_key') === env('LICENSE_KEY')) {
                $user = User::where('email', $email)->first();
                if($user) {
                    $user->password = Hash::make($request->input('password'));
                    $user->save();
                    return redirect()->route('login')->with('status', 'Password Reset Successfully');
                } else {
                    throw new \Exception('Invalid Details');
                }
            } else {
                throw new \Exception('Invalid Details');
            }
        } catch (\Exception $e) {
            return back()
                ->withInput($request->input())
                ->withErrors($e->getMessage());
        }
    }

    public function showAds($id) {
        $ad = Option::where('key', 'AD_SPACE_'.$id)->first();
        if($ad) {
            return $ad->value;
        }
        return '';
    }

    protected function updateStats($key) {
        $meta = Meta::where('key', $key)->first();
        if($meta) {
            $meta->value = intval($meta->value) + 1;
            $meta->update();
        } else {
            $newMeta = new Meta();
            $newMeta->key = $key;
            if($key == "emails_created") {
                $newMeta->value = intval(env('STATS_EMAIL')) + 1;
            } else if ($key == "emails_received") {
                $newMeta->value = intval(env('STATS_RECEIVED')) + 1;
            } else {
                return "";
            }
            $newMeta->save();
        }
    }
}
