<?php
namespace App\Http\Repository;

use App\Models\Sale;

class SalesRepository{
    protected $sale;

    public function __construct(Sale $con) {
        $this->sale = $con;
    }

    public function get_data_by_shop($id)
    {
        return $this->sale->with('detail')->where('shop_id', $id)->get();
    }

    public function get_data_by_id($id)
    {
        return $this->sale->with('detail')->where('id', $id)->first();
    }

    public function create($data)
    {
        $arr = [
            "seller_id" => $data['seller_id'],
            "shop_id" => $data['shop_id'],
            "invoice" => $this->generate_invoice($data['trans_date']),
            "trans_date" => $data['trans_date'],
            "include_tax" => $data['include_tax'],
            "tax_persen" => $data['tax_persen'],
            "notes" => $data['notes'],
        ];
        return $this->sale->create($arr);
    }

    public function update($id, $data)
    {
        $arr = [
            "trans_date" => $data['trans_date'],
            "include_tax" => $data['include_tax'],
            "tax_persen" => $data['tax_persen'],
            "notes" => $data['notes'],
        ];
        return $this->sale->where('id', $id)->update($arr);
    }

    public function update_total($id, $data)
    {
        return $this->sale->where('id', $id)->update($data);
    }

    public function generate_invoice($date)
    {
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $format = 'INV-';
        $check_order = $this->sale->whereYear('trans_date', $year)->whereMonth('trans_date', $month)->get()->count();
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
        $this->sale->find($id)->delete();
    }

    public function update_status($id, $type)
    {
        $this->sale->where('id',$id)->update(['status'=>$type]);
    }
}