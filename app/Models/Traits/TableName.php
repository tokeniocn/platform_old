<?php

namespace App\Models\Traits;

trait TableName
{
    public static function table()
    {
        static $model = null;
        if ($model === null) {
            $model = new static;
        }
        return $model->getTable();
    }
}
