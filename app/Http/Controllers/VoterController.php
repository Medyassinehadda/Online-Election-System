<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $condidats = Condidat::all();
        // dd($condidats);
        return view('welcome', ["condidats"=>$condidats]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!$request->filled('avatarVoter')){
            return redirect()->route('condidats.index')
            ->with('erreur','Failed vote !!');
        }

        if(!$request->filled('myvote')){
            return redirect()->route('condidats.index')
            ->with('erreur','Failed vote !!');
        }

        $request->validate([
            'myvote'=> 'required',
            'idVoter'=> 'required',
            'avatarVoter' => 'required'
        ]);
        
        $img =  $request['avatarVoter'];
        $folderPath = "avatarVoter/";
        $image_parts = explode(";base64,", $img);

        foreach ($image_parts as $key => $image){
            $image_base64 = base64_decode($image);
        }

        $fileName = uniqid() . '.png';
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        $voters = Voter::create([
            'myvote'=> $request->input('myvote'),
            'idVoter'=> $request->input('idVoter'),
            'avatar' => $fileName,
        ]);

        return redirect()->route('condidats.index')
            ->with('success','Vote added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voter  $voter
     * @return \Illuminate\Http\Response
     */
    public function show(Voter $voter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voter  $voter
     * @return \Illuminate\Http\Response
     */
    public function edit(Voter $voter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voter  $voter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voter $voter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voter  $voter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voter $voter)
    {
        //
    }
}
