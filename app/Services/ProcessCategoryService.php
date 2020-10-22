<?php

namespace App\Services;

use App\Repositories\ProcessCategoryRepository;
use Illuminate\Http\Request;

class ProcessCategoryService {

	public function __construct(ProcessCategoryRepository $repository) {
		$this->repository = $repository ;
	}

	public function getList() {
		return $this->repository->getList();
	}

}