<?php

namespace App\Repositories;

use App\ProcessRequest;

class ProcessRequestRepository  {
  
    protected $post;

    public function __construct(ProcessRequest $model) {
      $this->model = $model;
    }

    public function find($id) {
      return $this->model->find($id);
    }

    public function create($attributes) {
      return $this->model->create($attributes);
    }

    public function update($id, array $attributes) {
      return $this->model->find($id)->update($attributes);
    }
  
    public function all($queryParams) {
      $user = auth()->user()->id;
      $searchQuery = $queryParams;
      $data = $this->model->query()->where(function($q) use($searchQuery) {

        if ($searchQuery->query('created_start') !== NULL && $searchQuery->query('created_end') !== NULL) {
          $q->whereBetween('dDate', [$searchQuery->query('created_start'), $searchQuery->query('created_end')]);
        }

        if ($searchQuery->query('process_id') !== NULL) {
          $q->where('process_id', $searchQuery->query('process_id'));
        }

        if ($searchQuery->query('nStatus') !== NULL) {
          $q->where('nStatus', $searchQuery->query('nStatus'));
        }

      })->where('user_id', $user)->with('type')->orderBy('dDate', 'DESC')->get();
      foreach ($data as $key => $value) {
        if($value->sSourceFile !== null) {
          $data[$key]->sSourceFileDownload = url('storage/users/'.$user.'/request_'.$value->id.'/'.$value->sSourceFile);
        } else {
          $value->sSourceFile = null;
        }

        if($value->sTargetFile !== null) {
          $data[$key]->sTargetFileDownload = url('storage/users/'.$user.'/request_'.$value->id.'/'.$value->sTargetFile);
        } else {
          $value->sTargetFile = null;
        }

        if($value->sLogFile !== null) {
          $data[$key]->sLogFileDownload = url('storage/users/'.$user.'/request_'.$value->id.'/'.$value->sLogFile);
        } else {
          $value->sLogFile = null;
        }
      }
      return $data;
    }

    public function allByManager($queryParams) {
      $user = auth()->user()->id;
      $searchQuery = $queryParams;
      $data = $this->model->query()->where(function($q) use($searchQuery) {

        if ($searchQuery->query('created_start') !== NULL && $searchQuery->query('created_end') !== NULL) {
          $q->whereBetween('dDate', [$searchQuery->query('created_start'), $searchQuery->query('created_end')]);
        }

        if ($searchQuery->query('process_id') !== NULL) {
          $q->where('process_id', $searchQuery->query('process_id'));
        }

        if ($searchQuery->query('nStatus') !== NULL) {
          $q->where('nStatus', $searchQuery->query('nStatus'));
        }

      })->with(['type','user'])->orderBy('dDate', 'DESC')->get();
      foreach ($data as $key => $value) {
        if($value->sSourceFile !== null) {
          $data[$key]->sSourceFileDownload = url('storage/users/'.$value->id.'/request_'.$value->id.'/'.$value->sSourceFile);
        } else {
          $value->sSourceFile = null;
        }

        if($value->sTargetFile !== null) {
          $data[$key]->sTargetFileDownload = url('storage/users/'.$value->id.'/request_'.$value->id.'/'.$value->sTargetFile);
        } else {
          $value->sTargetFile = null;
        }

        if($value->sLogFile !== null) {
          $data[$key]->sLogFileDownload = url('storage/users/'.$value->id.'/request_'.$value->id.'/'.$value->sLogFile);
        } else {
          $value->sLogFile = null;
        }
      }
      return $data;
    }

    public function getList() {
      return $this->model->all();
    }

    public function delete($id) {
     return $this->model->find($id)->delete();
    }

}