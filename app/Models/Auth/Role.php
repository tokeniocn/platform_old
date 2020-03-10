<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Method\RoleMethod;
use App\Models\Traits\TableName;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role.
 */
class Role extends SpatieRole
{
    use TableName,
        RoleMethod;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        return $this->where($this->getRouteKeyName(), $value)
            ->where('guard_name', $this->getDefaultGuardName())
            ->first();
    }
}
