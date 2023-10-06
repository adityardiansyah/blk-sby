<?php

namespace App\Http\Controllers;
use App\Models\Sales;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Repository\SalesRepository;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    protected $SalesRepository, $detailSalesRepossitory, $conversionRepository;
    
    public function __construct(SalesRepository $sales) {
        $this->SalesRepository = $sales;
        $this->middleware(function ($request, $next){
            Session::put('menu_active','/sales');
            return $next($request);
        }); 
    }
    public function index(Request $request)
    {
        $data = $this->SalesRepository->get_data_all();
        $status = 'confirmed';
        $sales = Sales::where('status', $status)->get();
        return view('page.sales', compact('data'),['sales' => $sales, 'status' => $status]);
    }
//     public function getSales()
// {
//     $data = $data = $this->SalesRepository->get_data_all();
//     return response()->json($sales);
// }
    public function show($id)
    {
        $data = $this->SalesRepository->get_data_by_id($id);
        if(!empty($data)){
            return response()->json([
                'success' => true,
                'data' => $data 
            ]);
        }else{
            return response()->json([
                'success' => false,
                'data' => [] 
            ]);
        }
    }
    public function confirm($id)
    {
        $sales = Sales::find($id);
        $sales->status = 'confirmed';
        $sales->save();
    
        return response()->json(['message' => 'Status updated successfully.']);
    }
    public function update_status(Request $request,$id){
        $type = $request->type;
        if ($type == "open") {
            Sales::find($id)->update(['status'=>'open']);
        }
        return response()->json([
            'success'=>true,
            'message'=>'Status Berhasil Diubah',
        ]);
    }
}
