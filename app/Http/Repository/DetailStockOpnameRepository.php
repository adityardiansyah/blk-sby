<?php
namespace App\Http\Repository;

use App\Models\DetailStockOpname;
use App\Models\StockOpname;
use Illuminate\Support\Facades\Auth;

class DetailStockOpnameRepository{
    protected $stock, $detailStockOpname;

    public function __construct(StockOpname $stockOpname, DetailStockOpname $ds) {
        $this->stock = $stockOpname;
        $this->detailStockOpname = $ds;
    }

    public function get_data_by_shop($id)
    {
        return $this->detailStockOpname->with('detail')->where('shop_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function get_data_by_id($id)
    {
        return $this->detailStockOpname->with('detail')->where('id', $id)->first();
    }

    public function create($data, $stock_opname_id)
    {
        $arr = [
            "stock_opname_id" => $stock_opname_id,
            "conversion_id" => $data['conversion_id'],
            "item_name" => $data['item_name'],
            "sku" => $data['sku'],
            "qty" => $data['qty'],
        ];
        return $this->detailStockOpname->create($arr);
    }

    public function update($id, $data)
    {
        $arr = [
            "trans_date" => $data['trans_date'],
            "include_tax" => $data['include_tax'],
            "tax_persen" => $data['tax_persen'],
            "notes" => $data['notes'],
        ];
        return $this->detailStockOpname->where('id', $id)->update($arr);
    }

    public function delete($id)
    {
        $this->detailStockOpname->find($id)->delete();
    }

    public function update_status($id, $type)
    {
        $this->detailStockOpname->where('id',$id)->update(['status'=>$type]);
    }

    public function delete_by_stock_opname_id($id)
    {
        $this->detailStockOpname->where('stock_opname_id',$id)->delete();
    }
}