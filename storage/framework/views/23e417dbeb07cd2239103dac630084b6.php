<?php $__env->startSection('content'); ?>
    <?php if(session()->get('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo e(session()->get('success')); ?></div>
    <?php endif; ?>
    <?php if(session()->get('errors')): ?>
        <div class="alert alert-danger" role="alert"><?php echo e(session()->get('errors')->first()); ?></div>
    <?php endif; ?>
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between row pb-2 gap-3 gap-md-0 w-100">
                <div class="col-md-6">
                    <h5>Service List</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="<?php echo e(route('admin.service.add')); ?>" class="btn btn-label-primary">Add Service</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-sliders table" id="sliderList">
                    <thead class="border-top">
                    <tr>
                        <th>Title</th>
                        <th class="text-center">Short Description</th>
                        <th class="text-center">Image</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(count($services)): ?>
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($service->title); ?></td>
                                <td><?php echo e($service->description); ?></td>
                                <td>
                                    <?php if($service->image): ?>
                                        <img src="<?php echo e($service->image); ?>" alt="service image"
                                             style="width: 100px; height: 60px;">
                                    <?php else: ?>
                                        <span class="text-muted">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php switch($service->status):
                                        case (1): ?>
                                            <span class="badge bg-label-success">Active</span>
                                            <?php break; ?>
                                        <?php case (0): ?>
                                            <span class="badge bg-label-danger">Inactive</span>
                                            <?php break; ?>
                                        <?php default: ?>
                                            <span class="badge bg-label-secondary">Unknown</span>
                                    <?php endswitch; ?>
                                </td>
                                <td><?php echo e($service->user->name); ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="<?php echo e(route('admin.service.edit',$service)); ?>"
                                           class="btn btn-sm btn-icon btn-primary me-2" title="Edit Service">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.service.delete',$service)); ?>" class="btn btn-sm btn-icon btn-primary me-2" title="Edit Service">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <?php echo e($services->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Property/dproperty/resources/views/admin/service/list.blade.php ENDPATH**/ ?>