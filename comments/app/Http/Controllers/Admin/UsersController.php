<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;

class UsersController extends AdminController
{
  /**
     * @var \App\Repositories\UserRepository
     */
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('demo_admin', ['only' => [
            'update',
            'action',
            'destroy',
        ]]);

        $this->userRepository = $userRepository;
    }

    /**
     * Show User lists
     *
     * @return void
     */
    public function index()
    {
        return view('admin.pages.users');
    }

    /**
     * Show an User
     *
     * @return void
     */
    public function show($id)
    {
        $response = $this->userRepository->show($id);

        $user = $response->data();

        return view(
            'admin.pages.user',
            compact(
                'user'
            )
        );
    }

    /**
     * Update an User
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        $response = $this->userRepository->update($id, $request->all());

        return $response->json();
    }

    /**
     *
     * Update an User
     *
     * @return void
     */
    public function action(Request $request, $id)
    {
        $update = [];
        $do = $request->query('do');

        if ($do === 'unlock' || $do === 'member') {
            $update = ['user_type' => null];
        } elseif ($do === 'admin') {
            $update = ['user_type' => 'admin'];
        } elseif ($do === 'ban') {
            $update = ['user_type' => 'banned'];
        }

        $response = $this->userRepository->forceUpdate($id, $update);

        return $response->json();
    }

    /**
     *
     * Remove an User
     *
     * @return void
     */
    public function destroy($id)
    {
        $response = $this->userRepository->destroy($id);

        return $response->json();
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTableData(Request $request)
    {
        $users = DB::table('users');
        $users->select('*');

        if ($type = $request->query('user_type')) {
            $users->where('user_type', '=', $type);
        }

        return Datatables::of($users)
            ->editColumn(
                'user',
                function ($user) {
                    $type = $user->user_type ?? __('Member');
                    return '<a href="'.url('admin/users/'. $user->id).'">
                            <img src="'.image_url_create($user->icon, 's', 'avatars').'" style="width:45px;float:left;margin-right:8px;">
                            <b style="float:left;font-weight:bold;">'.$user->username.'</b>
                            <br><span style="color:black;font-weight:400">'.$type.'</span>
                        </a>';
                }
            )
            ->editColumn(
                'email',
                function ($user) {
                    return '<a href="mailto:'.$user->email.'">' . $user->email . '</a>';
                }
            )
            ->editColumn(
                'status',
                function ($user) {
                    if (get_user_is_online($user->last_seen)) {
                        $status='<span class="text-success">'.__('Online').'</span>';
                    } else {
                        $status='<span class="text-secondary">'.__('Offline').'</span>';
                    }

                    return $status;
                }
            )
            ->editColumn(
                'last_seen',
                function ($user) {
                    return Carbon::create($user->last_seen)->format('Y-m-d h:i');
                }
            )
            ->editColumn(
                'date',
                function ($user) {
                    return Carbon::create($user->created_at)->format('Y-m-d h:i');
                }
            )
            ->editColumn(
                'actions',
                function ($user) {
                    $buttons = '<a href="'.url('admin/users/'.$user->id.'?page=edit').'" class="btn btn-success">
                            <i class="fa fa-edit"></i>
                        </a>';

                    if ($user->user_type=="banned") {
                        $buttons .= '<a href="'.url('/admin/users/'.$user->id.'/action?do=unlock').'" title="'.__("Unlock").'" class="btn btn-danger do_action" data-reload="yes">
                            <i class="fa fa-unlock" style="margin-right:0"></i>
                        </a>';
                    } else {
                        if ($user->user_type=="admin") {
                            $buttons .= '<a href="'.url('/admin/users/'.$user->id.'/action?do=member').'" title="'.__("Make User").'" class="btn btn-danger do_action" data-reload="yes">
                                <i class="fa fa-download" style="margin-right:0"></i>
                            </a>';
                        } else {
                            $buttons .=
                            '<a href="'.url('/admin/users/'.$user->id.'/action?do=admin').'" title="'.__("Make Admin").'" class="btn btn-warning do_action" data-reload="yes" >
                                        <i class="fa fa-upload" style="margin-right:0"></i>
                                    </a>
                                <a href="'.url('/admin/users/'.$user->id.'/action?do=ban').'" title="'.__("Ban").'" class="btn btn-default do_action" data-reload="yes" >
                                    <i class="fa fa-lock" style="margin-right:0"></i>
                                </a>
                                <a href="'.url('admin/users/'.$user->id.'/destroy').'" title="'.__("Delete").'" class="btn btn-danger do_action" data-reload="yes" data-confirm="'.__("Do you realy want this?").'">
                                    <i class="fa fa-remove"></i>
                                </a>';
                        }
                    }

                    return '
                    <div class="d-flex text-center btn-group btn-group-justified btn-group-sm">
                        '. $buttons .'
                    </div>
                    ';
                }
            )
            ->escapeColumns(['*'])
            ->make(true);
    }
}
