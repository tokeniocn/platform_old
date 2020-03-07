<?php

namespace App\Models\Auth;

use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordHistory.
 */
class PasswordHistory extends Model
{
    use TableName;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'password_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['password'];
}
