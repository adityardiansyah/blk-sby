<?php
namespace App\Http\Repository;

use App\Models\Presence;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class PresenceRepository{
    protected $presence;

    public function __construct(Presence $con) {
        $this->presence = $con;
    }

    public function get_data_by_seller($seller_id)
    {
        return $this->presence->where('seller_id', $seller_id)->orderBy('created_at', 'desc')->get();
    }

    public function get_data_by_id($id)
    {
        return $this->presence->where('id', $id)->first();
    }

    public function create($data)
    {
        $arr = [
            "seller_id" => Auth::user()->seller->id,
            "date" => date('Y-m-d'),
            "time" => date('H:i:s'),
            "latitude" => $data['latitude'],
            "longitude" => $data['longitude'],
            "type" => $data['type']
        ];
        return $this->presence->create($arr);
    }

    public function delete($id)
    {
        $this->presence->find($id)->delete();
    }
}