<?php

namespace App\Http\Controllers;

use App\Traits\RolePermissionTrait;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{

    public $page_title;
    public $page_description;

    public function __construct($title = 'Permission', $description = 'User Permission')
    {
        $this->middleware('auth');
        $this->page_title = $title;
        $this->page_description = $description;

        $this->middleware(function ($request, $next) {

            if (Auth::user()->role_id != 1){
                return response()->view("page.error403");
            }

            return $next($request);
        });
    }

    protected function path(string $link)
    {
        return "permission.{$link}";
        /*if (RolePermissionTrait::checkRoleHasPermission('Permission',$link)){
            return "backend.permission.{$link}";
        } else {
            return response()->view("page.error403");
        }*/
    }

    public function index()
    {
        $data = [
            'page_title' => $this->page_title.' List',
            'page_description' => $this->page_description,
            'permissions' => Permission::query()->get()
        ];

        return view($this->path('index'))->with($data);
    }

    public function create()
    {
        $data = [
            'page_title' => $this->page_title.' Create',
            'page_description' => $this->page_description,
        ];

        return view($this->path('create'),$data);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Permission::query()->create($data);

        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit(Permission $permission)
    {
        $data = [
            'page_title' => $this->page_title.' Edit',
            'page_description' => $this->page_description,
            'permission' => $permission,
        ];

        return view($this->path('edit'),$data);
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->all();
        $permission->update($data);

        return back();
    }

    public function destroy(Permission $permission)
    {
        $permission->deleted_by = Auth::id();
        $permission->save();
        $permission->delete();

        return redirect()->route('permission.index')->with('success','Permission Deleted Successfully');
    }

}
