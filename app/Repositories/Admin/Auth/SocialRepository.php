<?php

namespace App\Repositories\Admin\Access\User;

use App\Events\Admin\Auth\User\UserSocialDeleted;
use App\Exceptions\GeneralException;
use App\Models\Auth\SocialAccount;
use App\Models\Auth\User;

/**
 * Class SocialRepository.
 */
class SocialRepository
{
    /**
     * @param User        $user
     * @param SocialAccount $social
     *
     * @throws GeneralException
     * @return bool
     */
    public function delete(User $user, SocialAccount $social)
    {
        if ($user->providers()->whereId($social->id)->delete()) {
            event(new UserSocialDeleted($user, $social));

            return true;
        }

        throw new GeneralException(__('exceptions.admin.access.users.social_delete_error'));
    }
}
