<?php

namespace  App\Models;

use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    protected $fillable = [
        'name',
    ];
    public $timestamps = true;
}
