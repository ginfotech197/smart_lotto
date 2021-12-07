<?php

namespace App\Http\Controllers;

use App\Models\CardPlayMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardPlayMasterController extends Controller
{

    public function get_total_sale($today, $draw_id, $game_type_id)
    {
        $total = DB::select(DB::raw("select sum(card_play_details.quantity*card_play_details.mrp) as total_balance from card_play_details
        inner join card_play_masters ON card_play_masters.id = card_play_details.card_play_master_id
        where card_play_masters.card_draw_master_id = $draw_id and card_play_details.game_type_id= $game_type_id  and date(card_play_details.created_at)= "."'".$today."'"."
        "));

        if(!empty($total) && isset($total[0]->total_balance) && !empty($total[0]->total_balance)){
            return $total[0]->total_balance;
        }else{
            return 0;
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
     * @param  \App\Models\CardPlayMaster  $cardPlayMaster
     * @return \Illuminate\Http\Response
     */
    public function show(CardPlayMaster $cardPlayMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CardPlayMaster  $cardPlayMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(CardPlayMaster $cardPlayMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CardPlayMaster  $cardPlayMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CardPlayMaster $cardPlayMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CardPlayMaster  $cardPlayMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardPlayMaster $cardPlayMaster)
    {
        //
    }
}
