<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\DetailStockOpnameRepository;
use Illuminate\Http\Request;

class DetailStockOpnameController extends Controller
{
    protected $detailStockOpnameRepository;
    
    public function __construct(DetailStockOpnameRepository $dso) {
        $this->detailStockOpnameRepository = $dso;
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
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->detailStockOpnameRepository->delete($id);
            
            return response()->json([
                'message' => 'success deleted',
                'data' => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'delete failed',
                'data' => []
            ]);
        }
    }
}
