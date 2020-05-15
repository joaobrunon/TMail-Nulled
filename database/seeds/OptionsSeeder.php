<?php

use Illuminate\Database\Seeder;

class OptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert([
            'key' => 'AD_SPACE_1',
            'value' => '',
            'created_at' => '2019-01-01 00:00:00', 
            'updated_at' => '2019-01-01 00:00:00'
        ]);
        DB::table('options')->insert([
            'key' => 'AD_SPACE_2',
            'value' => '',
            'created_at' => '2019-01-01 00:00:00', 
            'updated_at' => '2019-01-01 00:00:00'
        ]);
        DB::table('options')->insert([
            'key' => 'AD_SPACE_3',
            'value' => '',
            'created_at' => '2019-01-01 00:00:00', 
            'updated_at' => '2019-01-01 00:00:00'
        ]);
        DB::table('options')->insert([
            'key' => 'CUSTOM_HEADER',
            'value' => '',
            'created_at' => '2019-01-01 00:00:00', 
            'updated_at' => '2019-01-01 00:00:00'
        ]);
        DB::table('options')->insert([
            'key' => 'CUSTOM_CSS',
            'value' => '',
            'created_at' => '2019-01-01 00:00:00', 
            'updated_at' => '2019-01-01 00:00:00'
        ]);
        DB::table('options')->insert([
            'key' => 'CUSTOM_JS',
            'value' => '',
            'created_at' => '2019-01-01 00:00:00', 
            'updated_at' => '2019-01-01 00:00:00'
        ]);
    }
}
