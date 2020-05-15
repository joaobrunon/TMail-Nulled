<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CronController extends Controller {

    public function deleteEmails(Request $request) {

        if($request->has('key') && $request->key == env('CRON_PASSWORD')) {
            $hostname = '{'.env('IMAP_HOST').':'.env('IMAP_PORT').'/imap/ssl/novalidate-cert}INBOX';
            $username = env('IMAP_USERNAME'); 
            $password = env('IMAP_PASSWORD');
            $inbox = imap_open($hostname, $username, $password) or die('Cannot download information: ' . imap_last_error());
            $emails = imap_search($inbox,'ALL');
            $result = "no mails to delete";
            if($emails) {
                foreach($emails as $email_number) {
                    imap_delete($inbox,$email_number);
                    $result = "success";
                }
            } 
            imap_expunge($inbox);
            imap_close($inbox,CL_EXPUNGE);
            return $result;
        } else {
            return 401;
        }

    }

}
