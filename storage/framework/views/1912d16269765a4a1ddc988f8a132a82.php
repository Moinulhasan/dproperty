<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold">DProperty</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item <?php echo e(request()->routeIs('admin.dashboard')? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="menu-link">
                <i class="menu-icon tf-icons ti ti-dashboard"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <li class="menu-item <?php echo e(request()->routeIs('admin.user*')? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.user.list')); ?>" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Users">Users</div>
            </a>
        </li>
        <li class="menu-item <?php echo e(request()->routeIs('admin.slider*')? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.slider.list')); ?>" class="menu-link">
                <i class="menu-icon tf-icons ti ti-slideshow"></i>
                <div data-i18n="Slider">Slider</div>
            </a>
        </li>
        <li class="menu-item <?php echo e(request()->routeIs('admin.service*')? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.service.list')); ?>" class="menu-link">
                <i class="menu-icon tf-icons ti ti-servicemark"></i>
                <div data-i18n="Services">Services</div>
            </a>
        </li>
        <li class="menu-item <?php echo e(request()->routeIs('admin.testimonial*')? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.testimonial.list')); ?>" class="menu-link">
                <i class="menu-icon tf-icons ti ti-message"></i>
                <div data-i18n="Client Review">Client Review</div>
            </a>
        </li>
        <li class="menu-item <?php echo e(request()->routeIs('admin.property*')? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.property.list')); ?>" class="menu-link">
                <i class="menu-icon tf-icons ti ti-home"></i>
                <div data-i18n="Property">Property</div>
            </a>
        </li>
        <li class="menu-item <?php echo e(request()->routeIs('admin.app*')? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.app.settings')); ?>" class="menu-link">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="App Settings">App Settings</div>
            </a>
        </li>
    </ul>
</aside>
<!-- / Menu -->
<?php /**PATH /var/www/html/Property/dproperty/resources/views/admin/include/nav.blade.php ENDPATH**/ ?>