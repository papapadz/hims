<?php $__env->startComponent('mail::message'); ?>

<i>Congratulations! We have verified your registration, you can now create an account to access our system. Click the button below to create your account.</i>

<?php $__env->startComponent('mail::panel'); ?>

<?php $__env->startComponent('mail::promotion'); ?>

<div style="font-size: 2rem; text-align:center">
    <b style="color: green;">VERIFIED</b>
</div>
<?php echo $__env->renderComponent(); ?>
<ul class="list-group list-group-flush">
    <li>Patient Name: <b><?php echo e($data['name']); ?></b></li>
    <li>Date registered: <b><?php echo e($data['registration_date']); ?></b></li>
</ul>

<?php $__env->startComponent('mail::button', ['url' => $data['link'], 'color' => 'success']); ?>
    Create Acoount Now
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->renderComponent(); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\xampp\htdocs\hims\resources\views/email/verify-patient.blade.php ENDPATH**/ ?>