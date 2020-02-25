<?php

namespace App\Models\System;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Airlock\HasApiTokens;

class AdminUser extends Authenticatable
{
    use HasApiTokens, Notifiable;
}
