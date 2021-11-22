<?php

namespace App\Http\Controllers;

use App\Http\Resources\ManualResultResource;
use App\Models\GameType;
use App\Models\ManualResult;
use App\Models\ResultMaster;
use App\Models\TwoDigitNumberCombinations;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManualResultController extends Controller
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


    public function save_manual_result(Request $request)
    {
//        $rules = array(
//            'drawMasterId'=>['required','exists:draw_masters,id',
//                    function($attribute, $value, $fail){
//                        $existingManual=ManualResult::where('draw_master_id', $value)->where('game_date','=',Carbon::today())->first();
//                        if($existingManual){
//                            $fail($value.' Duplicate entry');
//                        }
//                    }
//                ],
////            'numberCombinationId'=>'required|exists:number_combinations,id',
//        );
//        $validator = Validator::make($request->all(),$rules);
//
//        if($validator->fails()){
//            return response()->json(['success'=>0,'data'=>null,'error'=>$validator->messages()], 406,[],JSON_NUMERIC_CHECK);
//        }
        $requestedData = $request->json()->all();
//        return response()->json(['success'=>1,'data'=> $requestedData], 200,[],JSON_NUMERIC_CHECK);
//        DB::beginTransaction();
//        try{
//        $requestedData.foreach ()
        foreach ($requestedData as $items) {
            $twoNumberCombination = TwoDigitNumberCombinations::select()->where('visible_number',$items['twoDigitNumberCombinationId'] )->first();
            $manualResult = new ManualResult();
            $manualResult->draw_master_id = $items['drawMasterId'];
            $manualResult->two_digit_number_combination_id = $twoNumberCombination->id;
            $manualResult->game_type_id = $items['gameTypeId'];
            $manualResult->game_date = Carbon::today();
            $manualResult->save();
        }

//            DB::commit();
//        }catch (\Exception $e){
//            DB::rollBack();
//            return response()->json(['success'=>0, 'data' => null, 'error'=>$e->getMessage()], 500);
//        }

//        return response()->json(['success'=>1,'data'=> new ManualResultResource($manualResult)], 200,[],JSON_NUMERIC_CHECK);
        return response()->json(['success'=>1,'data'=> $manualResult], 200,[],JSON_NUMERIC_CHECK);
    }

    public function get_load_details($id)
    {

//        $data = [
//            'id' => 1,
//            'game_id' => 2
//        ];
//
//        return response()->json(['success'=> 1, 'data' => $data], 200);

//        return response()->json(['success'=> 1, 'data' => $id], 200);

//        return response()->json(['success'=> 1, 'data' => $request], 200);
//        $data = DB::select("select game_types.id ,game_types.game_name, two_digit_number_sets.number_set, sum(play_details.quantity) as total from play_masters
//                inner join play_details on play_details.play_master_id = play_masters.id
//                inner join game_types on game_types.id = play_details.game_type_id
//                inner join two_digit_number_sets on two_digit_number_sets.id = play_details.two_digit_number_set_id
//                inner join draw_masters on draw_masters.id = play_masters.draw_master_id
//                group by  game_types.id ,game_types.game_name, two_digit_number_sets.number_set");

//        $gameTypes = GameType::select('id')->get();
//        $data1 = [];
//        $tempDate = [];
//        foreach ($gameTypes as $gameType){
//            $data = DB::select("select sum(play_details.quantity) as total from play_masters
//                inner join play_details on play_details.play_master_id = play_masters.id
//                inner join game_types on game_types.id = play_details.game_type_id
//                inner join two_digit_number_sets on two_digit_number_sets.id = play_details.two_digit_number_set_id
//                inner join draw_masters on draw_masters.id = play_masters.draw_master_id
//                where game_types.id = ".$gameType->id." and draw_masters.id = ".$id."
//                group by  game_types.id ,game_types.game_name, two_digit_number_sets.number_set
//                ");
//            if(!$data){
//                for($i = 0; $i <= 9; $i++){
//                    $data = [
//                        'total' => 0
//                    ];
//                    array_push($tempDate, $data);
//                }
//                $data = $tempDate;
//            };
//            array_push($data1, $data);
//        }
//        return response()->json(['success'=> 1, 'data' => $data1], 200);

        $play_date = Carbon::today()->format('Y-m-d');
//        return response()->json(['success'=> 1, 'data' => $play_date], 200);

//        $data = DB::select("SELECT game_type_id,max(set1)as set1,max(set2)as set2,
//max(set3)as set3,max(set4)as set4,max(set5)as set5,max(set6)as set6,max(set7)as set7,max(set8)as set8,max(set9)as set9,
//max(set10)as set10
//
//FROM(select *,case when two_digit_number_set_id = 1 then quantity end as set1 ,
//        case when two_digit_number_set_id = 2 then quantity end as set2,
//        case when two_digit_number_set_id = 3 then quantity end as set3,
//        case when two_digit_number_set_id = 4 then quantity end as set4,
//        case when two_digit_number_set_id = 5 then quantity end as set5,
//        case when two_digit_number_set_id = 6 then quantity end as set6,
//        case when two_digit_number_set_id = 7 then quantity end as set7,
//        case when two_digit_number_set_id = 8 then quantity end as set8,
//        case when two_digit_number_set_id = 9 then quantity end as set9,
//        case when two_digit_number_set_id = 10 then quantity end as set10
//
//from (SELECT play_details.game_type_id,play_details.two_digit_number_set_id,max(two_digit_number_sets.number_set) as number_set,sum(play_details.quantity) as quantity FROM `play_masters`
//INNER JOIN play_details ON play_masters.id=play_details.play_master_id
//INNER JOIN two_digit_number_sets ON play_details.two_digit_number_set_id=two_digit_number_sets.id
//WHERE play_masters.draw_master_id=".$id." and date(play_masters.created_at)=? GROUP BY play_details.game_type_id,play_details.two_digit_number_set_id) as table1) as table2 GROUP BY game_type_id"
//            ,[$play_date]);

        $data = DB::select("select game_types.id, table3.set1, table3.set2, table3.set3, table3.set4, table3.set5, table3.set6, table3.set7, table3.set8, table3.set9, table3.set10 from (sELECT game_type_id,max(set1)as set1,max(set2)as set2,
max(set3)as set3,max(set4)as set4,max(set5)as set5,max(set6)as set6,max(set7)as set7,max(set8)as set8,max(set9)as set9,
max(set10)as set10

FROM(select *,case when two_digit_number_set_id = 1 then quantity end as set1 ,
        case when two_digit_number_set_id = 2 then quantity end as set2,
        case when two_digit_number_set_id = 3 then quantity end as set3,
        case when two_digit_number_set_id = 4 then quantity end as set4,
        case when two_digit_number_set_id = 5 then quantity end as set5,
        case when two_digit_number_set_id = 6 then quantity end as set6,
        case when two_digit_number_set_id = 7 then quantity end as set7,
        case when two_digit_number_set_id = 8 then quantity end as set8,
        case when two_digit_number_set_id = 9 then quantity end as set9,
        case when two_digit_number_set_id = 10 then quantity end as set10

from (SELECT play_details.game_type_id,play_details.two_digit_number_set_id,max(two_digit_number_sets.number_set) as number_set,sum(play_details.quantity) as quantity FROM `play_masters`
INNER JOIN play_details ON play_masters.id=play_details.play_master_id
INNER JOIN two_digit_number_sets ON play_details.two_digit_number_set_id=two_digit_number_sets.id
WHERE play_masters.draw_master_id=".$id." and date(play_masters.created_at)=?
GROUP BY play_details.game_type_id,play_details.two_digit_number_set_id) as table1) as table2 GROUP BY game_type_id) as table3
right join game_types on table3.game_type_id = game_types.id",[$play_date]);



        return response()->json(['success'=> 1, 'data' => $data], 200);

    }

    public function show(ManualResult $manualResult)
    {
        //
    }

    public function edit(ManualResult $manualResult)
    {
        //
    }

    public function update(Request $request, ManualResult $manualResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ManualResult  $manualResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManualResult $manualResult)
    {
        //
    }
}
