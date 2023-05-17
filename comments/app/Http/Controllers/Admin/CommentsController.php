<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Repositories\CommentRepository;

class CommentsController extends AdminController
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
        $this->commentRepository = $commentRepository;

        $this->middleware('demo_admin', ['only' => [
            'approve',
            'update',
            'destroy',
        ]]);
    }

    /**
     * Show Comments lists
     *
     * @return void
     */
    public function index()
    {
        $type = request()->get('type');
        $orderBy = request()->get('orderBy');
        $unapprovedCount  = Comment::approved(0)->count();

        return view(
            'admin.pages.comments',
            compact(
                'unapprovedCount'
            )
        );
    }

    /**
     * Show a Comment
     *
     * @return void
     */
    public function show($id)
    {
        $comment  = Comment::findOrFail($id);

        return view(
            'admin.pages.comment',
            compact(
                'comment'
            )
        );
    }

    /**
     * Delete a comment
     *
     * @return void
     */
    public function approve($id)
    {
        return $this->commentRepository->approve($id)->json();
    }

   /**
     * Update a comment
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        return $this->commentRepository->update($id, $request->all())->json();
    }

    /**
     * Delete a comment
     *
     * @return void
     */
    public function destroy($id)
    {
        return $this->commentRepository->destroy($id)->json();
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTableData(Request $request)
    {
        $comments = Comment::leftJoin('users', 'comments.user_id', '=', 'users.id');
        $comments->select('comments.*');

        $approve = $request->query('approve');
        if ($approve === 'unapproved') {
            $comments->where('approve', 0);
        } else {
            $comments->where('approve', 1);
        }

        if ($domain = $request->query('domain')) {
            $comments->where('access_domain', base64_encode($domain));
        }

        return Datatables::of($comments)
            ->editColumn(
                'user',
                function ($comment) {
                    return '<a href="'.$comment->userdata->admin_link.'" target=_blank>
                                <img src="'.$comment->userdata->icon.'" style="width:35px;float:left;margin-right:8px;">
                                <b style="float:left;font-weight:bold;">'.$comment->userdata->username.'</b>
                                <br><span class="tag '.$comment->userdata->user_type.'">'.$comment->userdata->user_type.'</span>
                            </a>';
                }
            )
            ->editColumn(
                'content',
                function ($comment) {
                    return $comment->parent_id !== null
                    ? __("Reply of ") . '<a class="btn btn-default" href="'.url('admin/comments/' . $comment->parent_id).'" style="padding:1px 6px;">#'.$comment->parent_id.'</a>'
                    : $comment->content_id . '<a href="' . base64_decode($comment->content_url) . '" class="btn btn-default" style="padding:1px 6px;" target="_blank"><i class="fa fa-external-link"></i></a>';
                }
            )
            ->editColumn(
                'comment',
                function ($comment) {
                    return '<p class="konu" style="color:#999;">
                        ' . Str::substr($comment->comment, 0, 155) . '
                        </p>
                    ';
                }
            )
            ->editColumn(
                'date',
                function ($comment) {
                    return $comment->created_at->format('Y-m-d h:i');
                }
            )
            ->editColumn(
                'actions',
                function ($comment) {

                    $approve = !$comment->approve ? '<a href="'.url('admin/comments/'.$comment->id.'/approve').'" data-reload="yes" class="btn btn-success btn-small do_action">
                        <i class="btn-fa fa-only fa fa-check-square-o"></i>
                    </a>' : '';
                    return '
                    <div class="d-flex text-center btn-group-sm ">
                        '.$approve.'
                        <a href="'.url('admin/comments/'.$comment->id).'" class="btn btn-success">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="'.url('admin/comments/'.$comment->id.'/destroy').'" class="btn btn-danger do_action" data-reload="yes" data-confirm="'.__("Do you realy want this?").'">
                            <i class="fa fa-remove"></i>
                        </a>
                    </div>
                    ';
                }
            )
            ->escapeColumns(['*'])
            ->make(true);
    }
}
