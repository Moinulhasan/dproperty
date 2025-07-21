<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/libs/bs-stepper/bs-stepper.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/libs/select2/select2.css')); ?>" />
<?php $__env->stopSection(); ?>
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
                    <h5 class="mb-0">Settings</h5>
                </div>
            </div>
            <div class="">
                <div class="col-12 mb-4">
                    <div class="bs-stepper vertical wizard-vertical-icons-example mt-2">
                        <div class="bs-stepper-header">
                            <div class="step" data-target="#account-details-vertical">
                                <button type="button" class="step-trigger">
                          <span class="bs-stepper-circle">
                            <i class="ti ti-file-description"></i>
                          </span>
                                    <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Account Details</span>
                            <span class="bs-stepper-subtitle">Setup Account Details</span>
                          </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#personal-info-vertical">
                                <button type="button" class="step-trigger">
                          <span class="bs-stepper-circle">
                            <i class="ti ti-user"></i>
                          </span>
                                    <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Personal Info</span>
                            <span class="bs-stepper-subtitle">Add personal info</span>
                          </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#social-links-vertical">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="ti ti-brand-instagram"></i> </span>
                                    <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Social Links</span>
                            <span class="bs-stepper-subtitle">Add social links</span>
                          </span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <form onSubmit="return false">
                                <!-- Account Details -->
                                <div id="account-details-vertical" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-0">Account Details</h6>
                                        <small>Enter Your Account Details.</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="username1">Username</label>
                                            <input type="text" id="username1" class="form-control" placeholder="john.doe" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="email1">Email</label>
                                            <input
                                                type="text"
                                                id="email1"
                                                class="form-control"
                                                placeholder="john.doe"
                                                aria-label="john.doe" />
                                        </div>
                                        <div class="col-sm-6 form-password-toggle">
                                            <label class="form-label" for="password60">Password</label>
                                            <div class="input-group input-group-merge">
                                                <input
                                                    type="password"
                                                    id="password60"
                                                    class="form-control"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password6" />
                                                <span class="input-group-text cursor-pointer" id="password6"
                                                ><i class="ti ti-eye-off"></i
                                                    ></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 form-password-toggle">
                                            <label class="form-label" for="confirm-password61">Confirm Password</label>
                                            <div class="input-group input-group-merge">
                                                <input
                                                    type="password"
                                                    id="confirm-password61"
                                                    class="form-control"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="confirm-password7" />
                                                <span class="input-group-text cursor-pointer" id="confirm-password7"
                                                ><i class="ti ti-eye-off"></i
                                                    ></span>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-between">
                                            <button class="btn btn-label-secondary btn-prev" disabled>
                                                <i class="ti ti-arrow-left me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                            </button>
                                            <button class="btn btn-primary btn-next">
                                                <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                <i class="ti ti-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Personal Info -->
                                <div id="personal-info-vertical" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-0">Personal Info</h6>
                                        <small>Enter Your Personal Info.</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="first-name1">First Name</label>
                                            <input type="text" id="first-name1" class="form-control" placeholder="John" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="last-name1">Last Name</label>
                                            <input type="text" id="last-name1" class="form-control" placeholder="Doe" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="country1">Country</label>
                                            <select class="select2" id="country1">
                                                <option label=" "></option>
                                                <option>UK</option>
                                                <option>USA</option>
                                                <option>Spain</option>
                                                <option>France</option>
                                                <option>Italy</option>
                                                <option>Australia</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="language1">Language</label>
                                            <select
                                                class="selectpicker w-auto"
                                                id="language1"
                                                data-style="btn-default"
                                                data-icon-base="ti"
                                                data-tick-icon="ti-check text-white"
                                                multiple>
                                                <option>English</option>
                                                <option>French</option>
                                                <option>Spanish</option>
                                            </select>
                                        </div>
                                        <div class="col-12 d-flex justify-content-between">
                                            <button class="btn btn-label-secondary btn-prev">
                                                <i class="ti ti-arrow-left me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                            </button>
                                            <button class="btn btn-primary btn-next">
                                                <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                <i class="ti ti-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Social Links -->
                                <div id="social-links-vertical" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-0">Social Links</h6>
                                        <small>Enter Your Social Links.</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="twitter1">Twitter</label>
                                            <input
                                                type="text"
                                                id="twitter1"
                                                class="form-control"
                                                placeholder="https://twitter.com/abc" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="facebook1">Facebook</label>
                                            <input
                                                type="text"
                                                id="facebook1"
                                                class="form-control"
                                                placeholder="https://facebook.com/abc" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="google1">Google+</label>
                                            <input
                                                type="text"
                                                id="google1"
                                                class="form-control"
                                                placeholder="https://plus.google.com/abc" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="linkedin1">Linkedin</label>
                                            <input
                                                type="text"
                                                id="linkedin1"
                                                class="form-control"
                                                placeholder="https://linkedin.com/abc" />
                                        </div>
                                        <div class="col-12 d-flex justify-content-between">
                                            <button class="btn btn-label-secondary btn-prev">
                                                <i class="ti ti-arrow-left me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                            </button>
                                            <button class="btn btn-success btn-submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/vendor/libs/bs-stepper/bs-stepper.js')); ?>"></script>
    <script src="<?php echo e(asset("assets/vendor/libs/bootstrap-select/bootstrap-select.js")); ?>"></script>
    <script src="<?php echo e(asset("assets/vendor/libs/select2/select2.js")); ?>"></script>
    <script src="<?php echo e(asset('assets/js/form-wizard-icons.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/Property/dproperty/resources/views/admin/settings/list.blade.php ENDPATH**/ ?>