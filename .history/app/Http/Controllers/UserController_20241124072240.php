<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){
        $data=User::orderBy('id','DESC')->paginate(5);
        return view('users.show_users',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(){
        $roles=Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    public function store(Request $request){
        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'roles_name' => 'required'
            ]
            );
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            //create new user
            $user = User::create($input);
            //assign role to user
            $user->assignRole($request->input('roles_name'));
    }
}
