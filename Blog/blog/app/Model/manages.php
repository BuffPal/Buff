<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class manages extends Model
{
    protected $fillable= array('account','password','username','registertimet','logintime','order');
}
