<?php

namespace App\Http\Controllers;

use App\Models\DrawMaster;
use App\Models\ManualResult;
use App\Models\NextGameDraw;
use App\Models\NumberCombination;
use App\Models\ResultDetail;
use App\Models\ResultMaster;
use App\Models\SingleNumber;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;


class ResultMasterController extends Controller
{
    public function get_results()
    {
        $result_dates= ResultMaster::distinct()->orderBy('game_date','desc')->pluck('game_date');

//        return response()->json(['success'=>1,'data'=>$result_dates], 200,[],JSON_NUMERIC_CHECK);

        $result_array = array();
        foreach($result_dates as $result_date){
            $temp_array['date'] = $result_date;



            $data = DrawMaster::select('result_masters.game_date','draw_masters.end_time',
                'two_digit_number_combinations.visible_number')
                ->leftJoin('result_masters', function ($join) use ($result_date) {
                    $join->on('draw_masters.id','=','result_masters.draw_master_id')
                        ->where('result_masters.game_date','=', $result_date);
                })
                ->leftJoin('two_digit_number_combinations','result_details.two_digit_number_combination_id','two_digit_number_combinations.id')
                ->get();

            /*Do Not delete*/
            /* This is another way to use sub query */
//            $result_query =get_sql_with_bindings(ResultMaster::where('game_date',$result_date));
//            $data1 = DrawMaster::leftJoin(DB::raw("($result_query) as result_masters"),'draw_masters.id','=','result_masters.draw_master_id')
//                ->leftJoin('number_combinations','result_masters.number_combination_id','number_combinations.id')
//                ->leftJoin('single_numbers','number_combinations.single_number_id','single_numbers.id')
//                ->select('result_masters.game_date','draw_masters.end_time','number_combinations.triple_number','number_combinations.visible_triple_number','single_numbers.single_number')
//                ->get();
            $temp_array['result'] = $data;
            $result_array[] = $temp_array;

        }

        return response()->json(['success'=>1,'data'=>$result_array], 200,[],JSON_NUMERIC_CHECK);
    }
    public function get_results_by_current_date(){
        $result_array = array();

        $result_array['date'] = Carbon::today();

        // $result_query =get_sql_with_bindings(ResultMaster::where('game_date', Carbon::today()));
        // $data = DrawMaster::leftJoin(DB::raw("($result_query) as result_masters"),'draw_masters.id','=','result_masters.draw_master_id')
        //     ->leftJoin('two_digit_number_combinations','result_masters.two_digit_number_combination_id','two_digit_number_combinations.id')
        //     ->select('result_masters.game_date','draw_masters.end_time','two_digit_number_combinations.visible_number')
        //     ->get();
        $data = DB::select("select date_format(game_date,'%d/%m/%Y') as draw_date,visible_time,max(game_one) as game_one ,max(game_two) as game_two, max(game_three) as game_three,
        max(game_four) as game_four, max(game_five) as game_five
        from
        (select *,
        case when game_type_id = 1 then result end as game_one ,
        case when game_type_id = 2 then result end as game_two,
        case when game_type_id = 3 then result end as game_three,
        case when game_type_id = 4 then result end as game_four,
        case when game_type_id = 5 then result end as game_five
        from
        (select
        end_time
        ,draw_masters.id as draw_id
        ,game_types.id as game_type_id
        ,result_details.result_masters_id
        ,result_masters.game_date
        ,draw_masters.visible_time
        ,two_digit_number_combinations.visible_number as result
        from result_details
        inner join (select * from result_masters where date(game_date)=?)result_masters on result_details.result_masters_id = result_masters.id
        inner join draw_masters on result_masters.draw_master_id = draw_masters.id
        inner join game_types ON game_types.id = result_details.game_type_id
        inner join two_digit_number_combinations ON two_digit_number_combinations.id = result_details.two_digit_number_combination_id
        ) as table1) as table2
        group by result_masters_id order by draw_id DESC
        ",[ $result_array['date']]);
        $result_array['result'] = $data;


        return response()->json(['success'=>1,'data'=>$result_array], 200,[],JSON_NUMERIC_CHECK);

    }


    public function save_auto_result($draw_id,$two_digit_number_combination_id,$game_type_id)
    {
        //$single_number_result_id is the calculated result as per total sale
        $manualResult = ManualResult::where('game_date',Carbon::today())
            ->where('draw_master_id',$draw_id)->first();
//        if(!empty($manualResult)){
//            $single_number_for_result = $manualResult->single_number_id;requetAll
//        }else{
//            $selectRandomResult = SingleNumber::all()->random(1)->first();
//            $single_number_for_result = $selectRandomResult->id;
//        }
        if(!empty($manualResult)){
            $two_digit_for_result = $manualResult->two_digit_number_combination_id;
        }else{
            $two_digit_for_result = $two_digit_number_combination_id;
        }

        $tempData = ResultMaster::select()->where('draw_master_id',$draw_id)->where('game_date',Carbon::today())->first();
        if(empty($tempData)) {
            $resultMaster = new ResultMaster();
            $resultMaster->draw_master_id = $draw_id;
//        $resultMaster->two_digit_number_combination_id = $two_digit_for_result;
            $resultMaster->game_date = Carbon::today();
            $resultMaster->save();
        }else{
            $resultMaster = $tempData;
        }

        if(isset($resultMaster->id)){
            $resultDetails = new ResultDetail();
            $resultDetails->result_masters_id = $resultMaster->id;
            $resultDetails->two_digit_number_combination_id = $two_digit_for_result;
            $resultDetails->game_type_id = $game_type_id;
            $resultDetails->save();
        }

        if(isset($resultMaster->id)){
            return response()->json(['success'=>1, 'data' => 'added result'], 200);
        }else{
            return response()->json(['success'=>0, 'data' => 'result not added'], 500);
        }
    }

    public function get_last_result(){

        $result_query =get_sql_with_bindings(ResultMaster::where('game_date', Carbon::today()));
        $data = DrawMaster::join(DB::raw("($result_query) as result_masters"),'draw_masters.id','=','result_masters.draw_master_id')
            ->join('result_details','result_details.result_masters_id','result_masters.id')
            ->leftJoin('two_digit_number_combinations','result_details.two_digit_number_combination_id','two_digit_number_combinations.id')
            ->leftJoin('game_types','result_details.game_type_id','game_types.id')
            ->select('result_masters.game_date','draw_masters.end_time','draw_masters.visible_time','two_digit_number_combinations.visible_number',
                'game_types.game_name','game_types.series_name')
            ->orderBy('result_masters.draw_master_id','desc')
            ->whereNotNull('two_digit_number_combinations.visible_number')
            ->limit(5)
            ->get();

        return response()->json(['success'=> 1, 'data' => $data], 200);
    }

    public function get_result_by_date(Request $request){

        $date= $request['date'];
        // return response()->json(['success'=>1,'data'=>$date], 200,[],JSON_NUMERIC_CHECK);



        $data = DB::select("select date_format(game_date,'%d/%m/%Y') as draw_date,visible_time,max(game_one) as game_one ,max(game_two) as game_two, max(game_three) as game_three,
        max(game_four) as game_four, max(game_five) as game_five
        from
        (select *,
        case when game_type_id = 1 then result end as game_one ,
        case when game_type_id = 2 then result end as game_two,
        case when game_type_id = 3 then result end as game_three,
        case when game_type_id = 4 then result end as game_four,
        case when game_type_id = 5 then result end as game_five
        from
        (select
        end_time
        ,draw_masters.id as draw_id
        ,game_types.id as game_type_id
        ,result_details.result_masters_id
        ,result_masters.game_date
        ,draw_masters.visible_time
        ,two_digit_number_combinations.visible_number as result
        from result_details
        inner join (select * from result_masters where date(game_date)='$date')result_masters on result_details.result_masters_id = result_masters.id
        inner join draw_masters on result_masters.draw_master_id = draw_masters.id
        inner join game_types ON game_types.id = result_details.game_type_id
        inner join two_digit_number_combinations ON two_digit_number_combinations.id = result_details.two_digit_number_combination_id
        ) as table1) as table2
        group by result_masters_id order by draw_id DESC
        ");




        return response()->json(['success'=>1,'data'=>$data], 200,[],JSON_NUMERIC_CHECK);

    }
}
