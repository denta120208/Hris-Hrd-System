<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;

class NotificationStatus extends Model{
    public $timestamps = false;
    protected $table = 'MH_NOTIFICATION_STATUS';

    protected $fillable = ['NOTIFICATION_STATUS_ID','NOTIFICATION_STATUS_DESC','PAGE_ROUTE','TYPE'];
}
