<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = ['id'];

    public function kiosks()
    {
    	return $this->hasMany(Kiosk::class);
    }
    public function settings()
    {
    	return $this->belongsTo(Setting::class, 'setting_id');
    }
}
