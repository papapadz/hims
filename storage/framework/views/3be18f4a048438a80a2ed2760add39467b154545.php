<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header ">
        <h5 class="card-title">Rooms
          <div class="dropdown float-right mr-3">
            <button class="btn btn-outline-success btn-round btn-sm float-right" data-toggle="modal" data-target="#modalAddRoom">
            <i class="fa fa-plus"></i> Add
          </button>
          </div> 
        </h5>
      </div>
      <div class="card-body ">
       <table id="tblRooms" class="table" style="width:100%">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Room</th>
                    <th>Room Type</th>
                    <th>Fee</th>
                    <th>Max Occupancy</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($room->id); ?></td>
                    <td><?php echo e($room->room); ?></td>
                    <td><?php echo e($room->room_type); ?></td>
                    <td>P <?php echo e(number_format($room->fee,2)); ?></td>
                    <td><?php echo e($room->max_occupancy); ?> pax</td>
                    <td><?php echo e($room->created_at); ?></td>
                    <td>
                      <button 
                        class="btn btn-sm btn-primary btn-fab btn-icon btn-round btn-modalOpen" 
                        data-toggle="modal" 
                        data-id="<?php echo e($room->id); ?>" 
                        data-room="<?php echo e($room->room); ?>"
                        data-roomtype="<?php echo e($room->room_type_id); ?>"
                        data-fee="<?php echo e($room->fee); ?>"
                        data-max="<?php echo e($room->max_occupancy); ?>"
                        data-target="#modalEditRoom">
                          <i class="fa fa-edit"></i>
                      </button>
                      <a 
                        href="<?php echo e(url('settings/rooms/delete/'.$room->id)); ?>" 
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

<form action="<?php echo e(url('settings/rooms/add')); ?>" method="POST" enctype="multipart/form-data">
  <?php echo csrf_field(); ?>
<div id="modalAddRoom" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Room Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room</label>
                <input type="text" name="room" class="form-control" placeholder="Room" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room Type</label>
                <select class="form-control" name="room_type_id" required>
                  <option value="1">Service Ward</option>
                  <option value="2">Pay Ward</option>
                  <option value="3">OPD</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room Fee</label>
                <input type="number" name="fee" class="form-control" placeholder="Room Fee" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Max Occupancy</label>
                <input type="number" name="max_occupancy" class="form-control" placeholder="Max Occupancy" required />
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

<form action="<?php echo e(url('settings/rooms/edit')); ?>" method="POST" enctype="multipart/form-data">
  <?php echo csrf_field(); ?>
<input type="text" name="room_id" id="room_id" hidden>
<div id="modalEditRoom" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Room Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room</label>
                <input type="text" name="room" id="room" class="form-control" placeholder="Room" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room Type</label>
                <select class="form-control" name="room_type_id" id="room_type_id" required>
                  <option value="1">Service Ward</option>
                  <option value="2">Pay Ward</option>
                  <option value="3">OPD</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Room Fee</label>
                <input type="number" name="fee" id="fee" class="form-control" placeholder="Room Fee" required />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label>Max Occupancy</label>
                <input type="number" name="max_occupancy" id="max_occupancy" class="form-control" placeholder="Max Occupancy" required />
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
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hims\resources\views/admin/rooms.blade.php ENDPATH**/ ?>