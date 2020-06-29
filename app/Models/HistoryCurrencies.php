<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryCurrencies extends Model
{
    protected $fillable = ['buy', 'sell'];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function currency()
    {
        return $this->belongsTo('App\Models\Currencies');
    }
}
