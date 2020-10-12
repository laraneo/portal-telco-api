<?php

namespace App\Repositories;

use App\Client;

class ClientRepository  {
  
    protected $post;

    public function __construct(Client $model) {
      $this->model = $model;
    }

    public function getList() {
      return $this->model->all();
    }

}