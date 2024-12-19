<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //select or get all sections of the database:
        $sections=Sections::all();
        //return the view with all sections in  the database :

        return view('sections.sections',compact('sections'));
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
        
        //1-get all the data in this request:
        $input=$request->all();
        //2-validate input:
        $validateData=$request->validate([
            'section_name'=>'required|unique:sections|max:255',
            'description'=>'required',
            ]);
            //3-creating the section:        
            Sections::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'created_by'=>(Auth::user()->name),//created by the current logged in user
            ]);
            session()->flash('Add','The Section Was Successfully Added');
            return redirect('/sections');



            //check if the section name was previously added to the database to avoid repeatition
        //$b_exists=sections::where('section_name','=',$input['section_name'])->exists();
        //if yes display an error flash message and redirect
        //if($b_exists){
            //session()->flash('Error','The Section Was Previously Added');
            //return redirect('/sections');
            //if no add the data in a new record or row and display a flash success message and redirect
        //}else{

        //}
    }

    /**
     * Display the specified resource.
     */
    public function show(Sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sections $sections)
    {
        //return $request;
        //get the id of the section to be updated
        $id=$request->id;
        //validation
        $this->validate($request,[
            //if the id of the updated field is the same as the id of the pre updated one then there is no repetition
            'section_name'=>'required|max:255|unique:sections,section_name,'.$id,
            'description'=>'required',
        ]);

        //find the section by its id:
        $sections=Sections::find($id);
        //update that section:
        $sections->update(['section_name'=>$request->section_name,
        'description'=>$request->description]);

        //return a success message
        session()->flash('edit','Section Updated Successfully');
        return redirect('/sections');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Sections $sections)
    {
        //get the section to be deleted by its id:
        $id=$request->id;
        //delete that section:
        Sections::find($id)->delete();
        //return a success message
        session()->flash('delete','Section Deleted Successfully');
        return redirect('/sections');


    }
}
