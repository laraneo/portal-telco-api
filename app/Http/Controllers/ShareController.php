<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShareService;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Requests\BankValidator;

class ShareController extends Controller
{
    public function __construct(ShareService $service)
	{
		$this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banks = $this->service->index($request->query('perPage'));
        return response()->json([
            'success' => true,
            'data' => $banks
        ]);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $banks = $this->service->filter($request);
        return response()->json([
            'success' => true,
            'data' => $banks
        ]);
    }

    /**
     * Get the specified resource by search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        public function filterReport(Request $request) {
            $data = $this->service->filter($request, true);
            $data = [
                'data' => $data
            ];
            $pdf = PDF::loadView('reports/shares', $data);
            return $pdf->download('sharesReport.pdf');
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bankRequest = $request->all();
        $bank = $this->service->create($bankRequest);
        return $bank;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bank = $this->service->read($id);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bankRequest = $request->all();
        $bank = $this->service->update($bankRequest, $id);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = $this->service->delete($id);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
            ]);
        }
    }

    /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchToAssign(Request $request) {
        $bank = $this->service->searchToAssign($request);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
            ]);
        }
    }

        /**
     * get shares by partner
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getByPartner($id)
    {
        $data = $this->service->getByPartner($id);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

        /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $bank = $this->service->search($request);
        if($bank) {
            return response()->json([
                'success' => true,
                'data' => $bank
            ]);
        }
    }
}
