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
                        <form action="<?php echo e(route('admin.slider.edit.post',$slider)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('post'); ?>
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Slider Title</label>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="title" placeholder="Enter slider title" value="<?php echo e($slider->title); ?>" />
                                        </div>
                                        <?php if($errors->has('title')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('title')); ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="col-sm-3 col-form-label">Slider Image  <span class="text-gray">(3360×2240 px)</span></label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" name="image" />
                                            <div class="">
                                                <img src="<?php echo e($slider->image); ?>" alt="" class="mt-2" style="width: 100px; height: 60px;">
                                            </div>
                                        </div>
                                        <?php if($errors->has('file')): ?>
                                            <div class="error col-sm-10"><?php echo e($errors->first('file')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="multicol-country">Status</label>
                                        <div class="col-sm-9">
                                            <select id="multicol-country" name="status" class="select form-select"
                                                    data-allow-clear="true">
                                                <option value="">Select</option>
                                                <option value="active" <?php echo e($slider->status ==1 ?'selected':''); ?>>Active</option>
                                                <option value="inactive" <?php echo e($slider->status ==0 ?'selected':''); ?>>InActive</option>
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

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Property/dproperty/resources/views/admin/slider/edit.blade.php ENDPATH**/ ?>