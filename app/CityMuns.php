<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityMuns extends Model
{
    protected $table = 'tbl_citymun';

    public function brgys() {
        return $this->hasMany(Brgys::class,'citymunCode','citymunCode');
    }

    public function province() {
        return $this->belongsTo(Provinces::class,'provCode','provCode')->with('region');
    }
}
