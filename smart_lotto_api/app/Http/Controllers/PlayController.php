<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayDetailsResource;
use App\Http\Resources\PlayMasterResource;
use App\Http\Resources\PrintSingleGameInputResource;
use App\Http\Resources\PrintTripleGameInputResource;
use App\Models\CardPlayDetail;
use App\Models\CardPlayMaster;
use App\Models\GameType;
use App\Models\PlayDetails;
use App\Models\PlayMaster;
use App\Models\SingleNumber;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PlayController extends Controller
{
    public function save_play_details(Request $request)
    {
        $requestedData = $request->json()->all();

//        return response()->json(['success'=>1,'data'=> $requestedData], 200,[],JSON_NUMERIC_CHECK);
//        $validator = Validator::make($requestedData,[
//            'playMaster' => 'required',
//            'playDetails' => 'required'
//        ]);
//
//        if($validator->fails()){
//            return response()->json(['position'=>1,'success'=>0,'data'=>null,'error'=>$validator->messages()], 406,[],JSON_NUMERIC_CHECK);
//        }
        $inputPlayMaster = (object)$requestedData['playMaster'];
        $inputPlayDetails = $requestedData['playDetails'];


//        return response()->json(['success'=>1,'data'=> $inputPlayMaster], 200,[],JSON_NUMERIC_CHECK);
//
//        //        Validation for PlayMaster
//        $rules = array(
//            'drawMasterId'=>'required|exists:draw_masters,id',
//            'terminalId'=> ['required',
//                function($attribute, $value, $fail){
//                    $terminal=User::where('id', $value)->where('user_type_id','=',4)->first();
//                    if(!$terminal){
//                        return $fail($value.' is not a valid terminal id');
//                    }
//                }],
//        );
//        $messages = array(
//            'drawMasterId.required'=>'Draw time is required',
//            'terminalId.required'=>'Terminal Id is required',
//        );
//
//        $validator = Validator::make($requestedData['playMaster'],$rules,$messages );
//
//        if ($validator->fails()) {
//            return response()->json(['position'=>2,'success'=>0,'data'=>null,'error'=>$validator->messages()], 406,[],JSON_NUMERIC_CHECK);
//        }
//        //        Validation for PlayMaster complete
//
//
//        //validation for playDetails
//        $rules = array(
//            "*.gameTypeId"=>'required|exists:game_types,id',
//            // '*.singleNumberId' => 'required_if:*.gameTypeId,==,1',
//            '*.quantity' => 'bail|required|integer|min:1',
//            '*.mrp' => 'bail|required|integer|min:1'
//        );
//        $validator = Validator::make($requestedData['playDetails'],$rules );
//        if ($validator->fails()) {
//            return response()->json(['position'=>3,'success'=>0,'data'=>null,'error'=>$validator->messages()], 406,[],JSON_NUMERIC_CHECK);
//        }
        //end of validation for playDetails

//        $output_array = array();

//        $playMaster = new CardPlayMaster();
//        $playMaster->card_draw_master_id = $inputPlayMaster->drawMasterId;
//        $playMaster->barcode_number = "dsdasd";
//        $playMaster->user_id = $inputPlayMaster->terminalId;
//        $playMaster->save();
//        return response()->json(['success'=>1,'data'=> $playMaster], 200,[],JSON_NUMERIC_CHECK);

//        $quantity = 0;
//        $amount = 0;

        DB::beginTransaction();
        try{

            $playMaster = new CardPlayMaster();
            $playMaster->card_draw_master_id = $inputPlayMaster->drawMasterId;
//            $playMaster->barcode_number = "dsdasdr";
            $playMaster->user_id = $inputPlayMaster->terminalId;
            $playMaster->save();
            $output_array['play_master'] = new PlayMasterResource($playMaster);

            $output_play_details = array();
            foreach($inputPlayDetails as $inputPlayDetail){
                $detail = (object)$inputPlayDetail;
//                $quantity = $quantity + $inputPlayDetail->quantity;
                if($detail->gameTypeId) {
                    $gameType = GameType::find($detail->gameTypeId);
                    //insert value for triple
//                    if ($detail->gameTypeId == 1) {
                        $playDetails = new CardPlayDetail();
                        $playDetails->card_play_master_id = $playMaster->id;
                        $playDetails->game_type_id = $detail->gameTypeId;
                        $playDetails->card_combination_id = $detail->cardCombinationId;
                        $playDetails->quantity = $detail->quantity;
                        $playDetails->mrp = $detail->mrp;
                        $playDetails->commission = $gameType->commission;
                        $playDetails->payout = $gameType->payout;
                        $playDetails->save();
                        $output_play_details[] = $playDetails;
//                    }
                }else{
                    DB::rollBack();
                    return response()->json(['success'=>0,'exception'=> 'invalid game','error_line'=>null,'file_name' => null], 500);
                }

            }
//            $output_array['game_input'] = $this->get_game_input_details_by_play_master_id($playMaster->id);


            $amount = $playMaster->play_details->sum(function($t){
                return $t->quantity * $t->mrp;
            });

//            $amount =

            $terminal = User::findOrFail($inputPlayMaster->terminalId);
            $terminal->closing_balance-= $amount;
            $terminal->save();



            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['success'=>0,'exception'=>$e->getMessage(),'error_line'=>$e->getLine(),'file_name' => $e->getFile()], 500);
        }

        return response()->json(['success'=>1,'data'=> $amount], 200,[],JSON_NUMERIC_CHECK);
    }

    public function get_game_input_details_by_play_master_id($play_master_id){
        $output_array = array();
        $single_game_data = PlayDetails::select(DB::raw('two_digit_number_sets.number_set as two_digit_number_set')
            ,DB::raw('play_details.quantity as quantity'))
            ->join('two_digit_number_sets','play_details.two_digit_number_set_id','two_digit_number_sets.id')
            ->where('play_details.play_master_id',$play_master_id)
            ->where('play_details.game_type_id',1)
            ->orderBy('two_digit_number_sets.id')
            ->get();
            $output_array['single_game_data'] = PrintSingleGameInputResource::collection($single_game_data);
            // $output_array['two_digit_data'] = $single_game_data;

        return $output_array;
    }
}
