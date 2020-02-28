<?php

namespace App\Http\Controllers\Backend\Api\Auth;

use App\Events\Backend\Auth\Role\RoleDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\Role\ManageRoleRequest;
use App\Http\Requests\Backend\Auth\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Auth\Role\UpdateRoleRequest;
use App\Models\Auth\Role;
use App\Repositories\Backend\Auth\RoleRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class RoleController.
 */
class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @param RoleRepository       $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function index(ManageRoleRequest $request)
    {
        return $this->roleRepository
            ->where('guard_name', $request->get('guard', Auth::getDefaultDriver()))
            ->orderBy('sort')
            ->paginate();
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function withPermissions(ManageRoleRequest $request, Role $role)
    {
        $role->permissions;
        return $role;
    }

    /**
     * @param  StoreRoleRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreRoleRequest $request)
    {
        return $this->roleRepository->create($request->only('name', 'title', 'permissions', 'sort'));
    }


    /**
     * @param  UpdateRoleRequest  $request
     * @param  Role  $role
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        return $this->roleRepository->update($role, $request->only('name', 'title', 'permissions', 'sort'));
    }

    /**
     * @param ManageRoleRequest $request
     * @param Role              $role
     *
     * @throws \Exception
     * @return mixed
     */
    public function destroy(ManageRoleRequest $request, Role $role)
    {

        $this->roleRepository->deleteById($role->id);

        event(new RoleDeleted($role));

        return [];
    }
}
