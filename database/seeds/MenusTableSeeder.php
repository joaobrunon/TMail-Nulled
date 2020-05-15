<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('menus')->insert([
            'name' => 'Home',
            'link' => env('APP_URL').'/home',
            'status' => true
        ]);
        DB::table('menus')->insert([
            'name' => 'FAQ',
            'link' => env('APP_URL').'/faq',
            'status' => true
        ]);
        DB::table('menus')->insert([
            'name' => 'Purchase',
            'link' => 'https://codecanyon.net/item/tmail-multi-domain-temporary-email-system/20177819',
            'new_tab' => true,
            'status' => true
        ]);
        DB::table('menus')->insert([
            'name' => 'Developer',
            'link' => 'https://harshitpeer.com',
            'new_tab' => true,
            'status' => true
        ]);
    }
}
