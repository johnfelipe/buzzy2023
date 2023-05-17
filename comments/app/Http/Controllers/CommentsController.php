<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;

class CommentsController extends Controller
{
    /**
     * @var \App\Repositories\CommentRepository
     */
    private $commentRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->middleware('auth', ['except' => [
            'index',
            'store', //  buzzy comment posting || guest comment
            'vote', // do we need guest voting?
            'replies',
        ]]);

        $this->commentRepository = $commentRepository;
    }

    public function index()
    {
        $response = $this->commentRepository->validateRequest();

        if (request()->expectsJson()) {
            if ($response->failed()) {
                return $response->json();
            }

            return $this->ajax($response->data());
        }

        if ($response->failed()) {
            die($response->message());
        }

        return $this->init($response->data());
    }

    /**
     * Init comment page
     *
     * @param array $responseData
     * @return void
     */
    public function init($responseData)
    {
        $theme = $responseData['theme'];
        $title = $responseData['title'];
        $hide_footer = $responseData['hide_footer'];
        $content_id = $responseData['content_id'];
        $content_user = $responseData['content_user'];
        $content_sort = $responseData['content_sort'];
        $access_domain = $responseData['access_domain'];

        $popularComments = Comment::parent()
            ->approved()
            ->byContentId($content_id)
            ->byAccessDomain($access_domain)
            ->byUser($content_user)
            ->popular();

        $comments = Comment::parent()
            ->approved()
            ->byContentId($content_id)
            ->byAccessDomain($access_domain)
            ->byUser($content_user)
            ->whereNotIn('id', $popularComments->pluck('id'))
            ->orderCommentsBy($content_sort)
            ->paginate(env('COMMENTS_PAGE_COUNT', 15));

        $json_data = [
            'requestData' => $responseData,
        ];

        $data =  compact(
            'title',
            'hide_footer',
            'popularComments',
            'comments',
            'theme',
            'json_data'
        );

        if ($content_user) {
            return view('comments.pages.user_comments', $data);
        }

        return view('comments.pages.index', $data);
    }

    public function ajax($responseData)
    {
        $content_id = $responseData['content_id'];
        $content_user = $responseData['content_user'];
        $content_sort = $responseData['content_sort'];

        $comments = Comment::parent()
            ->approved()
            ->byContentId($content_id)
            ->byUser($content_user)
            ->orderCommentsBy($content_sort)
            ->paginate(env('COMMENTS_PAGE_COUNT', 15));

        return response()->json(['status' => 'success', 'html' => view(
            'comments.pages._comments_list',
            compact(
                'comments'
            )
        )->render()]);
    }


    public function replies($id)
    {
        $response = $this->commentRepository->validateRequest();

        if ($response->failed()) {
            return $response->json();
        }

        $repliesCount = env('COMMENTS_SHOW_REPLY_COUNT', 5);
        $repliesSort = env('COMMENTS_REPLIES_DEFAULT_SORT', 'new');

        $comments = Comment::findOrFail($id)->replies()
            ->approved()
            ->orderCommentsBy($repliesSort)
            ->paginate($repliesCount);

        $moreExist = $comments->hasMorePages();
        $hideLinks = true;

        return response()->json(['status' => 'success', 'moreExist' => $moreExist, 'html' => view(
            'comments.pages._comments_list',
            compact(
                'comments',
                'hideLinks'
            )
        )->render()]);
    }

    public function vote(Request $request)
    {
        $this->validate(
            $request,
            [
                'comment_id' => 'required',
                'vote' => 'required',
            ]
        );

        $response = $this->commentRepository->vote(
            $request->only(
                [
                    'comment_id',
                    'vote',
                ]
            )
        );

        return $response->json();
    }

    /**
     * Store
     *
     * @param Illuminate\Http\Request $request
     * @todo check this mess :)
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request, UserRepository $userRepository)
    {
        $rules = [
            'comment' => 'required|between:1,1500',
        ];

        if (env('GOOGLE_RECAPTCHA_SECRET') && !get_current_content_user()->authenticated && empty($request->input('user_password'))) {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|recaptcha'
            ]);
        }

        $this->validate($request, $rules,  [
            'required' => 'You need to write something!',
            'between' => __('The :attribute value :input is not between :min - :max.'),
            'recaptcha' => __('reCaptcha failed. You may need to refresh the page.'),
        ]);

        $response = $this->commentRepository->validateRequest();

        if ($response->failed()) {
            return $response->json();
        }

        $commentData = $request->only([
            'comment',
            'parent_id',
            'spoiler',
            'type',
            'content_id',
            'content_url',
            'access_domain',
        ]);

        if ($user_hash =  $request->get('user_hash')) {
            $commentData = array_merge($commentData, ["data" => parse_user_hash($user_hash)]);
        } else {
            $user_username = $request->input('user_username');
            $user_email = $request->input('user_email');
            $user_password = $request->input('user_password');
            if ($user_username && $user_email && $user_password) {
                $newUserResponse = $userRepository->storeAndAuthenticate([
                    'username' => $request->input('user_username'),
                    'email' => $request->input('user_email'),
                    'password' => $request->input('user_password'),
                    'g-recaptcha-response' => $request->input('g-recaptcha-response')
                ]);
                if ($newUserResponse->failed()) {
                    return $newUserResponse->json();
                }
                $commentData = array_merge($commentData, ["user_id" => $newUserResponse->data()->id]);
            } elseif ($user_username && $user_email) {
                $commentData = array_merge($commentData, ["data" => [
                    'guest' => true,
                    'ipno' => $request->ip(),
                    'username' => $request->input('user_username'),
                    'email' => $request->input('user_email'),
                ]]);
            }
        }

        $response = $this->commentRepository->store($commentData);

        if ($response->failed()) {
            return $response->json();
        }

        return $response->json(['html' => view(
            'comments.pages._comment',
            [
                'comment' => $response->data()
            ]
        )->render()]);
    }


    /**
     * Destroy
     *
     * @param  int $id
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->commentRepository->destroy($id);

        return $response->json();
    }

    /**
     * Show Report Form
     *
     * @param Illuminate\Http\Request $request
     * @param int $id comment id
     *
     * @return Illuminate\Http\Response
     */
    public function reportForm($id)
    {
        $response = $this->commentRepository->show($id);

        $comment = $response->data();

        return view('auth.pages.report', compact('comment'));
    }

    /**
     * Store Report
     *
     * @param Illuminate\Http\Request $request
     * @param int $id comment id
     *
     * @return Illuminate\Http\Response
     */
    public function report(Request $request, $id)
    {
        /*   $this->validate(
            $request,
            [
                'body' => 'max:1500',
            ]
        );
 */
        $response = $this->commentRepository->report($id, $request->only('body'));

        return $response->json();
    }
}
