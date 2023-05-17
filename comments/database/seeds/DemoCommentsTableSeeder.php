<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = [
            [
                'comment' => 'The First easyComment :)',
                'user' => 'ec-user-1',
            ],
            [
                'comment' => "This app really easy to use.\tI like it so much...",
                'user' => 'ec-user-2',
            ],
            [
                'comment' => "I can't tell you how impressed I am. I love what I am seeing. Keep it up good work.",
                'user' => 'ec-user-3',
            ],
            [
                'comment' => "Its help a lot on my project. Thanks for this nice system.",
                'user' => 'ec-user-4',
            ],
            [
                'comment' => "Our users loves this commenting. Can't wait for next projects of you.",
                'user' => 'ec-user-5',
            ],
            [
                'comment' => "Just trying post a comment.",
                'user' => 'ec-user-6',
            ],
            [
                'comment' => "Good job :) Looking good.",
                'user' => 'ec-user-7',
            ],
            [
                'comment' => "Who like this?",
                'user' => 'ec-user-8',
                'replies' => [
                    [
                        'comment' => '@EC User8, Me first :)',
                        'user' => 'ec-user-9'
                    ],
                    [
                        'comment' => "@EC User8, I'm",
                        'user' => 'ec-user-12'
                    ],
                    [
                        'comment' => "@EC User8, Me too.",
                        'user' => 'ec-user-7'
                    ],
                    [
                        'comment' => "@EC User8, I like it!",
                        'user' => 'ec-user-16'
                    ],
                    [
                        'comment' => "@EC User8, I just simply love it.",
                        'user' => 'ec-user-18'
                    ]
                ],
            ],
            [
                'comment' => "Just trying post a comment.",
                'user' => 'ec-user-9',
            ],
            [
                'comment' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                'user' => 'ec-user-9',
            ],
            [
                'comment' => "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\t\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.",
                'user' => 'ec-user-10',
            ],
            [
                'comment' => "This script works perfecly in my blog site. Just add one simple code to my site. And it's all good. Now I'm getting feedbacks from my followers.",
                'user' => 'ec-user-11',
            ],
            [
                'comment' => "Just random Greek text\t\nαπό τον 15ο αιώνα, όταν ένας ανώνυμος τυπογράφος πήρε ένα δοκίμιο και ανακάτεψε τις λέξεις για να δημιουργήσει ένα δείγμα βιβλίου. Όχι μόνο επιβίωσε πέντε αιώνες, αλλά κυριάρχησε στην ηλεκτρονική στοιχειοθεσία,",
                'user' => 'ec-user-12',
            ],
            [
                'comment' => "Great system! How can I access admin panel?",
                'user' => 'ec-user-13',
                'replies' => [
                    [
                        'comment' => "@EC User13, You can find this in documentation.\t\nhttp://easycomment.akbilisim.com/doc.html\t\nSimply you need to login as admin. And go to http://easycomment.akbilisim.com/demo/app/admin/. That it! Enjoy.",
                        'user' => 'akbilisim',
                        'replies' => [
                            [
                                'comment' => "@admin, Thanks for answering. How can I login as admin?",
                                'user' => 'ec-user-13',
                            ],
                            [
                                'comment' => "@EC User13, When you go admin panel. If you haven't log in as admin, system will redirect you login page.\t\n
                                It's must be;\t\n
                                " . url('admin') . "\t\n
                                Demo admin email: demo@admin.com\t\n
                                Demo admin password: demoadmin\t\n
                                Good Luck.",
                                'user' => 'akbilisim',
                            ],
                            [
                                'comment' => "@admin, Thanks you.",
                                'user' => 'ec-user-13',
                            ],
                            [
                                'comment' => "@EC User15, Your Welcome. :smile",
                                'user' => 'akbilisim',
                            ]
                        ]
                    ],
                    [
                        'comment' => "@EC User13, Just remember, your actions will not changing anything on demo panel.",
                        'user' => 'ec-user-16'
                    ],
                ],
            ],
            [
                'comment' => "I like all themes.",
                'user' => 'ec-user-14',
            ],
            [
                'comment' => "My first impression of that system was really cool.\t\nI can't hold myself to buy it. 8)",
                'user' => 'ec-user-15',
            ],
            [
                'comment' => "easyComment has many features;
                5 main themes, Comment approval system , Comment reporting , Social media login and registering , All ajax system , Rating system , Comment sorting (newest/oldest/best), Smilies support,Language file included, Avatar upload , Fontawesome icons and much more..

                See more awesome themes here
                http://easycomment.akbilisim.com/example.html",
                'user' => 'ec-user-16',
            ],
            [
                'comment' => "This is what I was looking for. Definitely I'll take it. Thanks for good work.",
                'user' => 'ec-user-17',
            ],
            [
                'comment' => "Easiest way to comment with this awesome plugin.. 8)",
                'user' => 'ec-user-18',
                'replies' => [
                    [
                        'comment' => "@EC User14, Agreed. It's great!!",
                        'user' => 'ec-user-2',
                        'replies' => [
                            [
                                'comment' => "@EC User14, That's true!",
                                'user' => 'ec-user-18',
                            ]
                        ]
                    ]
                ]
            ],
            [
                'comment' => "Here it's my guest comment",
                'user' => null,
            ],
        ];

        foreach (array_reverse($comments) as $key => $comment) {
            $this->createComment($comment, $key + 1);
        }
    }

    /**
     * Create
     *
     * @param array $comment
     * @param int|null $parent_id
     * @return void
     */
    private function createComment($comment, $key, $parent_id = null)
    {
        $user = DB::table('users')->where('username_slug', $comment['user'])->first();

        $date = Carbon::now()->subDays($key);

        DB::table('comments')->insert([
            'comment' => $comment['comment'],
            'user_id' => $user ? $user->id : null,
            'parent_id' => $parent_id,
            'approve' => 1,
            'content_id' => 'easyCommentHomepage',
            'access_domain' => base64_encode(request()->getHttpHost()),
            'created_at' =>  $date,
            'updated_at' =>  $date
        ]);

        $last_id = DB::getPDO()->lastInsertId();
        if (isset($comment['replies'])) {
            foreach ($comment['replies'] as $_key => $comment) {
                $this->createComment($comment, $_key + 1, $last_id);
            }
        }
    }
}
