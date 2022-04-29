<?php

namespace App\Http\Controllers;

use App\Models\Condidat;
use App\Models\User;
use App\Models\Voter;
use Illuminate\Http\Request;

class CondidatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $condidats = Condidat::all();
        $avatars = User::get()->pluck('avatar')->toArray();
        $avatarsVoters = Voter::get()->pluck('avatar')->toArray();
        // dd($condidats);

        return view('welcome')->with('condidats', $condidats)->with('avatars', $avatars)->with('avatarsVoters', $avatarsVoters);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('condidats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //methods we can use on $request
        
        //guessExtension()
        //getMimeType()
        //store()
        //asStore()
        //storePublicly()
        //move()
        //getClientOriginalName()
        //getClientMimeType()
        //guessClientExtension()
        //getSize()
        //getError()
        //isValid()

        // $test = $request->file('image')-> getClientMimeType();

        // dd($test);

        $request->validate([
            'name'=> 'required',
            'age'=> 'required',
            'detail'=> 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048',
            'cv'=> 'required|mimes:pdf,docx|max:10048'
        ]);
        

        //for image
        $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();

        $request->image->move(public_path('images'), $newImageName );

        //for cv
        $cvCondidat = time() . '-' .$request->name . '.' . $request->cv->extension();
        $request->cv->move(public_path('cvCondidats'),$cvCondidat);


        $condidats = Condidat::create([
            'name'=> $request->input('name'),
            'age'=> $request->input('age'),
            'detail'=> $request->input('detail'),
            'image_path' => $newImageName ,
            'cv' => $cvCondidat
        ]);

        return redirect()->route('condidats.index')
        ->with('success','Condidat added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Condidat  $condidat
     * @return \Illuminate\Http\Response
     */
    public function show(Condidat $condidat)
    {
        return view('welcome',compact('condidat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Condidat  $condidat
     * @return \Illuminate\Http\Response
     */
    public function edit(Condidat $condidat)
    {
        return view('condidats.edit',compact('condidat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Condidat  $condidat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Condidat $condidat)
    {
        $request->validate([
            'name'=> 'required',
            'age'=> 'required',
            'detail'=> 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048',
            'cv'=> 'required|mimes:pdf,docx|max:10048'
        ]);

        //for image
        $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();

        $request->image->move(public_path('images'), $newImageName );

        //for cv
        $cvCondidat = time() . '-' .$request->name . '.' . $request->cv->extension();
        $request->cv->move(public_path('cvCondidats'),$cvCondidat);
        
        $condidat->update($request->all());
        return redirect()->route('condidats.index')
        ->with('success','condidat updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Condidat  $condidat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Condidat $condidat)
    {
        $condidat->delete();
        return redirect()->route('condidats.index')
        ->with('success','condidat deleted successfully');
    }
}
