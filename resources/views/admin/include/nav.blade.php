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
        <!-- Dashboard -->
        @can('view-dashboard')
            <li class="menu-item {{request()->routeIs('admin.dashboard')? 'active' : ''}}">
                <a href="{{route('admin.dashboard')}}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-dashboard"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
        @endcan

        <!-- Multi-Tenancy -->
        @canany(['manage-company','manage-users'])
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Multi-Tenancy</span>
            </li>
            @can('manage-company')
                <li class="menu-item {{request()->routeIs('admin.company*')? 'active' : ''}}">
                    <a href="{{route('admin.company.list')}}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-building"></i>
                        <div data-i18n="Companies">Companies</div>
                    </a>
                </li>
            @endcan
            @can('manage-users')
                <li class="menu-item {{request()->routeIs('admin.user*')? 'active' : ''}}">
                    <a href="{{route('admin.user.list')}}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div data-i18n="Users">Users</div>
                    </a>
                </li>
            @endcan
        @endcanany
        <!-- Property Management -->
        @canany(['manage-properties','manage-tags'])
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Property Management</span>
            </li>
            @canany(['manage-properties','manage-amenities'])
                <li class="menu-item {{request()->routeIs('admin.property*')? 'active' : ''}}">
                    <a href="{{route('admin.property.list')}}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-home"></i>
                        <div data-i18n="Property">Property</div>
                    </a>
                </li>
                @can('manage-amenities')
                    <li class="menu-item {{request()->routeIs('admin.amenity*')? 'active' : ''}}">
                        <a href="{{route('admin.amenity.list')}}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-star"></i>
                            <div data-i18n="Amenities">Amenities</div>
                        </a>
                    </li>
                @endcan
                <li class="menu-item {{request()->routeIs('admin.location*')? 'active' : ''}}">
                    <a href="{{route('admin.location.list')}}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-map-pin"></i>
                        <div data-i18n="Locations">Locations</div>
                    </a>
                </li>
                <li class="menu-item {{request()->routeIs('admin.property-detail*')? 'active' : ''}}">
                    <a href="{{route('admin.property-detail.list')}}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-list-details"></i>
                        <div data-i18n="Property Details">Property Details</div>
                    </a>
                </li>
            @endcan
            @can('manage-tags')
                <li class="menu-item {{request()->routeIs('admin.tag*')? 'active' : ''}}">
                    <a href="{{route('admin.tag.list')}}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-tags"></i>
                        <div data-i18n="Tag Line">Tag Line</div>
                    </a>
                </li>
            @endcan
        @endcanany
        <!-- Content Management -->
        @canany(['manage-slider','manage-service','manage-client-review','manage-article'])
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Content Management</span>
            </li>
            @can('manage-slider')
                <li class="menu-item {{request()->routeIs('admin.slider*')? 'active' : ''}}">
                    <a href="{{route('admin.slider.list')}}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-slideshow"></i>
                        <div data-i18n="Slider">Slider</div>
                    </a>
                </li>
            @endcan
            @can('manage-service')
                <li class="menu-item {{request()->routeIs('admin.service*')? 'active' : ''}}">
                    <a href="{{route('admin.service.list')}}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-briefcase"></i>
                        <div data-i18n="Services">Services</div>
                    </a>
                </li>
            @endcan
            @can('manage-client-review')
                <li class="menu-item {{request()->routeIs('admin.testimonial*')? 'active' : ''}}">
                    <a href="{{route('admin.testimonial.list')}}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-message"></i>
                        <div data-i18n="Client Review">Client Review</div>
                    </a>
                </li>
            @endcan
            <li class="menu-item {{request()->routeIs('admin.article.*')? 'active' : ''}}">
                <a href="{{route('admin.article.list')}}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-news"></i>
                    <div data-i18n="Articles">Articles</div>
                </a>
            </li>
        @endcanany

        <!-- Access Control -->
        @canany(['manage-roles','manage-permissions'])
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Access Control</span>
            </li>
            @can('manage-roles')
                <li class="menu-item {{request()->routeIs('admin.role*')? 'active' : ''}}">
                    <a href="{{route('admin.role.list')}}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-lock"></i>
                        <div data-i18n="Roles">Roles</div>
                    </a>
                </li>
            @endcan
            @can('manage-permissions')
                <li class="menu-item {{request()->routeIs('admin.permission*')? 'active' : ''}}">
                    <a href="{{route('admin.permission.list')}}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-shield"></i>
                        <div data-i18n="Permissions">Permissions</div>
                    </a>
                </li>
            @endcan
        @endcanany
        <!-- System Settings -->
        @canany(['manage-app-settings'])
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">System Settings</span>
            </li>
            <li class="menu-item {{request()->routeIs('admin.app*')? 'active' : ''}}">
                <a href="{{route('admin.app.settings')}}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div data-i18n="App Settings">App Settings</div>
                </a>
            </li>
        @endcanany
    </ul>
</aside>
<!-- / Menu -->
