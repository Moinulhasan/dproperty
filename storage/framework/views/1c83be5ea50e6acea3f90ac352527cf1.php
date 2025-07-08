<header class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="<?php echo e(url('/')); ?>">
            <img src="<?php echo e(asset('images/logo_main.png')); ?>" alt="DProperty Logo" height="40" class="me-2 headerLogo">
        </a>

        <button class="navbar-toggler d-lg-none navbar-light" type="button" id="mobileNavToggle">
            <span class="navbar-toggler-icon text-white" style="color: white !important;"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#projects">Project</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#contact">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</header>
<div class="mobile-nav-overlay" id="mobileNavOverlay">
    <div class="mobile-nav-content">
        <div class="mobile-nav-header">
            <a href="<?php echo e(url('/')); ?>">
                <img src="<?php echo e(asset('images/logo_main.png')); ?>" alt="DProperty" height="25" class="headerLogo">
            </a>
            <button class="mobile-nav-close" id="mobileNavClose">
                <i class="bi bi-x"></i>
            </button>
        </div>
        <ul class="mobile-nav-menu">
            <li><a href="#home" class="mobile-nav-link">Home</a></li>
            <li><a href="#services" class="mobile-nav-link">Services</a></li>
            <li><a href="#projects" class="mobile-nav-link">Project</a></li>
            <li><a href="#contact" class="mobile-nav-link">Contact Us</a></li>
            <li><a href="#about" class="mobile-nav-link">About</a></li>
        </ul>
    </div>
</div>
<?php /**PATH /var/www/html/Property/dproperty/resources/views/component/nav.blade.php ENDPATH**/ ?>