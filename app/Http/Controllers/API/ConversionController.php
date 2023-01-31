<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\ConversionRepository;
use App\Models\Conversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversionController extends Controller
{
    protected $conversion;

    public function __construct(ConversionRepository $con) {
        $this->conversion = $con;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop_id = Auth::user()->seller->shop_id;

        $data = $this->conversion->get_data_by_shop($shop_id);
        
        return response()->json([
            'message' => 'Data found',
            'data' => $data
        ]);
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
            $data = $this->conversion->create($request->all());
            if($data){
                return response()->json([
                    'message' => 'success inserted',
                    'data' => $data
                ]);
            }else{
                return response()->json([
                    'message' => $request->sku.' sudah pernah dimasukkan, coba ganti nama lain',
                    'data' => []
                ], 400);
            }
            
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
        $data = $this->conversion->get_data_by_id($id);
        if(!empty($data)){
            return response()->json([
                'message' => 'Data found',
                'data' => $data
            ]);
        }else{
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
            $data = $this->conversion->update($id, $request->all());
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
        //
    }
}
