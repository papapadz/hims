

<?php $__env->startSection('content'); ?>
<div class="row">
  
  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forHRS" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Positions</p>
              <p class="card-title"><?php echo e(count($positions)); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of <?php echo e(Carbon\Carbon::now()->toFormattedDateString()); ?>

          <a href="<?php echo e(url('settings/positions')); ?>" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
 
  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPAT" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Rooms</p>
              <p class="card-title"><?php echo e(count($rooms)); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of <?php echo e(Carbon\Carbon::now()->toFormattedDateString()); ?>

          <a href="<?php echo e(url('settings/rooms')); ?>" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">User Accounts</p>
              <p class="card-title"><?php echo e(count($users)); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of <?php echo e(Carbon\Carbon::now()->toFormattedDateString()); ?>

          <a href="<?php echo e(url('user-accounts')); ?>" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPatient forBLL" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">
                <?php if(Auth::User()->account_type == 3): ?>
                  Total Bill
                <?php else: ?>
                  Receivables
                <?php endif; ?>
              </p>
              <p class="card-title">P <?php echo e(number_format($bills->sumSubTotal,2)); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of <?php echo e(Carbon\Carbon::now()->toFormattedDateString()); ?>

          <?php if(Auth::User()->account_type == 3): ?>
          <a href="<?php echo e(url('patients/profile/'.Auth::User()->user_id)); ?>" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
          <?php else: ?>
          <a href="<?php echo e(url('billings')); ?>" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forHRS" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Employees</p>
              <p class="card-title"><?php echo e(count($employees)); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of <?php echo e(Carbon\Carbon::now()->toFormattedDateString()); ?>

          <a href="<?php echo e(url('employees')); ?>" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPAT forMED forNRS forPHR forLAB forXRY forBLL" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">In Patients</p>
              <p class="card-title"><?php echo e(count($patients->WHERE('patient_stat','ADM'))); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of <?php echo e(Carbon\Carbon::now()->toFormattedDateString()); ?>

          <a href="<?php echo e(url('patients')); ?>" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPHR forPAT forMED forNRS forBLL" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Out Patients</p>
              <p class="card-title"><?php echo e(count($patients->WHERE('patient_stat','OPD'))); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of <?php echo e(Carbon\Carbon::now()->toFormattedDateString()); ?>

          <a href="<?php echo e(url('patients')); ?>" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6 forAdmin forPatient forPAT forMED forNRS" hidden="true">
    <div class="card card-stats">
      <div class="card-body ">
        <div class="row">
          <div class="col-5 col-md-4">
            <div class="icon-big text-center icon-warning">
              <i class="nc-icon nc-globe text-warning"></i>
            </div>
          </div>
          <div class="col-7 col-md-8">
            <div class="numbers">
              <p class="card-category">Appointments</p>
              <p class="card-title"><?php echo e(count($appointments)); ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer ">
        <hr>
        <div class="stats">
          <i class="fa fa-calendar-o"></i> as of <?php echo e(Carbon\Carbon::now()->toFormattedDateString()); ?>

          <a href="<?php echo e(url('appointment')); ?>" class="btn btn-sm btn-muted btn-fab btn-icon btn-round float-right">
            <i class="fa fa-gear text-white"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  

  
</div>    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\hims-server\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>