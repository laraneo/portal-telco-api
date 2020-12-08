<?php

namespace App\Repositories;

use App\ProcessRequest;

use Carbon\Carbon;

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
          $start = date($searchQuery->query('created_start'));
          $end = Carbon::parse($searchQuery->query('created_end'))->addDay(1)->format('Y-m-d');
          $q->whereDate('dDate','>=', $start);
          $q->whereDate('dDate','<=', $end);
          //$q->whereBetween('dDate', [$start, $end]);
        }


        if ($searchQuery->query('category') !== NULL ) {
          $q->whereHas('type', function($query) use($searchQuery) {
            if($searchQuery->query('process_id') !== NULL) {
              $query->where('id', $searchQuery->query('process_id'));
            }
              $query->where('idProcessCategory', $searchQuery->query('category'));
          });
        }

        if ($searchQuery->query('nStatus') !== NULL) {
          $q->where('nStatus', $searchQuery->query('nStatus'));
        }

       

      })->where('user_id', $user)->with(['type','user'])->orderBy('dDate', 'DESC')->get();
      foreach ($data as $key => $value) {
        if($value->sSourceFile !== null) {
          $data[$key]->sSourceFileDownload = url('storage/clients/'.$value->user()->first()->client_id.'/users/'.$value->user_id.'/request_'.$value->id.'/'.$value->sSourceFile);
        } else {
          $value->sSourceFile = null;
        }

        if($value->sTargetFile !== null) {
          $data[$key]->sTargetFileDownload = url('storage/clients/'.$value->user()->first()->client_id.'/users/'.$value->user_id.'/request_'.$value->id.'/'.$value->sTargetFile);
        } else {
          $value->sTargetFile = null;
        }

        if($value->sLogFile !== null) {
          $data[$key]->sLogFileDownload = url('storage/clients/'.$value->user()->first()->client_id.'/users/'.$value->user_id.'/request_'.$value->id.'/'.$value->sLogFile);
        } else {
          $value->sLogFile = null;
        }
      }
      return $data;
    }

    public function allByManager($queryParams) {
      $user = auth()->user()->client_id;
      $searchQuery = $queryParams;
      $data = $this->model->query()->where(function($q) use($searchQuery) {


        if($searchQuery->query('term')) {
          $q->where('reference', 'like', "%{$searchQuery->query('term')}%");

          if($searchQuery->query('process_id') === NULL ) {
              $q->orWhereHas('type', function($query) use($searchQuery) {
                $query->where('sName', 'like', "%{$searchQuery->query('term')}%");
              });
          }

          if($searchQuery->query('user_id') === NULL ) {
            $q->orWhereHas('user', function($query) use($searchQuery) {
              $query->where('username', 'like', "%{$searchQuery->query('term')}%");
            });
          }
          

        }

        if ($searchQuery->query('created_start') !== NULL && $searchQuery->query('created_end') !== NULL) {
          $start = date($searchQuery->query('created_start'));
          $end = Carbon::parse($searchQuery->query('created_end'))->addDay(1)->format('Y-m-d');
          $q->whereDate('dDate','>=', $start);
          $q->whereDate('dDate','<=', $end);
          //$q->whereBetween('dDate', [$start, $end]);
        }

        if ($searchQuery->query('category') !== NULL ) {
          $q->whereHas('type', function($query) use($searchQuery) {
            if($searchQuery->query('process_id') !== NULL) {
              $query->where('id', $searchQuery->query('process_id'));
            }
              $query->where('idProcessCategory', $searchQuery->query('category'));
          });
        }

        if ($searchQuery->query('nStatus') !== NULL) {
          $q->where('nStatus', $searchQuery->query('nStatus'));
        }

        if ($searchQuery->query('user_id') !== NULL) {
          $q->where('user_id', $searchQuery->query('user_id'));
        }


      })->whereHas('user', function($q) use($user) {
        $q->where('client_id', $user);
      })->with(['type','user'])->orderBy('user_id', 'ASC')->orderBy('id', 'ASC')->get();
      foreach ($data as $key => $value) {
        if($value->sSourceFile !== null) {
          $data[$key]->sSourceFileDownload = url('storage/clients/'.$value->user()->first()->client_id.'/users/'.$value->user_id.'/request_'.$value->id.'/'.$value->sSourceFile);
        } else {
          $value->sSourceFile = null;
        }

        if($value->sTargetFile !== null) {
          $data[$key]->sTargetFileDownload = url('storage/clients/'.$value->user()->first()->client_id.'/users/'.$value->user_id.'/request_'.$value->id.'/'.$value->sTargetFile);
        } else {
          $value->sTargetFile = null;
        }

        if($value->sLogFile !== null) {
          $data[$key]->sLogFileDownload = url('storage/clients/'.$value->user()->first()->client_id.'/users/'.$value->user_id.'/request_'.$value->id.'/'.$value->sLogFile);
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