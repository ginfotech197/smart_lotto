<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed play_master_id
 * @property mixed game_type_id
 * @property mixed number_position_id
 * @property mixed id
 * @property mixed game
 * @property mixed mrp
 * @property mixed quantity
 * @property mixed number_combination_id
 */
class PlayDetailsResource extends JsonResource
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
            'playMasterId' => $this->play_master_id,
            'game' => new GameTypeResource($this->game),
            'twoDigitNumberSetId' => $this->two_digit_number_set,
            'quantity' => $this->quantity,
            'mrp' => $this->mrp,
            'playDetailsId' => $this->id,
        ];
    }
}
