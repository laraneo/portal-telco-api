<?php

namespace App\Services;

use App\Repositories\ProcessRequestRepository;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Storage;

class ProcessRequestService {

	public function __construct(ProcessRequestRepository $repository) {
		$this->repository = $repository ;
	}

	public function index($queryParams) {
		return $this->repository->all($queryParams);
	}

	public function allByManager($queryParams) {
		return $this->repository->allByManager($queryParams);
	}


	public function getList() {
		return $this->repository->getList();
    }

    public function validateFile($file) {

		$fileToParse = preg_replace('/^data:application\/\w+;base64,/', '', $file);
		$ext = explode(';', $file)[0];
		$ext = explode('/', $ext)[1];

		$findDoc = 'data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,';
		$posDoc = strpos($file, $findDoc);
		if($posDoc !== false) {
			$fileToParse = str_replace('data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,', '', $file);
			$ext = 'docx';
		}

		$findXls = 'data:application/vnd.ms-excel;base64,';
		$posXls = strpos($file, $findXls);
		if($posXls !== false) {
			$fileToParse = str_replace('data:application/vnd.ms-excel;base64,', '', $file);
			$ext = 'xls';
		}

		$findXlsx = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,';
		$posXlsx = strpos($file, $findXlsx);
		if($posXlsx !== false) {
			$fileToParse = str_replace('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,', '', $file);
			$ext = 'xlsx';
		}

		$findTxt = 'data:text/plain;base64,';
		$posTxt = strpos($file, $findTxt);
		if($posTxt !== false) {
			$fileToParse = str_replace('data:text/plain;base64,', '', $file);
			$ext = 'txt';
		}

		$findCsv = 'data:text/csv;base64,';
		$posCsv = strpos($file, $findCsv);
		if($posCsv !== false) {
			$fileToParse = str_replace('data:text/csv;base64,', '', $file);
			$ext = 'csv';
		}

		$base64File = base64_decode($fileToParse);
		
		return (object)['ext' => $ext, 'content' => $base64File];
	}
    
    public function create($request) {
        $date = Carbon::now()->format('Y-m-d');
        $user = auth()->user()->id;
        $attr = [
            'nStatus' => $request['nStatus'],
            'process_id' => $request['process_id'],
            'user_id' => $user,
            'dDate' => Carbon::now(),
            'sSourceFile' => '',
            'reference' => $request['reference'],
            'description' => $request['description'],
        ];
		$data = $this->repository->create($attr);
		Storage::disk('users')->makeDirectory('/'.auth()->user()->client_id.'/users/'.$user.'/request_'.$data->id.'/',0775, true, true);
        if($request['file'] !== null) {
			$hash = bcrypt(rand());
			$hash = substr($hash,0,20);
			$parseFile = $this->validateFile($request['file']);
			$filename = 'source_'.$date.'-'.$data->id.'-'.$hash.'.'.$parseFile->ext;
			
			if($parseFile->ext === 'png' || $parseFile->ext === 'jpg' || $parseFile->ext === 'jpeg' ) {
				if($parseFile->ext === 'jpg' || $parseFile->ext === 'jpeg') {
					$filename = $date.'-'.$data->id.'-'.$hash.'.png';
				}
				\Image::make($request['file'])->save(public_path('storage/clients/'.auth()->user()->client_id.'/users/'.$user.'/request_'.$data->id.'/').$filename);
			} else {
				//Storage::disk('payments')->put($filename,$parseFile->content);
				\File::put(public_path(). '/storage/clients/'.auth()->user()->client_id.'/users/'.$user.'/request_'.$data->id.'/'.$filename, $parseFile->content);
			}
			// Storage::disk('users')->put($user.'/request_'.$data->id.'/target_'.$date.'-'.$data->id.'-'.$hash.'.xml', 'Test');
			// Storage::disk('users')->put($user.'/request_'.$data->id.'/log_'.$date.'-'.$data->id.'-'.$hash.'.txt', 'Test');
			$attr = [
				'sSourceFile' => $filename,
				'sTargetFile' => 'target_'.$date.'-'.$data->id.'-'.$hash.'.xml',
			'sLogFile' => 'log_'.$date.'-'.$data->id.'-'.$hash.'.txt',
				'path' => '/storage/clients/'.auth()->user()->client_id.'/users/'.$user.'/request_'.$data->id,
			];
			$this->repository->update($data->id, $attr);
        }
        $this->repository->update($data->id, $attr);
		return $data;
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
}