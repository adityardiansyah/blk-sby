<?php
namespace App\Http\Repository;

use App\Models\Conversion;
use App\Models\ReturnWarehouse;
use Illuminate\Support\Facades\Auth;

class ReturnWarehouseRepository{
    protected $returnWarehouse, $conversion;

    public function __construct(Conversion $conv, ReturnWarehouse $rw) {
        $this->returnWarehouse = $rw;
        $this->conversion = $conv;
    }

    public function get_data_by_shop($id)
    {
        return $this->returnWarehouse->with('detail')->where('shop_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function get_data_by_id($id)
    {
        return $this->returnWarehouse->with('detail')->where('id', $id)->first();
    }

    public function create($data, $file)
    {
        $return = [
            "seller_id" => Auth::user()->seller->id,
            "shop_id" => Auth::user()->seller->shop_id,
            "trans_no" => $this->generate_return_no(),
            "trans_date" => date('Y-m-d'),
            "notes" => $data['notes'],
            "file_attachment" => $file,
            "status" => "open"
        ];
        return $this->returnWarehouse->create($return);
    }

    public function update($data, $file, $id)
    {
        $return = [
            "notes" => $data['notes'],
            "file_attachment" => $file,
        ];
        $this->returnWarehouse->where('id',$id)->update($return);
    }

    public function generate_return_no()
    {
        $format = "RTR/";

        $check_order = $this->returnWarehouse->whereMonth('trans_date', date('m'))->whereYear('trans_date', date('Y'))->get()->count();
        $no = $check_order + 1;
        if($check_order === 0){
            $result = $format.date('m').'/001';
        }else{
            $result = $format.date('m').'/'.substr("000",0,3-strlen($no)).$no;
        }
        return $result;
    }

    public function update_status($id, $type)
    {
        return $this->returnWarehouse->where('id',$id)->update(['status' => $type]);
    }

    public function delete($id)
    {
        $this->returnWarehouse->find($id)->delete();
    }
}