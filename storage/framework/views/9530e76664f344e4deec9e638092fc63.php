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
                        <form action="<?php echo e(route('admin.property.edit.post',$property)); ?>" method="POST"
                              enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('post'); ?>
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="multicol-country">Property
                                            Link</label>
                                        <div class="col-sm-9">
                                            <select id="multicol-country" name="type" class="select form-select"
                                                    data-allow-clear="true">
                                                <option value="">Select</option>
                                                <option value="fb" <?php echo e($property->type =='fb' ? 'selected':''); ?>>Facebook
                                                </option>
                                                <option value="yu" <?php echo e($property->type =='yu' ? 'selected':''); ?>>Youtube
                                                </option>
                                            </select>
                                            <?php if($errors->has('type')): ?>
                                                <div class="error col-sm-10"><?php echo e($errors->first('type')); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Property Link</label>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="link"
                                                   placeholder="Enter property link" value="<?php echo e($property->link); ?>"/>
                                        </div>
                                        <?php if($errors->has('link')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('link')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Description</label>
                                        <div class="col-sm-9 ">
                                            <textarea class="form-control" name="description"
                                                      placeholder="Enter Review"><?php echo e($property->description); ?></textarea>
                                        </div>
                                        <?php if($errors->has('description')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('description')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="multicol-country">Status</label>
                                        <div class="col-sm-9">
                                            <select id="multicol-country" name="status" class="select form-select"
                                                    data-allow-clear="true">
                                                <option value="">Select</option>
                                                <option value="active" <?php echo e($property->status ==1 ?'selected':''); ?>>
                                                    Active
                                                </option>
                                                <option value="inactive" <?php echo e($property->status ==0 ?'selected':''); ?>>
                                                    InActive
                                                </option>
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

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Property/dproperty/resources/views/admin/property/edit.blade.php ENDPATH**/ ?>