<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
	protected $keyType = 'string';
	protected $primaryKey = 'hosp_no';
    protected $table = 'tbl_patients';
}
