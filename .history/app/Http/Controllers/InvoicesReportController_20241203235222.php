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
            //search with only invoice type
            if($request->type && $request->start_at=='' && $request->end_date==''){
                $invoices=Invoices::select('*')->where('status',$request->type)->get();
                $type=$request->type;
                return view('reports.invoices_report',compact('type'))->withDetails('invoices');
            }else{
                //search with invoice type,start date and end date
                $type=$request->type;
                //convert into valid date format
                $start_at=date($request->start_at);
                $end_at=date($request->end_at);
                $invoices=Invoices::select('*')
                ->whereBetween('invoice_Date',[$start_at,$end_at])
                ->where('status',$request->type)
                ->get();

                return view('reports.invoices_report',compact('type','start_at','end_at'))->withDetails('invoices');
            }
        }


    }
}
