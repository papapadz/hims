<?php $__env->startSection('content'); ?>
<form action="<?php echo e(url('patients/profile/save')); ?>" method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<input type="text" name="hosp_no" value="<?php echo e($patient->hosp_no); ?>" hidden>
<?php if(Auth::User()->account_type==3): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Welcome!</strong> Hello <?php echo e(Auth::User()->patientInfo->first_name); ?>! Welcome to your profile!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php endif; ?>
<div class="row">
  <div class="col-md-3">
    <div class="row">
      <div class="col-12">
        <div class="card" >
          <img class="card-img-top" style="width: 90%; align-self: center" src="<?php echo e(asset('assets/img/faces/'.$patient->profile_img)); ?>" alt="Card image cap">
          <div class="card-body">
            <h3 class="card-text text-center"><?php echo e($patient->hosp_no); ?></h3>
          </div>
          <div id="divEditProfileImg" class="card-footer" hidden="true">
            <label>Change Profile Image</label>
            <input type="file" name="profile_img" />
          </div>
        </div>
      </div>
    </div>
    <?php if($patient->patient_stat==null): ?>
      <div class="row">
        <div class="col-12">
          <button style="width: 100%" type="button" class="btn btn-success btn-round float-center forAdmin forPAT" id="btnAdmitPatient" data-toggle="modal" data-target="#modalAdmitPatient" hidden="true">
              Admit Patient
            </button>
        </div>
      </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12">
          <button style="width: 100%" type="button" class="btn btn-success btn-round float-center forAdmin forPAT" data-toggle="modal" data-target="#modalAddAppointment" hidden="true">
              Add Appointment
            </button>
        </div>
    </div>
  </div>

  <div class="col-md-9">
    <div class="row" style="width: 100%">
      <div class="card col-12">
        <div class="card-header ">
          <h5 class="card-title"><?php echo e($patient->last_name); ?>, <?php echo e($patient->first_name); ?> <?php echo e($patient->middle_name); ?> 
            <button type="button" class="btn btn-outline-primary btn-round btn-sm float-right forAdmin forPat" id="btnEditFields" hidden="true">
              <i class="fa fa-pencil"></i> Edit
            </button>
            <div id="divEditFields" hidden="true">
              <button type="submit" class="btn btn-outline-success btn-round btn-sm float-right" id="btnSaveFields">
                <i class="fa fa-save"></i> Save
              </button>
              <button type="button" class="btn btn-outline-danger btn-round btn-sm float-right" id="btnCancelEdit">
                <i class="fa fa-times"></i> Cancel
              </button>
            </div>
          </h5>
        </div>
        <div class="card-body ">
         <form>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Last Name:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="last_name" value="<?php echo e($patient->last_name); ?>">
            </div>
            <label class="col-sm-2 col-form-label">First Name:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="first_name" value="<?php echo e($patient->first_name); ?>">
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Middle Name:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="middle_name" value="<?php echo e($patient->middle_name); ?>">
            </div>
            <label class="col-sm-2 col-form-label">Gender:</label>
            <div class="col-sm-4">
                <select readonly="true" disabled="true" class="form-control-plaintext fieldToEdit" name="gender">
                  <option <?php if($patient->gender=='Male'): ?> selected <?php endif; ?> value="Male">Male</option>
                  <option <?php if($patient->gender=='Female'): ?> selected <?php endif; ?> value="Female">Female</option>
                </select>
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Birthdate:</label>
            <div class="col-sm-4">
              <input type="date" readonly="true" class="form-control-plaintext fieldToEdit" name="birthdate" value="<?php echo e($patient->birthdate); ?>">
            </div>
            <label class="col-sm-2 col-form-label">Age:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext" value="<?php echo e(Carbon\Carbon::now()->diffInYears($patient->birthdate)); ?> yrs old">
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Civil Status:</label>
            <div class="col-sm-4">
              <select readonly="true" disabled="true" class="form-control-plaintext fieldToEdit" name="civil_stat">
                  <option <?php if($patient->civil_stat=='Single'): ?> selected <?php endif; ?> value="Single">Single</option>
                  <option <?php if($patient->civil_stat=='Married'): ?> selected <?php endif; ?> value="Married">Married</option>
                  <option <?php if($patient->civil_stat=='Separated'): ?> selected <?php endif; ?> value="Separated">Separated</option>
                  <option <?php if($patient->civil_stat=='Widowed'): ?> selected <?php endif; ?> value="Widowed">Widowed</option>
                </select>
            </div>
            <label class="col-sm-2 col-form-label">Contact No:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="contact_no" value="<?php echo e($patient->contact_no); ?>">
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Address:</label>
            <div class="col-sm-10">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="address" value="<?php echo e($patient->brgy->brgyDesc); ?>, <?php echo e($patient->brgy->cityMun->citymunDesc); ?>, <?php echo e($patient->brgy->cityMun->province->provDesc); ?>">
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">PhilHealth No:</label>
            <div class="col-sm-4">
              <input type="text" readonly="true" class="form-control-plaintext fieldToEdit" name="philhealth_no" value="<?php echo e($patient->philhealth_no); ?>">
            </div>
            <label class="col-sm-2 col-form-label">Blood Type:</label>
            <div class="col-sm-4">
              <select readonly="true" disabled="true" class="form-control-plaintext fieldToEdit" name="blood_type">
                  <option <?php if($patient->blood_type=='A'): ?> selected <?php endif; ?> value="A">A</option>
                  <option <?php if($patient->blood_type=='B'): ?> selected <?php endif; ?> value="B">B</option>
                  <option <?php if($patient->blood_type=='AB'): ?> selected <?php endif; ?> value="AB">AB</option>
                  <option <?php if($patient->blood_type=='O'): ?> selected <?php endif; ?> value="O">O</option>
                </select>
            </div>
           </div>
           <div class="form-group row">
            <label class="col-sm-2 col-form-label">Patient Type:</label>
            <div class="col-sm-4">
              <select readonly="true" disabled="true" class="form-control-plaintext fieldToEdit" name="patient_type">
                <option <?php if($patient->patient_type==1): ?> selected <?php endif; ?> value="1">Regular Patient</option>
                <option <?php if($patient->patient_type==2): ?> selected <?php endif; ?> value="2">Mental Patient</option>
              </select>
            </div>
           </div>
         </form> 
        </div>
      </div>
    </div>

  <div class="row" style="width: 100%">
    <div class="card col-12">
        <div class="card-body">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#consults" role="tab" aria-selected="true">Consultations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#appointments" role="tab" aria-selected="false">Appointments</a>
              </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <br>
            <div class="tab-pane active" id="consults" role="tabpanel">
              <table id="tblConsults" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Complaint</th>
                    <th>Ward/Room/Clinic</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $consults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consult): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr
                    <?php if($consult->discharge_date != NULL): ?>
                      class="bg-danger"
                    <?php endif; ?>>
                      <td><?php echo e(Carbon\Carbon::parse($consult->created_at)->toDateString()); ?></td>
                      <td><?php echo e($consult->complaint); ?></td>
                      <td><?php echo e($consult->room); ?></td>
                      <td>
                        <?php if($consult->discharge_date == NULL): ?>
                          Active
                        <?php else: ?>
                          Inactive
                        <?php endif; ?>
                      </td>
                      <td>
                        <a href="<?php echo e(url('patients/consult/'.$consult->id)); ?>" class="btn btn-sm btn-primary btn-fab btn-icon btn-round">
                          <i class="fa fa-arrow-right"></i>
                        </a>
                        <a href="<?php echo e(url('patient/chart/'.$consult->id)); ?>" class="btn btn-sm btn-warning btn-fab btn-icon btn-round forAdmin forMED forNRS forPAT" hidden="true">
                          <i class="fa fa-file"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>
            </div>
            <div class="tab-pane" id="appointments" role="tabpanel">
              <table id="tblAppointments" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Remarks</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td><?php echo e(Carbon\Carbon::parse($appointment->consult_date)->toDateString()); ?> @ <?php echo e(Carbon\Carbon::parse($appointment->consult_date)->toTimeString()); ?></td>
                      <td><?php echo e($appointment->last_name); ?>, <?php echo e($appointment->first_name); ?> <?php echo e($appointment->last_name[0]); ?></td>
                      <td><?php echo e($appointment->remarks); ?></td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>
            </div>
          </div>
    
          
        </div>  
    </div>
  </div>
</div>
</form>

<!-- MODALS -->
<form action="<?php echo e(url('patients/admit')); ?>" method="POST">
  <?php echo csrf_field(); ?>
  <input type="text" name="hosp_no" value="<?php echo e($patient->hosp_no); ?>" hidden>
<div class="modal" tabindex="-1" role="dialog" id="modalAdmitPatient">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Admit Patient <?php echo e($patient->hosp_no); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row mb-3">
            <div class="col-12">
              <label>Complaint</label>
              <textarea name="complaint" class="form-control"></textarea>
            </div>
          </div>
          
        </div>   
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>

<form action="<?php echo e(url('consult/add-appointment')); ?>" method="POST">
  <?php echo csrf_field(); ?>
  <input type="text" name="hosp_no" value="<?php echo e($patient->hosp_no); ?>" hidden>
<div class="modal" tabindex="-1" role="dialog" id="modalAddAppointment">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Schedule Patient <?php echo e($patient->hosp_no); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row mb-3">
            <div class="col-12">
              <label>Doctor</label>
              <select class="form-control" name="emp_no">
                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($employee->emp_no); ?>"><?php echo e($employee->last_name); ?>, <?php echo e($employee->first_name); ?> <?php echo e($employee->middle_name[0]); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
          </div>
          <div class="row mb-3">
              <div class="col-12">
                <label>Date</label>
                <input type="date" name="consult_date" class="form-control" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label>Time</label>
                <input type="time" name="consult_time" class="form-control" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12">
                <label>Remarks</label>
                <textarea class="form-control" name="appointment_remarks"></textarea>
              </div>
            </div>
        </div>   
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>

<!-- END MODALS -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
  
  $('#btnEditFields').on('click', function() {
    $('.fieldToEdit').prop('readonly',false);
    $('.fieldToEdit').prop('disabled',false);
    $('.fieldToEdit').prop('class','form-control fieldToEdit');
    $('#divEditProfileImg').prop('hidden',false);
    $('#divEditFields').prop('hidden',false);
    $('#btnEditFields').hide();
  });

  $('#btnCancelEdit').on('click', function() {
    $('.fieldToEdit').prop('readonly',true);
    $('.fieldToEdit').prop('disabled',true);
    $('.fieldToEdit').prop('class','form-control-plaintext fieldToEdit');
    $('#divEditProfileImg').prop('hidden',true);
    $('#divEditFields').prop('hidden',true);
    $('#btnEditFields').show();
  });

</script>

<script type="text/javascript">
  $('#tblConsults').DataTable({
    "order": [[ 0, "desc" ]]
  });
  $('#tblAppointments').DataTable({
    "order": [[ 0, "desc" ]]
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hims\resources\views/patient/patient-profile.blade.php ENDPATH**/ ?>