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
use Brian2694\Toastr\Facades\Toastr;
use DB;
use Log;

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
        // if (request()->ajax()) {
        //     $parameter_array = [];
        //     /*if(auth()->user()->role_id != @$this->super_role){
        //     $parameter_array = [
        //     'where' =>[['role_id','!=',@$this->super_role]],
        //     'relations' =>['role']
        //     ];
        //     }*/
        //     return $this->user->datatable($parameter_array);
        // }
        // return view($this->path('index'));
        $data = User::all();

        $i = 1;

        return view('user.index',compact('data','i'));
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
        $data = array(
            'roles' => $roles,
            'branch' => branch_info::all(),
        );
        return view($this->path('create'))->with($data);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $data = $request->all();

        $data = array(
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'dob'=>$request->dob,
            'password'=>Hash::make($request->password),
            'picture'=>'0',
            'branch' => $request->branch,
        );

        //dd($data);

        $file = $request->file('image');

        if($file)
        {
            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/profile_images/',$imageName);

            $data['picture'] = $imageName;
        }
        $user = User::create($data);

        $role = Role::find($request->role_id);

        // dd($role);

        $user->assignRole($role);

        Toastr::success('User Created', 'Success');
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        // return $id;
        $data = User::find($id);

        $roles = Role::all();

        return view('user.edit',compact('data','roles'));
    }

    public function update(Request $request,$id)
    {
        $data = $request->all();

        $data = array(
            'name'=>$request->name,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'dob'=>$request->dob,
            // 'password'=>Hash::make($request->password),
            'branch' => $request->branch,
        );

        //dd($data);

        $file = $request->file('image');


        if($file)
        {
            $pathImage = User::find($id);

            $path = public_path().'/profile_images/'.$pathImage->picture;

            if(file_exists($path))
            {
                unlink($path);
            }
        }

        if($file)
        {
            $imageName = rand().'.'.$file->getClientOriginalExtension();

            $file->move(public_path().'/profile_images/',$imageName);

            $data['picture'] = $imageName;
        }
        User::find($id)->update($data);

        $user = User::find($id);

        $role = Role::find($request->role_id);

        // dd($role);

        $user->assignRole($role);

        Toastr::success('User Updated', 'Success');
        return redirect()->back();
    }

    public function destroy($id)
    {

        User::find($id)->delete();
        Toastr::success('User Deleted', 'Success');
        return redirect()->back();
    }

    public function restore($id)
    {
        User::where('id',$id)->restore();
        Toastr::success('User Restored', 'Success');
        return redirect()->back();
    }

    public function forceDelete($id)
    {
        $pathImage = User::where('id',$id)->withTrashed()->first();

            $path = public_path().'/profile_images/'.$pathImage->picture;

            if(file_exists($path))
            {
                unlink($path);
            }

        User::where('id',$id)->withTrashed()->forceDelete();
        Toastr::success('User Permenantly Deleted', 'Success');
        return redirect()->back();
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
        // return $this->user->changePassword($request, $request->user_id);

        // dd($request->all());

        $user = User::find($request->user_id);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withInput()->withErrors('Current Password Wrong');
            }

            if ($request->password) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
            } else {
                return back()->withInput()->withErrors('Password not found');
            }

            \Toastr::success('Password Updated', 'Success');
            return redirect()->back();

    }

    public function status(Request $request)
    {
        return $this->user->status($request->id);
    }
}
