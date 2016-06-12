<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class configs extends Model
{
    protected $fillable= array('title','name','content','order','tips','type','value');
}
