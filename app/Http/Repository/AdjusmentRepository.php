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
        return $this->adjusment->where('type', 'IN')->get();
    }
    
    public function get_adjusment_out()
    {
        return $this->adjusment->where('type', 'OUT')->get();
    }

    public function get_adjusment_by_id($id)
    {
        return $this->adjusment->where('id', $id)->first();
    }

    public function store($request)
    {
        $arr = [
            'conversion_id' => $request['conversion_id'],
            'type' => $request['type'],
            'qty' => $request['qty'],
            'notes' => $request['notes'],
            'shop_id' => $request['shop_id'],
            'status' => 'open'
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
                    'status' => $request['status'] 
                ]);
    }

    public function delete($id)
    {
        $this->adjusment->find($id)->delete();
    }

    public function add_qty_conversions()
    {
        
    }

    public function reduce_qty_conversions()
    {

    }
}