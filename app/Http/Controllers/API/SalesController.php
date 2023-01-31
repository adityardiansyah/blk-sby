<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\ConversionRepository;
use App\Http\Repository\DetailSalesRepository;
use App\Http\Repository\SalesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    protected $saleRepository, $detailSalesRepossitory, $conversionRepository;

    public function __construct(SalesRepository $sr, DetailSalesRepository $dsr, ConversionRepository $con) {
        $this->saleRepository = $sr;
        $this->detailSalesRepossitory = $dsr;
        $this->conversionRepository = $con;
    }

    public function index()
    {
        try {
            $shop_id = Auth::user()->seller->shop_id;
            $data = $this->saleRepository->get_data_by_shop($shop_id);
            
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

    public function store(Request $request)
    {
        try {
            $data = $this->saleRepository->create($request->all());
            if(!empty($request->detail) && $data->id){
                $total_price = 0;
                $total_tax = 0;
                $total_discount = 0;

                foreach ($request->detail as $key => $value) {
                    $value['bruto_price'] = $value['qty'] * $value['unit_price'];
                    $total_discount = $total_discount + $value['discount'];
                    $value['nett_total'] = $value['bruto_price'] - $value['discount'];
                    $total_price = $total_price + $value['bruto_price'];

                    $this->detailSalesRepossitory->create($value, $data->id);
                }
                if($request->include_tax === "YES"){
                    $total_tax = $total_price * ($request->tax_persen / 100);
                }

                $res_total = [
                    "total_price" => $total_price,
                    "total_tax" => $total_tax,
                    "total_discount" => $total_discount
                ];
                $data = $this->saleRepository->update_total($data->id, $res_total);
            }
            return response()->json([
                'data' => $data,
                'message' => 'success inserted',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            if($id){
                $data = $this->saleRepository->get_data_by_id($id);
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

    public function update(Request $request, $id)
    {
        try {
            if($id){
                $data = $this->saleRepository->update($id,$request->all());
                if(!empty($request->detail) && $id){
                    $total_price = 0;
                    $total_tax = 0;
                    $total_discount = 0;
                    foreach ($request->detail as $key => $value) {
                        $total_price = $total_price + ($value['unit_price'] * $value['qty']);
                        $total_discount = $total_discount + $value['discount'];

                        $this->detailSalesRepossitory->update($id, $value);
                    }
                    if($request->include_tax == "YES"){
                        $total_tax = $total_price * ($request->tax_persen / 100);
                    }
                    $res_total = [
                        "total_price" => $total_price,
                        "total_tax" => $total_tax,
                        "total_discount" => $total_discount
                    ];
                    $this->saleRepository->update_total($id, $res_total);
                }
                return response()->json([
                    'data' => $request->all(),
                    'message' => 'success updated',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->detailSalesRepossitory->delete_by_sales_id($id);
            $this->saleRepository->delete($id);
            
            return response()->json([
                'message' => 'success deleted',
                'data' => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => [],
            ]);
        }
    }

    public function update_status(Request $request, $id)
    {
        try{
            $type = $request->type;

            $detail = $this->saleRepository->get_data_by_id($id);
            if(!empty($detail->detail)){
                if($type === "confirmed"){
                    $checkStock = $this->conversionRepository->checkStockItem($detail->detail, 'OUT');
                    if($checkStock['error']){
                        return response()->json([
                            'message' => 'Cannot sale! '.$checkStock['data'].', Not enough stock',
                            'data' => []
                        ], 400);
                    }
                }
                
                foreach ($detail->detail as $key => $value) {
                    if($type === "confirmed" && $detail->status !== $type){
                        $update = $this->conversionRepository->update_qty($value->conversion_id, $value->qty, 'OUT');
                        if(!empty($update['error'])){
                            return response()->json([
                                'message' => 'Cannot sale! '.$update['data'].', Not enough stock',
                                'data' => []
                            ], 400);
                        }
                    }elseif($type === "open" && $detail->status !== $type){
                        $update = $this->conversionRepository->update_qty($value->conversion_id, $value->qty, 'IN');
                    }
                }
                $this->saleRepository->update_status($id, $request->type);
    
                return response()->json([
                    'message' => 'success updated',
                    'data' => $detail
                ]);
            }else{
                return response()->json([
                    'message' => 'data not found!',
                    'data' => []
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => [],
            ]);
        }

    }
}
