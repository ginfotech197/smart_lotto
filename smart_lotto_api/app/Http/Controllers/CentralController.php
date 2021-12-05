<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NumberCombination;
use App\Models\PlayMaster;
use Illuminate\Http\Request;
use App\Models\NextGameDraw;
use App\Models\DrawMaster;
use App\Http\Controllers\PlayMasterController;
use App\Http\Controllers\NumberCombinationController;
use App\Models\GameType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CentralController extends Controller
{

    public function createResult(){

        $today= Carbon::today()->format('Y-m-d');
        $nextGameDrawObj = NextGameDraw::first();
        $nextDrawId = $nextGameDrawObj->next_draw_id;
        $lastDrawId = $nextGameDrawObj->last_draw_id;
        $playMasterControllerObj = new PlayMasterController();

        $playMasterObj = new TerminalReportController();
        $playMasterObj->updateCancellation();
        $totalGame = GameType::count();

        for($i=1;$i<=$totalGame;$i++) {
            $totalSale = $playMasterControllerObj->get_total_sale($today, $lastDrawId, $i);
            $gameType = GameType::find($i);
            $payout = ($totalSale * ($gameType->payout)) / 100;
            $targetValue = floor($payout / $gameType->winning_price);
            // result less than equal to target value
            $result = DB::select(DB::raw("select two_digit_number_sets.id as two_digit_number_set_id,two_digit_number_sets.number_set,
                two_digit_number_combinations.id as two_digit_number_combination_id,
                sum(play_details.quantity) as total_quantity
                from play_details
                inner join play_masters ON play_masters.id = play_details.play_master_id
                inner join two_digit_number_sets ON two_digit_number_sets.id = play_details.two_digit_number_set_id
                inner join two_digit_number_combinations on two_digit_number_combinations.two_digit_number_set_id = two_digit_number_sets.id
                where play_masters.draw_master_id = $lastDrawId and play_details.game_type_id=$i and date(play_details.created_at)= " . "'" . $today . "'" . "
                group by two_digit_number_sets.number_set,two_digit_number_sets.id,two_digit_number_combinations.id
                having sum(play_details.quantity)<= $targetValue
                order by rand() limit 1"));

            // select empty item for result
            if (empty($result)) {
                // empty value
                $result = DB::select(DB::raw("SELECT two_digit_number_sets.id as two_digit_number_set_id,two_digit_number_combinations.id as two_digit_number_combination_id
                    FROM two_digit_number_sets
                    inner join two_digit_number_combinations on two_digit_number_combinations.two_digit_number_set_id = two_digit_number_sets.id
                    WHERE two_digit_number_sets.id NOT IN(SELECT DISTINCT
                    play_details.two_digit_number_set_id FROM play_details
                    INNER JOIN play_masters on play_details.play_master_id= play_masters.id
                    WHERE  DATE(play_masters.created_at) = " . "'" . $today . "'" . " and play_masters.draw_master_id = $lastDrawId
                    and play_details.game_type_id=$i)
                    ORDER by rand() LIMIT 1"));
            }

            // result greater than equal to target value
            if (empty($result)) {
                $result = DB::select(DB::raw("select two_digit_number_sets.id as two_digit_number_set_id,two_digit_number_sets.number_set,
                    two_digit_number_combinations.id as two_digit_number_combination_id,
                    sum(play_details.quantity) as total_quantity
                    from play_details
                    inner join play_masters ON play_masters.id = play_details.play_master_id
                    inner join two_digit_number_sets ON two_digit_number_sets.id = play_details.two_digit_number_set_id
                    inner join two_digit_number_combinations on two_digit_number_combinations.two_digit_number_set_id = two_digit_number_sets.id
                    where play_masters.draw_master_id = $lastDrawId and play_details.game_type_id=$i and date(play_details.created_at)= " . "'" . $today . "'" . "
                    group by two_digit_number_sets.number_set,two_digit_number_sets.id,two_digit_number_combinations.id
                    having sum(play_details.quantity)>= $targetValue
                    order by rand() limit 1"));
            }


            $two_digit_result_id = $result[0]->two_digit_number_combination_id;

            DrawMaster::query()->update(['active' => 0]);
            if (!empty($nextGameDrawObj)) {
                DrawMaster::findOrFail($nextDrawId)->update(['active' => 1]);
            }


            $resultMasterController = new ResultMasterController();
            $jsonData = $resultMasterController->save_auto_result($lastDrawId, $two_digit_result_id, $gameType->id);
        }

        $resultCreatedObj = json_decode($jsonData->content(),true);

//        $actionId = 'score_update';
//        $actionData = array('team1_score' => 46);
//        event(new ActionEvent($actionId, $actionData));

        if( !empty($resultCreatedObj) && $resultCreatedObj['success']==1){

            $totalDraw = DrawMaster::count();
            if($nextDrawId==$totalDraw){
                $nextDrawId = 1;
            }
            else {
                $nextDrawId = $nextDrawId + 1;
            }

            if($lastDrawId==$totalDraw){
                $lastDrawId = 1;
            }
            else{
                $lastDrawId = $lastDrawId + 1;
            }

            $nextGameDrawObj->next_draw_id = $nextDrawId;
            $nextGameDrawObj->last_draw_id = $lastDrawId;
            $nextGameDrawObj->save();

            return response()->json(['success'=>1, 'message' => 'Result added'], 200);
        }else{
            return response()->json(['success'=>0, 'message' => 'Result not added'], 401);
        }

    }


    public function createResultCard(){

        $today= Carbon::today()->format('Y-m-d');
        $nextGameDrawObj = NextGameDraw::first();
        $nextDrawId = $nextGameDrawObj->next_draw_id;
        $lastDrawId = $nextGameDrawObj->last_draw_id;
        $playMasterControllerObj = new PlayMasterController();

        $playMasterObj = new TerminalReportController();
        $playMasterObj->updateCancellation();
        $totalGame = GameType::count();

//        for($i=1;$i<=$totalGame;$i++) {
            $totalSale = $playMasterControllerObj->get_total_sale($today, $lastDrawId, 6);
            $gameType = GameType::find(6);
            $payout = ($totalSale * ($gameType->payout)) / 100;
            $targetValue = floor($payout / $gameType->winning_price);
            // result less than equal to target value
            $result = DB::select(DB::raw("select card_combinations.id as card_combination_id,
                sum(card_play_details.quantity) as total_quantity
                from card_play_details
                inner join card_play_masters ON card_play_masters.id = card_play_details.card_play_master_id
                inner join card_combinations ON card_combinations.id = card_play_details.card_combination_id
                where card_play_masters.card_draw_master_id = $lastDrawId and card_play_details.game_type_id=6 and date(card_play_details.created_at)= " . "'" . $today . "'" . "
                group by card_combinations.id
                having sum(card_play_details.quantity)<= $targetValue
                order by rand() limit 1"));

            // select empty item for result
            if (empty($result)) {
                // empty value
                $result = DB::select(DB::raw("SELECT card_combinations.id as card_combination_id
                    FROM card_combinations
                    WHERE card_combinations.id NOT IN(SELECT DISTINCT
                    card_play_details.card_combination_id FROM card_play_details
                    INNER JOIN card_play_masters on card_play_details.card_play_master_id= card_play_masters.id
                    WHERE  DATE(card_play_masters.created_at) = " . "'" . $today . "'" . " and card_play_masters.card_draw_master_id = $lastDrawId
                    and card_play_details.game_type_id=6)
                    ORDER by rand() LIMIT 1"));
            }

            // result greater than equal to target value
            if (empty($result)) {
                $result = DB::select(DB::raw("select card_combinations.id as card_combination_id,
                    sum(card_play_details.quantity) as total_quantity
                    from card_play_details
                    inner join card_play_masters ON card_play_masters.id = card_play_details.card_play_master_id
                    inner join card_combinations ON card_combinations.id = card_play_details.card_combination_id
                    where card_play_masters.card_draw_master_id = $lastDrawId and card_play_details.game_type_id=6 and date(card_play_details.created_at)= " . "'" . $today . "'" . "
                    group by card_combinations.id
                    having sum(card_play_details.quantity)>= $targetValue
                    order by rand() limit 1"));
            }


            $two_digit_result_id = $result[0]->card_combination_id;

            DrawMaster::query()->update(['active' => 0]);
            if (!empty($nextGameDrawObj)) {
                DrawMaster::findOrFail($nextDrawId)->update(['active' => 1]);
            }


            $resultMasterController = new ResultMasterController();
            $jsonData = $resultMasterController->save_auto_result_card($lastDrawId, $two_digit_result_id, 6);
//        }

        $resultCreatedObj = json_decode($jsonData->content(),true);

//        $actionId = 'score_update';
//        $actionData = array('team1_score' => 46);
//        event(new ActionEvent($actionId, $actionData));

        if( !empty($resultCreatedObj) && $resultCreatedObj['success']==1){

            $totalDraw = DrawMaster::count();
            if($nextDrawId==$totalDraw){
                $nextDrawId = 1;
            }
            else {
                $nextDrawId = $nextDrawId + 1;
            }

            if($lastDrawId==$totalDraw){
                $lastDrawId = 1;
            }
            else{
                $lastDrawId = $lastDrawId + 1;
            }

            $nextGameDrawObj->next_draw_id = $nextDrawId;
            $nextGameDrawObj->last_draw_id = $lastDrawId;
            $nextGameDrawObj->save();

            return response()->json(['success'=>1, 'message' => 'Result added'], 200);
        }else{
            return response()->json(['success'=>0, 'message' => 'Result not added'], 401);
        }

    }



    public function createResultByDate(){

        $today= '2021-09-02';
        $nextGameDrawObj = NextGameDraw::first();
        $nextDrawId = 7;
        $lastDrawId = 6;
        $playMasterControllerObj = new PlayMasterController();

        $totalSale = $playMasterControllerObj->get_total_sale($today,$lastDrawId);
        $single = GameType::find(1);

        $payout = ($totalSale*($single->payout))/100;
        $targetValue = floor($payout/$single->winning_price);
        echo $targetValue;

        // result less than equal to target value
        $result = DB::select(DB::raw("select single_numbers.id as single_number_id,single_numbers.single_number,sum(play_details.quantity) as total_quantity  from play_details
        inner join play_masters ON play_masters.id = play_details.play_master_id
        inner join single_numbers ON single_numbers.id = play_details.single_number_id
        where play_masters.draw_master_id = $lastDrawId  and date(play_details.created_at)= "."'".$today."'"."
        group by single_numbers.single_number,single_numbers.id
        having sum(play_details.quantity)<= $targetValue
        order by rand() limit 1"));

        echo 'Check1';
        print_r($result);
        if(empty($result)){
            // empty value
            $result = DB::select(DB::raw("SELECT single_numbers.id as single_number_id FROM single_numbers WHERE id NOT IN(SELECT DISTINCT
        play_details.single_number_id FROM play_details
        INNER JOIN play_masters on play_details.play_master_id= play_masters.id
        WHERE  DATE(play_masters.created_at) = "."'".$today."'"." and play_masters.draw_master_id = $lastDrawId) ORDER by rand() LIMIT 1"));
        }
        echo 'Check2';
        print_r($result);

        if(empty($result)){
            $result = DB::select(DB::raw("select single_numbers.id as single_number_id,single_numbers.single_number,sum(play_details.quantity) as total_quantity  from play_details
            inner join play_masters ON play_masters.id = play_details.play_master_id
            inner join single_numbers ON single_numbers.id = play_details.single_number_id
            where play_masters.draw_master_id= $lastDrawId  and date(play_details.created_at)= "."'".$today."'"."
            group by single_numbers.single_number,single_numbers.id
            having sum(play_details.quantity)>= $targetValue
            order by rand() limit 1"));
        }

        echo 'Check3';
        print_r($result);

        $single_number_result_id = $result[0]->single_number_id;


        $resultMasterController = new ResultMasterController();
        $jsonData = $resultMasterController->save_auto_result($lastDrawId,$single_number_result_id);

        $resultCreatedObj = json_decode($jsonData->content(),true);

//        $actionId = 'score_update';
//        $actionData = array('team1_score' => 46);
//        event(new ActionEvent($actionId, $actionData));

        if( !empty($resultCreatedObj) && $resultCreatedObj['success']==1){

            return response()->json(['success'=>1, 'message' => 'Result added'], 200);
        }else{
            return response()->json(['success'=>0, 'message' => 'Result not added'], 401);
        }

    }

}
