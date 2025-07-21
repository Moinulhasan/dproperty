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
                    <a href="<?php echo e(route('admin.property.add')); ?>" class="btn btn-label-primary">Add Property</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-sliders table" id="sliderList">
                    <thead class="border-top">
                    <tr>
                        <th>Property Link</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(count($properties)): ?>
                        <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propertie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php if($propertie->type == 'fb'): ?>
                                        <a href="<?php echo e($propertie->link); ?>" target="_blank">Facebook</a>
                                    <?php elseif($propertie->type == 'yu'): ?>
                                        <a href="<?php echo e($propertie->link); ?>" target="_blank">Youtube</a>
                                    <?php else: ?>
                                        <span class="text-muted">Unknown Type</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(Str::limit($propertie->description,120,'......')); ?></td>
                                <td>
                                    <?php switch($propertie->status):
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
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="<?php echo e(route('admin.property.edit',$propertie)); ?>"
                                           class="btn btn-sm btn-primary me-2">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="#"
                                           class="btn btn-sm btn-danger me-2">
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

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Property/dproperty/resources/views/admin/property/index.blade.php ENDPATH**/ ?>