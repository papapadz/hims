<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Facilities
          <div class="dropdown float-right mr-3">
            <button class="btn btn-outline-success btn-round btn-sm float-right" data-toggle="modal" data-target="#modalAddFacility">
            <i class="fa fa-plus"></i> Add
          </button>
          </div>
        </h5>
      </div>
      <div class="card-body ">
       <table class="table" style="width:100%">
              <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Address</th>
                    <th>Type</th>
                    <th>Classification</th>
                    <th>Bed Capacity</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($facility->facility_name); ?></td>
                    <td><?php echo e($facility->facility_code); ?></td>
                    <td><?php echo e($facility->brgy); ?></td>
                    <td><?php echo e($facility->facility_type); ?></td>
                    <td><?php echo e($facility->facility_classification); ?></td>
                    <td><?php echo e($facility->bed_capacity); ?></td>
                    <td><?php echo e($facility->contact_num); ?></td>
                    <td><?php echo e($facility->email_address); ?></td>
                    <td>
                      <button
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round btn-modalOpen"
                        data-toggle="modal"
                        data-id="<?php echo e($facility->id); ?>"
                        data-name="<?php echo e($facility->name); ?>"
                        data-code="<?php echo e($facility->facility_code); ?>"
                        data-type="<?php echo e($facility->facility_type); ?>"
                        data-classification="<?php echo e($facility->facility_classification); ?>"
                        data-capacity="<?php echo e($facility->bed_capacity); ?>"
                        data-email="<?php echo e($facility->email_address); ?>"
                        data-contact="<?php echo e($facility->contact_num); ?>"
                        data-target="#modalEdit">
                          <i class="fa fa-edit"></i>
                      </button>
                      <a
                        href="<?php echo e(url('facility/delete/'.$facility->id)); ?>"
                        class="btn btn-sm btn-danger btn-fab btn-icon btn-round"
                        onclick="return confirm('Are you sure you want to delete this record?');">
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

<form action="<?php echo e(route('admin.facility.add')); ?>" method="POST" enctype="multipart/form-data">
  <?php echo csrf_field(); ?>
<div id="modalAddFacility" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Facility Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="row mb-3">
                <div class="col-md-12">
                    <label>Facility Name <small class="text-danger">*</small></label>
                    <input type="text" name="facility_name" class="form-control" placeholder="Facility Name" required />
                </div>
                </div>
                <div class="row mb-3">
                <div class="col-md-12">
                    <label>Facility Code</label>
                    <input type="text" name="facility_code" class="form-control" placeholder="Facility Code" />
                </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">

                        <label>Province <small class="text-danger">*</small></label>
                    <select name="province" id="province" class="form-control" required>
                        <option selected disabled>Select Province</option>
                        <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($province->provCode); ?>"><?php echo e($province->provDesc); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    </div>
                    <div class="col-md-6">
                        <label>City <small class="text-danger">*</small></label>
                    <select name="citymun" id="citymun" class="form-control" required>
                        <option selected disabled>Select City/Municipality</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                    <label>Barangay <small class="text-danger">*</small></label>
                    <select name="address_id" id="brgy" class="form-control" required>
                        <option selected disabled>Select Barangay</option>
                    </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                      <label>Contact Number <small class="text-danger">*</small></label>
                      <input type="text" name="contact_num" class="form-control" placeholder="+63" required/>
                    </div>
                    <div class="col-md-6">
                        <label>Email Address <small class="text-danger">*</small></label>
                        <input type="email" name="email_address" class="form-control" placeholder="email@email.com" required/>
                      </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                      <label>Website URL</label>
                      <input type="text" name="website" class="form-control" placeholder="https://" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                      <label>Facility Type <small class="text-danger">*</small></label>
                      <select name="facility_type" class="form-control" required>
                        <option value="private">Private</option>
                        <option value="government">Government</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                        <label>Facility Classification <small class="text-danger">*</small></label>
                        <select name="facility_classification" class="form-control" required>
                          <option value="primary">Primary</option>
                          <option value="secondary">Secondary</option>
                          <option value="tertiary">Tertiary</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Bed Capacity <small class="text-danger">*</small></label>
                        <input type="number" min="1" step="1" name="bed_capacity" class="form-control" placeholder="1" required />
                      </div>
                    <div class="col-md-6">
                      <label>License Status <small class="text-danger">*</small></label>
                      <select name="licensing_status" class="form-control" required>
                        <option value="operational">Operational</option>
                        <option value="ongoing">On-Going</option>
                        <option value="expired">Expired</option>
                      </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
  $('#tblPositions').DataTable();

  $(document).on("click", ".btn-modalOpen", function () {

    $("#room_id").val( $(this).data('id') );
    $("#room").val( $(this).data('room') );
    $("#room_type_id select").val( $(this).data('roomType') );
    $("#max_occupancy").val( $(this).data('max') );
    $("#fee").val( $(this).data('fee') );
  });

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
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\hims-server\resources\views/admin/facilities.blade.php ENDPATH**/ ?>