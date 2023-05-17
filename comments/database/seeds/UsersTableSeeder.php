<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creating with installer
        /*    DB::table('users')->insert(
            [
                'user_type' => 'admin',
                'username' => 'admin',
                'username_slug' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
             ]
        ); */
    }
}
