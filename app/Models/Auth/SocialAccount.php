<?php

namespace App\Models\Auth;

use App\Models\RecordingModel;
use App\Models\Traits\TableName;

/**
 * Class SocialAccount.
 */
class SocialAccount extends RecordingModel
{
    use TableName;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'social_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'token',
        'avatar',
    ];
}
