<?php

namespace App\Http\Controllers;

use App\Exports\StockExporter;
use App\Http\Repository\ConversionRepository;
use App\Http\Repository\ReportRepository;
use App\Models\Shop;
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
            Session::put('menu_active','laporan');
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
        $pdf = PDF::loadview('page.report.stock',['data'=>$data]);
	    return $pdf->stream();
    }

    public function download_excel_stock()
    {
        // $q = new ReportRepository();
        // return $data =  $q->get_all_by_shop(1, '2023-02-01','2023-02-29');
        return (new StockExporter(1, '2023-02-01','2023-02-29'))->download('stock.xlsx');
    }
}