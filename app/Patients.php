<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
	protected $keyType = 'string';
	protected $primaryKey = 'hosp_no';
    protected $table = 'tbl_patients';

	public function address() {
		
		return $this->hasOne(Brgys::class,'id','brgy_id')->with('cityMun');
	}

	public function appointments() {
		return $this->belongsTo(Appointment::class,'hosp_no','hosp_no')->with('doctor');
	}
}
