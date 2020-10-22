<?php

namespace App\Services;

use App\Repositories\ProcessRepository;
use Illuminate\Http\Request;

class ProcessService {

	public function __construct(ProcessRepository $repository) {
		$this->repository = $repository ;
	}

	public function getList() {
		return $this->repository->getList();
	}

	public function getByCategory($category) {
		return $this->repository->getByCategory($category);
	  }
  

}