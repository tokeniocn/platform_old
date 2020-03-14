<?php

namespace App\Models\Auth;

use App\Models\Traits\Uuid;
use App\Models\Traits\TableName;
use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use App\Models\Auth\Traits\Relationship\UserRelationship;
use App\Models\Auth\Traits\Method\UserNotificationMethod;
use App\Models\Auth\Traits\Relationship\DynamicRelationship;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Airlock\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User.
 */
class User extends Authenticatable
{
    use TableName,
        DynamicRelationship,
        HasApiTokens,
        HasRoles,
        Notifiable,
        SoftDeletes,
        Uuid;

    use UserScope,
        UserMethod,
        UserAttribute,
        UserRelationship,
        UserNotificationMethod;

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
