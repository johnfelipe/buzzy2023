<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Repositories\PageRepository;

class PagesController extends AdminController
{
 /**
     * @var \App\Repositories\PageRepository
     */
    private $pageRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->middleware('demo_admin', ['only' => [
            'update',
            'store',
            'destroy',
        ]]);

        $this->pageRepository = $pageRepository;
    }

    /**
     * Show Pages lists
     *
     * @return void
     */
    public function index()
    {
        return view('admin.pages.pages');
    }

    /**
     * Show Pages lists
     *
     * @return void
     */
    public function create()
    {
        $page = false;
        return view('admin.pages.page', compact('page'));
    }

    /**
     * Show Pages lists
     *
     * @return void
     */
    public function edit($id)
    {
        $page  = Page::findOrFail($id);

        return view('admin.pages.page', compact('page'));
    }

    /**
     * Update a page
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        return $this->pageRepository->update($id, $request->all())->json();
    }

    /**
     * Store a page
     *
     * @return void
     */
    public function store(Request $request)
    {
        return $this->pageRepository->store($request->all())->json();
    }

    /**
     * Delete a page
     *
     * @return void
     */
    public function destroy($id)
    {
        return $this->pageRepository->destroy($id)->json();
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTableData()
    {
        $pages = DB::table('pages');
        $pages->select('*');

        return Datatables::of($pages)

            ->editColumn(
                'body',
                function ($page) {
                    return '<p class="konu" style="color:#999;">
                        ' . Str::substr($page->body, 0, 500) . '
                        </p>
                    ';
                }
            )
            ->editColumn(
                'date',
                function ($page) {
                   return Carbon::create($page->created_at)->format('Y-m-d h:i');
                }
            )
            ->editColumn(
                'actions',
                function ($page) {
                    return '
                    <div class="d-flex text-center btn-group-sm ">
                        <a href="'.url('admin/pages/'.$page->id).'" class="btn btn-success">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="'.url('admin/pages/'.$page->id.'/destroy').'" class="btn btn-danger do_action" data-reload="yes" data-confirm="'.__("Do you realy want this?").'">
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
