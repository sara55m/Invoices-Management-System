<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoices;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Support\Facades\Auth;

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
        dd(Auth::user()->permissions;
        /*$total=Invoices::count();
        if($total>0){

        $paid=Invoices::where('Value_Status',1)->count();
        $partially=Invoices::where('Value_Status',3)->count();
        $unpaid=Invoices::where('Value_Status',2)->count();
        $unpaidper=round(($unpaid/$total)*100);
        $paidper=round(($paid/$total)*100);
        $partiallyper=round(($partially/$total)*100);
        if(app()->getLocale() == 'ar'){
            $chart = Chartjs::build()
        ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 350, 'height' => 200])
         ->labels(['الفواتير الغير مدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
         ->datasets([
             [
                 "label" => "الفواتير الغير مدفوعة",
                 'backgroundColor' => ['#f85b75'],
                 'data' => [$unpaidper]
             ],
             [
                 "label" => "الفواتير المدفوعة",
                 'backgroundColor' => ['#25b687'],
                 'data' => [$paidper]
             ],
             [
                 "label" => "الفواتير المدفوعة جزئيا",
                 'backgroundColor' => ['#FF822C'],
                 'data' => [$partiallyper]
             ],


         ])
         ->options([]);

         $chart2 = Chartjs::build()
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير مدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#f85b75', '#25b687','#FF822C'],
                    'data' => [$unpaidper,$paidper,$partiallyper]
                ]
            ])
            ->options([]);
        }else{
            $chart = Chartjs::build()
        ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 350, 'height' => 200])
         ->labels(['UNPAID INVOICES', 'PAID INVOICES','PARTIALLY PAID INVOICES'])
         ->datasets([
             [
                 "label" => "UN PAID INVOICES",
                 'backgroundColor' => ['#f85b75'],
                 'data' => [$unpaidper]
             ],
             [
                 "label" => "PAID INVOICES",
                 'backgroundColor' => ['#25b687'],
                 'data' => [$paidper]
             ],
             [
                 "label" => "PARTIALLY PAID INVOICES  ",
                 'backgroundColor' => ['#FF822C'],
                 'data' => [$partiallyper]
             ],


         ])
         ->options([]);



         $chart2 = Chartjs::build()
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['UN PAID INVOICES', 'PAID INVOICES','PARTIALLY PAID INVOICES'])
            ->datasets([
                [
                    'backgroundColor' => ['#f85b75', '#25b687','#FF822C'],
                    'data' => [$unpaidper,$paidper,$partiallyper]
                ]
            ])
            ->options([]);

        }
        return view('home',compact('chart','chart2','total'));
        }else{
            return view('home',compact('total'));

        }


    }*/
}
}
