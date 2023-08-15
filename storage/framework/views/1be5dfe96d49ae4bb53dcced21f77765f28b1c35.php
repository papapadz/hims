<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Patients 
          <button class="btn btn-outline-success btn-round btn-sm float-right forAdmin forPAT" data-toggle="modal" data-target="#modalAddPatient" hidden="true">
            <i class="fa fa-plus"></i> Add
          </button>
        </h5>
      </div>
      <div class="card-body ">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#patients" role="tab" aria-selected="true">All Patients</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#in-patients" role="tab" aria-selected="false">In Patients</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#out-patients" role="tab" aria-selected="false">Out Patients</a>
          </li>
          
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
        <br>
          <div class="tab-pane active" id="patients" role="tabpanel">
            <table id="tblPatients" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>Hospital No.</th>
                    <th>Name</th>
                    <th>Birthdate</th>
                    <th>Gender</th>
                    <th>Address</th>
                    
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                      <?php if($patient->patient_stat!=null): ?>
                        <?php if($patient->consult_type=='ADM'): ?>
                          <i class="fa fa-circle text-primary"></i>
                        <?php else: ?>
                          <i class="fa fa-circle text-success"></i>
                        <?php endif; ?>
                      <?php else: ?>
                       <i class="fa fa-circle text-gray"></i>
                      <?php endif; ?>
                      <?php echo e($patient->hosp_no); ?>

                    </td>
                    <td><?php echo e($patient->last_name); ?>, <?php echo e($patient->first_name); ?> <?php echo e($patient->middle_name[0] ?? ''); ?></td>
                    <td><?php echo e($patient->birthdate); ?></td>
                    <td><?php echo e($patient->gender); ?></td>
                    <td><?php echo e($patient->brgy->brgyDesc); ?>, <?php echo e($patient->brgy->cityMun->citymunDesc); ?>, <?php echo e($patient->brgy->cityMun->province->provDesc); ?></td>
                    
                    <td>
                      <?php if(Auth::user()->account_type==1): ?>
                        <?php if($patient->email_verified_at!=NULL): ?>
                          <a href="<?php echo e(url('patients/profile/'.$patient->hosp_no)); ?>" class="btn btn-sm btn-primary btn-fab btn-icon btn-round">
                            <i class="fa fa-arrow-right"></i>
                          </a>
                        <?php else: ?>
                        <a 
                          href="<?php echo e(url('patient/verify-email/'.$patient->hosp_no)); ?>" 
                          class="btn btn-sm btn-warning btn-fab btn-icon btn-round forAdmin" 
                          hidden="true"
                          onclick="return confirm('Are you sure you want to verify this patient?');">
                          <i class="fa fa-check"></i>
                        </a>
                        <?php endif; ?>
                        <a 
                          href="<?php echo e(url('patient/delete/'.$patient->hosp_no)); ?>" 
                          class="btn btn-sm btn-danger btn-fab btn-icon btn-round forAdmin" 
                          hidden="true"
                          onclick="return confirm('Are you sure you want to delete this patient record?');">
                          <i class="fa fa-trash"></i>
                        </a>
                      <?php else: ?>
                        <a href="<?php echo e(url('patients/profile/'.$patient->hosp_no)); ?>" class="btn btn-sm btn-primary btn-fab btn-icon btn-round">
                          <i class="fa fa-arrow-right"></i>
                        </a>
                      <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="in-patients" role="tabpanel">
            <table id="tblInPatients" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>Hospital No.</th>
                    <th>Name</th>
                    <th>Birthdate</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Patient Type</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $patients->WHERE('patient_stat','ADM'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                      <?php if($patient->patient_stat!=null): ?>
                        <?php if($patient->consult_type=='ADM'): ?>
                          <i class="fa fa-circle text-primary"></i>
                        <?php else: ?>
                          <i class="fa fa-circle text-success"></i>
                        <?php endif; ?>
                      <?php else: ?>
                       <i class="fa fa-circle text-gray"></i>
                      <?php endif; ?>
                      <?php echo e($patient->hosp_no); ?>

                    </td>
                    <td><?php echo e($patient->last_name); ?>, <?php echo e($patient->first_name); ?> <?php echo e($patient->middle_name[0] ?? ''); ?></td>
                    <td><?php echo e($patient->birthdate); ?></td>
                    <td><?php echo e($patient->gender); ?></td>
                    <td><?php echo e($patient->address->brgyDesc); ?>, <?php echo e($patient->address->cityMun->citymunDesc); ?>, <?php echo e($patient->address->cityMun->province->provDesc); ?></td>
                    <td>
                      <?php if($patient->patient_type==1): ?>
                        Regular Patient
                      <?php else: ?>
                        Mental Patient
                      <?php endif; ?>
                    </td>
                    <td>

                      <a href="<?php echo e(url('patients/profile/'.$patient->hosp_no)); ?>" class="btn btn-sm btn-primary btn-fab btn-icon btn-round">
                        <i class="fa fa-arrow-right"></i>
                      </a>
                      <a 
                        href="<?php echo e(url('patient/delete/'.$patient->hosp_no)); ?>" 
                        class="btn btn-sm btn-danger btn-fab btn-icon btn-round forAdmin" 
                        hidden="true"
                        onclick="return confirm('Are you sure you want to delete this patient record?');">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>
          <div class="tab-pane" id="out-patients" role="tabpanel">
            <table id="tblOutPatients" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>Hospital No.</th>
                    <th>Name</th>
                    <th>Birthdate</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Patient Type</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $patients->WHERE('patient_stat','OPD'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                      <?php if($patient->patient_stat!=null): ?>
                        <?php if($patient->consult_type=='ADM'): ?>
                          <i class="fa fa-circle text-primary"></i>
                        <?php else: ?>
                          <i class="fa fa-circle text-success"></i>
                        <?php endif; ?>
                      <?php else: ?>
                       <i class="fa fa-circle text-gray"></i>
                      <?php endif; ?>
                      <?php echo e($patient->hosp_no); ?>

                    </td>
                    <td><?php echo e($patient->last_name); ?>, <?php echo e($patient->first_name); ?> <?php echo e($patient->middle_name[0] ?? ''); ?></td>
                    <td><?php echo e($patient->birthdate); ?></td>
                    <td><?php echo e($patient->gender); ?></td>
                    <td><?php echo e($patient->address->brgyDesc); ?>, <?php echo e($patient->address->cityMun->citymunDesc); ?>, <?php echo e($patient->address->cityMun->province->provDesc); ?></td>
                    <td>
                      <?php if($patient->patient_type==1): ?>
                        Regular Patient
                      <?php else: ?>
                        Mental Patient
                      <?php endif; ?>
                    </td>
                    <td>

                      <a href="<?php echo e(url('patients/profile/'.$patient->hosp_no)); ?>" class="btn btn-sm btn-primary btn-fab btn-icon btn-round">
                        <i class="fa fa-arrow-right"></i>
                      </a>
                      <a 
                        href="<?php echo e(url('patient/delete/'.$patient->hosp_no)); ?>" 
                        class="btn btn-sm btn-danger btn-fab btn-icon btn-round forAdmin" 
                        hidden="true"
                        onclick="return confirm('Are you sure you want to delete this patient record?');">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>
          
        </div>
      </div>
      <div class="card-footer ">
        <div class="legend">
          <i class="fa fa-circle text-primary"></i> In Patient
          <i class="fa fa-circle text-success"></i> Out Patient
          <i class="fa fa-circle text-gray"></i> Offline
        </div>
      </div>
  </div>
</div>

<form action="<?php echo e(url('patients/add')); ?>" method="POST" enctype="multipart/form-data">
  <?php echo csrf_field(); ?>
<div id="modalAddPatient" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Patient Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-6">
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" />
              </div>
              <div class="col-md-6">
                <input type="text" name="first_name" class="form-control" placeholder="First Name" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" />
              </div>
              <div class="col-md-6">
                <div class="form-check form-check-radio form-check-inline">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" id="gender_m" value="Male"> Male
                    <span class="form-check-sign"></span>
                  </label>
                </div>
                <div class="form-check form-check-radio form-check-inline">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" id="gender_f" value="Female"> Female
                    <span class="form-check-sign"></span>
                  </label>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <input type="date" name="birthdate" class="form-control" placeholder="Birthdate" />
              </div>
              <div class="col-md-6">
                <select name="civil_stat" class="form-control">
                  <option selected disabled>Civil Status</option>
                  <option value="Single">Single</option>
                  <option value="Married">Married</option>
                  <option value="Separated">Separated</option>
                  <option value="Widowed">Widowed</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <input type="text" name="contact_no" class="form-control" placeholder="Contact No." />
              </div>
              <div class="col-md-6">
                <input type="text" name="email" class="form-control" placeholder="Email Address" required/>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <input type="text" name="philhealth_no" class="form-control" placeholder="PhilHealth No." />
              </div>
            </div>
            
            <div class="row mb-3">
              <div class="col-md-6">
                <select name="province" id="province" class="form-control" required>
                  <option selected disabled>Select Province</option>
                  <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($province->provCode); ?>"><?php echo e($province->provDesc); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div class="col-md-6">
                <select name="citymun" id="citymun" class="form-control" required>
                  <option selected disabled>Select City/Municipality</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <select name="brgy" id="brgy" class="form-control" required>
                  <option selected disabled>Select Barangay</option>
                </select>
              </div>
              <div class="col-md-6">
                <textarea name="address" class="form-control" required placeholder="House #, Street/Sitio/Purok"></textarea>
              </div>
            </div>
            
            <div class="row mb-3">
              <div class="col-md-6">
                <select name="blood_type" class="form-control">
                  <option selected disabled>Blood Type</option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="AB">AB</option>
                  <option value="O">O</option>
                </select>
              </div>
              <div class="col-md-6">
                <div class="custom-file">
                  <input type="file" name="profile_img" class="custom-file-input">
                  <label class="custom-file-label f1" >Choose image file...</label>
                </div>
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">

$(document).ready(function(){
    
  $('#tblPatients').DataTable();
  $('#tblInPatients').DataTable();
  $('#tblOutPatients').DataTable();

    $('#province').on('change', function() {
      $.ajax ({
        url : '<?php echo e(url("get/citymun")); ?>/'+$(this).val()
        ,method : 'GET'
        ,cache : false
      }).done( function(response){
        $('.onChangeCityMun').remove();
        for (var key in response) {
            $('#citymun').append('<option class="onChangeCityMun" value="'+response[key]['citymunCode']+'">'+response[key]['citymunDesc']+'</option>');
        }
      });
    }); 

    $('#citymun').on('change', function() {
      $.ajax ({
        url : '<?php echo e(url("get/brgy")); ?>/'+$(this).val()
        ,method : 'GET'
        ,cache : false
      }).done( function(response){
        $('.onChangeBrgy').remove();
        for (var key in response) {
            $('#brgy').append('<option class="onChangeBrgy" value="'+response[key]['id']+'">'+response[key]['brgyDesc']+'</option>');
        }
      });
    });
  });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hims\resources\views/user/patients.blade.php ENDPATH**/ ?>