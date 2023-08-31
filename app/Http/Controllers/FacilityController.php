<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Facility;
use App\Provinces;
use Illuminate\Support\Facades\Hash;

class FacilityController extends Controller
{
    public function createFacility(Request $request) {

        $facility = new Facility;
        $facility->facility_name = $request->facility_name;
        $facility->facility_code = $request->facility_code;
        $facility->address_id = $request->address_id;
        $facility->location = $request->location;
        $facility->contact_num = $request->contact_num;
        $facility->website = $request->website;
        $facility->email_address = $request->email_address;
        $facility->facility_type = $request->facility_type;
        $facility->facility_classification = $request->facility_classification;
        $facility->licensing_status = $request->licensing_status;
        $facility->bed_capacity = $request->bed_capacity;
        $facility->save();

        $serverController = new ServerController;
        $serverController->initFacilityKey($facility->id);
    }

    public function showFacilityLists() {

        return view('admin.facilities')->with([
            'currPage' => 'facility',
            'facilities' => Facility::with('brgy')->get(),
            'provinces' => Provinces::ORDERBY('provDesc')->GET()
        ]);
    }
}
