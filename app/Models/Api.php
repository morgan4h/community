<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;

    // Add this line to disable automatic timestamps
    public $timestamps = false;

    protected $fillable = [
        'name',
        'api',
        'category',
    ];
}