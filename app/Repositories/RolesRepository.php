<?php

namespace App\Repositories;

use App\Role;

class RoleRepository  {

    public function __construct(Role $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->where('id', $id)->with('permissions')->first();
    }

    public function create($attributes) {
      $role = $this->model->create($attributes);
      $permissions = json_decode($attributes['permissions']);
      if($permissions && count($permissions)) {
        foreach ($permissions as $permission) {
          $role->assignPermission($permission);
        }
      }
      return $role;
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all() {
      $user = auth()->user();
      $isManager = $user->hasRole('manager');
      return $this->model->query()->where(function($q) use($isManager) {
        if($isManager) {
          $q->where('slug', 'end-user');
        }
      })->get();
    }

    public function delete($id) {
      $role = $this->find($id);
      $role->userRoles()->delete();
      $role->widgetRoles()->delete();
      $role->menuItemRoles()->delete();
      $role->revokeAllPermissions();
      $role->delete();
     return $role;
    }

    public function checkRecord($name)
    {
      $response = $this->model->where('slug', $name)->first();
      if ($response) {
        return $response;
      }
      return false; 
    }

        /**
     * get banks by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
      $search;
      if($queryFilter->query('term') === null) {
        $search = $this->model->all();  
      } else {
        $search = $this->model->where('description', 'like', '%'.$queryFilter->query('term').'%')->get();
      }
     return $search;
    }
}