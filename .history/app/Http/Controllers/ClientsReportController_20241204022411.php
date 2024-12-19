<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoices;
use App\Models\Sections;
use App\Models\Products;


class ClientsReportController extends Controller
{
    public function index(){
        $sections=Sections::all();
        return view('reports.customers_report',compact('sections'));
    }

    public function search_clients(Request $request){
        //dd($request);
        //when searching without date
        if($request->Section && $request->product && $request->start_at=='' && $request->end_date==''){
            $invoices=Invoices::select('*')->where('section_id',$request->Section)->where('product',$request->product);
            $sections=Sections::all();
            return view('reports.customers_report',compact('invoices','sections'));
        }else{
            //search with section , product,start date and end date
            //convert into valid date format
            $start_at=date($request->start_at);
            $end_at=date($request->end_at);
            $invoices=Invoices::select('*')
            ->whereBetween('invoice_Date',[$start_at,$end_at])
            ->where('section_id',$request->Section)
            ->where('product',$request->product)
            ->get();
            $sections=Sections::all();
            return view('reports.customers_report',compact('start_at','end_at','invoices','sections'));
        }
        }


    }

