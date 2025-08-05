<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model{
    public $timestamps = false;
    protected $table = 'MH_NOTIFICATION';

    protected $fillable = ['MH_NOTIFICATION_ID',
        'EMP_NUMBER',
        'EMPLOYEE_ID',
        'NOTIFICATION_TITLE',
        'NOTIFICATION_DESC',
        'IS_READ',
        'IS_DELETED',
        'CREATED_AT',
        'NOTIFICATION_STATUS_ID',
        'NOTIFICATION_TYPE_ID',
        'MODULE_ID'
    ];
    public function notif_status(){
        return $this->belongsTo('App\Models\Notifications\NotificationStatus', 'NOTIFICATION_STATUS_ID', 'NOTIFICATION_STATUS_ID');
    }
    public function notif_type(){
        return $this->belongsTo('App\Models\Notifications\NotificationType', 'NOTIFICATION_TYPE_ID', 'NOTIFICATION_TYPE_ID');
    }
}
