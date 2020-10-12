<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientService {

	public function __construct(ClientRepository $repository) {
		$this->repository = $repository ;
	}

	public function getList() {
		return $this->repository->getList();
	}

}