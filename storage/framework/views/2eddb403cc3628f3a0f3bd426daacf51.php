<?php $__env->startSection('content'); ?>
    <?php if(session()->get('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo e(session()->get('success')); ?></div>
    <?php endif; ?>
    <?php if(session()->get('errors')): ?>
        <div class="alert alert-danger" role="alert"><?php echo e(session()->get('errors')->first()); ?></div>
    <?php endif; ?>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Create</h5>
                </div>
                <div class="col-xxl">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.user.update',$user)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('post'); ?>
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">User Name</label>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="name"
                                                   placeholder="Enter user name" value="<?php echo e($user->name); ?>"/>
                                        </div>
                                        <?php if($errors->has('name')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('name')); ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email"
                                                   placeholder="Enter email" value="<?php echo e($user->email); ?>"/>
                                        </div>
                                        <?php if($errors->has('email')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('email')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="" class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="password"
                                                   placeholder="Enter Password" value="<?php echo e(old('password')); ?>"/>
                                        </div>
                                        <?php if($errors->has('password')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('password')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="w-100 text-center">
                                        <button type="submit" class="btn btn-primary w-100">Save</button>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Property/dproperty/resources/views/admin/user/edit.blade.php ENDPATH**/ ?>