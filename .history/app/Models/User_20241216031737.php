<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
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
'name', 'email', 'password','status','image',
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
    return $this->belongsToMany(Role::class,'role_user','user_id','role_id',);
}
// User can have many permissions through roles
public function permissions(){
    return $this->hasManyThrough(
        Permission::class, // The target model
        Role::class,       // The intermediate model
        'id',              // Foreign key on the `roles` table (local key in pivot table)
        'id',              // Foreign key on the `permissions` table
        'id',              // Local key on the `users` table
        'id'               // Local key on the `roles` table
    )->join('permission_role', 'permissions.id', '=', 'permission_role.permission_id')
      ->join('role_user', 'roles.id', '=', 'role_user.role_id')
      ->where('role_user.user_id', $this->id)
      ->select('permissions.*');
    //return $this->belongsToMany(Permission::class,'permission_role','role_id','permission_id');
}

// Check if the user has a specific role
public function hasRole($role)
{
    // Get the Names of all roles related to this user
    $roleNames = $this->roles()->pluck('roles.name')->toArray();

    // Check if the role exists in the user's role names
    return in_array($role, $roleNames);
}

// Check if the user has a specific permission
public function hasPermission($permission)
{
    // Get the Names of all permissions related to this user
    $permissionNames = $this->permissions()->pluck('permissions.name')->toArray();

    // Check if the permission exists in the user's permission Names
    return in_array($permission, $permissionNames);
}
}
