<?php

namespace App\Repositories;

use App\ProcessCategory;

class ProcessCategoryRepository  {
  
    protected $post;

    public function __construct(ProcessCategory $model) {
      $this->model = $model;
    }

    public function getList() {
      return $this->model->query()->where('nStatus', 1)->get();
    }

}