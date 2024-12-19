<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){
        $data=User::orderBy('id','DESC')->paginate(5);
        return view('users.show_users',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(){
        $roles=Role::all();
        return view('users.create',compact('roles'));
    }

    public function store(Request $request){
        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'status'=>'required',
                'roles' => 'array'
            ]
            );
            //create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status'=>$request->status,
            ]);
            //assign role/s to user
            if($request->has('roles')){
                $user->roles()->sync($request->input('roles'));

            }
            return redirect()->route('users.index')
            ->with('success','User Added Successfully');
    }

    public function edit($id){
        $user=User::find($id);
        $roles=Role::all();
        $userRoles=$user->roles()->get();
        return view('users.edit',compact('user','roles','userRoles'));
    }

    public function update(Request $request,$id){
        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'password' => 'required|same:confirm-password',
                'status'=>'required',
                'roles' => 'array'
            ]
            );
            $user=User::find($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status'=>$request->status,
            ]);
            //assign role/s to user
            if($request->has('roles')){
                $user->roles()->sync($request->input('roles'));

            }
            return redirect()->route('users.index')
            ->with('success','User Updated Successfully');
    }
}
