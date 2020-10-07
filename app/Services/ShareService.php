<?php

namespace App\Services;

use App\Repositories\ShareRepository;
use Illuminate\Http\Request;

class ShareService {

	public function __construct(ShareRepository $repository) {
		$this->repository = $repository ;
	}

	public function index($perPage) {
		return $this->repository->all($perPage);
	}

	public function filter($queryFilter, $isPDF = false) {
		return $this->repository->filter($queryFilter, $isPDF);
	}

	public function create($request) {
		return $this->repository->create($request);
	}

	public function update($request, $id) {
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
	 
	 public function getByPartner($id) {
		return $this->repository->getByPartner($id);
	   }

	   	/**
	 *  Search resource from repository
	 * @param  object $queryFilter
	*/
	public function searchToAssign($queryFilter) {
		return $this->repository->searchToAssign($queryFilter);
	 }
	 
}