<?php
namespace App\Http\Repository;

use App\Models\GoodsReceive;
use Illuminate\Support\Facades\Auth;

class GoodsReceiveRepository{
    protected $goodsReceive;

    public function __construct(GoodsReceive $con) {
        $this->goodsReceive = $con;
    }

    public function get_data_by_shop($shop_id)
    {
        return $this->goodsReceive->with('detail')->where('shop_id', $shop_id)->get();
    }

    public function get_data_by_id($id)
    {
        return $this->goodsReceive->with('detail')->where('id', $id)->first();
    }

    public function create($data, $file)
    {
        $user = Auth::user()->seller;
        $date_now = date('Y-m-d');
        $arr = [
            'seller_id' => $user->id,
            'shop_id' => $user->shop_id,
            'no_sj_from' => $data['no_sj_from'],
            'no_sj_receive' => $this->generate_number_trans($date_now),
            'sent_date' => $data['sent_date'],
            'receive_date' => $date_now,
            'notes' => $data['notes'],
            'file_attachment' => $file,
            'status' => 'open'
        ];
        
        return $this->goodsReceive->create($arr);
    }

    public function update($data, $file, $id)
    {
        $arr = [
            'no_sj_from' => $data['no_sj_from'],
            'sent_date' => $data['sent_date'],
            'notes' => $data['notes'],
            'file_attachment' => $file
        ];
        
        return $this->goodsReceive->where('id',$id)->update($arr);
    }

    public function delete($id)
    {
        $this->goodsReceive->find($id)->delete();
    }

    public function generate_number_trans($dateRecieve)
    {
        $date = date('ym', strtotime($dateRecieve));
        $format = 'GR/'.$date;
        $year = date('Y', strtotime($dateRecieve));
        $month = date('m', strtotime($dateRecieve));

        $check_order = $this->goodsReceive->whereYear('receive_date', $year)->whereMonth('receive_date', $month)->get()->count();
        $no = $check_order + 1;
        if($check_order === 0){
            $result = $format.'/001';
        }else{
            $result = $format.'/'.substr("000",0,3-strlen($no)).$no;
        }
        return $result;
    }    

    public function update_status($id, $type)
    {
        return $this->goodsReceive->where('id',$id)->update(['status' => $type]);
    }
}