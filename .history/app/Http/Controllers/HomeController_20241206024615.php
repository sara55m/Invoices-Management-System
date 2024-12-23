<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoices;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total=Invoices::count();
        $paid=Invoices::where('Value_Status',1)->count();
        $partially=Invoices::where('Value_Status',3)->count();
        $unpaid=Invoices::where('Value_Status',2)->count();

        $chart = Chartjs::build()
         ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 400, 'height' => 200])
         ->labels(['LABEL X', 'LABEL Y'])
         ->datasets([
             [
                 "label" => "TOTAL INVOICES","PARTIALLY PAID INVOICES",
                 'backgroundColor' => ['#f85b75','#25b687'],
                 'data' => [round(($unpaid/$total)*100),round(($paid/$total)*100)]
             ],
             [
                "label" => "PAID INVOICES",
                'backgroundColor' => ['#0EA5E9','#FF822C'],
                'data' => [100,round(($partially/$total)*100)]
            ]
         ])
         ->options([
            "scales" => [
                "y" => [
                    "beginAtZero" => true
                    ]
                ]
         ]);

        /*$chart2 = Chartjs::build()
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Label x', 'Label y'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => [69, 59]
            ]
        ])
        ->options([]);*/
        return view('home',compact('chart'));
    }
}
