<?php

namespace App\Models\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Airlock\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class AdminUser extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    public function canChangePassword()
    {
        return true;
    }
}
