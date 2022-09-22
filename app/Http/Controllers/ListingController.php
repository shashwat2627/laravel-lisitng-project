<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;


class ListingController extends Controller
{
    public function index()
    {
        return view('listings.index',[
        
            'listings'=> Listing::latest()->filter
            (request(['tag','search']))->paginate(3)
        
        ]);
    }

    public function show(Listing $listing)
    {
        return view('listings.show',[

            'listing'=>$listing
        ]);
    }

    public function create()
    {

        return view('listings.create');
    }

    public function store(Request $request)
    {
    //    dd($request->all());

        $formFields= $request->validate([

            'title'=>'required',
            'company'=>['required',Rule::unique('listings','company')],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
            
            
        ]);
        
        if($request->hasFile('logo'))
        {
            $formFields['logo'] =$request->filter('logo')->store('logos','public');
        }

        $formFields['user_id'] = auth()->id();
        

        Listing::create($formFields);

           //     

      return redirect('/')->with('message','Listing created');
    
    }
 
    
    public function edit(Listing $listing)
    {
 // dd($listing->title);
       
        return view('listings.edit',['listing'=>$listing]);
    }




     public function update(Request $request,Listing $listing)
    {
        if($listing->user_id !=auth()->id())
        {

            abort(403,'unknown action');

        }
        //dd($request);

        $formFields= $request->validate([

            'title'=>'required',
            'company'=>['required'],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'tags'=>'required',
            'description'=>'required'
            
            
        ]);
       
        
        if($request->hasFile('logo'))
        {
            $formFields['logo'] = $request->filter('logo')->store('logos','public');
        }

       $listing->update($formFields);

           //     

      return back()->with('message','record updated successfully');

    }

    public function destroy(Listing $listing)
    {
    
        $listing->delete();

        return redirect('/')->with('message','record deleted Succesfully');


    }

    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
