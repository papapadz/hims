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
use App\Prescriptions;
use App\Appointments;
use App\Supplies;
use App\SupplyCats;
use App\Billings;
use App\Employees;
use App\Positions;
use App\Departments;
use App\Attendances;
use App\Uploads;
use App\Payrolls;
use App\Countries;
use App\Provinces;
use App\CityMuns;
use App\Brgys;
use App\DTR;
/**/

class GetController extends Controller
{
    public function getEmployee($id) {

    	$employee = Employees::SELECT(
                    'emp_no',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'position',
                    'department',
                    'salary'
                )
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE('emp_stat',1)
                ->WHERE('emp_no',$id)
                ->FIRST();

        return $employee;
    }

    public function getAttendance($id,$date,$month,$year) {

        $d = Carbon::create($year,$month,1);
        
        if($date==1) {
            $start_date = $d->firstOfMonth()->toDateString();
            $end_date = Carbon::create($year,$month,15);
        }
        else {
            $start_date = $d;
            $end_date = $d->lastOfMonth()->toDateString(); 
        }
        
        $attendance = DTR::SELECT('dtr_date','total_hrs','total_ot')->WHEREBETWEEN('dtr_date',[$start_date, $end_date])->GET();

        $weekdays = $sat = $sun = $ot = 0;
        foreach ($attendance as $att) {
            $myDate = Carbon::parse($att->dtr_date);
            if($myDate->isWeekday()) 
                $weekdays = $weekdays + $att->total_hrs;
            else if($myDate->isSaturday())
                $sat = $sat + $att->total_hrs;
            else
                $sun = $sun + $att->total_hrs;
        
            if($att->total_ot>0)
                $ot = $ot + $att->total_ot;
        }

        $data = NULL;
        $data['weekdays'] = $weekdays;
        $data['sat'] = $sat;
        $data['sun'] = $sun;
        $data['ot'] = $ot;

        return $data;
    }  
    
    public function getCityMun($code) {

        $cityMuns = CityMuns::WHERE('provCode',$code)->GET();
        return $cityMuns;
    }

    public function getBrgy($code) {

        $brgys = Brgys::WHERE('citymunCode',$code)->GET();
        return $brgys;
    }
}
