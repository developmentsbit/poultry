<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Interfaces\RoleInterface;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleHasPermission;
use App\Models\User;
use App\Models\UserMenuAction;
use App\Models\ModelHasPermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    protected $role;

    public function __construct(RoleInterface $role)
    {
        $this->role = $role;
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "role.{$link}";
    }

    public function index()
    {

        $data = \Spatie\Permission\Models\Role::where('deleted_at',NULL)->get();
        // dd($data);
        $i = 1;
        return view('role.index',compact('data','i'));

    }

    public function deletedListIndex()
    {
        if (request()->ajax()) {
            $parameter_array = [];
            /*if(auth()->user()->role_id != $this->super_role){
            $parameter_array = [
            'where' =>[['id','!=',$this->super_role]],
            ];
            }*/
            return $this->role->deletedDatatable($parameter_array);
        }
    }

    public function create()
    {
        $data['role'] = [];
        return view($this->path('create'), $data);
    }

    public function store(RoleRequest $request)
    {
        return $this->role->create($request);
    }

    public function show($id)
    {
        //
    }

    public function edit(Role $role)
    {
        $data['role'] = $role;
        return view($this->path('edit'))->with($data);
    }

    public function update(Role $role, RoleRequest $request)
    {
        return $this->role->update($role->id, $request);
    }

    public function destroy(Role $role)
    {
        return $this->role->delete($role->id);
    }

    public function restore($id)
    {
        return $this->role->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->role->forceDelete($id);
    }

    public function permission(Request $request, $role_id)
    {
        $data['role'] = Role::query()->findOrFail($role_id);
        $data['menus'] = Menu::query()->where('parent_id', null)->where('status', 1)->get();
        $data['user_menu_action'] = UserMenuAction::query()->where('status', 1)->get();

        $data['all_permissions'] = Permission::all()->count();
        $data['permission_groups'] = Permission::all()->groupBy('parent');
        $data['rolePermissions'] = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $role_id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();


        if (count(request()->all()) > 0 && request()->isMethod('POST')) {
            //            dd($data['all_permissions'],request()->all());
            return $this->role->permission($request, $role_id);
        } else {
            return view($this->path('permission'))->with($data);
        }
    }

    public function getRolePermission(Request $request)
    {
        $role_id = $request->role_id;
        $data = [
            'menu_permission' => RoleHasPermission::query()->where('permission_type', 'menu')->where('role_id', $role_id)->pluck('permission_id')->toArray(),
            'menu_action_permission' => RoleHasPermission::query()->where('permission_type', 'menu_action')->where('role_id', $role_id)->pluck('permission_id')->toArray()
        ];

        return $data;
    }

    public function status(Request $request)
    {
        return $this->role->status($request->id);
    }
}
