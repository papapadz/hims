<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Appointments;
use App\Employees;
use Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('appointment.index')->with([
            'currPage' => 'appointments',
            'employees' => Employees::SELECT()->WHERE('department_id',1)->ORDERBY('last_name')->GET(),
            'hosp_no' => Auth::user()->user_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function fullCalendar(Request $request) {
        
        $startdate = explode('T',$request->start);
        $enddate = explode('T',$request->end);
        
        if(Auth::User()->account_type==3) {
            $user = 'doctor';
            $appointments = Appointments::orderBy('consult_date')
                ->whereBetween('consult_date',[ $startdate[0],$enddate[0] ])
                ->where('hosp_no',Auth::User()->user_id)
                ->with($user)
                ->get();
        } else {
            $user = 'patient';
            $appointments = Appointments::orderBy('consult_date')
                ->whereBetween('consult_date',[ $startdate[0],$enddate[0] ])
                ->with('patient')
                ->get();
        }
            
        $arrappointments = array();
        foreach($appointments as $k => $app) {

            if($app->confirmed_by!=null)
                $arrappointments[$k]['backgroundColor'] = 'green';

            $arrappointments[$k]['id'] = $app->patient->hosp_no; 
            $arrappointments[$k]['title'] = $app[$user]->last_name.', '.$app[$user]->first_name.' '.$app[$user]->middle_name;
            $arrappointments[$k]['start'] = Carbon::parse($app->consult_date)->toAtomString();
            $arrappointments[$k]['end'] = Carbon::parse($app->consult_date)->addHour()->toAtomString();
        }
        return json_encode($arrappointments);
    }
}
