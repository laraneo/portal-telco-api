<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProcessCategoryService;
use Barryvdh\DomPDF\Facade as PDF;

class ProcessCategoryController extends Controller
{
    public function __construct(ProcessCategoryService $service)
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
}
