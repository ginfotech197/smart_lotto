<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayDetails extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $hidden = [
        "created_at","updated_at"
    ];

    /**
     * @var mixed
     */
    private $play_master_id;
    /**
     * @var mixed
     */
    private $game_type_id;
    /**
     * @var mixed
     */
    private $mrp;
    /**
     * @var mixed
     */
    private $quantity;
    /**
     * @var mixed
     */
    private $commission;
    /**
     * @var mixed
     */
    private $payout;
    /**
     * @var mixed
     */
    private $two_digit_number_set_id;

    public function game(){
        return $this->belongsTo(GameType::class,'game_type_id');
    }

    public function two_digit_number_set(){
        return $this->belongsTo(TwoDigitNumberSets::class,'two_digit_number_set_id');
    }
}
