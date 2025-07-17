<?php

namespace App\Helpers;

use App\Models\AuditTrail;
use Illuminate\Support\Facades\Request;

class AuditHelper
{
    public static function log($event, $userId = null, $model = null, $oldValues = null, $newValues = null)
    {
        AuditTrail::create([
            'user_id' => $userId,
            'event' => $event,
            'auditable_type' => $model ? get_class($model) : null,
            'auditable_id' => $model ? $model->id : null,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
