<?php

namespace App\Http\Controllers;

use App\Models\CardDrawMaster;
use App\Http\Resources\CardDrawMasterResource;
use App\Models\DrawMaster;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardDrawMasterController extends Controller
{
    public function getActiveDraw()
    {
        $result = CardDrawMaster::where('active',1)->first();
        if(!empty($result)){
            return response()->json(['success'=>1,'data'=> new CardDrawMasterResource($result)], 200,[],JSON_NUMERIC_CHECK);
        }else{
            return response()->json(['success'=>1,'data'=> null], 200,[],JSON_NUMERIC_CHECK);
        }

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
     * @param  \App\Models\CardDrawMaster  $cardDrawMaster
     * @return \Illuminate\Http\Response
     */
    public function show(CardDrawMaster $cardDrawMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CardDrawMaster  $cardDrawMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(CardDrawMaster $cardDrawMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CardDrawMaster  $cardDrawMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CardDrawMaster $cardDrawMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CardDrawMaster  $cardDrawMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardDrawMaster $cardDrawMaster)
    {
        //
    }
}
