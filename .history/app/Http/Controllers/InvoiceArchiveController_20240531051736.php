<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoices;

class InvoiceArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get only the soft deleted invoices from the database:
        $invoices=Invoices::onlyTrashed()->get();
        return view('invoices.Archive_Invoices',compact('invoices'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id=$request->invoice_id;
        //search for invoice that was archived and restore it:
        $restore=Invoices::withTrashed()->where('id',$id)->restore();
        session()->flash('restore_invoice','Invoice Restored Successfully');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
