<?php
namespace App\Http\Repository;

use App\Models\DetailSale;

class DetailSalesRepository{
    protected $detailSale;

    public function __construct(DetailSale $con) {
        $this->detailSale = $con;
    }

    public function get_data_by_id($id)
    {
        return $this->detailSale->where('id', $id)->first();
    }

    public function create($data, $id)
    {
        $arr = [
            "sales_id" => $id,
            "conversion_id" => $data['conversion_id'],
            "item_name" => $data['item_name'], 
            "sku" => $data['sku'], 
            "qty" => $data['qty'],
            "unit" => $data['unit'],
            "unit_price" => $data['unit_price'], 
            "bruto_price" => $data['bruto_price'],
            "discount" => $data['discount'],
            "nett_total" => $data['nett_total'],
            "notes" => "-",
            "status" => "finished"
        ];
        return $this->detailSale->create($arr);
    }

    public function update($id, $data)
    {
        $detail = [
            "sales_id" => $id,
            "conversion_id" => $data['conversion_id'],
            "item_name" => $data['item_name'], 
            "sku" => $data['sku']
        ];

        $arr = [
            "sales_id" => $id,
            "conversion_id" => $data['conversion_id'],
            "item_name" => $data['item_name'], 
            "sku" => $data['sku'], 
            "qty" => $data['qty'],
            "unit" => $data['unit'],
            "unit_price" => $data['unit_price'], 
            "bruto_price" => $data['bruto_price'],
            "discount" => $data['discount'],
            "nett_total" => $data['nett_total'],
            "notes" => "-",
            "status" => "finished"
        ];
        return $this->detailSale->where('sales_id', $id)->updateOrCreate($detail, $arr);
    }

    public function delete($id)
    {
        $this->detailSale->find($id)->delete();
    }

    public function delete_by_sales_id($id)
    {
        $this->detailSale->where('sales_id',$id)->delete();
    }
}