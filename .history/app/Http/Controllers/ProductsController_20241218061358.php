<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sections;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    //protect the controller methods to prevent users from accessing views that they do not have permission for:
function __construct()
{

$this->middleware('permission:Products', ['only' => ['index']]);
$this->middleware('permission:Add Product', ['only' => ['create','store']]);
$this->middleware('permission:Edit Product', ['only' => ['edit','update']]);
$this->middleware('permission:Delete Product', ['only' => ['destroy']]);

}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all the sections in the database to choose from them the section for this product:
        $sections=Sections::all();
        //get all the products in the database
        $products=Products::all();
        return view('products.products',compact('sections','products'));
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
        //get the added data in the request:
        $input=$request->all();
        //validate the data:
        $validateData=$request->validate([
            'product_name'=>'unique:products|max:255|required',
            'description'=>'max:255|required',
            'section_id'=>'required',

        ]);

        //create a new product:
        Products::create([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$request->section_id,

        ]);

        session()->flash('Add','The Product Was Successfully Added');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {

        //getting the section id to which the product belongs using the section name:
        $id=Sections::where('section_name',$request->section_name)->first()->id;
        //find by product by its id:
        $products=Products::findOrFail($request->product_id);
        //validation
        $this->validate($request,[
            //if the id of the updated field is the same as the id of the pre updated one then there is no repetition
            'product_name'=>'required|max:255|unique:products,product_name,'.$id,
            'description'=>'max:255',

        ]);

        $products->update([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$id,

        ]);
        //return a success message

        session()->flash('Edit','Product Updated Successfully');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Products $products)

    {
        //find the id of the product to be deleted:
        $products=Products::findOrFail($request->product_id);
        //delete the product:
        $products->delete();
        //return a success message

        session()->flash('delete','Product Deleted Successfully');
        return back();


    }
}
