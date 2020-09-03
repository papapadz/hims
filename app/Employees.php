<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
	protected $keyType = 'string';
	protected $primaryKey = 'emp_no';
    protected $table = 'tbl_employees';
}
