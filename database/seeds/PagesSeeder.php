<?php

use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            'slug' => 'home',
            'title' => 'Welcome to TMail',
            'content' => '<p>TMail is a service that allows to receive email at a temporary address that self-destructed after a certain time elapses. It is also known by names like : tempmail, 10minutemail, throwaway email, fake-mail or trash-mail. Many forums, Wi-Fi owners, websites and blogs ask visitors to register before they can view content, post comments or download something. TMail is most advanced throwaway email service that helps you avoid spam and stay safe.</p><p><br></p><h3><br></h3><h3><strong><span class="ql-cursor">﻿</span>Why do I need TMail?</strong></h3><p><br></p><p>When we discover that an anonymous email exists, we do not fully understand how usefulness it can be. And the most important question is, “Why do we need a temporary email, if we already have regular email service providers (gmail.com, yahoo.com, …)?” If both the regular emails and anonymous emails are completely free, then, “What’s the difference?” you might ask. When you register to get a regular email, you will need to provide personal information. However, using a temporary email you don\'t need to do it. A regular email address will never delete your emails, while all the letters will be automatically deleted after an hour when you are using a temporary email. A regular email can\'t be completely removed. On the other hand, disposable email gives you this option without any problems.</p><p><br></p><p><br></p><p><br></p>',
            'created_at' => '2019-01-01 00:00:00', 
            'updated_at' => '2019-01-01 00:00:00'
        ]);
        DB::table('pages')->insert([
            'slug' => 'faq',
            'title' => 'Frequently Asked Questions',
            'content' => '<p><strong>1. How much I have to pay for this services?</strong></p><p>A. Its absolutely FREE! </p><p><br></p><p><strong>2. How long is my email ID active?</strong></p><p>A. Email ID is active for you forever. Your emails are deleted every 2 days.</p><p><br></p><p><strong>3. </strong><strong style="color: rgb(33, 37, 41);">I\'ve waited more than 15 min but no message arrived!</strong></p><p>A. Sometimes, there can be some delay due because our servers get swamped with tons of users daily. Just try again after sometime. Also, sometimes some of our domains gets blacklisted because of excessive use, so try creating emails from different domain.</p><p><br></p><p><strong>4.  How many email IDs I can create?</strong></p><p>A. There is no limit of number of email Ids you can create. </p><p><br></p><p><strong>5. </strong><strong style="color: rgb(33, 37, 41);">Is it necessary to download a mobile app or a software to use your service?</strong></p><p><span style="color: rgb(33, 37, 41);">A. No you do not need any software or app. This is a web-based service that is accessible from everywhere.</span></p>',
            'created_at' => '2019-01-01 00:00:00', 
            'updated_at' => '2019-01-01 00:00:00'
        ]);
    }
}
