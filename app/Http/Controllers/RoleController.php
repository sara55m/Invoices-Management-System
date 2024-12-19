<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/

//protect the controller methods to prevent users from accessing views that they do not have permission for:
function __construct()
{

$this->middleware('permission:Show Authority', ['only' => ['index']]);
$this->middleware('permission:Add Authority', ['only' => ['create','store']]);
$this->middleware('permission:Edit Authority', ['only' => ['edit','update']]);
$this->middleware('permission:Delete Authority', ['only' => ['destroy']]);

}

/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
$roles = Role::orderBy('id','DESC')->paginate(5);
return view('roles.index',compact('roles'))
->with('i', ($request->input('page', 1) - 1) * 5);
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
    $permissions = Permission::all();
    return view('roles.create',compact('permissions'));
}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
$this->validate($request, [
'name' => 'required|unique:roles,name',
'permissions' => 'array',
]);
$role = Role::create(['name' => $request->input('name')]);
$permissions = $request->input('permissions');
//make sure that permission names are returned not their ids
//$permissions = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
$role->permissions()->sync($permissions);
return redirect()->route('roles.index')
->with('success','Role created successfully');
//dd($request);
}
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
$role = Role::find($id);
$rolePermissions = Permission::join("permission_role","permission_role.permission_id","=","permissions.id")
->where("permission_role.role_id",$id)
->get();
return view('roles.show',compact('role','rolePermissions'));
}
/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
    //fetch the role to edit
$role = Role::find($id);
//fetch all permissions from permissions table
$permissions = Permission::get();
//fetch the permissions for this role from the pivot table permission_role
$rolePermissions = DB::table("permission_role")->where("permission_role.role_id",$id)
->pluck('permission_role.permission_id','permission_role.permission_id')
->all();
return view('roles.edit',compact('role','permissions','rolePermissions'));
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{
$this->validate($request, [
'name' => 'required',
'permissions' => 'array',
]);
$role = Role::find($id);
$role->name = $request->input('name');
$role->save();
$permissions = $request->input('permissions');
//make sure that permission names are returned not their ids
//$permissions = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
$role->permissions()->sync($permissions);
return redirect()->route('roles.index')
->with('success','Role updated successfully');
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
    //dd($id);
DB::table("roles")->where('id',$id)->delete();
return redirect()->route('roles.index')
->with('success','Role deleted successfully');
}
}
