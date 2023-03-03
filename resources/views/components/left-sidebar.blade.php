<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="/" class="logo logo-light">
        <span class="logo-lg">
            {{-- <img src="/assets/images/logo.png" alt="logo"> --}}
            <h1>{{ env('APP_NAME') }}</h1>
        </span>
        <span class="logo-sm">
            {{-- <img src="/assets/images/logo-sm.png" alt="small logo"> --}}
            <h1>{{ env('APP_NAME') }}</h1>
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="/" class="logo logo-dark">
        <span class="logo-lg">
            {{-- <img src="/assets/images/logo-dark.png" alt="dark logo"> --}}
            <h1>{{ env('APP_NAME') }}</h1>
        </span>
        <span class="logo-sm">
            {{-- <img src="/assets/images/logo-dark-sm.png" alt="small logo"> --}}
            <h1>{{ env('APP_NAME') }}</h1>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="pages-profile.html">
                <img src="/assets/images/users/avatar-1.jpg" alt="user-image" height="42" class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">{{ auth()->user()->fullname }}</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-item">
                <a href="/" class="side-nav-link">
                    <i class="uil-home"></i>
                    <span> Главная </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('customers.index') }}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Катнасыушылар </span>
                </a>
            </li>

            <x-admin-menu />
        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
