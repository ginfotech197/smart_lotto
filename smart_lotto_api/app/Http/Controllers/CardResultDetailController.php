<?php

namespace App\Http\Controllers;

use App\Models\CardResultDetail;
use App\Http\Requests\StoreCardResultDetailRequest;
use App\Http\Requests\UpdateCardResultDetailRequest;

class CardResultDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreCardResultDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCardResultDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CardResultDetail  $cardResultDetail
     * @return \Illuminate\Http\Response
     */
    public function show(CardResultDetail $cardResultDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CardResultDetail  $cardResultDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(CardResultDetail $cardResultDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCardResultDetailRequest  $request
     * @param  \App\Models\CardResultDetail  $cardResultDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCardResultDetailRequest $request, CardResultDetail $cardResultDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CardResultDetail  $cardResultDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardResultDetail $cardResultDetail)
    {
        //
    }
}
