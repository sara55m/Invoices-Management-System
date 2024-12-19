<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentsController extends Controller
{
     //protect the controller methods to prevent users from accessing views that they do not have permission for:
function __construct()
{
$this->middleware('permission:Add Attachment ', ['only' => ['create','store']]);
$this->middleware('permission:Delete Attachment', ['only' => ['destroy']]);
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $this->validate($request,[
            'file_name'=>'mimes:png,jpg,pdf,jpeg',
        ],
        [
            'file_name.mimes'=>'Attachment format must be png,jpg,pdf,jpeg'
        ]);
        $image=$request->file('file_name');
        $file_name = $image->getClientOriginalName();

        $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $request->invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $request->invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->file_name->getClientOriginalName();
            //creating a new folder called attachments and moving the file into tht folder by its original name:
            $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $imageName);

            session()->flash('Add', 'Attachment Added Successfully');
        return back();


    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoices_attachments $invoices_attachments)
    {
        //
    }
}
