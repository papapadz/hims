<?php if(Auth::User()->account_type==3): ?>
<li class="active"
>
  <a href="<?php echo e(url('patients/profile/'.Auth::User()->user_id)); ?>">
    <i class="fa fa-home"></i>
    <p>Profile</p>
  </a>
</li>
<?php endif; ?>

<li 
  <?php if($currPage=='home'): ?> 
    class="active forAdmin" 
  <?php endif; ?>
  hidden="true" 
>
  <a href="<?php echo e(url('home')); ?>">
    <i class="fa fa-home"></i>
    <p>Dashboard</p>
  </a>
</li>

<li 
  <?php if($currPage=='facility'): ?> 
    class="active forAdmin" 
  <?php endif; ?>
>
  <a href="<?php echo e(url('facilities')); ?>">
    <i class="fa fa-hospital"></i>
    <p>Facilities</p>
  </a>
</li>

<li 
  <?php if($currPage=='user-accounts'): ?> 
    class="active forAdmin" 
  <?php else: ?>
    class="forAdmin"
  <?php endif; ?>
  hidden="true" 
>
  <a href="<?php echo e(url('user-accounts')); ?>">
    <i class="fa fa-user-cog"></i>
    <p>User Accounts</p>
  </a>
</li>

<li 
  <?php if($currPage=='patients'): ?> 
    class="active forAdmin forPAT forMED forNRS forPHR forBLL forLAB forXRY" 
  <?php else: ?>
    class="forAdmin forPAT forMED forNRS forPHR forBLL forLAB forXRY" 
  <?php endif; ?>
  hidden="true" 
>
  <a href="<?php echo e(url('patients')); ?>">
    <i class="fa fa-user"></i>
    <p>Patients</p>
  </a>
</li>

<li 
  <?php if($currPage=='appointments'): ?> 
    class="active forAdmin forPAT forMED forNRS forPHR forBLL forLAB forXRY" 
  <?php else: ?>
    class="forAdmin forPAT forMED forNRS forPHR forBLL forLAB forXRY" 
  <?php endif; ?>
  hidden="true" 
>
  <a href="<?php echo e(url('appointment')); ?>">
    <i class="fa fa-calendar-alt"></i>
    <p>Appointments</p>
  </a>
</li>










<li 
  <?php if($currPage=='billings'): ?> 
    class="active forAdmin forBLL" 
  <?php else: ?>
    class="forAdmin forBLL" 
  <?php endif; ?>
  hidden="true" 
>
  <a href="<?php echo e(url('billings')); ?>">
    <i class="fa fa-receipt"></i>
    <p>Billings</p>
  </a>
</li>

<li 
  <?php if($currPage=='employees'): ?> 
    class="active forAdmin forHRS"
  <?php else: ?>
    class="forAdmin forHRS" 
  <?php endif; ?>
  hidden="true" 
>
  <a href="<?php echo e(url('employees')); ?>">
    <i class="fa fa-user-tie"></i>
    <p>Employees</p>
  </a>
</li>





<?php /**PATH C:\xampp\htdocs\hims\resources\views/layouts/sidenav.blade.php ENDPATH**/ ?>