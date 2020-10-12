<?php

namespace App\Repositories;

use App\Process;

class ProcessRepository  {
  
    protected $post;

    public function __construct(Process $model) {
      $this->model = $model;
    }

    public function getList() {
      return $this->model->all();
    }

}