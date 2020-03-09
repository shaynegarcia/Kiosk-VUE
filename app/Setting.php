<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public function currency()
    {
    	return $this->belongsTo(Currency::class, 'currency_id');
    }
}
