<?php

namespace App\Http\Controllers;

use App\Models\CardCombination;
use App\Models\CardPlayDetail;
use App\Models\CardPlayMaster;
use App\Models\CardResultDetail;
use App\Models\CardResultMaster;
use App\Models\ResultDetail;
use App\Models\ResultMaster;
use App\Models\TwoDigitNumberCombinations;
use App\Models\TwoDigitNumberSets;
use Faker\Core\Number;
use Illuminate\Http\Request;
use App\Models\PlayMaster;
use App\Models\PlayDetails;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CPanelReportController extends Controller
{
    public function barcode_wise_report(){
        $x = $this->get_total_quantity_by_barcode(2);

        $data = PlayMaster::select('play_masters.id as play_master_id', DB::raw('substr(play_masters.barcode_number, 1, 8) as barcode_number')
            ,'draw_masters.visible_time as draw_time',
            'users.email as terminal_pin','play_masters.created_at as ticket_taken_time'
            )
            ->join('draw_masters','play_masters.draw_master_id','draw_masters.id')
            ->join('users','users.id','play_masters.user_id')
            ->join('play_details','play_details.play_master_id','play_masters.id')
            ->where('play_masters.is_cancelled',0)
            ->groupBy('play_masters.id','play_masters.barcode_number','draw_masters.visible_time','users.email','play_masters.created_at')
            ->orderBy('play_masters.created_at','desc')
            ->get();

        foreach($data as $x){
            $detail = (object)$x;
            $detail->total_quantity = $this->get_total_quantity_by_barcode($detail->play_master_id);
            $detail->prize_value = $this->get_prize_value_by_barcode($detail->play_master_id);
            $detail->amount = $this->get_total_amount_by_barcode($detail->play_master_id);
        }
        return response()->json(['success'=> 1, 'data' => $data], 200);
    }

    public function barcode_wise_report_by_date(Request $request){
        $requestedData = (object)$request->json()->all();
        $start_date = $requestedData->startDate;
        $end_date = $requestedData->endDate;

        $data = PlayMaster::select('play_masters.id as play_master_id', DB::raw('substr(play_masters.barcode_number, 1, 8) as barcode_number')
            ,'draw_masters.visible_time as draw_time',
            'users.email as terminal_pin','play_masters.created_at as ticket_taken_time'
        )
            ->join('draw_masters','play_masters.draw_master_id','draw_masters.id')
            ->join('users','users.id','play_masters.user_id')
            ->join('play_details','play_details.play_master_id','play_masters.id')
            ->where('play_masters.is_cancelled',0)
//            ->where('play_masters.created_at','>=',$start_date)
//            ->where('play_masters.created_at','<=',$end_date)
            ->whereRaw('date(play_masters.created_at) >= ?', [$start_date])
            ->whereRaw('date(play_masters.created_at) <= ?', [$end_date])
            ->groupBy('play_masters.id','play_masters.barcode_number','draw_masters.visible_time','users.email','play_masters.created_at')
            ->orderBy('play_masters.created_at','desc')
            ->get();

        foreach($data as $x){
            $detail = (object)$x;
            $detail->total_quantity = $this->get_total_quantity_by_barcode($detail->play_master_id);
            $detail->prize_value = $this->get_prize_value_by_barcode($detail->play_master_id);
            $detail->amount = $this->get_total_amount_by_barcode($detail->play_master_id);
        }

        $card_data = $this->card_barcode_wise_report_by_dates($start_date,$end_date);
        foreach ($card_data as $x){
//            array_push($data,(object)$x);
            $data->push($x);
        }

        return response()->json(['success'=> 1, 'data' => $data], 200);
    }

    public function card_barcode_wise_report_by_date(Request $request){
        $requestedData = (object)$request->json()->all();
        $start_date = $requestedData->startDate;
        $end_date = $requestedData->endDate;

        $data = CardPlayMaster::select('card_play_masters.id as play_master_id', DB::raw('substr(card_play_masters.barcode_number, 1, 8) as barcode_number')
            ,'card_draw_masters.visible_time as draw_time',
            'users.email as terminal_pin','card_play_masters.created_at as ticket_taken_time'
        )
            ->join('card_draw_masters','card_play_masters.card_draw_master_id','card_draw_masters.id')
            ->join('users','users.id','card_play_masters.user_id')
            ->join('card_play_details','card_play_details.card_play_master_id','card_play_masters.id')
            ->where('card_play_masters.is_cancelled',0)
            ->whereRaw('date(card_play_masters.created_at) >= ?', [$start_date])
            ->whereRaw('date(card_play_masters.created_at) <= ?', [$end_date])
            ->groupBy('card_play_masters.id','card_play_masters.barcode_number','card_draw_masters.visible_time','users.email','card_play_masters.created_at')
            ->orderBy('card_play_masters.created_at','desc')
            ->get();

        foreach($data as $x){
            $detail = (object)$x;
            $detail->total_quantity = $this->get_card_total_quantity_by_barcode($detail->play_master_id);
            $detail->prize_value = $this->get_card_prize_value_by_barcode($detail->play_master_id);
            $detail->amount = $this->get_card_total_amount_by_barcode($detail->play_master_id);
        }
        return response()->json(['success'=> 1, 'data' => $data], 200);
    }

    public function card_barcode_wise_report_by_dates($start_date,$end_date){
        $data = CardPlayMaster::select('card_play_masters.id as play_master_id', DB::raw('substr(card_play_masters.barcode_number, 1, 8) as barcode_number')
            ,'card_draw_masters.visible_time as draw_time',
            'users.email as terminal_pin','card_play_masters.created_at as ticket_taken_time'
        )
            ->join('card_draw_masters','card_play_masters.card_draw_master_id','card_draw_masters.id')
            ->join('users','users.id','card_play_masters.user_id')
            ->join('card_play_details','card_play_details.card_play_master_id','card_play_masters.id')
            ->where('card_play_masters.is_cancelled',0)
            ->whereRaw('date(card_play_masters.created_at) >= ?', [$start_date])
            ->whereRaw('date(card_play_masters.created_at) <= ?', [$end_date])
            ->groupBy('card_play_masters.id','card_play_masters.barcode_number','card_draw_masters.visible_time','users.email','card_play_masters.created_at')
            ->orderBy('card_play_masters.created_at','desc')
            ->get();

        foreach($data as $x){
            $detail = (object)$x;
            $detail->total_quantity = $this->get_card_total_quantity_by_barcode($detail->play_master_id);
            $detail->prize_value = $this->get_card_prize_value_by_barcode($detail->play_master_id);
            $detail->amount = $this->get_card_total_amount_by_barcode($detail->play_master_id);
        }
        return $data ;
    }



    public function get_barcode_report_particulars($play_master_id){
        $data = array();
        $playMaster = PlayMaster::findOrFail($play_master_id);

//        $play_details = PlayDetails::select()->where('play_master_id',$play_master_id)->get();
        $play_game_ids = PlayDetails::where('play_master_id',$play_master_id)->distinct()->pluck('game_type_id');

//        return response()->json(['success'=> 1, 'data' => $play_game_ids], 200);

        $data = [];
        $data['barcode'] = Str::substr($playMaster->barcode_number,0,8);
       // foreach ($play_game_ids as $game_id){

        $gameInputDetails = DB::select("select play_details.game_type_id,game_types.game_name,game_types.series_name, two_digit_number_sets.number_set, play_details.quantity from play_details
        inner join game_types on play_details.game_type_id = game_types.id
        inner join two_digit_number_sets on play_details.two_digit_number_set_id = two_digit_number_sets.id
        where play_details.play_master_id = ".$play_master_id." order by play_details.game_type_id,two_digit_number_sets.id");

        $data['details'] = $gameInputDetails;
//        }
        return response()->json(['success'=> 1, 'data' => $data], 200);

    }

    public function get_card_prize_value_by_barcode($play_master_id){
        $play_master = CardPlayMaster::findOrFail($play_master_id);
        $play_details = CardPlayDetail::select()->where('card_play_master_id',$play_master_id)->get();
        $play_game_ids = CardPlayDetail::where('card_play_master_id',$play_master_id)->distinct()->pluck('game_type_id');
        $play_date = Carbon::parse($play_master->created_at)->format('Y-m-d');
        $result_master = CardResultMaster::where('card_draw_master_id', $play_master->draw_master_id)->where('game_date',$play_date)->first();
        if(empty($result_master)){
            return 0 ;
        }
        $result_details = CardResultDetail::where('result_masters_id',$result_master->id)->get();
        $prize_value = 0;
        foreach ($result_details as $tempDetails) {
            $temp_result_details = CardResultDetail::where('result_masters_id',$result_master->id)->where('game_type_id',$tempDetails->game_type_id)->first();
            $result_number_combination_id = !empty($temp_result_details) ? $temp_result_details->card_combination_id : null;

            if ($result_number_combination_id) {
                $two_digit_number_set_id = (CardCombination::select('id')->where('card_combination_id', $result_number_combination_id)->first())->card_combination_id;
            } else {
                $two_digit_number_set_id = null;
            }

            $prize_value = 0;
            foreach ($play_game_ids as $game_id) {
                $singleGamePrize = CardPlayMaster::join('card_play_details', 'card_play_masters.id', 'card_play_details.play_master_id')
                    ->join('card_combinations', 'card_play_details.card_combination_id', 'card_combinations.id')
                    ->join('game_types', 'card_play_details.game_type_id', 'game_types.id')
                    ->select(DB::raw("max(card_play_details.quantity)* max(game_types.winning_price) as prize_value"))
                    ->where('card_play_masters.id', $play_master_id)
                    ->where('card_play_details.game_type_id', $game_id)
                    ->where('card_play_details.card_combination_id', $two_digit_number_set_id)
                    ->groupBy('card_combinations.id')
                    ->first();

                if (!empty($singleGamePrize)) {
                    $prize_value += $singleGamePrize->prize_value;
                }
            }
        }

        return $prize_value;
    }

    public function get_prize_value_by_barcode($play_master_id){
        $play_master = PlayMaster::findOrFail($play_master_id);
        $play_details = PlayDetails::select()->where('play_master_id',$play_master_id)->get();
        $play_game_ids = PlayDetails::where('play_master_id',$play_master_id)->distinct()->pluck('game_type_id');
//        return response()->json(['success' => 1, 'data' => $play_game_ids], 200);
        $play_date = Carbon::parse($play_master->created_at)->format('Y-m-d');
        $result_master = ResultMaster::where('draw_master_id', $play_master->draw_master_id)->where('game_date',$play_date)->first();
        if(empty($result_master)){
            return 0 ;
        }
        $result_details = ResultDetail::where('result_masters_id',$result_master->id)->get();
//        return response()->json(['success' => 100, 'data' => $result_master, 'data2' => $result_details], 200);
        $prize_value = 0;
        foreach ($result_details as $tempDetails) {
            $temp_result_details = ResultDetail::where('result_masters_id',$result_master->id)->where('game_type_id',$tempDetails->game_type_id)->first();
//        return response()->json(['success' => 100, 'data' => $result_master, 'data2' => $result_details], 200);
            $result_number_combination_id = !empty($temp_result_details) ? $temp_result_details->two_digit_number_combination_id : null;
            if ($result_number_combination_id) {
                $two_digit_number_set_id = (TwoDigitNumberCombinations::select('two_digit_number_set_id')->where('visible_number', $result_number_combination_id)->first())->two_digit_number_set_id;
            } else {
                $two_digit_number_set_id = null;
            }
//        return response()->json(['success' => 1, 'data' => $result_number_combination_id, 'data2' => $two_digit_number_set_id], 200);
            $prize_value = 0;
            foreach ($play_game_ids as $game_id) {
//            if($game_id == 1){
                $singleGamePrize = PlayMaster::join('play_details', 'play_masters.id', 'play_details.play_master_id')
                    ->join('two_digit_number_sets', 'play_details.two_digit_number_set_id', 'two_digit_number_sets.id')
                    ->join('game_types', 'play_details.game_type_id', 'game_types.id')
                    ->select(DB::raw("max(play_details.quantity)* max(game_types.winning_price) as prize_value"))
                    ->where('play_masters.id', $play_master_id)
                    ->where('play_details.game_type_id', $game_id)
                    ->where('play_details.two_digit_number_set_id', $two_digit_number_set_id)
                    ->groupBy('two_digit_number_sets.id')
                    ->first();
//            }
//            if($game_id == 2){
//                $tripleGamePrize = PlayMaster::join('play_details','play_masters.id','play_details.play_master_id')
//                    ->join('number_combinations','play_details.single_number_id','number_combinations.id')
//                    ->join('game_types','play_details.game_type_id','game_types.id')
//                    ->select(DB::raw("play_details.quantity * game_types.winning_price as prize_value") )
//                    ->where('play_masters.id',$play_master_id)
//                    ->where('play_details.game_type_id',$game_id)
//                    ->where('play_details.single_number_id',$result_number_combination_id)
//                    ->first();
//            }

                if (!empty($singleGamePrize)) {
                    $prize_value += $singleGamePrize->prize_value;
                }
            }
        }
//        return ['single' => $singleGamePrize];

//        if(!empty($singleGamePrize)){
//            $prize_value+= $singleGamePrize->prize_value;
//        }
        return $prize_value;
    }

    public function get_card_total_quantity_by_barcode($play_master_id){

        $total_quantity = DB::select("select sum(total_ind) as total from (select sum(card_play_details.quantity) as total_ind from card_play_masters
            inner join card_play_details on card_play_details.card_play_master_id = card_play_masters.id
            where card_play_masters.id = ".$play_master_id."
            group by card_play_masters.id, card_play_details.quantity, card_play_details.mrp) as table1")[0]->total;

        return $total_quantity;
    }

    public function get_total_quantity_by_barcode($play_master_id){
//        $play_master = PlayMaster::findOrFail($play_master_id);
//        $play_game_ids = PlayDetails::where('play_master_id',$play_master_id)->distinct()->pluck('game_type_id');
        $total_quantity = DB::select("select sum(total_ind) as total from (select sum(play_details.quantity) as total_ind from play_masters
            inner join play_details on play_details.play_master_id = play_masters.id
            where play_masters.id = ".$play_master_id."
            group by play_masters.id, play_details.quantity, play_details.mrp) as table1")[0]->total;
//        foreach ($play_game_ids as $game_id){
//            if($game_id == 1){
//                $singleGameQuantity = DB::select("select sum(quantity) as total_quantity from(select max(quantity) as quantity from play_details
//inner join number_combinations ON number_combinations.id = play_details.single_number_id
//where play_details.play_master_id=".$play_master_id." and play_details.game_type_id=1
//group by number_combinations.single_number_id) as table1")[0];
//
//            }
//            if($game_id == 2){
//                $tripleGameQuantity = DB::select("select sum(quantity) as total_quantity from play_details
//inner join number_combinations ON number_combinations.id = play_details.single_number_id
//where play_details.play_master_id=".$play_master_id." and play_details.game_type_id= 2
//group by play_details.play_master_id")[0];
//
//            }
//        }
//
//        if(!empty($singleGameQuantity)){
//            $total_quantity+= $singleGameQuantity->total_quantity;
//        }
//        if(!empty($tripleGameQuantity)){
//            $total_quantity+= $tripleGameQuantity->total_quantity;
//        }
        return $total_quantity;
    }

    public function get_card_total_amount_by_barcode($play_master_id){
        $total_amount =
        $singleGameTotalAmount = DB::select("select sum(total_ind) as total from (select sum(card_play_details.quantity) * card_play_details.mrp as total_ind from card_play_masters
                inner join card_play_details on card_play_details.card_play_master_id = card_play_masters.id
                where card_play_masters.id =  ".$play_master_id."
                group by card_play_masters.id, card_play_details.quantity, card_play_details.mrp) as table1")[0]->total;

        return number_format($total_amount,2);
    }

    public function get_total_amount_by_barcode($play_master_id){
//    public function get_total_amount_by_barcode(){
//        $play_master_id = 2;
//        $play_game_ids = PlayDetails::where('play_master_id',$play_master_id)->distinct()->pluck('game_type_id');
        $total_amount =
        $singleGameTotalAmount = DB::select("select sum(total_ind) as total from (select sum(play_details.quantity) * play_details.mrp as total_ind from play_masters
                inner join play_details on play_details.play_master_id = play_masters.id
                where play_masters.id =  ".$play_master_id."
                group by play_masters.id, play_details.quantity, play_details.mrp) as table1")[0]->total;
//        foreach ($play_game_ids as $game_id){
//            if($game_id == 1){
//                $singleGameTotalAmount = DB::select("select sum(quantity)*max(mrp) as total_amount from(select max(quantity) as quantity,round(max(mrp)*22) as mrp from play_details
//                inner join number_combinations ON number_combinations.id = play_details.single_number_id
//                where play_details.play_master_id= ".$play_master_id." and play_details.game_type_id=1
//                group by number_combinations.single_number_id) as table1")[0];

//                $singleGameTotalAmount = DB::select("select sum(play_details.quantity) * play_details.mrp as total from play_masters
//                    inner join play_details on play_details.play_master_id = play_masters.id
//                    where play_masters.id = ".$play_master_id."
//                    group by play_masters.id, play_details.quantity, play_details.mrp")[0];
//            }
//            if($game_id == 2){
//                $tripleGameTotalAmount = DB::select("select sum(quantity*mrp) as total_amount from play_details
//                inner join number_combinations ON number_combinations.id = play_details.single_number_id
//                where play_details.play_master_id= ".$play_master_id." and play_details.game_type_id= 2
//                group by play_details.play_master_id")[0];
//            }
//        }

//        if(!empty($singleGameTotalAmount)){
//            $total_amount+= $singleGameTotalAmount->total_amount;
//        }
//        if(!empty($tripleGameTotalAmount)){
//            $total_amount+= $tripleGameTotalAmount->total_amount;
//        }
//        return $total_amount;
        return number_format($total_amount,2);
    }

    public function customer_sale_report(){
        $data = DB::select("select table1.play_master_id, table1.terminal_pin, table1.user_name, table1.user_id, table1.stockist_id, table1.total, table1.commission, users.user_name as stokiest_name from (select max(play_master_id) as play_master_id,terminal_pin,user_name,user_id,stockist_id,
        sum(total) as total,round(sum(commission),2) as commission from (
        select max(play_masters.id) as play_master_id,users.user_name,users.email as terminal_pin,
        round(sum(play_details.quantity * play_details.mrp)) as total,
        sum(play_details.quantity * play_details.mrp)* (max(play_details.commission)/100) as commission,
        play_masters.user_id, stockist_to_terminals.stockist_id
        FROM play_masters
        inner join play_details on play_details.play_master_id = play_masters.id
        inner join game_types ON game_types.id = play_details.game_type_id
        inner join users ON users.id = play_masters.user_id
        left join stockist_to_terminals on play_masters.user_id = stockist_to_terminals.terminal_id
        where play_masters.is_cancelled=0
        group by stockist_to_terminals.stockist_id, play_masters.user_id,users.user_name,play_details.game_type_id,users.email) as table1 group by user_name,user_id,terminal_pin,stockist_id) as table1
        left join users on table1.stockist_id = users.id ");

        foreach($data as $x){
            $newPrize = 0;
            $tempntp = 0;
            $newData = PlayMaster::where('user_id',$x->user_id)->get();
            foreach($newData as $y) {
                $tempData = 0;
                $newPrize += $this->get_prize_value_by_barcode($y->id);
                $tempData = (PlayDetails::select(DB::raw("if(game_type_id = 1,(mrp*22)*quantity-(commission/100),mrp*quantity-(commission/100)) as total"))
                    ->where('play_master_id',$y->id)->distinct()->get())[0];
                $tempntp += $tempData->total;
            }
            $detail = (object)$x;
            $detail->prize_value = $newPrize;
            $detail->ntp = $tempntp;
        }
        return response()->json(['success'=> 1, 'data' => $data], 200);
    }

    public function customer_sale_reports(Request $request){
        $requestedData = (object)$request->json()->all();
        $start_date = $requestedData->startDate;
        $end_date = $requestedData->endDate;


        $data = DB::select("select table1.play_master_id, table1.terminal_pin, table1.user_name, table1.user_id, table1.stockist_id, table1.total, table1.commission, users.user_name as stokiest_name from (select max(play_master_id) as play_master_id,terminal_pin,user_name,user_id,stockist_id,
        sum(total) as total,round(sum(commission),2) as commission from (
        select max(play_masters.id) as play_master_id,users.user_name,users.email as terminal_pin,
        round(sum(play_details.quantity * play_details.mrp)) as total,
        sum(play_details.quantity * play_details.mrp)* (max(play_details.commission)/100) as commission,
        play_masters.user_id, stockist_to_terminals.stockist_id
        FROM play_masters
        inner join play_details on play_details.play_master_id = play_masters.id
        inner join game_types ON game_types.id = play_details.game_type_id
        inner join users ON users.id = play_masters.user_id
        left join stockist_to_terminals on play_masters.user_id = stockist_to_terminals.terminal_id
        where play_masters.is_cancelled=0 and date(play_masters.created_at) >= ? and date(play_masters.created_at) <= ?
        group by stockist_to_terminals.stockist_id, play_masters.user_id,users.user_name,play_details.game_type_id,users.email) as table1 group by user_name,user_id,terminal_pin,stockist_id) as table1
        left join users on table1.stockist_id = users.id ",[$start_date,$end_date]);

        foreach($data as $x){
            $newPrize = 0;
            $tempntp = 0;
            $newData = PlayMaster::where('user_id',$x->user_id)->get();
            foreach($newData as $y) {
                $tempData = 0;
//                $newPrize += $this->get_prize_value_by_barcode($y->id);
                $tempPrize = $this->get_prize_value_by_barcode($y->id);
                if($tempPrize>0 && $y->is_claimed == 1){
                    $newPrize += $this->get_prize_value_by_barcode($y->id);
                }else{
                    $newPrize += 0;
                }

                $tempData = (PlayDetails::select(DB::raw("if(game_type_id = 1,(mrp*22)*quantity-(commission/100),mrp*quantity-(commission/100)) as total"))
                    ->where('play_master_id',$y->id)->distinct()->get())[0];
                $tempntp += $tempData->total;
            }
            $detail = (object)$x;
            $detail->prize_value = $newPrize;
            $detail->ntp = $tempntp;
        }

        $card_data = ($this->card_customer_sale_report($start_date,$end_date));

        foreach ($card_data as $x){
            foreach ($data as $y){
                if($x->terminal_pin === $y->terminal_pin){
                    $y->total = $y->total + $x->total;
                    $y->ntp = $y->ntp + $x->ntp;
                    $y->commission = $y->commission + $x->commission;
                    $y->prize_value = $y->prize_value + $x->prize_value;
                }
            }
        }

        return response()->json(['success'=> 1, 'data' => $data], 200);

    }

    public function card_customer_sale_reports(Request $request){
        $requestedData = (object)$request->json()->all();
        $start_date = $requestedData->startDate;
        $end_date = $requestedData->endDate;


        $data = DB::select("select table1.card_play_master_id, table1.terminal_pin, table1.user_name, table1.user_id, table1.stockist_id, table1.total, table1.commission, users.user_name as stokiest_name from (select max(card_play_master_id) as card_play_master_id,terminal_pin,user_name,user_id,stockist_id,
        sum(total) as total,round(sum(commission),2) as commission from (
        select max(card_play_masters.id) as card_play_master_id,users.user_name,users.email as terminal_pin,
        round(sum(card_play_details.quantity * card_play_details.mrp)) as total,
        sum(card_play_details.quantity * card_play_details.mrp)* (max(card_play_details.commission)/100) as commission,
        card_play_masters.user_id, stockist_to_terminals.stockist_id
        FROM card_play_masters
        inner join card_play_details on card_play_details.card_play_master_id = card_play_masters.id
        inner join game_types ON game_types.id = card_play_details.game_type_id
        inner join users ON users.id = card_play_masters.user_id
        left join stockist_to_terminals on card_play_masters.user_id = stockist_to_terminals.terminal_id
        where card_play_masters.is_cancelled=0 and date(card_play_masters.created_at) >= ? and date(card_play_masters.created_at) <= ?
        group by stockist_to_terminals.stockist_id, card_play_masters.user_id,users.user_name,card_play_details.game_type_id,users.email) as table1 group by user_name,user_id,terminal_pin,stockist_id) as table1
        left join users on table1.stockist_id = users.id ",[$start_date,$end_date]);

        foreach($data as $x){
            $newPrize = 0;
            $tempntp = 0;
            $newData = CardPlayMaster::where('user_id',$x->user_id)->get();
            foreach($newData as $y) {
                $tempData = 0;
//                $newPrize += $this->get_prize_value_by_barcode($y->id);
                $tempPrize = $this->get_prize_value_by_barcode($y->id);
                if($tempPrize>0 && $y->is_claimed == 1){
                    $newPrize += $this->get_prize_value_by_barcode($y->id);
                }else{
                    $newPrize += 0;
                }

                $tempData = (CardPlayDetail::select(DB::raw("if(game_type_id = 6,(mrp**quantity)-(commission/100),mrp*quantity-(commission/100)) as total"))
                    ->where('card_play_master_id',$y->id)->distinct()->get())[0];
                $tempntp += $tempData->total;
            }
            $detail = (object)$x;
            $detail->prize_value = $newPrize;
            $detail->ntp = $tempntp;
        }
        return response()->json(['success'=> 1, 'data' => $data], 200);
    }
    public function card_customer_sale_report($start_date,$end_date){
//        $requestedData = (object)$request->json()->all();
//        $start_date = $requestedData->startDate;
//        $end_date = $requestedData->endDate;


        $data = DB::select("select table1.card_play_master_id, table1.terminal_pin, table1.user_name, table1.user_id, table1.stockist_id, table1.total, table1.commission, users.user_name as stokiest_name from (select max(card_play_master_id) as card_play_master_id,terminal_pin,user_name,user_id,stockist_id,
        sum(total) as total,round(sum(commission),2) as commission from (
        select max(card_play_masters.id) as card_play_master_id,users.user_name,users.email as terminal_pin,
        round(sum(card_play_details.quantity * card_play_details.mrp)) as total,
        sum(card_play_details.quantity * card_play_details.mrp)* (max(card_play_details.commission)/100) as commission,
        card_play_masters.user_id, stockist_to_terminals.stockist_id
        FROM card_play_masters
        inner join card_play_details on card_play_details.card_play_master_id = card_play_masters.id
        inner join game_types ON game_types.id = card_play_details.game_type_id
        inner join users ON users.id = card_play_masters.user_id
        left join stockist_to_terminals on card_play_masters.user_id = stockist_to_terminals.terminal_id
        where card_play_masters.is_cancelled=0 and date(card_play_masters.created_at) >= ? and date(card_play_masters.created_at) <= ?
        group by stockist_to_terminals.stockist_id, card_play_masters.user_id,users.user_name,card_play_details.game_type_id,users.email) as table1 group by user_name,user_id,terminal_pin,stockist_id) as table1
        left join users on table1.stockist_id = users.id ",[$start_date,$end_date]);

        foreach($data as $x){
            $newPrize = 0;
            $tempntp = 0;
            $newData = CardPlayMaster::where('user_id',$x->user_id)->get();
            foreach($newData as $y) {
                $tempData = 0;
//                $newPrize += $this->get_prize_value_by_barcode($y->id);
                $tempPrize = $this->get_prize_value_by_barcode($y->id);
                if($tempPrize>0 && $y->is_claimed == 1){
                    $newPrize += $this->get_prize_value_by_barcode($y->id);
                }else{
                    $newPrize += 0;
                }

                $tempData = (CardPlayDetail::select(DB::raw("if(game_type_id = 6,(mrp*quantity)-(commission/100),mrp*quantity-(commission/100)) as total"))
                    ->where('card_play_master_id',$y->id)->distinct()->get())[0];
                $tempntp += $tempData->total;
            }
            $detail = (object)$x;
            $detail->prize_value = $newPrize;
            $detail->ntp = $tempntp;
        }
        return $data;
    }
}
