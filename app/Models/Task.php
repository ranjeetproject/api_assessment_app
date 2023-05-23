<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Task extends Model
{
    use HasFactory,SoftDeletes;

   
    protected $fillable = ['name','description','image','type'];
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

}