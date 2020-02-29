<?php

namespace App\Http\Controllers\Admin\Auth\Role;

use App\Events\Admin\Auth\Role\RoleDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\Role\ManageRoleRequest;
use App\Http\Requests\Admin\Auth\Role\StoreRoleRequest;
use App\Http\Requests\Admin\Auth\Role\UpdateRoleRequest;
use App\Models\Auth\Role;
use App\Repositories\Admin\Auth\PermissionRepository;
use App\Repositories\Admin\Auth\RoleRepository;

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
     * @var PermissionRepository
     */
    protected $permissionRepository;

    /**
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function index(ManageRoleRequest $request)
    {
        return view('admin.auth.role.index');
    }

    /**
     * @param ManageRoleRequest $request
     *
     * @return mixed
     */
    public function create(ManageRoleRequest $request)
    {
        return view('admin.auth.role.edit');
    }

    /**
     * @param ManageRoleRequest $request
     * @param Role              $role
     *
     * @return mixed
     */
    public function edit(ManageRoleRequest $request, Role $role)
    {

        return view('admin.auth.role.edit')
            ->withRole($role);
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
        if ($role->isAdmin()) {
            return redirect()->route('admin.auth.roles')->withFlashDanger(__('exceptions.admin.access.roles.cant_delete_admin'));
        }

        $this->roleRepository->deleteById($role->id);

        event(new RoleDeleted($role));

        return redirect()->route('admin.auth.roles')->withFlashSuccess(__('alerts.admin.roles.deleted'));
    }
}
