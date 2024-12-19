<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    //a role can be assigned to many users
    public function users(){
        $this->belongsToMany(User::class);
    }
    //a role can have many permissions
    public function permissions(){
        $this->belongsToMany(Permission::class,'permission_role');
    }
}
