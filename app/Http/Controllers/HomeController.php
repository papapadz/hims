<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

/* Models */
use App\Patients;
use App\Rooms;
use App\Positions;
use App\User;
use App\Billings;
use App\Employees;
use App\Appointments;
use App\Results;
use App\Professions;
use App\Supplies;
/**/

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $positions = Positions::ALL();
        $rooms = Rooms::ALL();
        $users = User::ALL();
        $employees = Employees::WHERE('emp_stat',1)->GET();
        $patients = Patients::ALL();
        $professions = Professions::ALL();
        $supplies = Supplies::ALL();

        if(Auth::User()->account_type == 3) { /*If User is Patient*/

            $bills = Billings::SELECT(DB::RAW('sum(sub_total) as sumSubTotal'))
                    ->JOIN('tbl_consults','tbl_consults.id','=','tbl_billings.consult_id')
                    ->WHERE([
                        ['is_paid',0],
                        ['hosp_no',Auth::User()->user_id]
                    ])
                    ->FIRST();
            
            $appointments = Appointments::SELECT()
                    ->WHEREDATE('consult_date',Carbon::now()->toDateString())
                    ->WHERE('hosp_no',Auth::User()->user_id)
                    ->GET();

            $requests = Results::SELECT()
                    ->JOIN('tbl_supplies','tbl_supplies.id','=','tbl_results.result_type')
                    ->JOIN('tbl_supply_cat','tbl_supply_cat.id','=','tbl_supplies.category_id')
                    ->JOIN('tbl_consults','tbl_consults.id','=','tbl_results.consult_id')
                    ->WHERE([
                        ['result',NULL],
                        ['hosp_no',Auth::User()->user_id]
                    ])
                    ->GET();
        } else {

            $bills = Billings::SELECT(DB::RAW('sum(sub_total) as sumSubTotal'))
                    ->WHERE('is_paid',0)
                    ->FIRST();
            
            $appointments = Appointments::WHEREDATE('consult_date',Carbon::now()->toDateString())->GET();
            $requests = Results::SELECT()
                    ->JOIN('tbl_supplies','tbl_supplies.id','=','tbl_results.result_type')
                    ->JOIN('tbl_supply_cat','tbl_supply_cat.id','=','tbl_supplies.category_id')
                    ->WHERE('result',NULL)
                    ->GET();
            
        }
        
        return view('admin/dashboard')
                ->with('currPage','home')
                ->with('positions',$positions)
                ->with('rooms',$rooms)
                ->with('users',$users)
                ->with('employees',$employees)
                ->with('bills',$bills)
                ->with('patients',$patients)
                ->with('appointments',$appointments)
                ->with('requests',$requests)
                ->with('professions',$professions)
                ->with('supplies',$supplies);
    }

    public function logout()
    {   
        Session::flush();
        Auth::logout();
        return redirect("/");
    }
}
