<?php
namespace App\Http\Repository;

use App\Models\Adjusment;
use Illuminate\Support\Facades\Auth;
use App\Http\Repository\ConversionRepository;

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
            'convensions_id' => $request['convensions_id'],
            'type' => $request['type'],
            'qty' => $request['qty'],
            'notes' => $request['notes'],
            'status' => 'open'
        ];

        $this->conversion->update_qty($request['convensions_id'], $request['qty'], $request['type']);

        return $this->adjusment->create($arr);
    }

    public function update($request)
    {
        $arr = [
            'convensions_id' => $request['convensions_id'],
            'type' => $request['type'],
            'qty' => $request['qty'],
            'notes' => $request['notes'],
            'status' => $request['status']
        ];

        $this->conversion->update_qty($request['convensions_id'], $request['qty'], $request['type']);

        return $this->adjusment->update($arr);
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