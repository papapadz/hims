<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use SoftDeletes;
    
    public function brgy() {
		return $this->hasOne(Brgys::class,'id','brgy_id')->with('cityMun');
	}
}
