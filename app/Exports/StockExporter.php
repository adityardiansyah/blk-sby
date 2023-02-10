<?php

namespace App\Exports;

use App\Http\Repository\ReportRepository;
use App\Models\GoodsReceive;
use App\Models\Shop;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;

class StockExporter implements FromView
{
    use Exportable;
    protected $shop_id, $date_start, $date_end;

    public function __construct($id, $date_start, $date_end) {
        $this->shop_id = $id;
        $this->date_start = $date_start;
        $this->date_end = $date_end;
    }

    public function view(): View
    {
        $shop = Shop::find($this->shop_id);
        $report = new ReportRepository();
        $data =  $report->get_all_by_shop($this->shop_id, $this->date_start,$this->date_end);
        return view('exports.stock', [
            'data' => $data,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'shop' => $shop->name
        ]);
    }
}
