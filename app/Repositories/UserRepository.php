<?php

namespace App\Repositories;

use App\User;

class UserRepository  {
  
    protected $user;
    protected $teamUser;

    public function __construct(User $user) {
      $this->model = $user;
    }

    public function find($id) {
      return $this->model->where('id', $id)->with('roles')->first();
    }

    public function create($attributes) {
      $user = $this->model->create($attributes);
      $roles = json_decode($attributes['roles']);
      if($roles && count($roles)) {
				foreach ($roles as $role) {
					$user->assignRole($role);
				}
      }
      return $user;
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }

    public function all() {
      $user = auth()->user();
      $isManager = $user->hasRole('manager');
      return $this->model->query()->where(function($q) use($isManager, $user) {    
        if($user->client_id !== null) {
          $q->where('client_id', $user->client_id);
        }
      })->with('roles')->whereHas('roles', function($q) use ($isManager){
        if($isManager){
          $q->where('slug', 'end-user');
        }
      })->get();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

    public function checkUser($email)
    {
      $user = $this->model->where('email', $email)->first();
      if ($user) {
        return true;
      }
      return false; 
    }

    public function forcedLogin($username)
    {
      return $this->model->where('username', $username)->first(); 
    }

            /**
     * get persons by query params
     * @param  object $queryFilter
    */
    public function search($queryFilter) {
        $user = auth()->user();
        $isManager = $user->hasRole('manager');
        $searchQuery = trim($queryFilter->query('term'));
        $this->share = $queryFilter->query('term');
        $requestData = ['name', 'username', 'email'];
        $search = $this->model->where(function($q) use($requestData, $searchQuery, $user ) {
                    foreach ($requestData as $field) {
                       $q->orWhere($field, 'like', "%{$searchQuery}%");
                    }

                    if($user->client_id !== null) {
                      $q->where('client_id', $user->client_id);
                    }

                  })->with('roles')->whereHas('roles', function($q) use ($isManager){
                    if($isManager){
                      $q->where('slug', 'end-user');
                    }
                  })->get();
        return $search;
    }
    public function check($request)
    {
      return $this->model->where('username', $request['username'])->first();
    }

    public function checkUsernameLegacy($request)
    {
      return $this->model->where('username_legacy', $request['username_legacy'])->first();
    }

    public function checkFieldBeforeUpdate($field, $value, $id)
    {
      return $this->model->where($field, $value)->where('id', '!=',$id)->first();
    }

    public function getUsersByManager() {
      $user = auth()->user()->client_id;
      return $this->model->query()->where('client_id', $user)->get();
    }
}