<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
	protected $keyType = 'string';
	protected $primaryKey = 'emp_no';
    protected $table = 'tbl_employees';

	protected $fillable = [
		'emp_no', 'last_name', 'first_name', 'middle_name', 'extension', 'gender', 'birthdate', 'birthplace', 'citizenship_id', 'civil_stat',
		'height', 'weight', 'blood_type', 'house_no', 'street', 'subdivision', 'brgy_id', 'house_no2', 'street2', 'subdivision2', 'brgy_id2',
		'contact_no', 'telphone', 'email', 'gsis', 'pagibig', 'phic', 'sss', 'tin', 'eligibility_id', 'profession', 'position_id', 'deparment_id',
		'profile_img', 'pds_file', 'emp_stat' 
	];
}
