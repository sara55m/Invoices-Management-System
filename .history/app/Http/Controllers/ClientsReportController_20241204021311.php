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
        //$products=Products::all();
        return view('reports.customers_report',compact('sections','products'));
    }

    public function search_clients(Request $request){
        //dd($request);
        //when searching using invoice type

            if($request->Section && $request->product && $request->start_at=='' && $request->end_date==''){
                $invoices=Invoices::select('*')->where('Section',$request->Section)->where('product',$request->product);
                return view('reports.customers_report',compact('invoices'));
            }else{
                //search with invoice type,start date and end date
                //convert into valid date format
                $start_at=date($request->start_at);
                $end_at=date($request->end_at);
                $invoices=Invoices::select('*')
                ->whereBetween('invoice_Date',[$start_at,$end_at])
                ->where('Section',$request->Section)
                ->where('product',$request->product)
                ->get();

                return view('reports.customers_report',compact('start_at','end_at','invoices'));
            }


        }


    }

