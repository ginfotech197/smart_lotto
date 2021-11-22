<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TwoDigitNumberCombinationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'twoDigitNumberCombinationId' => $this->id,
            'twoDigitNumberSetId' => $this->two_digit_number_set_id,
            'visibleNumber' => $this->visible_number,

        ];
    }
}
