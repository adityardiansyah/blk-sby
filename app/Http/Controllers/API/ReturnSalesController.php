<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\ConversionRepository;
use App\Http\Repository\DetailSalesRepository;
use App\Http\Repository\ReturnSalesRepository;
use App\Http\Repository\SalesRepository;
use Illuminate\Http\Request;

class ReturnSalesController extends Controller
{
    protected $saleRepository, $detailSalesRepossitory, $conversionRepository, $returnSalesRepository;

    public function __construct(SalesRepository $sr, DetailSalesRepository $dsr, ConversionRepository $con, ReturnSalesRepository $rsp) {
        $this->saleRepository = $sr;
        $this->detailSalesRepossitory = $dsr;
        $this->conversionRepository = $con;
        $this->returnSalesRepository = $rsp;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data = $this->returnSalesRepository->create($request->all());
            return response()->json([
                'data' => $data,
                'message' => 'success return',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => $th->getMessage(),
                'error' => 500
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
