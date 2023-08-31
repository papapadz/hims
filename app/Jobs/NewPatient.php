<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Patients;
use Carbon\Carbon;

class NewPatient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $data;

    public function __construct($arrPatient)
    {
        $this->data = $arrPatient;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*create hospital number*/
        $patient_count = count(Patients::whereBetween('created_at',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])->GET()) + 1;
        $hospital_no_count = str_pad($patient_count, 4, '0', STR_PAD_LEFT);
        $hospital_no_set = Carbon::now()->year.$hospital_no_count; /* Patient hospital number ex. 20190001 */
        //

        /*save patient info to database*/
        $patient = new Patients;
        $patient->hosp_no = $hospital_no_set;
        $patient->last_name = $this->data['last_name'];
        $patient->first_name = $this->data['first_name'];
        $patient->middle_name = $this->data['middle_name'];
        $patient->gender = $this->data['gender'];
        $patient->birthdate = $this->data['birthdate'];
        $patient->brgy_id = $this->data['brgy'];
        $patient->email = $this->data['email'];
        //$patient->address = $this->data['address'];
        $patient->contact_no = $this->data['contact_no'];
        $patient->civil_stat = $this->data['civil_stat'];
        $patient->philhealth_no = $this->data['philhealth_no'];
        $patient->blood_type = $this->data['blood_type'];
        $patient->facility_id = $this->data['facility_id'];
        $patient->SAVE();

        return $hospital_no_set;
    }
}
