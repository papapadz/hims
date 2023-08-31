<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('get/citymun/{code}','GetController@getCityMun');
Route::get('get/brgy/{code}','GetController@getBrgy');
Route::post('patient/self-register','PatientController@register');
Route::get('patient/view/create-account/{hosp_no}',function($hosp_no) {

	$user = DB::table('tbl_user_accounts')->where([['user_id',$hosp_no],['email_verified_at','!=',NULL]])->first();
	if($user)
		return view('auth.verify')->with('hosp_no',$hosp_no);
	else
		abort(401);
});
Route::post('patient/verified/create-account','UserController@newPatientAccount');

Route::group(['middleware' => ['auth','verified']], function() {

	Route::group(['middleware' => 'is_admin'], function() {

		/** v3 */
		Route::get('facilities','FacilityController@showFacilityLists');
		Route::post('facility/add','FacilityController@createFacility')->name('admin.facility.add');
		/** END V3 */

		Route::get('home', 'HomeController@index')->name('home');
		Route::get('user-accounts', 'AdminController@viewUserAccounts');
		Route::post('user-accounts/add', 'AdminController@addUserAccount');
		Route::post('user-accounts/edit','AdminController@editUserAccount');
		Route::get('user-accounts/delete/{id}','AdminController@deleteUserAccount');

		Route::get('patients', 'UserController@viewPatients');
		Route::post('patient/add-account','AdminController@addPatientAccount');
		Route::post('patient/edit-account','AdminController@editPatientAccount');
		Route::post('patients/add', 'UserController@addPatient');
		Route::post('patients/profile/save', 'UserController@updatePatientInfo');
		Route::post('patients/admit', 'UserController@admitPatient');
		Route::post('patient/add-medicine','UserController@addPatientMedicine');
		Route::post('patient/bill-out','UserController@billOut');
		Route::get('patient/delete/{hosp_no}','AdminController@deletePatient');
		Route::get('patient/verify-email/{hosp_no}','AdminController@verifyPatient');

		Route::get('appointment/delete/{id}', 'UserController@deleteAppointment');
		Route::post('consult/add-diagnosis', 'UserController@addDiagnosis');
		Route::post('consult/add-lab-request', 'UserController@addLabRequest');
		Route::post('consult/add-xray-request', 'UserController@addXRayRequest');
		Route::post('consult/add-prescription','UserController@addPrescription');
		Route::post('consult/add-consultation-fee','UserController@addConsultationFee');
		// Route::get('lab-requests', 'UserController@viewLabRequests');
		// Route::post('lab/add-result','UserController@addLabResult');
		// Route::get('lab/delete-request/{id}','UserController@deleteRequest');

		// Route::get('xray-requests', 'UserController@viewXRayRequests');
		// Route::post('xray/add-result','UserController@addXRayResult');
		// Route::get('xray/delete-request/{id}','UserController@deleteRequest');

		// Route::get('pharmacy','UserController@viewPharmacy');
		// Route::post('pharmacy/pay','UserController@pharmacyPay');

		// Route::get('supplies','UserController@viewSupplies');
		// Route::post('supply/add', 'UserController@addSupply');
		// Route::post('supply/edit', 'UserController@editSupply');
		// Route::get('supply/delete/{id}', 'UserController@deleteSupply');

		//Route::post('supply-category/add', 'UserController@addSupplyCat');
		//Route::post('supply-category/edit', 'UserController@editSupplyCat');

		Route::get('billings','UserController@viewBillings');
		Route::get('billing/{id}', 'PatientController@viewBillingInfo');
		Route::get('billing/delete/{id}', 'UserController@deleteBilling');

		Route::get('employees','UserController@viewEmployees');
		Route::post('employees/add','UserController@addEmployee');
		Route::get('employee/profile/{emp_no}','UserController@viewEmployeeProfile');
		Route::post('employee/profile/save','UserController@updateEmployeeInfo');
		Route::get('employee/delete/{emp_no}','AdminController@deleteEmployee');

		// Route::get('payroll','UserController@viewPayroll');
		// Route::post('payroll/add','UserController@addPayroll');
		// Route::post('payroll/search','UserController@searchPayroll');
		// Route::get('payroll/edit/{id}','UserController@viewEditPayroll');
		// Route::post('payroll/edit/save','UserController@updatePayroll');

		// Route::get('attendance','UserController@viewAttendance');
		// Route::post('attendance/add','UserController@addAttendance');
		// Route::post('dtr/upload','UserController@uploadFile');
		// Route::post('dtr/view','UserController@searchDTR');
		// Route::post('dtr/edit','UserController@editAttendance');
		// Route::get('dtr/{id}','UserController@viewDTR');
		// Route::get('dtr/delete/{id}','UserController@deleteAttendance');
		// Route::post('dtr/batch-print','UserController@batchPrintDtr');

		// Route::get('schedules','UserController@viewSchedules');
		// Route::post('schedule/add','UserController@addSchedule');
		// Route::post('schedule/search','UserController@searchSchedule');
		// Route::get('schedule/delete/{id}','UserController@deleteSchedule');

		// Route::get('payroll/delete/{id}','UserController@deletePayroll');
		// Route::get('payroll/payslip/{id}','UserController@viewPayslip');
		// Route::post('uploads/add','UserController@uploadFile');
		// Route::post('payroll/upload','UserController@uploadFile');
		// Route::post('payroll/batch-print','UserController@batchPrintPayslip');

		Route::get('settings/professions','AdminController@viewAllProfessions');
		Route::post('settings/profession/add','AdminController@addProfession');
		Route::get('settings/profession/delete/{id}','AdminController@deleteProfession');

		Route::get('settings/positions','AdminController@viewAllPositions');
		Route::post('settings/positions/add','AdminController@addPosition');
		Route::post('settings/positions/edit','AdminController@editPosition');
		Route::get('settings/positions/delete/{id}','AdminController@deletePosition');

		Route::get('settings/rooms','AdminController@viewAllRooms');
		Route::post('settings/rooms/add','AdminController@addRoom');
		Route::post('settings/rooms/edit','AdminController@editRoom');
		Route::get('settings/rooms/delete/{id}','AdminController@deleteRoom');
	});

	Route::get('user-logout','HomeController@logout');
	Route::get('patients/profile/{hosp_no}', 'PatientController@viewPatientProfile');
	Route::get('patients/consult/{id}', 'PatientController@viewConsult');
	Route::get('patient/chart/{id}', 'PatientController@viewPatientChart');
	Route::post('consult/add-appointment', 'UserController@addAppointment');

	Route::get('get/employee/{id}','GetController@getEmployee');
	Route::get('get/attendance/{id}/{date}/{month}/{year}','GetController@getAttendance');

	/** Appointments */
	Route::resources([
		'appointment' => 'AppointmentController'
	]);

	Route::get('appointment-calendar','AppointmentController@fullCalendar');

	Route::get('patient/video-call/{hosp_no}','PatientController@videoCallPatient');

	/** Patient Side */
});

