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
                    <h5 class="mb-0">Review Create</h5>
                </div>
                <div class="col-xxl">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.testimonial.add.post')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('post'); ?>
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Client Name</label>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="name"
                                                   placeholder="Enter slider title" value="<?php echo e(old('name')); ?>"/>
                                        </div>
                                        <?php if($errors->has('name')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('name')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Client Designation</label>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="designation"
                                                   placeholder="Enter Designation" value="<?php echo e(old('designation')); ?>"/>
                                        </div>
                                        <?php if($errors->has('designation')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('designation')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Review</label>
                                        <div class="col-sm-9 ">
                                            <textarea class="form-control" name="review"
                                                      placeholder="Enter Review"><?php echo e(old('review')); ?></textarea>
                                        </div>
                                        <?php if($errors->has('review')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('review')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="" class="col-sm-3 col-form-label">Client Image</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" name="image"/>
                                        </div>
                                        <?php if($errors->has('file')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('file')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Social Link</label>
                                        <div class="col-sm-9 ">
                                            <input class="form-control" name="s_link" type="text"
                                                   placeholder="Enter social link"><?php echo e(old('s_link')); ?></input>
                                        </div>
                                        <?php if($errors->has('s_link')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('s_link')); ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="multicol-country">Status</label>
                                        <div class="col-sm-9">
                                            <select id="multicol-country" name="status" class="select form-select"
                                                    data-allow-clear="true">
                                                <option value="">Select</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">InActive</option>
                                            </select>
                                        </div>
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

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Property/dproperty/resources/views/admin/testimonial/add.blade.php ENDPATH**/ ?>