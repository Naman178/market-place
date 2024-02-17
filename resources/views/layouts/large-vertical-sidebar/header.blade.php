<div class="main-header">
    <div class="logo">
        <?php
            $site = \App\Models\Settings::where('key','site_setting')->first();
            $logo = '';
            if(!empty($site['value']['logo_image'])){
                $logo = asset('storage/Logo_Settings/'.$site['value']['logo_image']);
            }
        ?>
        @if($logo == '')
            <p class="text-primary text-24 line-height-1 mb-2" style="text-align: center">{{$site["value"]["site_name"] ?? "Infinity"}}</p>
        @else
            <img src="{{$logo}}" alt="logo" style="object-fit: contain;">
        @endif
    </div>
    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div style="margin: auto"></div>

    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>

        <!-- Notificaiton -->
        {{-- <div class="dropdown">
            <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="badge badge-primary">3</span>
                <i class="i-Bell text-muted header-icon"></i>
            </div>
            <!-- Notification dropdown -->
            <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none"
                aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
                <div class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <i class="i-Speach-Bubble-6 text-primary mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span>New message</span>
                            <span class="badge badge-pill badge-primary ml-1 mr-1">new</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-auto">10 sec ago</span>
                        </p>
                        <p class="text-small text-muted m-0">James: Hey! are you busy?</p>
                    </div>
                </div>
                <div class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <i class="i-Receipt-3 text-success mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span>New order received</span>
                            <span class="badge badge-pill badge-success ml-1 mr-1">new</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-auto">2 hours ago</span>
                        </p>
                        <p class="text-small text-muted m-0">1 Headphone, 3 iPhone x</p>
                    </div>
                </div>
                <div class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <i class="i-Empty-Box text-danger mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span>Product out of stock</span>
                            <span class="badge badge-pill badge-danger ml-1 mr-1">3</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-auto">10 hours ago</span>
                        </p>
                        <p class="text-small text-muted m-0">Headphone E67, R98, XL90, Q77</p>
                    </div>
                </div>
                <div class="dropdown-item d-flex">
                    <div class="notification-icon">
                        <i class="i-Data-Power text-success mr-1"></i>
                    </div>
                    <div class="notification-details flex-grow-1">
                        <p class="m-0 d-flex align-items-center">
                            <span>Server Up!</span>
                            <span class="badge badge-pill badge-success ml-1 mr-1">3</span>
                            <span class="flex-grow-1"></span>
                            <span class="text-small text-muted ml-auto">14 hours ago</span>
                        </p>
                        <p class="text-small text-muted m-0">Server rebooted successfully</p>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Notificaiton End -->

        <!-- User avatar dropdown -->
        <?php $user = auth()->user(); ?>
        <div class="dropdown">
            <div class="user col align-self-end">
                <img src="{{ asset('assets/images/faces/1.png') }}" id="userDropdown" alt=""
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{ $user['fname'] }} {{ $user['lname'] }}
                    </div>
                    <a class="dropdown-item" href="{{ route('profile-settings', $user['id']) }}">Profile settings</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- header top menu end -->
