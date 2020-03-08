<?php

namespace App\Config;

use App\Config\Traits\SettingStore;
use Illuminate\Config\Repository as ConfigRepository;

class Repository extends ConfigRepository
{
    use SettingStore;
}
