<?php

namespace App\Models;


class Media extends \Plank\Mediable\Media
{
    protected $appends = [
        'path',
        'url',
    ];

    public function getUrlAttribute()
    {
        return $this->getUrl();
    }

    public function getPathAttribute()
    {
        return $this->getDiskPath();
    }
}
