<?php $__env->startSection('content'); ?>
    <?php if(session()->get('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo e(session()->get('success')); ?></div>
    <?php endif; ?>
    <?php if(session()->get('errors')): ?>
        <div class="alert alert-danger" role="alert"><?php echo e(session()->get('errors')->first()); ?></div>
    <?php endif; ?>
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between  row pb-2 gap-3 gap-md-0 w-100">
                <div class="col-md-6">
                    <h5>Filter Item</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="<?php echo e(route('admin.user.add')); ?>" class="btn btn-label-primary">Add User</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="slotList">
                    <thead class="border-top">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created at</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(count($users)): ?>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo e(\Illuminate\Support\Carbon::parse($user->created_at)->diffForHumans()); ?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="<?php echo e(route('admin.user.edit',$user)); ?>"
                                           class="btn btn-sm btn-icon btn-primary me-2" title="Edit User">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.user.delete',$user)); ?>"
                                           class="btn btn-sm btn-icon btn-primary me-2">
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
                <?php echo e($users->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Property/dproperty/resources/views/admin/user/list.blade.php ENDPATH**/ ?>