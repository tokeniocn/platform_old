<?php

namespace App\Models\Auth;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserVerify extends Model
{
    const TYPE_VERIFY_EMAIL = 'verify_email';
    const TYPE_VERIFY_MOBILE = 'verify_mobile';

    const UPDATED_AT = null;

    public $fillable = [
        'uid',
        'key',
        'token',
        'type',
        'expired_at',
    ];

    /**
     * 应该转换为日期格式的属性.
     *
     * @var array
     */
    protected $dates = [
        'expired_at',
    ];


    public function scopeNotExpired($query)
    {
        return $query->where('expired_at', '>=', Carbon::now());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'id');
    }

    /**
     *  make same type expired
     */
    public function makeOtherExpired()
    {
        return static::where('type', $this->type)
            ->where('uid', $this->uid)
            ->where('id', '<>', $this->id)
            ->notExpired()
            ->update([
                'expired_at' => Carbon::now(),
            ]);
    }

    /**
     *  make same type expired
     */
    public function setExpired()
    {
        $this->expired_at = Carbon::now();

        return $this;
    }
}
