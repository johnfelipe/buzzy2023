<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call('UsersTableSeeder');
         $this->call('PagesTableSeeder');

         if(env('APP_DEMO')){
            $this->call('DemoUsersTableSeeder');
            $this->call('DemoCommentsTableSeeder');
        }
    }
}
