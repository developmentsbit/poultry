<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\MenuAction;
use App\Models\Permission;
use App\Models\Role;
use App\Models\UserMenuAction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class MenuController extends Controller
{
    protected $menu;
    protected $model;
    protected $trans;
    protected $deleted_relation;
    protected array $log_context;

    public function __construct($trans = null)
    {
        $this->deleted_relation = ['userMenuAction'];
        $this->middleware('auth');
        $this->trans = $trans;
        $this->log_context = [
            'module' => 'Base Repository',
            'logger' => 'Farhan',
            'time' => date('Y-m-d H:i:s')
        ];
    }

    protected function path(string $blade)
    {
        return "menu.{$blade}";
    }

    public function index()
    {

        $data['page_title'] = 'Menu';
        $data['menus'] = Menu::query()->with('parent', 'children')->get();

        return view($this->path('index'))->with($data);
    }

    public function deletedListIndex()
    {
        $data['menus'] = Menu::onlyTrashed()->with('parent', 'children')->get();

        return view($this->path('index'))->with($data);
    }

    public function create()
    {
        $data['page_title'] = 'Menu Create';
        $data['menus'] = Menu::query()->whereNull('parent_id')->pluck('name', 'id');
        $data['roles'] = Role::query()->pluck('name', 'id');
        $actions_array_to_ignore = ['permission', 'order', 'check', 'restore', 'custom_element'];
        $data['actions'] = MenuAction::query()->whereNotIn('slug', $actions_array_to_ignore)->get();
        return view($this->path('create'))->with($data);
    }

    public function store(MenuRequest $request)
    {
        try {
            // update other order_by values
            if ($request->parent_id) {
                $menus = Menu::query()->where('parent_id', $request->parent_id)->where('order_by', '>=', $request->order_by)->get();
                foreach ($menus as $menu) {
                    $menu->order_by++;
                    $menu->save();
                }
            } else {
                $menus = Menu::query()->whereNull('parent_id')->where('order_by', '>=', $request->order_by)->get();
                foreach ($menus as $menu) {
                    $menu->order_by++;
                    $menu->save();
                }
            }

            $menu = Menu::query()->create($request->all());

            if (@$request->menu_type == 'Module') {
                if (@$request->create_permissions == 'Yes') {
                    Permission::query()->create(['name' => ucfirst($request->system_name) . ' List', 'parent' => ucfirst($request->system_name)]);
                }

                $parent_id = '';
                if (@$request->actions != null) {
                    // create related permissions
                    foreach ($request->actions as $action => $value) {
                        if (@$request->create_permissions == 'Yes') {
                            Permission::query()->create(['name' => ucfirst($request->system_name) . ' ' . ucfirst($action), 'parent' => ucfirst($request->system_name)]);
                        }
                        $user_menu_action = $this->actionBuilder($action, $menu->id, $menu->route_name);
                        $user_menu_action->save();
                        if ($action == 'deleted_list') {
                            $parent_id = $user_menu_action->id;
                        } elseif ($action == 'restore' || $action == 'permanent_delete') {
                            $user_menu_action->update(['parent_id' => $parent_id]);
                        }
                    }
                }

                $menu->update(['route_name' => $menu->route_name . (@$request->create_permissions == 'Yes' ? '.index' : '')]);
            } elseif (@$request->menu_type == 'Single') {
                Permission::query()->create(['name' => ucfirst($request->name), 'parent' => ucfirst($request->system_name)]);
            }

            Toastr::success('Menu Created', 'Success');
            return redirect(route('menu.index'));
        } catch (\Exception $e) {
            Log::error('Method: ' . __METHOD__ . ' Exception:' . $e->getMessage(), $this->log_context);
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(Menu $menu)
    {
        //
    }

    public function edit(Menu $menu)
    {
        $data['menu'] = $menu;
        $data['menus'] = Menu::query()->whereNot('id', $menu->id)->pluck('name', 'id');
        $data['roles'] = Role::query()->pluck('name', 'id');
        $actions_array_to_ignore = ['permission', 'order', 'check', 'restore', 'custom_element'];

        foreach ($menu->userMenuAction as $action) {
            if ($action->slug != null) {
                array_push($actions_array_to_ignore, $action->slug);
            }
        }

        $data['actions'] = MenuAction::query()->whereNotIn('slug', $actions_array_to_ignore)->get();
        return view($this->path('edit'))->with($data);
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        try {
            $menu = Menu::query()->find($menu->id);
            $menu->update($request->all());
            // update child menu-actions if present otherwise create new
            if (@$request->actions != null) {
                foreach ($request->actions as $action => $value) {
                    $user_menu_action = $this->actionBuilder($action, $menu->id, $menu->route_name);
                    $user_menu_action->save();
                    if ($action == 'deleted_list') {
                        $parent_id = $user_menu_action->id;
                    } elseif ($action == 'restore' || $action == 'permanent_delete') {
                        $user_menu_action->update(['parent_id' => $parent_id]);
                    }
                }
            }

            Toastr::success('Menu Updated', 'Success');
            return redirect(route('menu.index'));
        } catch (\Exception $e) {
            Log::error('Method: ' . __METHOD__ . ' Exception:' . $e->getMessage(), $this->log_context);
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Menu $menu)
    {

        // return $this->menu->delete($menu->id);
        DB::beginTransaction();
        try {
            $data = Menu::find($menu->id);
            $data->deleted_by = Auth::id();
            $data->save();

            $relations = ['children', 'userMenuAction'];

            if (@$relations != null && strpos($data->route_name, '.index')) {
                foreach ($data->userMenuAction as $action) {
                    Permission::query()->where('name', $data->system_name . ' ' . $action->name)->forceDelete();
                }
                foreach ($relations as $relation) {
                    $data->$relation()->forceDelete();
                }
            }

            Permission::query()
                ->where('name', $menu->system_name)
                ->orWhere('name', $menu->system_name . ' List')
                ->forceDelete();

            $data->forceDelete($menu->id);

            DB::commit();
            return response()->json([
                'message' => trans('common.deleted', ['model' => $this->getTranslateKey()])
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Method: ' . __METHOD__ . ' Exception:' . $e->getMessage(), $this->log_context);
            return back()->withInput()->withErrors($e->getMessage());
        }

    }

    public function restore($id)
    {
        return $this->menu->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->menu->forceDelete($id);
    }

    public function status(Request $request)
    {
        return $this->menu->status($request->id);
    }

    public function multipleDelete(Request $request)
    {
        return $this->menu->multipleDelete($request);
    }

    public function multipleRestore(Request $request)
    {
        return $this->menu->multipleRestore($request);
    }

    private function getTranslateKey()
    {
        $routeName = explode('.', Route::currentRouteName());
        /*$menu = Menu::where('route_name',$routeName[0].".index")->first();
        if($this->trans){
        return $this->trans;
        }elseif (@$menu){
        return $menu->bn_name;
        }*/
    }

    private function actionBuilder($action, $menu_id, $route = null)
    {
        if ($action == 'create') {
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 1,
                'name' => 'Create',
                'system_name' => 'Create',
                'route_name' => $route ? explode('.', $route)[0] . '.create' : null,
                'type' => 'action',
                'order_by' => 1,
                'is_hidden' => 'No',
                'show_in_table' => 0,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'edit') {
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 2,
                'name' => 'Edit',
                'system_name' => 'Edit',
                'route_name' => $route ? explode('.', $route)[0] . '.edit' : null,
                'type' => 'action',
                'order_by' => 2,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'delete') {
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 3,
                'name' => 'Delete',
                'system_name' => 'Delete',
                'route_name' => $route ? explode('.', $route)[0] . '.destroy' : null,
                'type' => 'action',
                'order_by' => 4,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'view') {
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 4,
                'name' => 'View',
                'system_name' => 'View',
                'route_name' => $route ? explode('.', $route)[0] . '.show' : null,
                'type' => 'action',
                'order_by' => 3,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'print') {
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 8,
                'name' => 'Print',
                'system_name' => 'Print',
                'route_name' => $route ? explode('.', $route)[0] . '.print' : null,
                'type' => 'action',
                'order_by' => 5,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 1,
                'status' => 1,
            ]);
        } elseif ($action == 'deleted_list') {
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'name' => 'Trash',
                'system_name' => 'Trash',
                'route_name' => $route ? explode('.', $route)[0] . '.deleted_list' : null,
                'type' => 'tab',
                'slug' => 'deleted_list',
                'order_by' => 6,
                'is_hidden' => 'No',
                'show_in_table' => 0,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'restore') {
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 9,
                'name' => 'Restore',
                'system_name' => 'Restore',
                'route_name' => $route ? explode('.', $route)[0] . '.restore' : null,
                'type' => 'action',
                'slug' => 'restore',
                'order_by' => 7,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'permanent_delete') {
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 3,
                'name' => 'Delete Permanently',
                'system_name' => 'Delete Permanently',
                'route_name' => $route ? explode('.', $route)[0] . '.force_destroy' : null,
                'type' => 'action',
                'slug' => 'force_destroy',
                'order_by' => 8,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'edit_history') {
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 10,
                'name' => 'Edit History',
                'system_name' => 'Edit History',
                'route_name' => $route ? explode('.', $route)[0] . '.edit_history' : null,
                'type' => 'action',
                'slug' => 'edit_history',
                'order_by' => 9,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        }
    }
}
