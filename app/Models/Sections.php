<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Sections extends Model
{
    use HasFactory;
    //attributes that can be mass assigned
    protected $fillable=[
        'section_name',
        'description',
        'created_by'
    ];
    //define the one to many relationship between the products and the sections:
    //one section has many products :

    public function Products(){
        return $this->hasMany(Products::class);
    }

    //defining a one-to-many relationship between the invoice and the section
    //the section has many invoices belonging to it:
    public function Invoices(){
        return $this->hasMany(Invoices::class);
    }
}
