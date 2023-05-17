<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OldVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Artisan::call('db:seed', ['--class'=> 'OldVersionSeeder', '--force' => true]);
        // tables from v1
        if (DB::table('yorumlar')->exists()) {
            collect(DB::table('yorumlar')->get())->each(function ($comment) {
                $data = [];
                if (!empty($comment->u_name) && !empty($comment->u_email)) {
                    $data = [
                        'guest' => true,
                        'ipno' => '',
                        'username' => $comment->u_name,
                        'email' => $comment->u_email,
                    ];
                } elseif (!empty($comment->out_name)) {
                    $data =  [
                        'CUSER' => true,
                        'CUSER_ID' => $comment->out_id,
                        'CUSER_NAME' => $comment->out_name,
                        'CUSER_LINK' => $comment->out_link,
                        'CUSER_ICON' => $comment->out_icon,
                    ];
                }

                $year = substr($comment->tarih, 0, 4);
                $month = substr($comment->tarih, 4, 2);
                $day = substr($comment->tarih, 6, 2);
                $hour = substr($comment->tarih, 8, 2);
                $minute = substr($comment->tarih, 10, 2);

                DB::table('comments')->insert([
                    'id' => $comment->id,
                    'comment' => $comment->yorum,
                    'user_id' => $comment->ekleyen ? $comment->ekleyen : null,
                    'parent_id' => in_array($comment->tip, ['yorumcevap', 'yorumcevapyanit']) ? $comment->icerikid : NULL,
                    'type' => 'addcomment',
                    'approve' => $comment->onay ?  1 : 0,
                    'content_id' => !in_array($comment->tip, ['yorumcevap', 'yorumcevapyanit']) ? $comment->icerikid : NULL,
                    'content_url' => !in_array($comment->tip, ['yorumcevap', 'yorumcevapyanit']) ? $comment->tip : NULL,
                    'access_domain' => $comment->domainaccess,
                    'data' => json_encode($data),
                    'spoiler' => 0,
                    'created_at' => Carbon::create($year, $month, $day, $hour, $minute),
                    'updated_at' => Carbon::create($year, $month, $day, $hour, $minute)
                ]);
            });
        }
    }
}
