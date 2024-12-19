<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class InvoicesReportController extends Controller
{
    public function index(){
        return view('reports.invoices_report');
    }

    public function search_invoices(Request $request){
        //dd($request);
        //when searching using invoice type
        $rdio=$request->rdio;
        if($rdio==1){
            if($request->type && $request->start_at=='' && $request->end_date==''){
                $invoices=Invoices::select('*')->where('status',$request->type)->get();
                $type=$request->type;
                return view('reports.invoices_report',compact('type'))->withDetails('invoices');
            }else{
                $type=$request->type;
                $start_at=$request->start_at;
                $end_at=$request->end_at;
                $invoices=Invoices::select('*')
                ->whereBetween('invoice_Date',[$start_at,$end_at])
                ->where('status',$request->type)
                ->get();

                return view('reports.invoices_report',compact('type','start_at','end_at'))->withDetails('invoices');
            }
        }


    }
}
