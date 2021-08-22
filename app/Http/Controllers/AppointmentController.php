<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Appointments;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('appointment.index')->with('currPage','appointments');
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
        
        $appointments = Appointments::orderBy('consult_date')
            ->whereBetween('consult_date',[ $startdate[0],$enddate[0] ])
            ->with('patient')
            ->get();
            
        $arrappointments = array();
        foreach($appointments as $k => $app) {

            if($app->confirmed_by!=null)
                $arrappointments[$k]['backgroundColor'] = 'green';

            $arrappointments[$k]['id'] = $app->patient->hosp_no; 
            $arrappointments[$k]['title'] = $app->patient->last_name.', '.$app->patient->first_name.' '.$app->patient->middle_name;
            $arrappointments[$k]['start'] = Carbon::parse($app->consult_date)->toDateString();
        }
        return json_encode($arrappointments);
    }
}
