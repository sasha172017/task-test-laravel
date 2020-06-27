<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    public $timestamps = false;
    protected $fillable = ['buy', 'sell'];

    public function historyCurrencies()
    {
        return $this->hasMany('App\Models\HistoryCurrencies', 'currency_id');
    }
}
