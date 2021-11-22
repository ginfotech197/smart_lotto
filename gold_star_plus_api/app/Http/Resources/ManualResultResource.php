<?php

namespace App\Http\Resources;

use App\Http\Resources\NumberCombinationSimpleResource;
use App\Models\NumberCombination;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\SingleNumber;
use App\Http\Resources\SingleNumberSimpleResource;
use App\Http\Resources\TwoDigitNumberCombinationResource;

/**
 * @property mixed id
 * @property mixed draw_master_id
 * @property mixed number_combination_id
 * @property mixed game_date
 */
class ManualResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'manualResultId'=> $this->id,
            'drawMaster'=> new DrawMasterResource($this->draw_master),
//            'twoDigitNumberCombination'=> new TwoDigitNumberCombinationResource($this->two_digit_number_combination),
            'gameDate'=> $this->game_date,
        ];
    }
}
