<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

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
        //dd($request);
        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'status'=>'nullable',
                'roles' => 'array',
                'image'=>'required|mimes:png,jpg,jpeg,pdf'
            ]
            );
            $uploadPath = public_path('images');
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $request->image->extension();
                $image->move($uploadPath, $imageName);
            }
            //create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'image' => $imageName, // Save the image name to the database
            ]);
            if($request->status){
                $user->status=$request->status;
            }
             //assign role/s to user
             if($request->has('roles')){
                $user->roles()->sync($request->input('roles'));
            }else{
                dd('cannot add roles to user');
            }

            return redirect()->route('users.index')
            ->with('success','User Added Successfully');
    }

    public function show($id){
        $user=User::findOrFail($id);
        $userRoles=Role::join('role_user','role_user.role_id','=','roles.id')
        ->where('role_user.user_id',$id)->get();
        return view('users.show',compact('user','userRoles'));
    }

    public function edit($id){
        $user=User::findOrFail($id);
        $roles=Role::all();
        //get the user roles ids from role_user table where user_id=$id
        $userRoles = DB::table("role_user")->where("role_user.user_id",$id)
->pluck('role_user.role_id','role_user.role_id')
->all();
        return view('users.edit',compact('user','roles','userRoles'));
    }

    public function update(Request $request,$id){
        //dd($request);
        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'required|same:confirm-password',
                'status'=>'required',
                'roles' => 'array',
                'image'=>'mimes:png,jpg,jpeg,pdf',
            ]
            );
            $user=User::findOrFail($id);
            //delete old image first
            if(File::exists(public_path('images/'.$user->image))){
                File::delete(public_path('images/'.$user->image));
            }else{
                return redirect('users.edit')->with('update','No Image' );
            }
            //add the new image
            $uploadPath = public_path('images');
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $request->image->extension();
                $image->move($uploadPath, $imageName);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status'=>$request->status,
                'image'=>$imageName,
            ]);
            //assign role/s to user
            if($request->has('roles')){
                $user->roles()->sync($request->input('roles'));

            }
            return redirect()->route('users.index')
            ->with('success','User Updated Successfully');
    }

    public function destroy(Request $request){
        $user=User::find($request->user_id);
        $user->delete();
        return redirect()->route('users.index')
            ->with('success','User Deleted Successfully');
    }
}
