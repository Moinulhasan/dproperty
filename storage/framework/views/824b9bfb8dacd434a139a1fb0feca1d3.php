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
                    <h5>Review List</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="<?php echo e(route('admin.testimonial.add')); ?>" class="btn btn-label-primary">Add Review</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-sliders table" id="sliderList">
                    <thead class="border-top">
                    <tr>
                        <th>Client Name</th>
                        <th class="text-center">Designation</th>
                        <th class="text-center">Avatar</th>
                        <th class="text-center">Comment</th>
                        <th class="text-center">Social Link</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(count($testimonials)): ?>
                        <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($testimonial->name); ?></td>
                                <td><?php echo e($testimonial->designation); ?></td>
                                <td>
                                    <div class="avatar avatar-lg me-2">
                                        <img src="<?php echo e($testimonial->image); ?>" alt="avatar" class="rounded-circle">
                                    </div>
                                </td>
                                <td>
                                    <?php echo e(Str::limit($testimonial->review,150,'........ more')); ?>

                                </td>
                                <td class="text-center">
                                    <a href="<?php echo e($testimonial->s_link); ?>" class="btn btn-sm btn-icon btn-primary me-2">
                                        <i class="ti ti-social"></i>
                                    </a>
                                </td>
                                <td>
                                    <?php switch($testimonial->status):
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
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="<?php echo e(route('admin.testimonial.edit',$testimonial)); ?>"
                                           class="btn btn-sm btn-icon btn-primary me-2" title="Edit Service">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.testimonial.delete',$testimonial)); ?>"
                                           class="btn btn-sm btn-icon btn-primary me-2" title="Edit Service">
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
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Property/dproperty/resources/views/admin/testimonial/index.blade.php ENDPATH**/ ?>