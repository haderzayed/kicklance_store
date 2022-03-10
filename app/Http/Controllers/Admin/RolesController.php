<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class RolesController extends Controller
{
    public function __construct(){

        $this->authorizeResource(Role::class,'role');
    }
    public function index()
    {
        $roles=Role::all();
       $permission=RolePermission::pluck('permission');
       return view('admin.roles.index',compact('roles','permission'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['name' => 'required']
        );
        if ($validator->fails()){
            $errors = $validator->errors();
            return Response::json($errors,400);

        }


        $role = new Role();
        $role->name = $request->name;
        $role->save();
        $permissions=json_decode($request->post('permissions'), true);
        foreach ($permissions as $permission){
            $role->permissions()->create([
                'permission'=>$permission
            ]);
        }
        return Response::json($role);

    }


    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(),
            ['name' => 'required']
        );
        if ($validator->fails()){
            $errors = $validator->errors()->all();
            return Response::json($errors,400);
        }
        $role->update($request->all());
        $role->permissions()->delete();
        $permissions=json_decode($request->post('permissions'), true);
        foreach ($permissions as $permission){
            $role->permissions()->create([
               'permission'=>$permission
            ]);
        }
        return Response::json($role);
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return Response::json($role);
    }
}
