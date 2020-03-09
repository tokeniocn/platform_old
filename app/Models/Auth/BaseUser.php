<?php

namespace App\Models\Auth;

use App\Models\Traits\TableName;
use App\Models\Traits\Uuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Airlock\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Altek\Eventually\Eventually;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * Class User.
 */
abstract class BaseUser extends Authenticatable implements Recordable
{
    use TableName,
        HasApiTokens,
        HasRoles,
        Eventually,
        Notifiable,
        RecordableTrait,
        SoftDeletes,
        Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'email_verified_at',
        'password',
        'password_changed_at',
        'mobile',
        'mobile_verified_at',
        'avatar',
        'active',
        'last_login_at',
        'last_login_ip',
        'to_be_logged_out',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'last_login_at',
        'password_changed_at',
        'mobile_verified_at',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
    ];
}
