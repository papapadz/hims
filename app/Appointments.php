<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    protected $table = 'tbl_consult_scheds';
    protected $fillable = [
        'emp_no', 'hosp_no', 'consult_date'
    ];

    public function patient() {
        return $this->hasOne(Patients::class,'hosp_no','hosp_no');
    }

    public function doctor() {
        return $this->hasOne(Employees::class,'emp_no','emp_no');
    }
}
