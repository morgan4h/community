<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    public $timestamps = false;

    protected $fillable = [
        'notification_name',
        'notification_attr',
        'notification_description'
    ];
}