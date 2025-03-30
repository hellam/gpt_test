<?php

namespace App\Helpers;

use App\Models\InternalAlert;

class AlertHelper
{
    public static function log($type, $message, $model = null, $modelId = null, $source = 'system')
    {
        InternalAlert::create([
            'type' => $type, // info, warning, critical
            'source' => $source,
            'message' => $message,
            'model' => $model,
            'model_id' => $modelId,
        ]);
    }
}
