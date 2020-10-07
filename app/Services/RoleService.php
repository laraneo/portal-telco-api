<?php

namespace App\Services;

use App\Permission;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class RoleService {

	public function __construct(RoleRepository $repository, PermissionRepository $permissionRepository) {
		$this->repository = $repository ;
		$this->permissionRepository = $permissionRepository ;
	}

	public function index() {
		return $this->repository->all();
	}

	public function create($request) {
		if ($this->repository->checkRecord($request['slug'])) {
            return response()->json([
                'success' => false,
                'message' => 'El registro ya existe'
            ])->setStatusCode(400);
		}
		return $this->repository->create($request);
	}

	public function update($request, $id) {

	$role = $this->repository->find($id);
	$role->revokeAllPermissions();
	$role = $this->repository->find($id);
	$permissions = json_decode($request['permissions']);
	
	if($request['permissions'] !== null && count($permissions)) {
		foreach ($permissions as $permission) {
			$role->assignPermission($permission);
		}
	}

	return $this->repository->update($id, $request);
	}

	public function read($id) {
     return $this->repository->find($id);
	}

	public function delete($id) {
      return $this->repository->delete($id);
	}

	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function search($queryFilter) {
		return $this->repository->search($queryFilter);
 	}
}