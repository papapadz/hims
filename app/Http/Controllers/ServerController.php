<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccessKey;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ServerController extends Controller
{
    public function createHospitalNumber() {

    }

    public function setFacilityAccess(Request $request) {

    }

    public function initFacilityKey($id,$url) {
        $genKey = Str::random(20);

        AccessKey::firstOrCreate([
            'facility_id' => $id
        ],[
            'public' => Hash::make($genKey)
        ]);

        $response = Http::post($url.'/api/facility/init/'.config('hims.own'), [
            'fkey' => $genKey
        ]);
    }
    
}
