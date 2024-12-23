<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    //a permission can belong to more than one role
    public function roles(){
        $this->belongsToMany(Role::class,'role_permission');
    }
}
