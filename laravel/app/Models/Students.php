<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    // specific data
    // protected $fillable = ['first_name', 'last_name', 'age']

    protected $guarded = [];
    
    use HasFactory;
}
