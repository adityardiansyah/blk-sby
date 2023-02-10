<?php
namespace App\Http\Repository;

use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportRepository{

    public function get_all_by_shop($shop_id, $date_start, $date_end)
    {
        $data = DB::select("
            select c.id, c.name_item, c.sku, pm.`group`, pm.brand, pm.variant, pm.motive, c.color, c.`size`,
            sum(qty_final) qty_on_hand, c.price
            from conversions c 
            join product_masters pm on pm.id = c.product_master_id 
            where c.shop_id = $shop_id
            group by 1,2,3,4,5,6,7,8,9,11
        ");

        foreach ($data as $key => $value) {
            $stock_awal = $this->query_stock_last_month($date_start, $value->id, $shop_id);
            $gr = $this->query_gr($date_start, $date_end, $value->id, $shop_id);
            $sales = $this->query_sales($date_start, $date_end, $value->id, $shop_id);
            
            $value->last_month = !empty($stock_awal[0])? (int)$stock_awal[0]->total : 0;
            $value->gr = !empty($gr[0])? (int)$gr[0]->total : 0;
            $value->sales = !empty($sales[0])? (int)$sales[0]->total : 0;
            $value->qty_on_hand = (int)$value->qty_on_hand;
        }
        return $data;
    }

    public function query_stock_last_month($date_start, $conversion_id, $shop_id)
    {
        $data = DB::select("
            SELECT sum(qty) total from stock_opname so 
            join detail_stock_opname dso on dso.stock_opname_id = so.id 
            where trans_date = LAST_DAY(DATE_ADD('$date_start', INTERVAL - 1 MONTH)) 
            and shop_id = $shop_id 
            and dso.conversion_id = $conversion_id
            and so.status = 'confirmed'
            group by dso.conversion_id 
            limit 1
        ");
        return $data;
    }

    public function query_gr($date_start, $date_end, $conversion_id, $shop_id)
    {
        $data = DB::select("
            SELECT sum(grd.qty) total from goods_receives gr 
            join goods_receive_details grd on grd.goods_receive_id = gr.id 
            where 
            gr.shop_id = $shop_id
            and grd.conversion_id = $conversion_id
            and gr.receive_date BETWEEN '$date_start' and '$date_end'
            and gr.status = 'confirmed'
            group by grd.conversion_id 
            limit 1
        ");
        return $data;
    }

    public function query_sales($date_start, $date_end, $conversion_id, $shop_id)
    {
        $data = DB::select("
            SELECT sum(ds.qty) total from sales s 
            join detail_sales ds on ds.sales_id = s.id 
            where s.shop_id = $shop_id
            and ds.conversion_id = $conversion_id
            and s.trans_date BETWEEN '$date_start' and '$date_end'
            and s.status = 'confirmed'
            group by ds.conversion_id 
            limit 1
        ");
        return $data;
    }

    public function get_all_sales_by_shop($shop_id, $date_start, $date_end)
    {
        $data = DB::select("
            SELECT s.trans_date, ds.item_name, ds.sku, pm.`group`, pm.brand, pm.variant, pm.motive, c.color, 
            c.`size`, ds.qty, ds.unit_price, 0 disc, 0 add_disc, ds.bruto_price, ds.bruto_price total
            from sales s 
            join detail_sales ds on ds.sales_id = s.id 
            join conversions c on c.id = ds.conversion_id 
            join product_masters pm on pm.id = c.product_master_id 
            where s.shop_id = $shop_id
            and s.trans_date BETWEEN '$date_start' and '$date_end'
            and s.status = 'confirmed'
            order by s.trans_date asc
        ");
        return $data;
    }

}