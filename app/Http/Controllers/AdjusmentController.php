<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Adjusment;
use App\Http\Repository\AdjusmentRepository;
use App\Http\Repository\ConversionRepository;
use App\Http\Repository\ShopRepository;

class AdjusmentController extends Controller
{
    protected $adjusment, $conversions, $shop;

    public function __construct(AdjusmentRepository $adjs, ConversionRepository $conv, ShopRepository $shp) {
        $this->adjusment = $adjs;
        $this->conversions = $conv;
        $this->shop = $shp;
        $this->middleware(function ($request, $next){
            Session::put('menu_active','adjusment');
            return $next($request);
        });
    }

    public function adjusment_in()
    {
        $data = $this->adjusment->get_adjusment_in();
        $shop = $this->shop->get_all();
        return view('page.adjusment.adjusin', compact('data', 'shop'));
    }

    public function adjusment_out()
    {
        $data = $this->adjusment->get_adjusment_out();
        $shop = $this->shop->get_all();
        return view('page.adjusment.adjusout', compact('data', 'shop'));
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'conversion_id' => 'required',
                'qty' => 'required|integer',
                'notes' => 'required',
            ]);

            $storing = $this->adjusment->store($request);

            if ($storing) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil ditambahkan'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal ditambahkan'
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $data = $this->adjusment->get_adjusment_by_id($id);

            if (empty($data)) {
                return response()->json([
                    'success'=> false,
                    'message' => 'Gagal dihapus!' 
                ]);
            }

            $deleting = $this->adjusment->delete($id);

            return back()->with('message', ['type' => 'success','content' => 'Berhasil dihapus']);
        } catch (\Throwable $th) {
            return back()->with('message', ['type' => 'danger','content' => 'Gagal dihapus']);
        }
    }

    public function update(Request $request, $id)
    {

    }
}
