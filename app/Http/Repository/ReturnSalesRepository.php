<?php
namespace App\Http\Repository;

use App\Models\Conversion;
use App\Models\DetailSale;
use App\Models\ReturnSale;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class ReturnSalesRepository{
    protected $sale, $detailSale, $returnSale, $conversion, $detailSalesRepository;

    public function __construct(Sale $sl, DetailSale $ds, ReturnSale $rs, Conversion $conv, DetailSalesRepository $detailSalesRepository) {
        $this->sale = $sl;
        $this->detailSale = $ds;
        $this->returnSale = $rs;
        $this->conversion = $conv;
        $this->detailSalesRepository = $detailSalesRepository;
    }

    public function get_data_by_shop($id)
    {
        return $this->returnSale->where('shop_id', $id)->get();
    }

    public function get_data_by_id($id)
    {
        return $this->returnSale->where('id', $id)->first();
    }

    public function create($data)
    {
        $detail_sales_id = $data['detail_sales_id'];
        $qty = $data['qty'];

        $detailSale = $this->detailSale->with('sales')->find($detail_sales_id);
        // update qty produk awal
        $dev = $detailSale->qty;
        if($qty < $detailSale->qty){
            $dev = $detailSale->qty - $qty;
        }
        
        $bruto = $dev * $detailSale->unit_price;
        $netto = $bruto - $detailSale->discount;
        $updateDataOld = [
            'qty'=>$dev,
            'bruto_price' => $bruto,
            'nett_total' => $netto
        ];

        if($qty < $detailSale->qty){
            $detailSale->qty_return = $qty;
            // pecah detail sales
            $this->detailSalesRepository->create($detailSale, $detailSale->sales_id, "return");
            
            $this->detailSale->find($detail_sales_id)->update($updateDataOld);
        }else{
            $updateDataOld['status'] = "return";
            $this->detailSale->find($detail_sales_id)->update($updateDataOld);
        }
        // update qty final konversi
        $conv = $this->conversion->find($detailSale->conversion_id);
        $qty_final = $conv->qty_final + $qty;
        $this->conversion->find($detailSale->conversion_id)->update(['qty_final'=>$qty_final]);
        
        $retur = [
            'seller_id' => Auth::user()->seller->id,
            'shop_id' => Auth::user()->seller->shop_id,
            'conversion_id' => $detailSale->conversion_id,
            'no_return' => $detailSale->sales->invoice.'-'.date('ymdHis'),
            'date_return' => date('Y-m-d'),
            'date_sale' => $detailSale->sales->trans_date,
            'invoice' => $detailSale->sales->invoice,
            'item_name' => $detailSale->item_name,
            'sku' => $detailSale->sku,
            'qty' =>  $data['qty'],
            'unit' => $detailSale->unit,
            'unit_price' => $detailSale->unit_price,
            'bruto_price' => $detailSale->unit_price * $data['qty'],
            'discount' => $detailSale->discount,
            'nett_total' => $detailSale->unit_price * $data['qty'] - $detailSale->discount,
            'notes' => $data['notes']
        ];
        // Insert tabel retur
        return $this->returnSale->create($retur);
    }

}