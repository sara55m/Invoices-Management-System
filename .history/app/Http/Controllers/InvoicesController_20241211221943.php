<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Sections;
use App\Models\Products;
use App\Models\User;
use App\Models\invoices_details;
use App\Models\invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddInvoice;
use App\Notifications\UserNotification;
use Illuminate\Notifications\DatabaseNotification;

class InvoicesController extends Controller
{
    //protect the controller methods to prevent users from accessing views that they do not have permission for:
function __construct()
{
$this->middleware('permission:Invoices Menu', ['only' => ['index']]);
$this->middleware('permission:Add Invoice', ['only' => ['create','store']]);
$this->middleware('permission:Edit Invoice', ['only' => ['edit','update']]);
$this->middleware('permission:Delete Invoice', ['only' => ['destroy']]);

}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices=Invoices::all();

        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //get all the sections:
        $sections=Sections::all();
        //get all the products:
        //$products=Products::all();
        return view('invoices.add_invoices',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input=$request->all();
        //1-inserting in the invoices table:
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'unpaid',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

         //2-inserting in the invoices details table:

        //get the latest added invoice id from the invoices table:
        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'unpaid',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

         //3-inserting in the invoices attachments table:
        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            //creating a new folder called attachments and moving the file into tht folder by its original name:
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }
        //get all users to notify:
        $user=User::get();
        //get the last added invoice id:
        $invoice=Invoices::latest()->first();
        //send notification to the current user email
        //first method
        //$user->notify(new AddInvoice($invoice_id));
        //second method
        Notification::send($user,new UserNotification($invoice));
        //$user->notify(new UserNotification($invoice));

        session()->flash('Add','The Invoice Was Successfully Added');
        return redirect('/invoices');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       $invoices=Invoices::where('id',$id)->first();
       return view('invoices.status_update',compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices=Invoices::where('id',$id)->first();
        $sections=sections::all();
        return view('invoices.edit_invoice',compact('invoices','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices $invoices)
    {
        //find the invoice to be updated by its id which is in the firm as a hidden input:
        $invoices=Invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'Invoice Updated Successfully');
        return redirect('/invoices');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Invoices $invoices)
    {
        $id=$request->invoice_id;
        $invoices=Invoices::where('id',$id)->first();
        $Details=invoices_attachments::where('invoice_id',$id)->first();
        $id_page=$request->id_page;
        //if the operation is the delete operation:
        if(!$id_page==2){
            //to delete the attachments by deleting the folder named by the invoice number of the invoice
        if (!empty($Details->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
        }
        //deleting the invoice permenantally from the database:
        $invoices->forceDelete();

        session()->flash('delete_invoice');
        return redirect('/invoices');
        }else{
            //if the operation is the archive operation:
            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/invoices');
        }
    }

    public function getProducts($id){
        //this function gets the products and their ids that belong to a specific section by the section id that comes in the request
        $products=DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($products);
    }
    //function to update the status of the invoice:

    public function Status_Update($id,Request $request){
        //find the invoice to update by its id:
        $invoices=Invoices::findOrFail($id);
        //update the status of the invoice:
        if($request->Status==='Paid'){
            $invoices->update([
                'Value_Status'=>1,
                'Status'=>$request->Status,
                'Payment_Date'=>$request->Payment_Date,
            ]);
            //create a new details record where the status is updated to paid:

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'Section' => $request->Section,
                'product' => $request->product,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);

        }else{
            $invoices->update([
                'Value_Status'=>3,
                'Status'=>$request->Status,
                'Payment_Date'=>$request->Payment_Date,
            ]);
            //create a new details record where the status is updated to paid:

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'Section' => $request->Section,
                'product' => $request->product,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);

        }
        return redirect('/invoices');
    }

    public function Invoice_Paid(){
        //get all the paid invoices:
        $invoices=Invoices::where('Value_Status',1)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }

    public function Invoice_unPaid(){
        //get all the unpaid invoices:
        $invoices=Invoices::where('Value_Status',2)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
    }

    public function Invoice_Partial()
    {
        //get all the partially paid invoices:
        $invoices = Invoices::where('Value_Status',3)->get();
        return view('invoices.invoices_partial',compact('invoices'));
    }

    public function Print_invoice($id){
        //get the invoice to be printed by its id:
        $invoices=Invoices::where('id',$id)->first();
        return view('invoices.Print_invoice',compact('invoices'));

    }

    public function mark_all(Request $request){
        $userUnreadNotifications=Auth::user()->unreadNotifications;
        if($userUnreadNotifications){
            $userUnreadNotifications->markAsRead();
            return back();
        }
    }

        public function mark(Request $request,$id){
            $userUnreadNotification=DatabaseNotification::find($id);
            if($userUnreadNotification){
                $userUnreadNotification->markAsRead();
                return back();
            }
    }
}
