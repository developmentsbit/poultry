<?php


namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserRepository extends BaseRepository implements UserInterface
{
    protected $model;
    protected array $log_context;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->log_context = [
            'module' => 'Role Repository',
            'logger' => 'Farhan',
            'time' => date('Y-m-d H:i:s')
        ];
        parent::__construct($model);
    }

    public function sync_role($id, UserRequest $request)
    {
        try {
            $user = User::query()->find($id);
            $roles = Role::query()->where('id', $request->role_id)->get();
            $user->syncRoles($roles);
            DB::commit();
            return redirect(route($this->getModelNameLower() . '.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: ' . __METHOD__ . ' Exception:' . $e->getMessage(), $this->log_context);
            return back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function send_email_with_credentials($id, $data)
    {
        try {
            $user = User::query()->find($id);
            $user->SendWelcomeEmail($data);
            DB::commit();
            return redirect(route($this->getModelNameLower() . '.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: ' . __METHOD__ . ' Exception:' . $e->getMessage(), $this->log_context);
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    /*public function permissionUpdate(object $data, $id)
    {
    $user = User::findOrFail($id);
    $last_id = UserPermission::max('id');
    if($last_id){
    \DB::statement("ALTER TABLE user_permissions AUTO_INCREMENT =  $last_id");
    }else{
    \DB::statement("ALTER TABLE user_permissions AUTO_INCREMENT =  1");
    }
    if($data->permission_as_role){
    $this->permissionUpdateFromRole($user);
    $user->update([
    'permission_as_role' => 'Yes'
    ]);
    }else{
    $this->permissionUpdateFromInput($user,$data->all());
    $user->update([
    'permission_as_role' => 'No'
    ]);
    }
    \Toastr::success('User Permission Updated', 'Success');
    return redirect(route('user.index'));
    }
    public function permissionUpdateFromRole($user){
    UserPermission::where('user_id',$user->id)->delete();
    $role_permissions = RolePermission::where('role_id',$user->role_id)->get();
    foreach ($role_permissions as $permission){
    $user_permission = new UserPermission();
    $user_permission->user_id = $user->id;
    $user_permission->permission_id = $permission->permission_id;
    $user_permission->route_name = $permission->route_name;
    $user_permission->permission_type = $permission->permission_type;
    $user_permission->save();
    }
    }
    public function permissionUpdateFromInput($user,$data){
    UserPermission::where('user_id',$user->id)->delete();
    if($data['menu_id']) {
    $countMenu = count($data['menu_id']);
    for ($i = 0; $i < $countMenu; $i++) {
    $menu = Menu::findOrFail($data['menu_id'][$i]);
    $user_permission = new UserPermission();
    $user_permission->user_id = $user->id;
    $user_permission->permission_id = $data['menu_id'][$i];
    $user_permission->route_name = $menu->route_name;
    $user_permission->permission_type = 'menu';
    $user_permission->save();
    }
    }
    if($data['user_menu_action_id']) {
    $countUserMenuAction = count($data['user_menu_action_id']);
    for ($j = 0; $j < $countUserMenuAction; $j++) {
    $user_menu_action = UserMenuAction::findOrFail($data['user_menu_action_id'][$j]);
    $user_permission = new UserPermission();
    $user_permission->user_id = $user->id;
    $user_permission->permission_id = $data['user_menu_action_id'][$j];
    $user_permission->route_name = $user_menu_action->route_name;
    $user_permission->permission_type = 'menu_action';
    $user_permission->save();
    }
    }
    }*/

    public function profileUpdate(ProfileRequest $data, $id)
    {
        $user = User::find($id);
        try {
            if ($data->password) {
                $data->request->add(['password' => bcrypt($data->password)]);
                $user->update($data->all());
            } else {
                $user->update($data->except('password'));
            }

            Toastr::success('Profile Updated', 'Success');
            return back();
        } catch (\Exception $e) {
            Log::error('Method: ' . __METHOD__ . ' Exception:' . $e->getMessage(), $this->log_context);
            return back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function changePassword(ChangePasswordRequest $data, $id)
    {
        $user = User::find($id);
        try {
            if (!Hash::check($data->current_password, $user->password)) {
                return back()->withInput()->withErrors('Current Password Wrong');
            }

            if ($data->password) {
                $user->update([
                    'password' => Hash::make($data->password)
                ]);
            } else {
                return back()->withInput()->withErrors('Password not found');
            }

            \Toastr::success('Password Updated', 'Success');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: ' . __METHOD__ . ' Exception:' . $e->getMessage(), $this->log_context);
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

}