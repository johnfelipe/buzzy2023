<?php

namespace App\Repositories;

use App\Comment;
use Illuminate\Support\Arr;
use App\Traits\RepositoryResponse;
use Illuminate\Support\Facades\Auth;

class CommentRepository
{
    use RepositoryResponse;

    /**
     * Validate comments page request.
     *
     * @return $this
     */
    public function validateRequest()
    {
        $request = request()->all();
        $access_domain = Arr::get($request, 'access_domain');
        $theme = Arr::get($request, 'theme', env('COMMENTS_THEME', 'Default'));
        $title = Arr::get($request, 'title', env('COMMENTS_TITLE', __('Comments')));
        $hide_footer = Arr::get($request, 'hide_footer');
        $language = Arr::get($request, 'language', env('APP_LOCALE', 'en'));
        $content_sort = Arr::get($request, 'content_sort', env('COMMENTS_DEFAULT_SORT', 'new'));
        $content_id = Arr::get($request, 'content_id');
        $content_url = Arr::get($request, 'content_url');
        $content_user = Arr::get($request, 'content_user');
        $user_hash = Arr::get($request, 'user_hash');
        $CUSER = false;

        // old
        if ($user_hash) {
            $userhash_in = parse_user_hash($user_hash);
            $CUSER = $userhash_in['CUSER'];

            if (!$CUSER) {
                return $this->fail(__('Access denied'));
            }
        }

        if (!$this->checkAllowedSite($access_domain)) {
            return $this->fail(__('No access for this domain. Add your domain name on Admin > Settings > Allowed Domains field'));
        }

        if (!$theme || !in_array($theme, get_available_themes(), true)) {
            return $this->fail(__('Not a Valid Theme'));
        }

        // Content Id
        if (!$content_id && !$content_user) {
            return $this->fail(__('Not a Valid Content ID'));
        }

        // Content Url
        if ($content_url) {
            $C_url = base64_decode($content_url);

            if (!filter_var($C_url, FILTER_VALIDATE_URL)) {
                return $this->fail(__('Not a Valid Content Url'));
            }
        } else {
            return $this->fail(__('Not a Valid Content Url'));
        }

        if ($content_user) {
            $hide_footer = 'Off';
            $title = __('User Comments');
        }

        return $this->success(
            [
                'theme' => $theme,
                'title' => $title,
                'hide_footer' => $hide_footer === 'Off' || env('COMMENTS_SHOW_FOOTER', true),
                'language' => $language,
                'content_sort' => $content_sort,
                'content_id' => $content_id,
                'content_url' => $content_url,
                'content_user' => $content_user,
                'access_domain' => $access_domain,
                'user_hash' => $user_hash,
            ]
        );
    }

    /**
     * Get comments.
     *
     * @param int $id Comment ID
     *
     * @return array
     */
    public function get()
    {
        $comments = Comment::parent()->get();

        return $comments;
    }


    /**
     * Get a comment.
     *
     * @param int $id Comment ID
     *
     * @return $this
     */
    public function show($id)
    {
        if ($comment = Comment::find($id)) {
            $response = $this->success($comment);
        } else {
            $response = $this->fail();
        }

        return $response;
    }

    /**
     * Update a comment.
     *
     * @param array $data
     *
     * @return $this
     */
    public function update($id, $data)
    {
        $comment  = Comment::find($id);

        try {
            $comment = $comment->update($data);
            $response = $this->success($comment, __('Updated'));
        } catch (\Exception $e) {
            $response = $this->fail($e->getMessage());
        }

        return $response;
    }



    /**
     * Store a comment.
     *
     * @param array $data
     *
     * @return $this
     */
    public function store($data)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = Arr::get($data, 'user_id', null);
        }

        $is_cuser = isset($data["data"]["CUSER"]) && !empty($data["data"]["CUSER_ID"]);
        $is_guest = isset($data["data"]["guest"]);

        if (!$user_id && !($is_guest || $is_cuser)) {
            return $this->fail(__('You must be logged in'));
        }

        if (Auth::check() && in_array(Auth::user()->user_type, ['admin', 'mod']) && Auth::user()->email !== 'demo@admin.com') {
            $approve = 1;
        } else {
            $approve = env('COMMENTS_USE_APPROVAL') ? 0 : 1;
        }

        $parent_id = Arr::get($data, 'parent_id');

        $data = array_merge(
            $data,
            [
                'user_id' => $user_id,
                'approve' => $approve,
                'parent_id' => $parent_id ? intval($parent_id) : null,
            ]
        );

        try {
            $comment = Comment::create($data);

            $approveMessage = !$approve ? __('Thanks for your comment. Your comment will appear after it is approved!')  : '';
            $response = $this->success($comment, $approveMessage);
        } catch (\Exception $e) {
            $response = $this->fail($e->getMessage());
        }

        return $response;
    }

    /**
     * Vote a comment.
     *
     * @param array $data
     *
     * @return $this
     */
    public function vote($data)
    {
        $data = array_merge(
            $data,
            [
                'type' => "comment",
                'user_id' => Auth::user()->id ?? null,
                'ipno' => request()->ip(),
            ]
        );

        try {
            $comment = Comment::findOrFail($data['comment_id']);
            $logged = Auth::check();
            $guest = env('COMMENTS_GUEST_VOTE');

            if (!$logged && !$guest) {
                return $this->fail(__('You must login to vote!'));
            }

            if (
                $logged && in_array(Auth::user()->id, $comment->votes->pluck('user_id')->toArray())
                || $guest && in_array(request()->ip(), $comment->votes->pluck('ipno')->toArray())
            ) {
                return $this->fail(__('You have already voted this comment!'));
            }

            $vote = $comment->votes()->create($data);
            $response = $this->success($vote);
        } catch (\Exception $e) {
            $response = $this->fail($e->getMessage());
        }

        return $response;
    }


    /**
     * Destroy a comment.
     *
     * @param integer $id Comment Id
     *
     * @return $this
     */
    public function destroy($id)
    {
        try {
            Comment::destroy($id);
            $response = $this->success(true, __('Comment Deleted'));
        } catch (\Exception $e) {
            $response = $this->fail($e->getMessage());
        }

        return $response;
    }

    /**
     * Approve a comment.
     *
     * @param integer $id Comment Id
     *
     * @return $this
     */
    public function approve($id)
    {
        if ($comment = Comment::findOrFail($id)) {
            $comment->update(['approve' => 1]);
            $response = $this->success(null, __('Comment Approved'));
        } else {
            $response = $this->fail();
        }

        return $response;
    }

    /**
     * Report a comment.
     *
     * @param integer $id Comment Id
     *
     * @return $this
     */
    public function report($id, $data)
    {
        if ($comment = Comment::findOrFail($id)) {
            $comment->reports()->create(array_merge([
                'user_id' => Auth::user()->id,
            ], $data));
            $response = $this->success(null, __('Comment Reported'));
        } else {
            $response = $this->fail();
        }

        return $response;
    }

    /**
     * Success Returns
     *
     * @param array|string $data
     *
     * @return bool
     */
    public function checkAllowedSite($access)
    {
        $url = base64_decode($access);
        if ($url === request()->getHttpHost()) {
            return true;
        }

        $allowedSites = array_filter(explode(',', env('ALLOWED_DOMAINS')));

        $url = str_replace("http://", "", $url);
        $url = str_replace("https://", "", $url);

        return in_array($url, $allowedSites, true);
    }
}
