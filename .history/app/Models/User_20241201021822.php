<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{

    use Notifiable;

/**
* The attributes that are mass assignable.
*
* @var array
*/
protected $fillable = [
'name', 'email', 'password','status'
];
/**
* The attributes that should be hidden for arrays.
*
* @var array
*/
protected $hidden = [
'password', 'remember_token',
];
/**
* The attributes that should be cast to native types.
*
* @var array
*/
protected $casts = [
'email_verified_at' => 'datetime',
//the user can have an array of roles(cast roles_name to array datatype)
'roles_name'=>'array',
];

//a user can have many roles
public function roles(){
    $this->belongsToMany(Role::class);
}
// User can have many permissions through roles
public function permissions(){
    $this->belongsToMany(Permission::class,'permission_role','user_id','permission_id');
}

// Check if the user has a specific role
public function hasRole($role)
{
    return $this->roles->contains('name', $role);
}

// Check if the user has a specific permission
public function can($permission)
{
    return $this->permissions->contains('name', $permission);
}
}
