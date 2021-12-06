<?php

namespace App\Http\Controllers;

use App\Models\CardResultMaster;
use App\Http\Requests\StoreCardResultMasterRequest;
use App\Http\Requests\UpdateCardResultMasterRequest;
use App\Models\CardDrawMaster;
use App\Models\ResultMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $data = CardDrawMaster::select('card_result_masters.game_date','card_draw_masters.end_time',
                                            'card_result_masters.card_combination_id','card_combinations.rank_name',
                                            'card_combinations.suit_name'
                )
                ->leftJoin('card_result_masters', function ($join) use ($result_date) {
                    $join->on('card_draw_masters.id','=','card_result_masters.card_draw_master_id')
                        ->where('card_result_masters.game_date','=', $result_date);
                })
                // ->leftJoin('card_result_details','card_result_details.card_combination_id','card_combinations.id')
                ->leftJoin('card_combinations','card_result_masters.card_combination_id','card_combinations.id')
                // ->leftJoin('card_combinations','result_masters.card_combination_id','card_combinations.id')
                ->get();
            $temp_array['result'] = $data;
            $result_array[] = $temp_array;

        }

        return response()->json(['success'=>1,'data'=>$result_array[0]], 200,[],JSON_NUMERIC_CHECK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_card_result_by_date(Request $request){

        $date= $request['game_date'];
        // echo $date.' test date';
        // return response()->json(['success'=>1,'data'=>$date], 200,[],JSON_NUMERIC_CHECK);

        $toDay= ResultMaster::where('game_date','2021-12-06')->get();


        $data = DB::select("select
        end_time
        ,card_draw_masters.id as card_draw_id
        ,card_result_details.card_result_masters_id
        ,card_result_masters.game_date
        ,card_draw_masters.visible_time
        ,card_combinations.rank_name
        ,card_result_details.card_combination_id
        ,card_combinations.suit_name as result
        from card_result_details
        inner join (select * from card_result_masters where date(game_date)='$date')
        card_result_masters on card_result_details.card_result_masters_id = card_result_masters.id
        inner join card_draw_masters on card_result_masters.card_draw_master_id = card_draw_masters.id
        inner join game_types ON game_types.id = card_result_details.game_type_id
        inner join card_combinations ON card_combinations.id = card_result_details.card_combination_id
        ");
        $temp_array['result'] = $data;
        $result_array[] = $temp_array;




        return response()->json(['success'=>1,'data'=>$result_array[0]], 200,[],JSON_NUMERIC_CHECK);

    }

    public function get_card_results_by_current_date(){
        $result_array = array();

        $result_array['game_date'] = Carbon::today()->format('Y-m-d');
        // $today= Carbon::today()->format('Y-m-d');

        $data = DB::select("select
        end_time
        ,card_draw_masters.id as card_draw_id
        ,card_result_details.card_result_masters_id
        ,card_result_masters.game_date
        ,card_draw_masters.visible_time
        ,card_combinations.suit_name
        ,card_combinations.rank_name
        from card_result_details
        inner join (select * from card_result_masters where date(game_date)=?)card_result_masters on card_result_details.card_result_masters_id = card_result_masters.id
        inner join card_draw_masters on card_result_masters.card_draw_master_id = card_draw_masters.id
        inner join card_combinations ON card_combinations.id = card_result_details.card_combination_id
        ",[ $result_array['game_date']]);
        $result_array['result'] = $data;


        return response()->json(['success'=>1,'data'=>$result_array], 200,[],JSON_NUMERIC_CHECK);

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
