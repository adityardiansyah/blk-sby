<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductMaster;
use Illuminate\Http\Request;

class ProductMasterController extends Controller
{
    public function syncProductMaster(ProductMaster $productMaster)
    {
        try {
            $data_erp = $productMaster->syncProductMasterERP();
            $data_db = $productMaster->count();
            if(count($data_erp) > $data_db){
                foreach ($data_erp as $key => $value) {
                    $check = ProductMaster::where('code', $value->code)
                                            ->where('name', $value->name)->first();
                    if(empty($check)){
                        $arr = [
                            'code' => $value->code,
                            'name' => $value->name,
                            'name_warehouse' => $value->name_warehouse
                        ];
                        ProductMaster::create($arr);
                    }
                }
            }
            return response()->json(['message' => 'success', 'date' => date('Y-m-d H:i:s')]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = ProductMaster::get();
            return response()->json([
                'message' => 'Data ditemukan',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => [],
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
