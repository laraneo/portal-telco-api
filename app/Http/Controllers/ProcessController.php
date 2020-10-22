<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProcessService;
use Barryvdh\DomPDF\Facade as PDF;

class ProcessController extends Controller
{
    public function __construct(ProcessService $service)
	{
		$this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $data = $this->service->getList();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByCategory(Request $request)
    {
        $data = $this->service->getByCategory($request['category']);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
