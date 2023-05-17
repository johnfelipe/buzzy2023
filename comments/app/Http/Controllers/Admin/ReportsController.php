<?php

namespace App\Http\Controllers\Admin;

use App\Report;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Repositories\CommentRepository;

class ReportsController extends AdminController
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
        $this->middleware('demo_admin', ['only' => [
            'destroy',
        ]]);

        $this->commentRepository = $commentRepository;
    }

    /**
     * Show reports lists
     *
     * @return void
     */
    public function index()
    {
        return view('admin.pages.reports');
    }

      /**
     * Remove report
     *
     * @return void
     */
    public function destroy($id)
    {
        Report::destroy($id);

        return ['status' => 'success', 'message' => __('Deleted')];
    }


    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTableData(Request $request)
    {
        $reports = Report::leftJoin('users', 'reports.user_id', '=', 'users.id');
        $reports->select('reports.*');

        return Datatables::of($reports)
            ->editColumn(
                'user',
                function ($report) {
                    if ($report->user) {
                        return '<a href="'.url('admin/users/'. $report->user->id).'">
                                <img src="'.image_url_create($report->user->icon, 's', 'avatars').'" style="width:35px;float:left;margin-right:8px;">
                                <b style="float:left;font-weight:bold;">'.$report->user->username.'</b>
                                <br><font size=2 color=#ccc>'.$report->user->user_type.'</font>
                            </a>';
                    }
                    return '-';
                }
            )
            ->editColumn(
                'content',
                function ($report) {
                    return '<a href="'.url('admin/comments/' . $report->comment->id).'" style="padding:1px 6px;">'.__("Comment").' #'.$report->comment->id.'</a>';
                }
            )
            ->editColumn(
                'body',
                function ($report) {
                    return '<p class="konu" style="color:#999;">
                        ' . Str::substr($report->body, 0, 500) . '
                        </p>
                    ';
                }
            )
            ->editColumn(
                'date',
                function ($report) {
                    return $report->created_at->format('Y-m-d h:i');
                }
            )
            ->editColumn(
                'actions',
                function ($report) {
                    return '
                    <div class="d-flex text-center btn-group-sm ">
                        <a href="'.url('/admin/reports/'.$report->id.'/destroy').'" title="'.__("Remove the report").'" class="btn btn-danger do_action" data-reload="yes" >
                            <i class="fa fa-flag"></i>
                        </a>
                        <a href="'.url('admin/comments/'.$report->comment->id.'/destroy').'" title="'.__("Delete Comment").'" class="btn btn-danger do_action" data-reload="yes" data-confirm="'.__("Do you realy want this?").'">
                            <i class="fa fa-comment"></i> & <i class="fa fa-flag"></i>
                        </a>
                    </div>
                    ';
                }
            )
            ->escapeColumns(['*'])
            ->make(true);
    }
}
