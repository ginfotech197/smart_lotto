<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class CardPlayMaster extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        CardPlayMaster::saving(function ($model) {
            $model->barcode_number = str_replace('-','x', ((string)Uuid::generate()));
        });
    }

    public function play_details(){
        return $this->hasMany(CardPlayDetail::class,'card_play_master_id');
    }
}
