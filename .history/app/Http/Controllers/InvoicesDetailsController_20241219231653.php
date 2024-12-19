<?php

namespace App\Http\Controllers;

use App\Models\invoices_details;
use App\Models\invoices_attachments;
use Illuminate\Http\Request;
use App\Models\Invoices;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //get the details of the invoice by its id which is in the request coming:
        $invoices=Invoices::where('id',$id)->first();
        //each invoice has many details records(one-to-many),so we get the details records of a specific invoice by its id:
        $details=invoices_details::where('id_invoice',$id)->get();
        $attachments=invoices_attachments::where('invoice_id',$id)->get();
        return view('invoices\details_invoices',compact('invoices','details','attachments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //find the attachment to delete by its id:
        $invoices=invoices_attachments::findOrFail($request->id_file);
        $invoices->delete();
        //delete the attachment form the attachments folder:
            $files = Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
            session()->flash('delete','Deleted Successfully');
            return back();

    }

    public function open_file($invoice_number,$file_name)

    {
        //return $file_name;
        $files = Storage::disk('public_uploads')->path($invoice_number.'/'.$file_name);
        return response()->file($files);
    }



    public function get_file($invoice_number,$file_name)

    {
        //return $file_name;
        $contents = Storage::disk('public_uploads')->path($invoice_number.'/'.$file_name);
        return response()->download($contents);
    }
}
