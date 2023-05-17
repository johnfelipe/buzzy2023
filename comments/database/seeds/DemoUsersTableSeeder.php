<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         // Create demo admin account
         DB::table('users')->insert([
            'user_type' => 'admin',
            'username' => 'demo',
            'username_slug' => 'demo',
            'email' => 'demo@admin.com',
            'password' => bcrypt('demoadmin'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $i = 1;
        while ($i <= 18) {
            DB::table('users')->insert([
                'user_type' => $i === 16 ? 'mod' : null,
                'username' => 'EC User'.$i,
                'username_slug' => 'ec-user-'.$i,
                'email' => 'ec-user'.$i.'@easycomment.com',
                'icon' => 'https://cdn.akbilisim.com/products/easycomment/user-avatar/ec-user'.$i.'.jpg',
                'password' => bcrypt(rand(6, 10)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $i++;
        }
    }
}
