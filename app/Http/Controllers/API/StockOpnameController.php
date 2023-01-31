<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\ConversionRepository;
use App\Http\Repository\DetailStockOpnameRepository;
use App\Http\Repository\StockOpnameRepository;
use App\Models\Conversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    protected $stockOpnameRepository, $detailStockOpnameRepository, $conversionRepository;
    
    public function __construct(StockOpnameRepository $stok, DetailStockOpnameRepository $dso, ConversionRepository $con) {
        $this->stockOpnameRepository = $stok;
        $this->detailStockOpnameRepository = $dso;
        $this->conversionRepository = $con;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $shop_id = Auth::user()->seller->shop_id;
            $data = $this->stockOpnameRepository->get_data_by_shop($shop_id);
            
            return response()->json([
                'message' => 'Data found',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Data not found',
                'data' => []
            ]);
        }
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
            $data = $this->stockOpnameRepository->create($request->all());
            if(!empty($data) && !empty($request->detail)){
                foreach ($request->detail as $key => $value) {
                    $conv = $this->conversionRepository->get_data_by_id($value['conversion_id']);
                    if(!empty($conv)){
                        $value['item_name'] = $conv->name_item;
                        $value['sku'] = $conv->sku;
                        $this->detailStockOpnameRepository->create($value, $data->id);
                    }
                }
            }
            return response()->json([
                'message' => 'success return',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => []
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
        try {
            if($id){
                $data = $this->stockOpnameRepository->get_data_by_id($id);
                return response()->json([
                    'message' => 'Data found',
                    'data' => $data
                ]);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Data not found',
                'data' => []
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
        try {
            $data = $this->stockOpnameRepository->update($id, $request->all());
            if(!empty($data->detail)){
                foreach ($data->detail as $key => $value) {
                    $this->detailStockOpnameRepository->update($id, $value);
                }
            }
            return response()->json([
                'message' => 'success updated',
                'data' => $data
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => []
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
        try {
            $this->detailStockOpnameRepository->delete_by_stock_opname_id($id);
            $this->stockOpnameRepository->delete($id);
            
            return response()->json([
                'message' => 'success deleted',
                "data" => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                "data" => []
            ]);
        }
    }
}
