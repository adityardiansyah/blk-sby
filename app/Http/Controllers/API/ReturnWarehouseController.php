<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repository\DetailReturnWarehouseRepository;
use App\Http\Repository\ReturnWarehouseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReturnWarehouseController extends Controller
{
    protected $returnWarehouseRepository, $detailReturnWarehouseRepository;

    public function __construct(ReturnWarehouseRepository $rwr, DetailReturnWarehouseRepository $drwr) {
        $this->returnWarehouseRepository = $rwr;
        $this->detailReturnWarehouseRepository = $drwr;
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
