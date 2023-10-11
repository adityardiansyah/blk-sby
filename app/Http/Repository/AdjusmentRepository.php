<?php
namespace App\Http\Repository;

use App\Models\Adjusment;
use Illuminate\Support\Facades\Auth;
use App\Http\Repository\ConversionRepository;
use DB;

class AdjusmentRepository{
    protected $adjusment, $conversion;

    public function __construct(Adjusment $adjs, ConversionRepository $conv)
    {
        $this->conversion = $conv;
        $this->adjusment = $adjs;
    }

    public function get_adjusment_in()
    {
        return $this->adjusment
                ->select('adjusments.id', 'adjusments.conversion_id', 'adjusments.type', 'adjusments.qty', 'adjusments.notes', 'adjusments.status', 'adjusments.shop_id', 'adjusments.created_at', 'conversions.sku')
                ->join('conversions', 'conversions.id', '=', 'conversion_id')
                ->where('type', 'IN')
                ->get();
    }
    
    public function get_adjusment_out()
    {
        return $this->adjusment
                ->select('adjusments.id', 'adjusments.conversion_id', 'adjusments.type', 'adjusments.qty', 'adjusments.notes', 'adjusments.status', 'adjusments.shop_id', 'adjusments.created_at', 'conversions.sku')
                ->join('conversions', 'conversions.id', '=', 'conversion_id')
                ->where('type', 'OUT')
                ->get();
    }

    public function get_adjusment_by_id($id)
    {
        return $this->adjusment
                ->select('adjusments.id', 'adjusments.conversion_id', 'adjusments.type', 'adjusments.qty', 'adjusments.notes', 'adjusments.status', 'adjusments.shop_id', 'adjusments.created_at', 'conversions.sku', 'shop.name')
                ->join('conversions', 'conversions.id', '=', 'adjusments.conversion_id')
                ->join('shop', 'shop.id', '=', 'adjusments.shop_id')
                ->where('adjusments.id', $id)->first();
    }

    public function store($request)
    {
        $arr = [
            'conversion_id' => $request['conversion_id'],
            'type' => $request['type'],
            'qty' => $request['qty'],
            'notes' => $request['notes'],
            'shop_id' => $request['shop_id'],
            'status' => 'open',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return DB::table('adjusments')
            ->insert($arr);
    }

    public function update($request, $id)
    {     

        if ($request->status === 'confirmed') {
            $this->conversion->update_qty($request['conversion_id-edit'], $request['qty-edit'], $request['type-edit']);
        }

        return DB::table('adjusments')
                ->where('id', $id)
                ->update([
                    'conversion_id' => $request['conversion_id-edit'],
                    'type' => $request['type-edit'],
                    'qty' => $request['qty-edit'],
                    'notes' => $request['notes-edit'],
                    'shop_id' => $request['shop_id-edit'],
                    'status' => $request['status'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
    }

    public function delete($id)
    {
        $this->adjusment->find($id)->delete();
    }

    public function confirm($request, $id)
    {
        $this->conversion->update_qty($request['conversion_id'], $request['qty'], $request['type']);

        return DB::table('adjusments')->where('id', $id)->update([ 'status' => 'confirmed' ]);
    }

    public function add_qty_conversions()
    {
        
    }

    public function reduce_qty_conversions()
    {

    }
}