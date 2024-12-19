<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sections;

class Products extends Model
{
    use HasFactory;
    protected $fillable=[
        'product_name',
        'description',
        'section_id',

    ];

    //define the one to many relationship between the products and the sections:
    //one product belongs to one section
    public function Section(){
        return $this->belongsTo(Sections::class);
    }
}
