<?php


namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Models\RoleHasPermission;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use App\Models\Role;


class RoleRepository extends BaseRepository implements RoleInterface
{
    protected $model;
    protected array $log_context;

    public function __construct(Role $model)
    {
        $this->model = $model;
        $this->log_context = [
            'module' => 'Role Repository',
            'logger' => 'Farhan',
            'time' => date('Y-m-d H:i:s')
        ];
        parent::__construct($model);
    }

    public function permission(Request $request, $role_id)
    {
        DB::beginTransaction();

        try {
            RoleHasPermission::query()->where('role_id',$role_id)->delete();

            $role = Role::query()->find($role_id);

            if ($request->checkAll == 'on'){
                $role->syncPermissions(Permission::all());
            } else {
                $role->syncPermissions(Permission::query()->whereIn('id',$request->permission)->get());
            }

//            $users = User::query()->where('role_id',$role_id)->where('permission_as_role','Yes')->get();
//            $this->permissionUpdateFroUser($users);

            Toastr::success('Role Permissions Updated', 'Success');
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: permission Exception:' . $e->getMessage(), $this->log_context);
            return back()->withInput()->withErrors($e->getMessage());
        }
        return redirect(route('role.index'));
    }

    /*public function permissionUpdateFroUser($users){
        foreach ($users as $user){
            ModelHasPermission::query()->where('user_id',$user->id)->delete();
            $role_permissions = RoleHasPermission::query()->where('role_id',$user->role_id)->get();
            foreach ($role_permissions as $permission){
                $user_permission = new ModelHasPermission();
                $user_permission->user_id = $user->id;
                $user_permission->permission_id = $permission->permission_id;
                $user_permission->route_name = $permission->route_name;
                $user_permission->permission_type = $permission->permission_type;
                $user_permission->save();
            }
        }
    }*/

}
