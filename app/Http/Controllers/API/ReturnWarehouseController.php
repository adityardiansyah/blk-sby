<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\ConversionRepository;
use App\Http\Repository\DetailReturnWarehouseRepository;
use App\Http\Repository\ReturnWarehouseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReturnWarehouseController extends Controller
{
    protected $returnWarehouseRepository, $detailReturnWarehouseRepository, $conversionRepository;

    public function __construct(ReturnWarehouseRepository $rwr, DetailReturnWarehouseRepository $drwr, ConversionRepository $con) {
        $this->returnWarehouseRepository = $rwr;
        $this->detailReturnWarehouseRepository = $drwr;
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
            $data = $this->returnWarehouseRepository->get_data_by_shop($shop_id);
            
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
        try {
            $file = "";
            if(!empty($request->file('file_attachment'))){
                $request->validate([
                    'file_attachment' => 'mimes:jpg,jpeg,png|max:2048',
                ]);
                $path = $request->file('file_attachment')->store('files/return_warehouse', 'public');
                $file = $path;
            }
            $data = $this->returnWarehouseRepository->create($request->all(), $file);
            if(!empty($data)){
                foreach ($request->detail as $key => $value) {
                    $this->detailReturnWarehouseRepository->create($data['id'], $value);
                }
            }
            return response()->json([
                'data' => $data,
                'message' => 'success inserted',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => $th->getMessage(),
                'error' => 500
            ]);
        }
        // return $request->all();
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
                $data = $this->returnWarehouseRepository->get_data_by_id($id);
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
        try {
            if($id){
                $this->detailReturnWarehouseRepository->delete($id);
                $this->returnWarehouseRepository->delete($id);
            }
            
            return response()->json([
                'message' => 'success deleted',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'delete failed',
                "error" => 500
            ]);
        }
        
    }

    public function update_status($id, Request $request)
    {
        try{
            $type = $request->type;
            $detail = $this->returnWarehouseRepository->get_data_by_id($id);
            if(!empty($detail->detail) && $detail->status !== $type){
                if($type === "confirmed"){
                    $checkStock = $this->conversionRepository->checkStockItem($detail->detail, 'OUT');
                    if($checkStock['error']){
                        return response()->json([
                            'message' => 'Cannot sale! '.$checkStock['data'].', Not enough stock',
                            'error' => true
                        ]);
                    }
                }

                foreach ($detail->detail as $key => $value) {
                    if($type === "confirmed" && $detail->status !== $type){
                        $this->conversionRepository->update_qty($value->conversion_id, $value->qty, 'OUT');
                    }elseif($type === "open" && $detail->status !== $type){
                        $update = $this->conversionRepository->update_qty($value->conversion_id, $value->qty, 'IN');
                        if(!empty($update['error'])){
                            return response()->json([
                                'message' => 'Cannot open!, '.$update['data'].' Not enough stock',
                                'error' => true
                            ]);
                        }
                    }
                }
            }

            $this->returnWarehouseRepository->update_status($id, $request->type);

            return response()->json([
                'message' => 'success updated',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => [],
                'message' => $th->getMessage(),
                'error' => 500
            ]);
        }
    }
}
