<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded=[];

    //defining a one-to-many relationship between the invoice and the section
    //the invoice belongs to a specific section:
    public function Section(){
        return $this->belongsTo(Sections::class);
    }        
}
