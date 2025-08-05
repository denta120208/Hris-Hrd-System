<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model{
    public $timestamps = false;
    protected $table = 'MH_NOTIFICATION_TYPE';

    protected $fillable = ['NOTIFICATION_TYPE_ID',
        'NOTIFICATION_TYPE_NAME'
    ];
}