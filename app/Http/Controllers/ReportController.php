<?php

namespace App\Http\Controllers;

use App\Exports\SalesExporter;
use App\Exports\StockExporter;
use App\Http\Repository\ConversionRepository;
use App\Http\Repository\ReportRepository;
use App\Models\Shop;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    public function __construct(
        private ConversionRepository $conversionRepository,
        private ReportRepository $reportRepository
    ) {
        $this->middleware(function ($request, $next){
            Session::put('menu_active','/laporan');
            return $next($request);
        });
    }
    public function index()
    {
        $shop = Shop::all();
        return view('page.report.report', compact('shop'));
    }

    public function laporan_stock($date_start, $date_end,$shop_id)
    {
        $data = [];
        $pdf = FacadePdf::loadview('page.report.stock',['data'=>$data]);
	    return $pdf->stream();
    }

    public function download_excel($type, Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $shop_id = $request->shop_id;
        if($type === "stock"){
            return $this->download_excel_stock($date_start, $date_end, $shop_id);
        }elseif($type === "sales"){
            return $this->download_excel_sales($date_start, $date_end, $shop_id);
        }
    }

    public function download_excel_stock($date_start, $date_end, $shop_id)
    {
        return (new StockExporter($shop_id, $date_start,$date_end))->download('laporan-stock.xlsx');
    }

    public function download_excel_sales($date_start, $date_end, $shop_id)
    {
        return (new SalesExporter($shop_id, $date_start,$date_end))->download('laporan-sales.xlsx');
    }
}
