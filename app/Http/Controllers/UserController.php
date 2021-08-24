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
use App\Uploads;
use App\Payrolls;
use App\DTR;
use App\Countries;
use App\Provinces;
use App\CityMuns;
use App\Brgys;
use App\Eligibilities;
use App\Schedules;
use App\Professions;
/**/

class UserController extends Controller
{

    public function viewPatients() {
        
        if(Auth::User()->account_type == 1 || Auth::User()->employeeInfo->department_id = 7) { /*If user is ADMIN or under Patient Service Unit, get all records*/
            $patients = Patients::WHERE('hosp_no','!=','X')->GET();

            $appointments = Appointments::SELECT(
                        'tbl_consult_scheds.id',
                        'tbl_consult_scheds.hosp_no',
                        'tbl_patients.patient_stat',
                        'tbl_patients.last_name as patient_last_name',
                        'tbl_patients.first_name as patient_first_name',
                        'tbl_patients.middle_name as patient_middle_name',
                        'tbl_consult_scheds.consult_date',
                        'tbl_employees.first_name',
                        'tbl_employees.last_name',
                        'tbl_employees.middle_name'
                    )
                    ->JOIN('tbl_patients','tbl_patients.hosp_no','=','tbl_consult_scheds.hosp_no')
                    ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_consult_scheds.emp_no')
                    ->GET();
        } else {

            if(Auth::User()->employeeInfo->department_id == 1) { /*If user is DOCTOR, get all his/her patients only*/

                $patients = Diagnosis::GROUPBY(
                        'tbl_diagnosis.id',
                        'tbl_consults.id',
                        'emp_no',
                        'tbl_consults.hosp_no',
                        'first_name',
                        'last_name',
                        'middle_name',
                        'patient_stat',
                        'consult_type',
                        'birthdate',
                        'gender',
                        'address',
                        'patient_type'
                    )
                    ->SELECT(
                        'tbl_diagnosis.id',
                        'tbl_consults.id',
                        'emp_no',
                        'tbl_consults.hosp_no',
                        'first_name',
                        'last_name',
                        'middle_name',
                        'patient_stat',
                        'consult_type',
                        'birthdate',
                        'gender',
                        'address',
                        'patient_type'
                    )
                    ->JOIN('tbl_consults','tbl_consults.id','=','tbl_diagnosis.consult_id')
                    ->JOIN('tbl_patients','tbl_patients.hosp_no','=','tbl_consults.hosp_no')
                    ->WHERE([['patient_stat','!=','WLK'],['tbl_diagnosis.emp_no',Auth::User()->user_id]])
                    ->GET();

            $appointments = Appointments::SELECT(
                        'tbl_consult_scheds.id',
                        'tbl_consult_scheds.hosp_no',
                        'tbl_patients.patient_stat',
                        'tbl_patients.last_name as patient_last_name',
                        'tbl_patients.first_name as patient_first_name',
                        'tbl_patients.middle_name as patient_middle_name',
                        'tbl_consult_scheds.consult_date',
                        'tbl_employees.first_name',
                        'tbl_employees.last_name',
                        'tbl_employees.middle_name'
                    )
                    ->JOIN('tbl_patients','tbl_patients.hosp_no','=','tbl_consult_scheds.hosp_no')
                    ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_consult_scheds.emp_no')
                    ->WHEREDATE('consult_date',Carbon::now()->toDateString())
                    ->WHERE('tbl_consult_scheds.emp_no',Auth::User()->user_id)
                    ->GET();
            } else { 

                /*If user is under Nursing,Pharmacy,Billing,Lab and XRay, get all patient records who are admitted*/

                $patients = Patients::WHERENOTIN('patient_stat',[NULL,'WLK'])->GET();

                $appointments = Appointments::SELECT(
                            'tbl_consult_scheds.id',
                            'tbl_consult_scheds.hosp_no',
                            'tbl_patients.patient_stat',
                            'tbl_patients.last_name as patient_last_name',
                            'tbl_patients.first_name as patient_first_name',
                            'tbl_patients.middle_name as patient_middle_name',
                            'tbl_consult_scheds.consult_date',
                            'tbl_employees.first_name',
                            'tbl_employees.last_name',
                            'tbl_employees.middle_name'
                        )
                        ->JOIN('tbl_patients','tbl_patients.hosp_no','=','tbl_consult_scheds.hosp_no')
                        ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_consult_scheds.emp_no')
                        ->WHEREDATE('consult_date',Carbon::now()->toDateString())
                        ->GET();
            }
            
        }

        $provinces = Provinces::ORDERBY('provDesc')->GET();
        $cityMuns = CityMuns::ORDERBY('citymunDesc')->GET();
        $brgys = Brgys::SELECT()->ORDERBY('brgyDesc')->GET();
        
        return view('user/patients')
            ->with('currPage','patients')
            ->with('patients',$patients)
            ->with('appointments',$appointments)
            ->with('provinces',$provinces)
            ->with('cityMuns',$cityMuns)
            ->with('brgys',$brgys);
    }

    public function addPatient(Request $request) {

        /*create hospital number*/
        $patient_count = count(Patients::whereBetween('created_at',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])->GET()) + 1;
        $hospital_no_count = str_pad($patient_count, 4, '0', STR_PAD_LEFT);
        $hospital_no_set = Carbon::now()->year.$hospital_no_count; /* Patient hospital number ex. 20190001 */
        //
        
        $filename = "default.png";
        /*save file to public folder*/
        if($request->hasFile('profile_img')) {
            $file = $request->file('profile_img');
            $filename = $hospital_no_set.'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('assets/img/faces');
            $file->move($destinationPath,$filename);
        } else if($request->input('gender')=='Female')
            $filename = 'default-F.jpg';

        /*save patient info to database*/
        $patient = new Patients;
        $patient->hosp_no = $hospital_no_set;
        $patient->last_name = $request->input('last_name');
        $patient->first_name = $request->input('first_name');
        $patient->middle_name = $request->input('middle_name');
        $patient->gender = $request->input('gender');
        $patient->birthdate = $request->input('birthdate');
        $patient->brgy_id = $request->input('brgy');
        // $patient->patient_type = $request->input('patient_type');
        $patient->contact_no = $request->input('contact_no');
        $patient->civil_stat = $request->input('civil_stat');
        $patient->philhealth_no = $request->input('philhealth_no');
        $patient->blood_type = $request->input('blood_type');
        $patient->profile_img = $filename;
        $patient->SAVE();
        //

        return redirect()->back()->with('success','You have saved a new patient information!');
    }

    public function updatePatientInfo(Request $request) {

        /* find patient using hosp_no then update fields */
        $patient = Patients::FIND($request->input('hosp_no'));
        $patient->last_name = $request->input('last_name');
        $patient->first_name = $request->input('first_name');
        $patient->middle_name = $request->input('middle_name');
        $patient->gender = $request->input('gender');
        $patient->birthdate = $request->input('birthdate');
        $patient->address = $request->input('address');
        $patient->patient_type = $request->input('patient_type');
        $patient->contact_no = $request->input('contact_no');
        $patient->civil_stat = $request->input('civil_stat');
        $patient->philhealth_no = $request->input('philhealth_no');
        $patient->blood_type = $request->input('blood_type');

        /* Update profile image if there is an attached file*/
        if($request->hasFile('profile_img')) {

            /* Save file to public folder*/
            $file = $request->file('profile_img');
            $filename = $request->input('hosp_no').'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('assets/img/faces');
            $file->move($destinationPath,$filename);

            $patient->profile_img = $filename;
       }

        $patient->SAVE();

        return redirect()->back()->with('success','You have updated this patient\'s information!');
    }

    public function admitPatient(Request $request) {

        $consult = new Consults;
        $consult->hosp_no = $request->input('hosp_no');
        $consult->complaint = $request->input('complaint');
        $consult->consult_type = $request->input('consult_type');
        $consult->room_id = $request->input('room_id');
        $consult->SAVE();

        $patient = Patients::FIND($request->input('hosp_no'));
        $patient->patient_stat = $request->input('consult_type');
        $patient->SAVE();

        return redirect()->back()->with('success','You have successfully admitted this patient!');
    }

    public function addAppointment(Request $request) {

        $appointment = new Appointments;
        $appointment->emp_no = $request->input('emp_no');
        $appointment->hosp_no = $request->input('hosp_no');
        $appointment->consult_date = $request->input('consult_date').' '.$request->input('consult_time');
        $appointment->remarks = $request->input('appointment_remarks');
        $appointment->SAVE();

        return redirect()->back()->with('success','Appointment has been saved!');
    }

    public function deleteAppointment($id) {

        $appointment = Appointments::FIND($id);
        $appointment->DELETE();

        return redirect()->back()->with('danger','Appointment has been deleted!');
    }

    public function addDiagnosis(Request $request) {

        $diagnosis = new Diagnosis;
        $diagnosis->consult_id = $request->input('consult_id');
        $diagnosis->emp_no = Auth::User()->user_id;
        $diagnosis->diagnosis = $request->input('diagnosis');
        $diagnosis->SAVE();

        return redirect()->back()->with('success','Diagnosis has been saved!');
    }

    public function addLabRequest(Request $request) {

        /* Save into info into tbl_results table */
        $labRequest = new Results;
        $labRequest->consult_id = $request->input('consult_id');
        $labRequest->result_type = $request->input('result_type');
        $labRequest->requested_by = Auth::User()->user_id;
        $labRequest->SAVE();

        return redirect()->back()->with('success','Lab Request has been saved!');
    }

    public function addXrayRequest(Request $request) {

        /* Save into info into tbl_results table */
        $xrayRequest = new Results;
        $xrayRequest->consult_id = $request->input('consult_id');
        $xrayRequest->result_type = $request->input('result_type');
        $xrayRequest->requested_by = Auth::User()->user_id;
        $xrayRequest->SAVE();

        return redirect()->back()->with('success','X-Ray Request has been saved!');
    }

    public function deleteRequest($id) {

        $req = Results::FIND($id)->DELETE();
        return redirect()->back()->with('danger','Lab Request has been deleted!');
    }

    public function addPrescription(Request $request) {
        
        $prescription = new Prescriptions;
        $prescription->consult_id = $request->input('consult_id');
        $prescription->prescription = $request->input('prescription');
        $prescription->prescribed_by = Auth::User()->user_id;        
        /* Save file to public folder*/
        $filename = NULL;
        if($request->hasFile('prescription_img')) {
            $file = $request->file('prescription_img');
            $filename = Carbon::now()->valueOf().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads\prescriptions');
            $file->move($destinationPath,$filename);
        }
        //
        $prescription->file_upload = $filename;
        $prescription->SAVE();

        return redirect()->back()->with('success','Prescription has been saved!');
    }

    public function viewLabRequests() {

        /* query all lab requests */
        $labRequests = Results::SELECT(
                        'tbl_results.id',
                        'supply',
                        'tbl_patients.last_name as patient_last_name',
                        'tbl_patients.first_name as patient_first_name',
                        'tbl_patients.middle_name as patient_middle_name',
                        'tbl_employees.last_name as emp_last_name',
                        'tbl_employees.first_name as emp_first_name',
                        'tbl_employees.middle_name as emp_middle_name',
                        'result',
                        'result_file',
                        'tbl_results.created_at'
                    )
                    ->JOIN('tbl_supplies','tbl_supplies.id','=','tbl_results.result_type')
                    ->JOIN('tbl_consults','tbl_consults.id','=','tbl_results.consult_id')
                    ->JOIN('tbl_patients','tbl_patients.hosp_no','=','tbl_consults.hosp_no')
                    ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_results.requested_by')
                    ->WHERE('category_id',2)
                    ->ORDERBY('tbl_results.created_at','DESC')
                    ->GET();

        return view('user/lab-requests')
                ->with('currPage','lab-requests')
                ->with('labRequests',$labRequests);
    }

    public function addLabResult(Request $request) {

        /* Save file to public folder*/
        $file = $request->file('result_file');
        $filename = $request->input('lab_id').'.'.$file->getClientOriginalExtension();
        $destinationPath = public_path('uploads/lab-results');
        $file->move($destinationPath,$filename);
        //

        /* Update the record of the lab request */
        $labRequest = Results::FIND($request->input('lab_id'));
        $labRequest->result = $request->input('result');
        $labRequest->entered_by = Auth::User()->user_id;
        $labRequest->result_file = $filename;
        $labRequest->SAVE();

        /* deduct supply stock */
        $supply = Supplies::FIND($labRequest->result_type);
        $supply->qty =  ($supply->qty - 1);
        $supply->SAVE();

        /* Save into billings table */
        $bill = new Billings;
        $bill->consult_id = $labRequest->consult_id;
        $bill->supply_id = $labRequest->result_type;
        $bill->qty = 1;
        $bill->sub_total = $supply->price;
        $bill->emp_no = Auth::User()->user_id;
        $bill->SAVE();

        return redirect()->back()->with('success','Lab Result has been saved!');
    }

    public function viewXRayRequests() {

        /* query all lab requests */
        $xrayRequests = Results::SELECT(
                        'tbl_results.id',
                        'supply',
                        'tbl_patients.last_name as patient_last_name',
                        'tbl_patients.first_name as patient_first_name',
                        'tbl_patients.middle_name as patient_middle_name',
                        'tbl_employees.last_name as emp_last_name',
                        'tbl_employees.first_name as emp_first_name',
                        'tbl_employees.middle_name as emp_middle_name',
                        'result',
                        'result_file',
                        'tbl_results.created_at'
                    )
                    ->JOIN('tbl_supplies','tbl_supplies.id','=','tbl_results.result_type')
                    ->JOIN('tbl_consults','tbl_consults.id','=','tbl_results.consult_id')
                    ->JOIN('tbl_patients','tbl_patients.hosp_no','=','tbl_consults.hosp_no')
                    ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_results.requested_by')
                    ->WHERE('category_id',3)
                    ->ORDERBY('tbl_results.created_at','DESC')
                    ->GET();

        return view('user/xray-requests')
                ->with('currPage','xray-requests')
                ->with('xrayRequests',$xrayRequests);
    }

    public function addXRayResult(Request $request) {

        /* Save file to public folder*/
        $file = $request->file('result_file');
        $filename = $request->input('xray_id').'.'.$file->getClientOriginalExtension();
        $destinationPath = public_path('uploads/xray-results');
        $file->move($destinationPath,$filename);
        //

        /* Update the record of the lab request */
        $xrayRequest = Results::FIND($request->input('xray_id'));
        $xrayRequest->result = $request->input('result');
        $xrayRequest->entered_by = Auth::User()->user_id;
        $xrayRequest->result_file = $filename;
        $xrayRequest->SAVE();

        /* deduct supply stock */
        $supply = Supplies::FIND($xrayRequest->result_type);
        $supply->qty =  ($supply->qty - 1);
        $supply->SAVE();

        /* Save into billings table */
        $bill = new Billings;
        $bill->consult_id = $xrayRequest->consult_id;
        $bill->supply_id = $xrayRequest->result_type;
        $bill->qty = 1;
        $bill->sub_total = $supply->price;
        $bill->emp_no = Auth::User()->user_id;
        $bill->SAVE();

        return redirect()->back()->with('success','X-Ray Result has been saved!');
    }

    public function addPatientMedicine(Request $request) {
        
        /* find the patient's active consultation */
        $consult = Consults::SELECT('id')
                    ->WHERE([
                        ['hosp_no',$request->input('hosp_no')],
                        ['discharge_date',null]
                    ])
                    ->FIRST();

        /* deduct supply stock */
        $supply = Supplies::FIND($request->input('supply_id'));
        $supply->qty =  ($supply->qty - $request->input('qty'));
        $supply->SAVE();

        /* add to billing */
        $billing = new Billings;
        $billing->consult_id = $consult->id;
        $billing->supply_id = $request->input('supply_id');
        $billing->qty = $request->input('qty');
        $billing->sub_total = $supply->price * $request->input('qty'); /* Get the price of the supply using supply_id X qty */
        $billing->emp_no = Auth::User()->user_id;
        $billing->SAVE();
        
        return redirect()->back()->with('success','Medicine has been added to the current bill!'); 
    }

    public function viewPharmacy() {

        $supplies = Supplies::SELECT(
                    'tbl_supplies.id',
                    'supply',
                    'price',
                    'qty',
                    'unit',
                    'category',
                    'category_id'
                )
                ->JOIN('tbl_supply_cat','tbl_supply_cat.id','=','tbl_supplies.category_id')
                ->WHERE([
                    ['qty','>',0],
                    ['category_id',1]
                ])
                ->GET();

        $billsGrouped = Billings::GROUPBY('consult_id','tbl_consults.created_at','or_num')
                ->SELECT(DB::RAW('
                    consult_id,
                    tbl_consults.created_at,
                    sum(sub_total) as sumSubTotal,
                    or_num
                '))
                ->JOIN('tbl_supplies','tbl_supplies.id','=','tbl_billings.supply_id')
                ->JOIN('tbl_consults','tbl_consults.id','=','tbl_billings.consult_id')
                ->WHERE('tbl_consults.hosp_no','X')
                ->GET();

        $bills = Billings::SELECT('tbl_billings.consult_id','tbl_supplies.supply','tbl_supplies.price','tbl_billings.qty')
                ->JOIN('tbl_supplies','tbl_supplies.id','=','tbl_billings.supply_id')
                ->WHERE('is_paid',1)
                ->ORDERBY('supply')
                ->GET();

        return view('user/pharmacy')
                ->with('currPage','pharmacy')
                ->with('supplies',$supplies)
                ->with('billsGrouped',$billsGrouped)
                ->with('bills',$bills);
    }

    public function pharmacyPay(Request $request) {

         /* find the patient's active consultation */
        $consult = new Consults;
        $consult->hosp_no = "X";
        $consult->complaint = "Walk in at Pharmacy";
        $consult->consult_type = "WLK";
        $consult->room_id = 0;
        $consult->SAVE();

        $supplyToPay = $request->input('supply_id');
        $price = $request->input('price');
        $qty = $request->input('qty');

        foreach ($supplyToPay as $k => $supply_id) {

            /* deduct supply stock */
            $supply = Supplies::FIND($supply_id);
            $supply->qty =  ($supply->qty - $qty[$k]);
            $supply->SAVE();

            /* add to billing */
            $billing = new Billings;
            $billing->consult_id = $consult->id;
            $billing->supply_id = $supply_id;
            $billing->qty = $qty[$k];
            $billing->sub_total = $price[$k] * $qty[$k];
            $billing->emp_no = Auth::User()->user_id;
            $billing->payee = $request->input('payee');
            $billing->or_num = $request->input('or_num');
            $billing->is_paid = 1;
            $billing->SAVE();
        }
        
        return redirect()->back()->with('success','Medicine has been successfully charged!');
    }

    public function viewSupplies() {

        $supplies = Supplies::SELECT(
                    'tbl_supplies.id',
                    'supply',
                    'price',
                    'qty',
                    'unit',
                    'category',
                    'category_id'
                )
                ->JOIN('tbl_supply_cat','tbl_supply_cat.id','=','tbl_supplies.category_id')
                ->WHERE('qty','>',0)
                ->GET();

        $categories = SupplyCats::ALL();

        return view('user/supplies')
                ->with('currPage','supplies')
                ->with('supplies',$supplies)
                ->with('categories',$categories);
    }

    public function addSupply(Request $request) {

        $supply = new Supplies;
        $supply->supply = $request->input('supply');
        $supply->price = $request->input('price');
        $supply->unit = $request->input('unit');
        $supply->qty = $request->input('qty');
        $supply->category_id = $request->input('category_id');
        $supply->SAVE();

        return redirect()->back()->with('success','Supply has been successfully added!');
    }

    public function editSupply(Request $request) {

        $supply = Supplies::FIND($request->input('supply_id'));
        $supply->supply = $request->input('supply');
        $supply->price = $request->input('price');
        $supply->unit = $request->input('unit');
        $supply->qty = $request->input('qty');
        $supply->category_id = $request->input('category_id');
        $supply->SAVE();

        return redirect()->back()->with('success','Supply has been successfully updated!');
    }

    public function deleteSupply($id) {

        $supply = Supplies::FIND($id);
        $supply->qty = 0;
        $supply->SAVE();

        return redirect()->back()->with('danger','Supply has been deleted!');
    }

    public function addSupplyCat(Request $request) {

        $supplyCat = new SupplyCats;
        $supplyCat->category = $request->input('category');
        $supplyCat->description = $request->input('description');
        $supplyCat->SAVE();

        return redirect()->back()->with('success','Supply Category has been successfully added!');
    }

    public function editSupplyCat(Request $request) {

        $supplyCat = SupplyCats::FIND($request->input('category_id'));
        $supplyCat->category = $request->input('category');
        $supplyCat->description = $request->input('description');
        $supplyCat->SAVE();

        return redirect()->back()->with('success','Supply Category has been successfully updated!');
    }

    public function viewBillings() {

        $bills = Billings::GROUPBY('tbl_patients.hosp_no','last_name','first_name','middle_name','consult_id','tbl_consults.created_at','room','is_paid','payee','or_num')
                ->SELECT(DB::RAW('
                    tbl_patients.hosp_no,
                    last_name,
                    first_name,
                    middle_name,
                    consult_id,
                    tbl_consults.created_at,
                    room,
                    sum(sub_total) as sumSubTotal,
                    is_paid,
                    payee,
                    or_num
                '))
                ->JOIN('tbl_supplies','tbl_supplies.id','=','tbl_billings.supply_id')
                ->JOIN('tbl_consults','tbl_consults.id','=','tbl_billings.consult_id')
                ->JOIN('tbl_patients','tbl_patients.hosp_no','=','tbl_consults.hosp_no')
                ->JOIN('tbl_rooms','tbl_rooms.id','=','tbl_consults.room_id')
                ->GET();

        return view('user/billings')
                ->with('currPage','billings')
                ->with('bills',$bills);
    }

    public function deleteBilling($id) {

        $bill = Billings::FIND($id); //Get the bill info
 
        $supply_id = $bill->supply_id; //Save the id
        $qty = $bill->qty; //Save the qty

        $supply = Supplies::FIND($supply_id); //Get the supply info

        $new_qty = $supply->qty + $qty; //Current qty + deleted bill qty

        /*Update the qty of the supply*/
        $supply->qty = $new_qty;
        $supply->SAVE();

        /*Delete bill*/
        $bill->DELETE();

        return redirect()->back()->with('danger','You have successfully deleted this record.');
    }

    public function billOut(Request $request) {

        /* Set all items as paid */
        $bills = Billings::WHERE('consult_id',$request->input('consult_id'))
                ->UPDATE([
                    'payee' => $request->input('payee'),
                    'or_num' => $request->input('or_num'),
                    'is_paid' => 1
        ]);

        /* Set discharge date of consultation */
        $consult = Consults::FIND($request->input('consult_id'));
        $consult->discharge_date = Carbon::now();
        $consult->SAVE();

        /* Change patient status to NULL */
        $patient = Patients::FIND($consult->hosp_no);
        $patient->patient_stat = NULL;
        $patient->SAVE();

        return redirect()->back()->with('success','Patient has been successfully discharged!');
    }

    public function viewEmployees() {

        $employees = Employees::SELECT(
                    'emp_no',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'position',
                    'department'
                )
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE('emp_stat',1)
                ->GET();

        $positions = Positions::ALL();

        $departments = Departments::ALL();

        $payrolls = Payrolls::SELECT(
                    'tbl_employees.last_name',
                    'tbl_employees.first_name',
                    'tbl_employees.middle_name',
                    'tbl_positions.position',
                    'tbl_departments.department',
                    'tbl_emp_payroll.*'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_payroll.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->GET();

        $countries = Countries::ORDERBY('nationality')->GET();
        $provinces = Provinces::ORDERBY('provDesc')->GET();
        $cityMuns = CityMuns::ORDERBY('citymunDesc')->GET();
        $brgys = Brgys::ORDERBY('brgyDesc')->GET();
        $eligibilities = Eligibilities::ORDERBY('e_title')->GET();
        $professions = Professions::ORDERBY('profession')->GET();
        return view('user/employees')
                ->with('currPage','employees')
                ->with('employees',$employees)
                ->with('positions',$positions)
                ->with('departments',$departments)
                ->with('payrolls',$payrolls)
                ->with('countries',$countries)
                ->with('provinces',$provinces)
                ->with('cityMuns',$cityMuns)
                ->with('brgys',$brgys)
                ->with('eligibilities',$eligibilities)
                ->with('professions',$professions);
    }

    public function viewEmployeeProfile($emp_no) {

        $employee = Employees::SELECT()
                    ->JOIN('tbl_brgy','tbl_brgy.id','=','tbl_employees.brgy_id')
                    ->WHERE('emp_no',$emp_no)
                    ->FIRST();

        $positions = Positions::ALL();

        $departments = Departments::ALL();

        $attendances = DTR::SELECT(
                    'tbl_emp_dtr.*',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'position',
                    'department'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_dtr.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE('tbl_emp_dtr.emp_no',$emp_no)
                ->ORDERBY('dtr_date','DESC')
                ->GET();

        $payrolls = Payrolls::SELECT(
                    'tbl_employees.last_name',
                    'tbl_employees.first_name',
                    'tbl_employees.middle_name',
                    'tbl_positions.position',
                    'tbl_departments.department',
                    'tbl_emp_payroll.*'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_payroll.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE('tbl_emp_payroll.emp_no',$emp_no)
                ->GET();

        $eligibilities = Eligibilities::ORDERBY('e_title')->GET();
        $countries = Countries::SELECT()->ORDERBY('nationality')->GET();
        $provinces = Provinces::SELECT()->ORDERBY('provDesc')->GET();
        $cityMuns = CityMuns::SELECT()->WHERE('provCode',$employee->provCode)->ORDERBY('citymunDesc')->GET();
        $brgys = Brgys::SELECT()->WHERE('id',$employee->brgy_id)->GET();
        $professions = Professions::ALL();
        
        $brgys2 = Brgys::FIND($employee->brgy_id2);
        $cityMuns2 = CityMuns::SELECT()->WHERE('provCode',$brgys2->provCode)->ORDERBY('citymunDesc')->GET();
        
        $schedules = Schedules::SELECT()
                ->WHERE('emp_no',$emp_no)
                ->GET();

        return view('user/employee-profile')
                ->with('currPage','employees')
                ->with('employee',$employee)
                ->with('positions',$positions)
                ->with('departments',$departments)
                ->with('attendances',$attendances)
                ->with('payrolls',$payrolls)
                ->with('eligibilities',$eligibilities)
                ->with('countries',$countries)
                ->with('provinces',$provinces)
                ->with('cityMuns',$cityMuns)
                ->with('brgys',$brgys)
                ->with('professions',$professions)
                ->with('cityMuns2',$cityMuns2)
                ->with('brgys2',$brgys2)
                ->with('schedules',$schedules);
    }

    public function addEmployee(Request $request) {

        $emp_no_set = $request->input('emp_no');
        
        $filename = "";
        $filename2 = "";

        /*save file to public folder*/
        if($request->hasFile('profile_img')) {
            $file = $request->file('profile_img');
            $filename = $emp_no_set.'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('assets/img/faces');
            $file->move($destinationPath,$filename);
        }
        if($request->hasFile('pds')) {
            $file2 = $request->file('pds');
            $filename2 = $emp_no_set.'.'.$file2->getClientOriginalExtension();
            $destinationPath2 = public_path('uploads/pds');
            $file2->move($destinationPath2,$filename2);
        }
        
        /* Save Employee Info to database*/
        $employee = new Employees;
        $employee->emp_no = $emp_no_set;
        $employee->last_name = $request->input('last_name');
        $employee->first_name = $request->input('first_name');
        $employee->middle_name = $request->input('middle_name');
        $employee->extension = $request->input('extension');
        $employee->gender = $request->input('gender');
        $employee->birthdate = $request->input('birthdate');
        $employee->birthplace = $request->input('birthplace');
        $employee->citizenship_id = $request->input('citizenship_id');
        $employee->civil_stat = $request->input('civil_stat');
        $employee->height = $request->input('height');
        $employee->weight = $request->input('weight');
        $employee->blood_type = $request->input('blood_type');
        $employee->house_no = $request->input('house_no');
        $employee->street = $request->input('street');
        $employee->subdivision = $request->input('subdivision');
        $employee->brgy_id = $request->input('brgy');
        $employee->house_no2 = $request->input('house_no2');
        $employee->street2 = $request->input('street2');
        $employee->subdivision2 = $request->input('subdivision2');
        $employee->brgy_id2 = $request->input('brgy2');
        $employee->contact_no = $request->input('contact_no');
        $employee->telphone = $request->input('telphone');
        $employee->email = $request->input('email');
        $employee->acct_no = $request->input('acct_no');
        $employee->gsis = $request->input('gsis');
        $employee->pagibig = $request->input('pagibig');
        $employee->phic = $request->input('phic');
        $employee->sss = $request->input('sss');
        $employee->tin = $request->input('tin');
        $employee->eligibility_id = $request->input('eligibility_id');
        $employee->profession = $request->input('profession');
        $employee->position_id = $request->input('position_id');
        $employee->department_id = $request->input('department_id');
        $employee->profile_img = $filename;
        $employee->pds_file = $filename2;
        $employee->SAVE();
        
        return redirect()->back()->with('success','You have saved a new employee information!');
    }

    public function updateEmployeeInfo(Request $request) {

        /* find employee using emp_no then update fields */
        $employee = Employees::FIND($request->input('emp_no'));
        $employee->last_name = $request->input('last_name');
        $employee->first_name = $request->input('first_name');
        $employee->middle_name = $request->input('middle_name');
        $employee->extension = $request->input('extension');
        $employee->gender = $request->input('gender');
        $employee->birthdate = $request->input('birthdate');
        $employee->birthplace = $request->input('birthplace');
        $employee->citizenship_id = $request->input('citizenship_id');
        $employee->civil_stat = $request->input('civil_stat');
        $employee->height = $request->input('height');
        $employee->weight = $request->input('weight');
        $employee->blood_type = $request->input('blood_type');
        $employee->house_no = $request->input('house_no');
        $employee->street = $request->input('street');
        $employee->subdivision = $request->input('subdivision');
        $employee->brgy_id = $request->input('brgy');
        $employee->house_no2 = $request->input('house_no2');
        $employee->street2 = $request->input('street2');
        $employee->subdivision2 = $request->input('subdivision2');
        $employee->brgy_id2 = $request->input('brgy2');
        $employee->contact_no = $request->input('contact_no');
        $employee->telphone = $request->input('telphone');
        $employee->email = $request->input('email');
        $employee->acct_no = $request->input('acct_no');
        $employee->gsis = $request->input('gsis');
        $employee->pagibig = $request->input('pagibig');
        $employee->phic = $request->input('phic');
        $employee->sss = $request->input('sss');
        $employee->tin = $request->input('tin');
        $employee->eligibility_id = $request->input('eligibility_id');
        $employee->profession = $request->input('profession');
        $employee->position_id = $request->input('position_id');
        $employee->department_id = $request->input('department_id');
        
        /* Update profile image if there is an attached file*/
        if($request->hasFile('profile_img')) {

            /* Save file to public folder*/
            $file = $request->file('profile_img');
            $filename = $request->input('emp_no').'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('assets/img/faces');
            $file->move($destinationPath,$filename);

            $employee->profile_img = $filename;
       }

       if($request->hasFile('pds')) {
            $file2 = $request->file('pds');
            $filename2 = $request->input('emp_no').'.'.$file2->getClientOriginalExtension();
            $destinationPath2 = public_path('uploads/pds');
            $file2->move($destinationPath2,$filename2);

            $employee->pds_file = $filename2;
        }

        $employee->SAVE();
        
        return redirect()->back()->with('success','You have updated this employee\'s information!');
    }

    public function viewSchedules() {

        $schedules = Schedules::SELECT(
                    'sched_date',
                    'tbl_employees.emp_no',
                    'first_name',
                    'last_name',
                    'middle_name',
                    'department',
                    'position',
                    'sched_in',
                    'sched_out'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_scheds.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->GET();

        $employees = Employees::SELECT(
                    'emp_no',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'position',
                    'department'
                )
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE('emp_stat',1)
                ->GET();

        $departments = Departments::ALL();

        return view('user/schedules')
                ->with('currPage','schedules')
                ->with('schedules',$schedules)
                ->with('employees',$employees)
                ->with('departments',$departments);
    }

    public function addSchedule(Request $request) {

        $schedule = new Schedules;
        $schedule->emp_no = $request->input('emp_no');
        $schedule->sched_in = $request->input('sched_in');
        $schedule->sched_out = $request->input('sched_out');
        $schedule->sched_date = $request->input('sched_date');
        $schedule->SAVE();

        return redirect()->back()->with('success','Schedule has bee successfully added!');
    }

    public function searchSchedule(Request $request) {

        $emp_no = $request->input('emp_no');
        $department = $request->input('department');

        if($emp_no!=NULL) {
            $stmt1 = 'tbl_employees.emp_no';
            $stmt2 = $emp_no;
        } else if($department!=NULL) {
            $stmt1 = 'tbl_departments.id';
            $stmt2 = $department;
        } else {
            $stmt1 = 'tbl_emp_scheds.sched_date';
            $stmt2 = Carbon::parse($request->input('sched_date'))->toDateString();
        }

        $schedules = Schedules::SELECT(
                    'sched_date',
                    'tbl_employees.emp_no',
                    'first_name',
                    'last_name',
                    'middle_name',
                    'department',
                    'position',
                    'sched_in',
                    'sched_out'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_scheds.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE($stmt1,$stmt2)
                ->GET();

        $employees = Employees::SELECT(
                    'emp_no',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'position',
                    'department'
                )
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE('emp_stat',1)
                ->GET();

        $departments = Departments::ALL();

        return view('user/schedules')
                ->with('currPage','schedules')
                ->with('schedules',$schedules)
                ->with('employees',$employees)
                ->with('departments',$departments);
    }

    public function deleteSchedule($id) {

        $schedule = Schedules::FIND($id);
        $schedule->DELETE();

        return redirect()->back()->with('danger','Schedule has bee deleted!');
    }

    public function viewPayroll() {

        $payrolls = Payrolls::SELECT(
                    'tbl_employees.last_name',
                    'tbl_employees.first_name',
                    'tbl_employees.middle_name',
                    'tbl_positions.position',
                    'tbl_departments.department',
                    'tbl_emp_payroll.*'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_payroll.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->GET();

        $employees = Employees::SELECT(
                    'emp_no',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'position',
                    'department'
                )
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE('emp_stat',1)
                ->GET();

        $departments = Departments::ALL();

        return view('user/payroll')
                ->with('currPage','payroll')
                ->with('payrolls',$payrolls)
                ->with('employees',$employees)
                ->with('departments',$departments);
    }

    public function viewEditPayroll($id) {

        $payroll = Payrolls::SELECT(
                    'tbl_employees.last_name',
                    'tbl_employees.first_name',
                    'tbl_employees.middle_name',
                    'tbl_positions.position',
                    'tbl_departments.department',
                    'tbl_emp_payroll.*'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_payroll.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->FIRST();


        return view('user/payroll-edit')
                ->with('currPage','payroll')
                ->with('payroll',$payroll);
    }

    public function updatePayroll(Request $request) {

        $payroll = Payrolls::FIND($request->input('id'));
        $payroll->accrued_income = $request->input('accrued_income');
        $payroll->salary_diff = $request->input('salary_diff');
        $payroll->salary_increase = $request->input('salary_increase');
        $payroll->personnel_allowance = $request->input('personnel_allowance');
        $payroll->refund = $request->input('refund');
        $payroll->gsis = $request->input('gsis');
        $payroll->tax = $request->input('tax');
        $payroll->philhealth = $request->input('philhealth');
        $payroll->pagibig = $request->input('pagibig');
        $payroll->pagibig2 = $request->input('pagibig2');
        $payroll->hdmf = $request->input('hdmf');
        $payroll->salary_loan = $request->input('salary_loan');
        $payroll->policy_loan = $request->input('policy_loan');
        $payroll->cash_advance = $request->input('cash_advance');
        $payroll->umid_cash = $request->input('umid_cash');
        $payroll->conso_loan = $request->input('conso_loan');
        $payroll->emergency_loan = $request->input('emergency_loan');
        $payroll->housing_loan = $request->input('housing_loan');
        $payroll->sdmpc_loan = $request->input('sdmpc_loan');
        $payroll->sdmpc_coop = $request->input('sdmpc_coop');
        $payroll->landbank = $request->input('landbank');
        $payroll->dorm_fee = $request->input('dorm_fee');
        $payroll->mortuary_fund = $request->input('mortuary_fund');
        $payroll->bereavement_asst = $request->input('bereavement_asst');
        $payroll->assoc_due = $request->input('assoc_due');
        $payroll->other_deductions =$request->input('other_deductions');
        $payroll->hazard = $request->input('hazard');
        $payroll->subs_laundry = $request->input('subs_laundry');
        $payroll->food_allowance = $request->input('food_allowance');
        $payroll->travel_allowance = $request->input('travel_allowance');
        $payroll->clothing_allowance = $request->input('clothing_allowance');
        $payroll->adjustments = $request->input('adjustments');
        $payroll->other_benefits =  $request->input('other_benefits');
        $payroll->SAVE();

        return redirect()->back()->with('success','Payroll has been updated!');
    }

    public function searchPayroll(Request $request) {

        $emp_no = $request->input('emp_no');
        $department = $request->input('department');

        if($emp_no!=NULL) {
            $stmt1 = 'tbl_employees.emp_no';
            $stmt2 = $emp_no;
        } else if($department!=NULL) {
            $stmt1 = 'tbl_departments.id';
            $stmt2 = $department;
        } else {
            $stmt1 = 'tbl_emp_payroll.payroll_date';
            $stmt2 = Carbon::create($request->input('payroll_year'),$request->input('payroll_month'),$request->input('payroll_date'));
        }
            
        $payrolls = Payrolls::SELECT(
                    'tbl_employees.last_name',
                    'tbl_employees.first_name',
                    'tbl_employees.middle_name',
                    'tbl_positions.position',
                    'tbl_departments.department',
                    'tbl_emp_payroll.*'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_payroll.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE($stmt1,$stmt2)
                ->GET();

        $employees = Employees::SELECT(
                    'emp_no',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'position',
                    'department'
                )
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE('emp_stat',1)
                ->GET();

        $departments = Departments::ALL();

        return view('user/payroll')
                ->with('currPage','payroll')
                ->with('payrolls',$payrolls)
                ->with('employees',$employees)
                ->with('departments',$departments);
    }

    public function addPayroll(Request $request) {

        $pdate = 1;
        if($request->input('payroll_date')!=1)
            $pdate = 16;
        $payroll_date = Carbon::create($request->input('payroll_year'),$request->input('payroll_month'),$pdate);

        $payroll = new Payrolls;
        $payroll->emp_no = $request->input('emp_no');
        //$payroll->basic_pay = $request->input('basic_pay1')/2;
        $payroll->accrued_income = $request->input('accrued_income');
        $payroll->salary_diff = $request->input('salary_diff');
        $payroll->salary_increase = $request->input('salary_increase');
        $payroll->personnel_allowance = $request->input('personnel_allowance');
        $payroll->refund = $request->input('refund');
        $payroll->gsis = $request->input('gsis');
        $payroll->tax = $request->input('tax');
        $payroll->philhealth = $request->input('philhealth');
        $payroll->pagibig = $request->input('pagibig');
        $payroll->pagibig2 = $request->input('pagibig2');
        $payroll->hdmf = $request->input('hdmf');
        $payroll->salary_loan = $request->input('salary_loan');
        $payroll->policy_loan = $request->input('policy_loan');
        $payroll->cash_advance = $request->input('cash_advance');
        $payroll->umid_cash = $request->input('umid_cash');
        $payroll->conso_loan = $request->input('conso_loan');
        $payroll->emergency_loan = $request->input('emergency_loan');
        $payroll->housing_loan = $request->input('housing_loan');
        $payroll->sdmpc_loan = $request->input('sdmpc_loan');
        $payroll->sdmpc_coop = $request->input('sdmpc_coop');
        $payroll->landbank = $request->input('landbank');
        $payroll->dorm_fee = $request->input('dorm_fee');
        $payroll->mortuary_fund = $request->input('mortuary_fund');
        $payroll->bereavement_asst = $request->input('bereavement_asst');
        $payroll->assoc_due = $request->input('assoc_due');
        $payroll->other_deductions =$request->input('other_deductions');
        $payroll->hazard = $request->input('hazard');
        $payroll->subs_laundry = $request->input('subs_laundry');
        $payroll->food_allowance = $request->input('food_allowance');
        $payroll->travel_allowance = $request->input('travel_allowance');
        $payroll->clothing_allowance = $request->input('clothing_allowance');
        $payroll->adjustments = $request->input('adjustments');
        $payroll->other_benefits =  $request->input('other_benefits');
        $payroll->payroll_date = $payroll_date;
        $payroll->SAVE();

        return redirect()->back()->with('success','Payroll has been saved!');
    }

    public function viewPayslip($id) {

        $payroll = Payrolls::SELECT(
                    'tbl_employees.last_name',
                    'tbl_employees.first_name',
                    'tbl_employees.middle_name',
                    'tbl_positions.position',
                    'tbl_departments.department',
                    'tbl_emp_payroll.*'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_payroll.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE('tbl_emp_payroll.id',$id)
                ->FIRST();

        return view('user/payslip')
                ->with('currPage','payroll')
                ->with('payroll',$payroll);
    }

    public function batchPrintPayslip(Request $request) {

        if($request->input('payroll_date')!=0) {

            $date = Carbon::create($request->input('payroll_year'),$request->input('payroll_month'),$request->input('payroll_date'));

            $payrolls = Payrolls::SELECT(
                        'tbl_employees.last_name',
                        'tbl_employees.first_name',
                        'tbl_employees.middle_name',
                        'tbl_positions.position',
                        'tbl_departments.department',
                        'tbl_emp_payroll.*'
                    )
                    ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_payroll.emp_no')
                    ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                    ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                    ->WHERE('tbl_departments.id',$request->input('department'))
                    ->WHERE('tbl_emp_payroll.payroll_date',$date->toDateString())
                    ->GET();

            if(count($payrolls)>0) {

                return view('user/payslip-batch')
                    ->with('currPage','payroll')
                    ->with('payrolls',$payrolls);
            } else 
                return redirect()->back()->with('danger','No data found!');
            
            } else {

                $date1 = Carbon::create($request->input('payroll_year'),$request->input('payroll_month'),1);
                $date2 = Carbon::create($request->input('payroll_year'),$request->input('payroll_month'),16);

                $payrolls1 = Payrolls::SELECT(
                        'tbl_employees.last_name',
                        'tbl_employees.first_name',
                        'tbl_employees.middle_name',
                        'tbl_positions.position',
                        'tbl_departments.department',
                        'tbl_emp_payroll.*'
                    )
                    ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_payroll.emp_no')
                    ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                    ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                    ->WHERE('tbl_departments.id',$request->input('department'))
                    ->WHERE('tbl_emp_payroll.payroll_date',$date1->toDateString())
                    ->GET();

                $payrolls2 = Payrolls::SELECT(
                        'tbl_employees.last_name',
                        'tbl_employees.first_name',
                        'tbl_employees.middle_name',
                        'tbl_positions.position',
                        'tbl_departments.department',
                        'tbl_emp_payroll.*'
                    )
                    ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_payroll.emp_no')
                    ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                    ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                    ->WHERE('tbl_departments.id',$request->input('department'))
                    ->WHERE('tbl_emp_payroll.payroll_date',$date2->toDateString())
                    ->GET();

                if(count($payrolls1)>0) {
                
                    return view('user/payslip-batch2')
                        ->with('currPage','payroll')
                        ->with('payrolls1',$payrolls1)
                        ->with('payrolls2',$payrolls2);
                } else 
                    return redirect()->back()->with('danger','No data found!');
            }
    }

    public function viewAttendance() {

        $attendances = DTR::SELECT(
                    'tbl_emp_dtr.*',
                    'last_name',
                    'first_name',
                    'middle_name'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_dtr.emp_no')
                ->GET();

        $employees = Employees::SELECT(
                    'emp_no',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'position',
                    'department'
                )
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE('emp_stat',1)
                ->GET();

        $departments = Departments::ALL();

        return view('user/attendance')
                ->with('currPage','dtr')
                ->with('attendances',$attendances)
                ->with('employees',$employees)
                ->with('departments',$departments);
    }

    public function addAttendance(Request $request) {

        $diff = $am = $pm = $ot = 0;

        if($request->input('timein_am')!=NULL) {
            if($request->input('timein_pm')!=NULL) {
                $timein_pm = Carbon::parse($request->input('timein_pm'));
                $timeout_pm = Carbon::parse($request->input('timeout_pm'));
                $pm = $timein_pm->diffInHours($timeout_pm);
            } 

            if($request->input('timeout_am')!=NULL) {
                $timein_am = Carbon::parse($request->input('timein_am'));
                $timeout_am = Carbon::parse($request->input('timeout_am'));
                $am = $timein_am->diffInHours($timeout_am);
            } 

            if($request->input('timeout_am')==NULL && $request->input('timeout_am')==NULL) {
                $timein_am = Carbon::parse($request->input('timein_am'));
                $timeout_pm = Carbon::parse($request->input('timeout_pm'));
                $am = $timein_am->diffInHours($timeout_pm);
            }
            
        } else {
            $timein_pm = Carbon::parse($request->input('timein_pm'));
            $timeout_pm = Carbon::parse($request->input('timeout_pm'));
            $pm = $timein_pm->diffInHours($timeout_pm);
        }

        if($request->input('timein_ot')!=NULL) {
            $timein_ot = Carbon::parse($request->input('timein_ot'));
            $timeout_ot = Carbon::parse($request->input('timeout_ot'));
            $ot = $timein_ot->diffInHours($timeout_ot);   
        }

        $diff = $am + $pm;
        if($diff>8)
            $diff = 8;

        $attendance = new DTR;
        $attendance->emp_no = $request->input('emp_no');
        $attendance->timein_am = $request->input('timein_am');
        $attendance->timeout_am = $request->input('timeout_am');
        $attendance->timein_pm = $request->input('timein_pm');
        $attendance->timeout_pm = $request->input('timeout_pm');
        $attendance->timein_ot = $request->input('timein_ot');
        $attendance->timeout_ot = $request->input('timeout_ot');
        $attendance->dtr_date = $request->input('dtr_date');
        $attendance->total_hrs = $diff;
        $attendance->total_ot = $ot;
        $attendance->SAVE();

        return redirect()->back()->with('success','Attendance has been successfully added!');
    }

    public function searchDTR(Request $request) {

        $date1 = Carbon::parse($request->input('fromdate'))->toDateString();
        $date2 = Carbon::parse($request->input('todate'))->toDateString(); 

        $attendances = DTR::SELECT(
                    'tbl_emp_dtr.*',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'acct_no',
                    'position',
                    'department'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_dtr.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHEREBETWEEN('dtr_date',[$date1,$date2])
                ->WHERE('tbl_emp_dtr.emp_no',$request->input('emp_no'))
                ->ORDERBY('dtr_date')
                ->GET();

        if(count($attendances)>0) {
            return view('user/dtr')
                ->with('currPage','dtr')
                ->with('attendances',$attendances);
        } else {
            return redirect()->back()->with('danger','No data found!');
        }

        
    }

    public function viewDTR($id) {

        $dtr = DTR::FIND($id);

        $date1 = Carbon::parse($dtr->dtr_date)->firstOfMonth();
        $date2 = Carbon::parse($dtr->dtr_date)->lastOfMonth(); 

        $attendances = DTR::SELECT(
                    'tbl_emp_dtr.*',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'acct_no',
                    'position',
                    'department'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_dtr.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHEREBETWEEN('dtr_date',[$date1,$date2])
                ->WHERE('tbl_emp_dtr.emp_no',$dtr->emp_no)
                ->ORDERBY('dtr_date')
                ->GET();

        return view('user/dtr')
                ->with('currPage','dtr')
                ->with('attendances',$attendances);
    }

    public function batchPrintDtr(Request $request) {

        $date = Carbon::create($request->input('year'),$request->input('month'),1);

        $employees = DTR::SELECT(
                    'tbl_employees.emp_no',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'acct_no',
                    'position',
                    'department'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_dtr.emp_no')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHEREBETWEEN('dtr_date',[Carbon::parse($date)->firstOfMonth(),$date->lastOfMonth()])
                ->WHERE('tbl_departments.id',$request->input('department'))
                ->GROUPBY('emp_no','last_name','first_name','middle_name','acct_no','position','department')
                ->GET();


        $attendances = DTR::SELECT('tbl_emp_dtr.*')
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_emp_dtr.emp_no')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHEREBETWEEN('dtr_date',[Carbon::parse($date)->firstOfMonth(),$date->lastOfMonth()])
                ->WHERE('tbl_departments.id',$request->input('department'))
                ->ORDERBY('dtr_date')
                ->GET();

        if(count($employees)>0) {

            return view('user/dtr-batch')
                    ->with('currPage','dtr')
                    ->with('dtr_date',$date)
                    ->with('employees',$employees)
                    ->with('attendances',$attendances);
        } else {

            return redirect()->back()->with('danger','No data found!');
        }

    }

    public function editAttendance(Request $request) {

        $diff = $am = $pm = $ot = 0;

        if($request->input('timein_am')!=NULL) {
            if($request->input('timein_pm')!=NULL) {
                $timein_pm = Carbon::parse($request->input('timein_pm'));
                $timeout_pm = Carbon::parse($request->input('timeout_pm'));
                $pm = $timein_pm->diffInHours($timeout_pm);
            } 

            if($request->input('timeout_am')!=NULL) {
                $timein_am = Carbon::parse($request->input('timein_am'));
                $timeout_am = Carbon::parse($request->input('timeout_am'));
                $am = $timein_am->diffInHours($timeout_am);
            } 

            if($request->input('timeout_am')==NULL && $request->input('timeout_am')==NULL) {
                $timein_am = Carbon::parse($request->input('timein_am'));
                $timeout_pm = Carbon::parse($request->input('timeout_pm'));
                $am = $timein_am->diffInHours($timeout_pm);
            }
            
        } else {
            $timein_pm = Carbon::parse($request->input('timein_pm'));
            $timeout_pm = Carbon::parse($request->input('timeout_pm'));
            $pm = $timein_pm->diffInHours($timeout_pm);
        }

        if($request->input('timein_ot')!=NULL) {
            $timein_ot = Carbon::parse($request->input('timein_ot'));
            $timeout_ot = Carbon::parse($request->input('timeout_ot'));
            $ot = $timein_ot->diffInHours($timeout_ot);   
        }

        $diff = $am + $pm;
        if($diff>8)
            $diff = 8;

        $attendance = DTR::FIND($request->input('dtr_id'));
        $attendance->timein_am = $request->input('timein_am');
        $attendance->timeout_am = $request->input('timeout_am');
        $attendance->timein_pm = $request->input('timein_pm');
        $attendance->timeout_pm = $request->input('timeout_pm');
        $attendance->timein_ot = $request->input('timein_ot');
        $attendance->timeout_ot = $request->input('timeout_ot');
        $attendance->dtr_date = $request->input('dtr_date');
        $attendance->total_hrs = $diff;
        $attendance->total_ot = $ot;
        $attendance->SAVE();

        return redirect()->back()->with('success','Record has been successfully updated!');
    }

    public function deleteAttendance($id) {

        $attendance = DTR::FIND($id);
        $attendance->DELETE();

        return redirect()->back()->with('danger','Record has been deleted!');
    }

     public function deletePayroll($id) {

        $payroll = Payrolls::FIND($id);
        $payroll->DELETE();
        return redirect()->back()->with('danger','Payroll data has been deleted!');
    }

    public function uploadFile(Request $request) {

        /* Validate file if CSV */
        $this->validate($request, array(
          'fileupload'   => 'required|mimes:csv,txt'
        ));

        /* Determine where to save file */
        if($request->input('file_type')=='DTR')
            $destinationPath = public_path('uploads/dtr');
        else
            $destinationPath = public_path('uploads/payroll');

        /* Save file to public folder*/
        $file = $request->file('fileupload');
        $filename = Carbon::now()->valueOf().'.'.$file->getClientOriginalExtension();
        $file->move($destinationPath,$filename);

        /* Read CSV file and save details to database*/
        $csvfile = fopen($destinationPath.'//'.$filename, 'r');
        
        $lineCount = 0;
        while (($line = fgetcsv($csvfile)) !== FALSE) {
            
            if($lineCount>0) {

                if($request->input('file_type')=='DTR') {

                    $timein_am = $timeout_am = $timein_pm = $timeout_pm = $timein_ot = $timeout_ot = NULL;
                    $diff = $am = $pm = $ot = 0;

                    // if($line[2]!=NULL) {
                    //     if($line[4]!=NULL && $line[5]!=NULL) {
                    //         $timein_pm = Carbon::parse($line[4]);
                    //         $timeout_pm = Carbon::parse($line[5]);
                    //         $pm = $timein_pm->diffInHours($timeout_pm);
                    //     } 

                    //     if($line[3]!=NULL && $line[2]!=NULL) {
                    //         $timein_am = Carbon::parse($line[2]);
                    //         $timeout_am = Carbon::parse($line[3]);
                    //         $am = $timein_am->diffInHours($timeout_am);
                    //     } 

                    //     if($line[3]==NULL && $line[4]==NULL && $line[5]!=NULL) {
                    //         $timein_am = Carbon::parse($line[2]);
                    //         $timeout_pm =Carbon::parse($line[5]);
                    //         $am = $timein_am->diffInHours($timeout_pm);
                    //     }
                        
                    // } else if($line[4]!=NULL && $line[5]!=NULL) {
                    //     $timein_pm = Carbon::parse($line[4]);
                    //     $timeout_pm = Carbon::parse($line[5]);
                    //     $pm = $timein_pm->diffInHours($timeout_pm);
                    // }

                    $timein_am = Carbon::parse($line[2]);
                    $timeout_am = Carbon::parse($line[3]);
                    $timein_pm = Carbon::parse($line[4]);
                    $timeout_pm =Carbon::parse($line[5]);
                    $am = $timein_am->diffInHours($timeout_am);
                    $pm = $timein_pm->diffInHours($timeout_pm);

                    if($line[6]!=NULL && $line[7]!=NULL) {
                        $timein_ot = Carbon::parse($line[6]);
                        $timeout_ot = Carbon::parse($line[7]);
                        $ot = $timein_am->diffInHours($timeout_am);   
                    }

                    $diff = $am + $pm;
                    if($diff>=8)
                        $diff = 8;

                    $attendance = new DTR;
                    $attendance->emp_no = $line[0];
                    if($line[2]!=NULL)
                        $attendance->timein_am = $line[2];
                    if($line[3]!=NULL)
                        $attendance->timeout_am = $line[3];
                    if($line[4]!=NULL)
                        $attendance->timein_pm = $line[4];
                    if($line[5]!=NULL)
                        $attendance->timeout_pm = $line[5];
                    if($line[6]!=NULL)
                        $attendance->timein_ot = $line[6];
                    if($line[7]!=NULL)
                        $attendance->timeout_ot = $line[7];
                    $attendance->dtr_date =  Carbon::parse($line[1])->toDateString();
                    $attendance->total_hrs = $diff;
                    $attendance->total_ot = $ot;
                    $attendance->SAVE();  
                } else {

                    $payroll = new Payrolls;
                    $payroll->emp_no = $line[0];
                    $payroll->basic_pay = $line[2];
                    $payroll->accrued_income = $line[3];
                    $payroll->salary_diff = $line[4];
                    $payroll->salary_increase = $line[5];
                    $payroll->personnel_allowance = $line[6];
                    $payroll->refund = $line[7];
                    $payroll->gsis = $line[15];
                    $payroll->tax = $line[16];
                    $payroll->philhealth = $line[17];
                    $payroll->pagibig = $line[18];
                    $payroll->pagibig2 = $line[19];
                    $payroll->hdmf = $line[20];
                    $payroll->salary_loan = $line[21];
                    $payroll->policy_loan = $line[22];
                    $payroll->cash_advance = $line[23];
                    $payroll->umid_cash = $line[24];
                    $payroll->conso_loan = $line[25];
                    $payroll->emergency_loan = $line[26];
                    $payroll->housing_loan = $line[27];
                    $payroll->sdmpc_loan = $line[28];
                    $payroll->sdmpc_coop = $line[29];
                    $payroll->landbank = $line[30];
                    $payroll->dorm_fee = $line[31];
                    $payroll->mortuary_fund = $line[32];
                    $payroll->bereavement_asst = $line[33];
                    $payroll->assoc_due = $line[34];
                    $payroll->other_deductions = $line[35];
                    $payroll->hazard = $line[8];
                    $payroll->subs_laundry = $line[9];
                    $payroll->food_allowance = $line[10];
                    $payroll->travel_allowance = $line[11];
                    $payroll->clothing_allowance = $line[12];
                    $payroll->adjustments = $line[13];
                    $payroll->other_benefits = $line[14];
                    $payroll->payroll_date = Carbon::parse($line[1])->toDateString();
                    $payroll->SAVE();
                }   
            }
            
            $lineCount++;
        }
        

        /* Close file */
        fclose($csvfile);

        return redirect()->back()->with('success','File has been successfully uploaded!');
    }
}