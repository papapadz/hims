<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*Models*/
use App\User;
use App\Positions;
use App\Rooms;
use App\Professions;
use App\Employees;
use App\Patients;
/**/

class AdminController extends Controller
{
    
    public function viewUserAccounts() {

    	$users = User::SELECT(
                    'tbl_user_accounts.id',
                    'emp_no',
                    'username',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'position',
                    'department',
                    'account_type'
                )
                ->JOIN('tbl_employees','tbl_employees.emp_no','=','tbl_user_accounts.user_id')
                ->JOIN('tbl_positions','tbl_positions.id','=','tbl_employees.position_id')
                ->JOIN('tbl_departments','tbl_departments.id','=','tbl_employees.department_id')
                ->WHERE('account_type','!=',3) //Where accounts are not patient
                ->WHERE('emp_stat','=',1) // Where employees are active
                ->GET();

        $patients = User::SELECT(
                    'tbl_user_accounts.id',
                    'hosp_no',
                    'username',
                    'last_name',
                    'first_name',
                    'middle_name'
                )
                ->JOIN('tbl_patients','tbl_patients.hosp_no','=','tbl_user_accounts.user_id')
                ->GET();

    	return view('admin/user-accounts')
            ->with('currPage','user-accounts')
            ->with('users',$users)
            ->with('patients',$patients);
    }

    public function addUserAccount(Request $request) {

    	$user = new User;
        $user->user_id = $request->input('emp_no');
    	$user->username = $request->input('username');
    	$user->password = bcrypt($request->input('password'));
    	$user->account_type = $request->input('account_type');
    	$user->SAVE();

    	return redirect()->back()->with('success','User Account has been succesfully added!');
    }

    public function editUserAccount(Request $request) {

        $user = User::FIND($request->input('username_id'));
        $user->user_id = $request->input('emp_no');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->account_type = $request->input('account_type');
        $user->SAVE();

        return redirect()->back()->with('success','User Account has been succesfully updated!');
    }

    public function addPatientAccount(Request $request) {

        $user = new User;
        $user->user_id = $request->input('hosp_no');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->account_type = 3;
        $user->SAVE();

        return redirect()->back()->with('success','Patient Account has been succesfully added!');
    }

    public function editPatientAccount(Request $request) {

        $user = User::FIND($request->input('username_id'));
        $user->user_id = $request->input('hosp_no');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->account_type = 3;
        $user->SAVE();

        return redirect()->back()->with('success','Patient Account has been succesfully updated!');
    }

    public function deleteUserAccount($id) {

        $user = User::FIND($id)->DELETE();

        return redirect()->back()->with('danger','User Account has been deleted!');
    }  

    public function deleteEmployee($emp_no) {

        $employee = Employees::FIND($emp_no);
        $employee->DELETE();

        return redirect()->back()->with('danger','Employee Record has been deleted!');
    }

    public function deletePatient($hosp_no) {

        $patient = Patients::FIND($hosp_no);
        $patient->DELETE();

        return redirect()->back()->with('danger','Patient Record has been deleted!');
    }

    public function viewAllPositions() {

        $positions = Positions::ALL();

        return view('admin/positions')
                ->with('currPage','home')
                ->with('positions',$positions);
    }

    public function addPosition(Request $request) {

        $position = new Positions;
        $position->position = $request->input('position');
        $position->salary = $request->input('salary');
        $position->salary_grade = $request->input('salary_grade');
        $position->SAVE();

        return redirect()->back()->with('success','Position has been successfully added!');
    }

    public function editPosition(Request $request) {

        $position = Positions::FIND($request->input('position_id'));
        $position->position = $request->input('position');
        $position->salary = $request->input('salary');
        $position->SAVE();

        return redirect()->back()->with('success','Position has been successfully updated!');
    }

    public function deletePosition($id) {

        $position = Positions::FIND($id)->DELETE();

        return redirect()->back()->with('danger','Record has been deleted.');
    }

    public function viewAllRooms() {

        $rooms = Rooms::SELECT(
                    'tbl_rooms.*','tbl_room_types.room_type'
                )
                ->JOIN('tbl_room_types','tbl_room_types.id','=','tbl_rooms.room_type_id')
                ->GET();

        return view('admin/rooms')
                ->with('currPage','home')
                ->with('rooms',$rooms);
    }

    public function addRoom(Request $request) {

        $room = new Rooms;
        $room->room = $request->input('room');
        $room->room_type_id = $request->input('room_type_id');
        $room->fee = $request->input('fee');
        $room->max_occupancy = $request->input('max_occupancy');
        $room->SAVE();

        return redirect()->back()->with('success','Room has been successfully added!');
    }

    public function editRoom(Request $request) {

        $room = Rooms::FIND($request->input('room_id'));
        $room->room = $request->input('room');
        $room->room_type_id = $request->input('room_type_id');
        $room->fee = $request->input('fee');
        $room->max_occupancy = $request->input('max_occupancy');
        $room->SAVE();

        return redirect()->back()->with('success','Room has been successfully updated!');
    }

    public function deleteRoom($id) {

        $room = Rooms::FIND($id)->DELETE();

        return redirect()->back()->with('danger','Record has been deleted.');
    }

    public function viewAllProfessions() {

        $professions = Professions::SELECT()->ORDERBY('profession')->GET();

        return view('admin/professions')
                ->with('currPage','home')
                ->with('professions',$professions);
    }

    public function addProfession(Request $request) {

        $profession = new Professions;
        $profession->profession = $request->input('profession');
        $profession->SAVE();

        return redirect()->back()->with('success','Record has been saved!');
    }

    public function deleteProfession($id) {

        $profession = Professions::FIND($id);
        $profession->DELETE();

        return redirect()->back()->with('danger','Record has been deleted.');
    }

}
