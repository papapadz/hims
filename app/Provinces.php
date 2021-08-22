<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    protected $table = 'tbl_province';

    public function cityMuns() {
        return $this->hasMany(CityMuns::class,'provCode','provCode');
    }

    public function region() {
        return $this->belongsTo(Regions::class,'regCode','regCode');
    }
}
