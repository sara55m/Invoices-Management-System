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
        $products=Products::all();
        return view('reports.customers_report',compact('sections','products'));
    }

    public function search_clients(Request $request){
        //dd($request);
        //when searching using invoice type

            if($request->Section && $request->product && $request->start_at=='' && $request->end_date==''){
                $invoices=Invoices::select('*')->where('Section',$request->Section)->where('product',$request->product);
                return view('reports.invoices_report',compact('invoices'));
            }
            //search with only invoice type
            if($request->type && $request->start_at=='' && $request->end_date==''){
                $invoices=Invoices::select('*')->where('Status',$request->type)->get();
                $type=$request->type;
                return view('reports.invoices_report',compact('type','invoices'));
            }else{
                //search with invoice type,start date and end date
                $type=$request->type;
                //convert into valid date format
                $start_at=date($request->start_at);
                $end_at=date($request->end_at);
                $invoices=Invoices::select('*')
                ->whereBetween('invoice_Date',[$start_at,$end_at])
                ->where('Status',$request->type)
                ->get();

                return view('reports.invoices_report',compact('type','start_at','end_at','invoices'));
            }


        }


    }

