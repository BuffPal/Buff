<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class navs extends Model
{
    protected $fillable= array('name','ename','url','order');
}
