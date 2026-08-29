<?php

namespace App\Models;

use Illuminate\Database\Lookup\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    
    // 👇 ADD THIS LINE to tell Laravel your custom primary key name
    protected $primaryKey = 'notification_id';

    public $timestamps = false;

    protected $fillable = [
        'notification_name',
        'notification_attr',
        'notification_description'
    ];
}