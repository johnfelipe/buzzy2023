<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('pages')->insert([
            'title' => 'About',
            'body' => 'About Page Text here',
            'type' => 'page',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
         DB::table('pages')->insert([
            'title' => 'Help',
            'body' => 'Help Page Text here',
            'type' => 'page',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
         DB::table('pages')->insert([
            'title' => 'Terms',
            'body' => 'Terms Page Text here',
            'type' => 'page',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
         DB::table('pages')->insert([
            'title' => 'Privacy',
            'body' => 'Privacy Page Text here',
            'type' => 'page',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
