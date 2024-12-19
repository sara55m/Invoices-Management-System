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

        /*$chart = Chartjs::build()
         ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 400, 'height' => 200])
         ->labels(['LABEL X', 'LABEL Y'])
         ->datasets([
             [
                 "label" => "UN PAID INVOICES",
                 'backgroundColor' => ['#f85b75','#0EA5E9'],
                 'data' => [round(($unpaid/$total)*100),round(($partially/$total)*100)]
             ],
             [
                "label" =>"PAID INVOICES",
                'backgroundColor' => ['#25b687','#FF822C'],
                'data' => [100,round(($paid/$total)*100)]
            ]
         ])
         ->options([
            "scales" => [
                "y" => [
                    "beginAtZero" => true
                    ]
                ]
         ]);*/

         $chart = Chartjs::build()
         ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 350, 'height' => 200])
         ->labels(['UN PAID INVOICES', 'PAID INVOICES','PARTIALLY PAID INVOICES'])
         ->datasets([
             [
                 "label" => "UN PAID INVOICES",
                 'backgroundColor' => ['#f85b75'],
                 'data' => [round(($unpaid/$total)*100)]
             ],
             [
                 "label" => "PAID INVOICES",
                 'backgroundColor' => ['#25b687'],
                 'data' => [round(($paid/$total)*100)]
             ],
             [
                 "label" => "PARTIALLY PAID INVOICES  ",
                 'backgroundColor' => ['#FF822C'],
                 'data' => [round(($partially/$total)*100)]
             ],


         ])
         ->options([]);


        return view('home',compact('chart'));
    }
}
