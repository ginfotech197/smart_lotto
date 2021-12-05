<?php

namespace App\Http\Controllers;

use App\Models\CardResultMaster;
use App\Http\Requests\StoreCardResultMasterRequest;
use App\Http\Requests\UpdateCardResultMasterRequest;
use App\Models\CardDrawMaster;

class CardResultMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_card_results()
    {
        $result_dates= CardResultMaster::distinct()->orderBy('game_date','desc')->pluck('game_date');
        $result_array = array();
        foreach($result_dates as $result_date){
            $temp_array['date'] = $result_date;
            $data = CardDrawMaster::select('card_result_masters.game_date','card_draw_masters.end_time'
                )
                ->leftJoin('card_result_masters', function ($join) use ($result_date) {
                    $join->on('card_draw_masters.id','=','card_result_masters.card_draw_master_id')
                        ->where('card_result_masters.game_date','=', $result_date);
                })
                ->leftJoin('card_result_details','card_result_details.card_combination_id','card_combinations.id')
                ->leftJoin('card_combinations','result_masters.card_combination_id','card_combinations.id')
                ->get();
            $temp_array['result'] = $data;
            $result_array[] = $temp_array;

        }

        return response()->json(['success'=>1,'data'=>$result_array], 200,[],JSON_NUMERIC_CHECK);
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
     * @param  \App\Http\Requests\StoreCardResultMasterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCardResultMasterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CardResultMaster  $cardResultMaster
     * @return \Illuminate\Http\Response
     */
    public function show(CardResultMaster $cardResultMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CardResultMaster  $cardResultMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(CardResultMaster $cardResultMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCardResultMasterRequest  $request
     * @param  \App\Models\CardResultMaster  $cardResultMaster
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCardResultMasterRequest $request, CardResultMaster $cardResultMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CardResultMaster  $cardResultMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardResultMaster $cardResultMaster)
    {
        //
    }
}
