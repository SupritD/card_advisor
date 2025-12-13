<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstCard extends Model
{
    protected $table = 'mst_cards';

    protected $fillable = [
        'bank_name',
        'card_name',
        'network_type',
        'card_category',
        'card_tier',
        'joining_fee',
        'annual_fee',
        'pros',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_cards', 'card_id', 'user_id');
    }
}
