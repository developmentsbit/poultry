<?php

namespace App\Helpers;

use App\Models\Menu;
use App\Models\UserMenuAction;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuHelper
{
    public static function Menu()
    {
        //$menu_permission = UserPermission::query()->where('permission_type','menu')->where('user_id',auth()->user()->id)->pluck('permission_id')->toArray();
        /*if(!@$menu_permission){
        $menu_permission = RolePermission::where('permission_type','menu')->where('role_id',auth()->user()->role_id)->pluck('permission_id')->toArray();
        }*/
        if (Schema::hasTable('menus')) {
            $menu_list = Menu::with([
                'children' => function ($q) /*use($menu_permission)*/{
                    $q->where('status', '=', 1);
                    /*$q->whereIn('id', $menu_permission);*/

                }
            ])
                ->where('parent_id', NULL)
                ->where('status', 1)
                /*->whereIn('id',$menu_permission)*/
                ->where('is_hidden', 'No')
                ->orderBy('order_by', 'asc')
                ->get();
            return $menu_list;
        } else {
            return [];
        }

    }

    public static function MenuElement($menu, $segment = '')
    {
        $role_permissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();
        $show = false;

        $data['active_class'] = false;
        if ((str_replace('-', '_', $segment) == explode('.', $menu->route_name)[0] && (str_replace('-', '_', $segment) != null))) {
            $data['active_class'] = true;
        }

        $data['parent_active_class'] = false;
        if (count($menu->children) > 0) {
            $menu_link = '';
            $has_arrow = 'has-arrow ';

            foreach ($menu->children as $child) {
                // check if menu should be active as parent
                if ((str_replace('-', '_', $segment) == explode('.', $child->route_name)[0] && (str_replace('-', '_', $segment) != null))) {
                    $data['parent_active_class'] = true;
                }

                if (Permission::query()->where('name', ucfirst($child->system_name) . ' List')->first()) {
                    if (in_array(ucfirst($child->system_name) . ' List', $role_permissions)) {
                        $show = true;
                    }
                } elseif (Permission::query()->where('name', ucfirst($child->system_name))->first()) {
                    if (in_array(ucfirst($child->system_name), $role_permissions)) {
                        $show = true;
                    }
                }
            }

        } else {
            if (Permission::query()->where('name', ucfirst($menu->system_name) . ' List')->first()) {
                if (in_array(ucfirst($menu->system_name) . ' List', $role_permissions)) {
                    $show = true;
                }
            } elseif (Permission::query()->where('name', ucfirst($menu->system_name))->first()) {
                if (in_array(ucfirst($menu->system_name), $role_permissions)) {
                    $show = true;
                }
            }

            if ($menu->route_name) {
                if (!Route::has($menu->route_name)) {
                    $menu_link = '#';
                } else {
                    $menu_link = route($menu->route_name);
                }
            } else {
                $menu_link = '#';
            }

            $has_arrow = '';
        }

        if ($menu->icon) {
            $menu_icon = $menu->icon;
        } else {
            $menu_icon = 'uil-layer-group';
        }

        $data['menu_link'] = $menu_link;
        $data['has_arrow'] = $has_arrow;
        $data['menu_icon'] = $menu_icon;
        $data['show'] = $show;

        return $data;
    }

    public static function menuName($menu)
    {
        if (App::isLocale('bn')) {
            return $menu->bn_name;
        } else {
            return $menu->name;
        }
    }

    public static function TableActionButton(array $action_array = null)
    {
        $id = $action_array['id'];
        $subject = @$action_array['subject'];
        $status = @$action_array['status'] ? $action_array['status'] : null;
        $action_type = @$action_array['action_type'] ? $action_array['action_type'] : null;

        $url_param = '';
        if (request('status')) {
            $url_param .= '&status=' . request('status');
        }
        if (request('type')) {
            $url_param .= '&type=' . request('type');
        }

        $routeName = Route::currentRouteName();
        //if any index route match in user menu action table
        $user_menu_action = UserMenuAction::query()
            ->where('status', '=', 1)
            ->where('route_name', $routeName)->first();

        if (@$user_menu_action) {
            $role_permissions = auth()->user()->getAllPermissions()->toQuery()->where('name', 'like', "%{$user_menu_action->menu->system_name}%")->pluck('name');

            $permission_action_names = [];
            foreach ($role_permissions as $role_permission) {
                $permission_action_names[] = explode($user_menu_action->menu->system_name . ' ', $role_permission)[1];
            }

            $get_user_menu_actions = UserMenuAction::query()->where('show_in_table', '=', 1)
                ->where('status', '=', 1)
                ->where('parent_id', $user_menu_action->id)
                ->whereIn('system_name', $permission_action_names)
                ->orderBy('order_by', 'asc')
                ->get();
        }

        if (@$user_menu_action && $get_user_menu_actions) {
            $user_menu_actions = $get_user_menu_actions;
        } else {

            $menu = Menu::with(
                [
                    'userMenuAction' => function ($query) use ($action_type) {
                        $query->where('show_in_table', '=', 1);
                        $query->where('status', '=', 1);
                        $query->where('parent_id', null);
                        if ($action_type) {
                            $query->where('type', $action_type);
                        }
                    },
                    'userMenuAction.menuAction'
                ]
            )->where('route_name', $routeName)->first();

            $role_permissions = auth()->user()->getAllPermissions()->toQuery()->where('name', 'like', "%{$menu->name}%")->pluck('name');

            $permission_action_names = [];
            foreach ($role_permissions as $role_permission) {
                $permission_action_names[] = explode($menu->system_name . ' ', $role_permission)[1];
            }

            $user_menu_actions = $menu->userMenuAction->toQuery()->whereIn('system_name', $permission_action_names)->get();
        }

        $button = '';
        if (count($user_menu_actions) > 0) {
            foreach ($user_menu_actions as $action) {
                if ($action->route_name) {
                    $link = route($action->route_name, [$id, $url_param]);
                    $route = $action->route_name;
                } else {
                    $link = 'javascript:';
                    $route = ':';
                }
                if ($action->class) {
                    $action_class = ' ' . $action->class;
                } else {
                    $action_class = '';
                }
                if ($action->menuAction->button_class) {
                    $button_class = $action->menuAction->button_class . $action_class;
                } else {
                    $button_class = 'btn btn-primary btn-sm' . $action_class;
                }
                if ($action->menuAction->icon) {
                    $icon_class = $action->menuAction->icon;
                    $button_name = '';
                } else {
                    $icon_class = 'fas fa-radiation';
                    $button_name = $action->system_name;
                }

                if ($action->new_tab == 1) {
                    $target = 'target=_blank';
                } else {
                    $target = '';
                }

                if ($action->slug == 'edit_history') {
                    $button .=
                        '<a
                    href="javascript:"
                    class="' . $button_class . ' mb-1"
                    data-bs-toggle="modal"
                    data-bs-target="#edit_history' . $id . '"
                    data-id="' . $id . '">
                    <i class="' . $icon_class . '"></i> ' . $button_name . '
                </a>' . view('admin.layouts.edit_history', [
                            'model' => Activity::query()
                                ->with('causer')
                                ->whereNotNull('causer_id')
                                ->where('subject_type', get_class($subject))
                                ->where('subject_id', $id)
                                ->get(),
                            'id' => $id
                        ]);

                } else {
                    $button .=
                        '<a class="' . $button_class . ' mb-1"
                    href="' . $link . '"
                    data-id="' . $id . '"
                    data-route="' . $route . '"
                    data-status="' . $status . '"
                    ' . $target . ' /*data-toggle="tooltip" data-placement="top"*/ title="' . $action->name . '">
                    <i class="' . $icon_class . '"></i> ' . $button_name . '
                </a>';
                }
            }
        }
        return $button;

    }

    public static function CustomElementPermission($slug)
    {
        $routeName = Route::currentRouteName();
        $menu = Menu::query()->where('status', 1)->where('route_name', $routeName)->first();
        $user_menu_action = UserMenuAction::query()->where('status', 1)->where('menu_id', $menu->id)->where('slug', $slug)->first();
        if (@$user_menu_action) {
            $permission = UserPermission::query()->where('user_id', auth()->user()->id)->where('permission_type', 'menu_action')->where('permission_id', $user_menu_action->id)->first();
            /*if(!@$permission){
            $permission = RolePermission::where('role_id',auth()->user()->role_id)->where('permission_type','menu_action')->where('permission_id',$user_menu_action->id)->first();
            }*/

            if (@$permission) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function status($id = null, $status = null)
    {

        $data_status = '';
        if ($status === 'Active' || $status == 1) {
            $checked = 'checked';
        } else {
            $checked = '';
        }

        $data_status .= '<div class="form-check form-switch form-switch-md status_' . $id . '" dir="ltr">
                            <input class="form-check-input" type="checkbox" onchange="statusChange(' . $id . ')" ' . $checked . '>
                        </div>';

        return $data_status;
    }
}
