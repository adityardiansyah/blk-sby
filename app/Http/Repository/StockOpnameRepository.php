<?php
namespace App\Http\Repository;

use App\Models\StockOpname;
use Illuminate\Support\Facades\Auth;

class StockOpnameRepository{
    protected $stock;

    public function __construct(StockOpname $stockOpname) {
        $this->stock = $stockOpname;
    }

    public function get_data_all()
    {
        return $this->stock->with('detail')->with('file_attachment')->orderBy('created_at', 'desc')->get();
    }

    public function get_data_by_shop($id)
    {
        return $this->stock->with('detail')->where('shop_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function get_data_by_id($id)
    {
        return $this->stock->with('detail')->with('file_attachment')->with('seller')->with('shop')->where('id', $id)->first();
    }

    public function create($data)
    {
        $arr = [
            "seller_id" => Auth::user()->seller->id,
            "shop_id" => Auth::user()->seller->shop_id,
            "trans_no" => $this->generate_trans_no($data['trans_date']),
            "trans_date" => $data['trans_date'],
            "notes" => $data['notes'],
            "status" => "open"
        ];
        return $this->stock->create($arr);
    }

    public function update($id, $data)
    {
        $arr = [
            "trans_date" => $data['trans_date'],
            "notes" => $data['notes'],
        ];
        return $this->stock->where('id', $id)->update($arr);
    }

    public function update_total($id, $data)
    {
        return $this->stock->where('id', $id)->update($data);
    }

    public function generate_trans_no($date)
    {
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $format = 'STK-'.date('m').'-';
        $check_order = $this->stock->whereYear('trans_date', $year)->whereMonth('trans_date', $month)->get()->count();
        $no = $check_order + 1;
        if($check_order === 0){
            $result = $format.'00001';
        }else{
            $result = $format.substr("00000",0,5-strlen($no)).$no;
        }
        return $result;
    }

    public function delete($id)
    {
        $this->stock->find($id)->delete();
    }

    public function update_status($id, $type)
    {
        $this->stock->where('id',$id)->update(['status'=>$type]);
    }
}