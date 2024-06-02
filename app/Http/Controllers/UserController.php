<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Interfaces\UserInterface;
use App\Models\Menu;
use App\Models\User;
use App\Models\UserMenuAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\branch_info;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "user.{$link}";
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $parameter_array = [];
            /*if(auth()->user()->role_id != @$this->super_role){
            $parameter_array = [
            'where' =>[['role_id','!=',@$this->super_role]],
            'relations' =>['role']
            ];
            }*/
            return $this->user->datatable($parameter_array);
        }
        return view($this->path('index'));
    }

    public function deletedListIndex()
    {
        if (request()->ajax()) {
            $parameter_array = [];
            /*if(auth()->user()->role_id != @$this->super_role){
            $parameter_array = [
            'where' =>[['role_id','!=',@$this->super_role]],
            'relations' =>['role']
            ];
            }*/
            return $this->user->deletedDatatable($parameter_array);
        }
    }

    public function create()
    {
        if (auth()->user()->role_id != @$this->super_role) {
            $roles = Role::query()->where('status', 1)->where('id', '!=', @$this->super_role)->pluck('name', 'id');
        } else {
            $roles = Role::query()->where('status', 1)->pluck('name', 'id');
        }
        $branch = branch_info::where('status',1)->get();
        $data = array(
            'roles' => $roles,
            'branch' => $branch,
        );

        return view($this->path('create'))->with($data);
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        if ($request->image_remote_url) {
            // make name unique with date time
            $unique_name = $request->image_real_name . '_' . date('d-m-Y-H-i-s') . '_' . microtime(true) . '.jpg';

            // get image from remote/external url
            $contents = file_get_contents($request->image_remote_url);

            // Save image
            Storage::put('/public/profile_images/' . $unique_name, $contents);

            $request['picture'] = $unique_name;
        }
        if ($request->password != null) {
            $request['password'] = Hash::make($request->password);
        }
        $this->user->create($request);
        $user = session('created_user');
        $this->user->send_email_with_credentials($user->id, $data);
        return $this->user->sync_role($user->id, $request);
    }

    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        if (auth()->user()->role_id != @$this->super_role) {
            $roles = Role::query()->where('status', 1)->where('id', '!=', @$this->super_role)->pluck('name', 'id');
        } else {
            $roles = Role::query()->where('status', 1)->pluck('name', 'id');
        }

        $data = array(
            'roles' => $roles,
            'user' => $user,
        );

        return view($this->path('edit'))->with($data);
    }

    public function update(UserRequest $request, User $user)
    {
        if ($request->image_remote_url) {
            // make name unique with date time
            $unique_name = $request->image_real_name . '_' . date('d-m-Y-H-i-s') . '_' . microtime(true) . '.jpg';

            // get image from remote/external url
            $contents = file_get_contents($request->image_remote_url);

            // Save image
            Storage::put('/public/profile_images/' . $unique_name, $contents);

            $request['picture'] = $unique_name;
        }
        if ($request->password != null) {
            $request['password'] = Hash::make($request->password);
        } else {
            $request['password'] = $user->password;
        }

        $this->user->sync_role($user->id, $request);
        return $this->user->update($user->id, $request);
    }

    public function destroy(User $user)
    {
        return $this->user->delete($user->id);
    }

    public function restore($id)
    {
        return $this->user->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->user->forceDelete($id);
    }

    /*public function permission($id)
    {
    $data['user'] = User::findOrFail($id);
    $data['role'] = $data['user']->role;
    $data['menus'] = Menu::where('parent_id',null)->where('status',1)->get();
    $data['user_menu_action'] = UserMenuAction::where('status',1)->get();
    $data['menu_permission'] = UserPermission::where('permission_type','menu')->where('user_id',$id)->pluck('permission_id')->toArray();
    $data['menu_action_permission'] = UserPermission::where('permission_type','menu_action')->where('user_id',$id)->pluck('permission_id')->toArray();
    return view($this->path('permission'))->with($data);
    }
    public function permissionUpdate(Request $request, $id)
    {
    return $this->user->permissionUpdate($request,$id);
    }
    public function profile()
    {
    $id = auth()->user()->id;
    $user = User::find($id);
    $data = array(
    'user' => $user,
    );
    return view($this->path('profile'))->with($data);
    }*/

    public function profileUpdate(ProfileRequest $request)
    {
        $id = $request->user_id;

        if ($request->image) {
            $file = $request->image;

            // make name unique with date time
            $extension = $file->getClientOriginalExtension();
            $unique_name = $file->getClientOriginalName() . '_' . date('d-m-Y-H-i-s') . '_' . microtime(true) . '.' . $extension;

            // Save image
            $request->file('image')->move(
                Storage::path('public/profile_images'),
                $unique_name
            );

            // Save name
            $request['picture'] = $unique_name;
        }

        return $this->user->profileUpdate($request, $id);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->user->changePassword($request, $request->user_id);
    }

    public function status(Request $request)
    {
        return $this->user->status($request->id);
    }
}
