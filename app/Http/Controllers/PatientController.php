<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/* Models */
use App\Patients;
use App\Rooms;
use App\Consults;
use App\Diagnosis;
use App\Results;
use App\Supplies;
use App\Prescriptions;
use App\Employees;
use App\Appointments;
use App\Billings;
/**/

class PatientController extends Controller
{
    public function viewPatientProfile($hosp_no) {

    	/* Query all Rooms */
    	$rooms = Rooms::ALL();

    	/* Query Patient Info using hosp_no */
    	$patient = Patients::FIND($hosp_no);

    	/* Query Patient Consultations based on his/her hosp_no */
    	$consults = Consults::SELECT(
    				'tbl_consults.id',
    				'tbl_consults.created_at',
    				'complaint',
    				'room'
    			)
    			->JOIN('tbl_rooms','tbl_rooms.id','=','tbl_consults.room_id')
    			->WHERE('hosp_no',$hosp_no)
    			->GET();

        /* Query Patient Info using hosp_no */
        $employees = Employees::SELECT()->WHERE('department_id',1)->ORDERBY('last_name')->GET();
        
        /* Query Appointments of Patient using hosp_no */
        $appointments = Appointments::SELECT(
                    'tbl_consult_scheds.id',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'consult_date'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_consult_scheds.emp_no')
                ->WHERE('tbl_consult_scheds.hosp_no',$hosp_no)
                ->ORDERBY('tbl_consult_scheds.consult_date','DESC')
                ->GET();

        $supplies = Supplies::SELECT(
                    'tbl_supplies.id',
                    'supply',
                    'price',
                    'unit'
                )
                ->JOIN('tbl_supply_cat','tbl_supply_cat.id','=','tbl_supplies.category_id')->WHERE('category_id',1)->GET();


    	/* Go to View (HTML) with variables */
    	return view('patient/patient-profile')
                ->with('currPage','patients')
    			->with('rooms',$rooms)
    			->with('patient',$patient)
    			->with('consults',$consults)
                ->with('employees',$employees)
                ->with('appointments',$appointments)
                ->with('supplies',$supplies);
    }

    public function viewConsult($id) {

    	$patient = Consults::SELECT(
    				'*','tbl_consults.id as consult_id'
    			)
    			->JOIN('tbl_patients','tbl_patients.hosp_no','=','tbl_consults.hosp_no')
    			->JOIN('tbl_rooms','tbl_rooms.id','=','tbl_consults.room_id')
                ->WHERE('tbl_consults.id',$id)
    			->FIRST();

    	$diagnosis = Diagnosis::SELECT(
                    'diagnosis',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'tbl_diagnosis.created_at'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_diagnosis.emp_no')
                ->WHERE('consult_id',$id)->GET();
    	
    	$resultTypes = Supplies::WHEREIN('category_id',[2,3])->GET();

        $results = Results::SELECT(
                    'last_name',
                    'first_name',
                    'middle_name',
                    'supply',
                    'tbl_results.result',
                    'result_file',
                    'tbl_results.created_at',
                    'tbl_results.updated_at',
                    'category_id'
                )
                ->JOIN('tbl_supplies','tbl_supplies.id','=','tbl_results.result_type')
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_results.requested_by')
                ->WHERE('consult_id',$id)
                ->GET();
                
        $prescriptions = Prescriptions::SELECT(
                    'last_name',
                    'first_name',
                    'middle_name',
                    'prescription',
                    'tbl_prescriptions.created_at'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_prescriptions.prescribed_by')
                ->WHERE('consult_id',$id)
                ->GET();

        $bills = Billings::SELECT(
                    'tbl_billings.id as bill_id',
                    'tbl_supplies.id',
                    'tbl_billings.created_at',
                    'supply',
                    'price',
                    'unit',
                    'tbl_billings.qty',
                    'sub_total'
                )
                ->JOIN('tbl_supplies','tbl_supplies.id','=','tbl_billings.supply_id')
                ->WHERE('consult_id',$id)
                ->GET();

        $billGrouped = Billings::GROUPBY('supply','price','unit')
                ->SELECT(DB::RAW('
                    supply,
                    tbl_supplies.price,
                    tbl_supplies.unit,
                    sum(tbl_billings.qty) as sumQty, 
                    sum(sub_total) as sumSubTotal
                '))
                ->JOIN('tbl_supplies','tbl_supplies.id','=','tbl_billings.supply_id')
                ->WHERE('consult_id',$id)
                ->GET();

        $supplies = Supplies::SELECT(
                    'tbl_supplies.id',
                    'supply',
                    'price',
                    'unit',
                    'qty'
                )
                ->JOIN('tbl_supply_cat','tbl_supply_cat.id','=','tbl_supplies.category_id')->WHERE('category_id',1)->GET();

    	return view('patient/patient-history')
                ->with('currPage','patients')
    			->with('patient',$patient)
    			->with('diagnosis',$diagnosis)
    			->with('resultTypes',$resultTypes)
                ->with('results',$results)
                ->with('prescriptions',$prescriptions)
                ->with('bills',$bills)
                ->with('billGrouped',$billGrouped)
                ->with('supplies',$supplies);
    }

    public function viewPatientChart($id) {

        $patient = Consults::SELECT(
                    '*','tbl_consults.id as consult_id'
                )
                ->JOIN('tbl_patients','tbl_patients.hosp_no','=','tbl_consults.hosp_no')
                ->JOIN('tbl_rooms','tbl_rooms.id','=','tbl_consults.room_id')
                ->WHERE('tbl_consults.id',$id)
                ->FIRST();

        $diagnosis = Diagnosis::SELECT(
                    'diagnosis',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'tbl_diagnosis.created_at'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_diagnosis.emp_no')
                ->WHERE('consult_id',$id)->GET();
        
        $results = Results::SELECT(
                    'supply',
                    'tbl_results.result',
                    'tbl_results.created_at',
                    'tbl_results.updated_at'
                )
                ->JOIN('tbl_supplies','tbl_supplies.id','=','tbl_results.result_type')
                ->WHERE('consult_id',$id)
                ->GET();

        $prescriptions = Prescriptions::SELECT(
                    'last_name',
                    'first_name',
                    'middle_name',
                    'prescription',
                    'tbl_prescriptions.created_at'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_prescriptions.prescribed_by')
                ->WHERE('consult_id',$id)
                ->GET();

        return view('patient/patient-chart')
                ->with('currPage','patients')
                ->with('patient',$patient)
                ->with('diagnosis',$diagnosis)
                ->with('results',$results)
                ->with('prescriptions',$prescriptions);
    }
}
