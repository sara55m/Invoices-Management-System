<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoicesReportController extends Controller
{
    public function index(){
        return view('reports.invoices_report');
    }
}
