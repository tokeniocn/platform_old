<?php

namespace App\Http\Controllers\Admin\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\User\ManageUserRequest;
use App\Http\Requests\Admin\Auth\User\UpdateUserPasswordRequest;
use App\Models\Auth\User;
use App\Repositories\Admin\Auth\UserRepository;

/**
 * Class UserPasswordController.
 */
class UserPasswordController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     */
    public function edit(ManageUserRequest $request, User $user)
    {
        return view('admin.auth.user.change-password')
            ->withUser($user);
    }

    /**
     * @param UpdateUserPasswordRequest $request
     * @param User                      $user
     *
     * @throws \App\Exceptions\GeneralException
     * @return mixed
     */
    public function update(UpdateUserPasswordRequest $request, User $user)
    {
        $this->userRepository->updatePassword($user, $request->only('password'));

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.admin.users.updated_password'));
    }
}
