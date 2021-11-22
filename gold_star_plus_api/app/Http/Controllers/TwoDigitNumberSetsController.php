<?php

namespace App\Http\Controllers;

use App\Models\TwoDigitNumberSets;
use Illuminate\Http\Request;

class TwoDigitNumberSetsController extends Controller
{
    public function getTwoDigitNumberSets()
    {
       $data = TwoDigitNumberSets::select('id','number_set')->get();
        return response()->json(['success' => 1, 'data' => $data], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\twoDigitNumberSets  $twoDigitNumberSets
     * @return \Illuminate\Http\Response
     */
    public function show(twoDigitNumberSets $twoDigitNumberSets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\twoDigitNumberSets  $twoDigitNumberSets
     * @return \Illuminate\Http\Response
     */
    public function edit(twoDigitNumberSets $twoDigitNumberSets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\twoDigitNumberSets  $twoDigitNumberSets
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, twoDigitNumberSets $twoDigitNumberSets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\twoDigitNumberSets  $twoDigitNumberSets
     * @return \Illuminate\Http\Response
     */
    public function destroy(twoDigitNumberSets $twoDigitNumberSets)
    {
        //
    }
}
