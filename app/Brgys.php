<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brgys extends Model
{
    protected $table = 'tbl_brgy';

    public function cityMun() {
        return $this->belongsTo(CityMuns::class,'citymunCode','citymunCode')->with('province');
    }

    public function patients() {
        return $this->belongsTo(Patients::class,'brgy_id','id');
    }
}
