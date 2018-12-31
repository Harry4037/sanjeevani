<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="#" class="site_title"><i class="fa fa-heartbeat"></i> <span>Sanjeevani</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ auth('admin')->user()->profile_pic_path }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ auth('admin')->user()->user_name ? auth('admin')->user()->user_name : "Admin" }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br />
        @include('layouts.admin.control-sidebar')
    </div>
</div>

<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img style="border:1px solid #b7b7b7;" src="{{ auth('admin')->user()->profile_pic_path }}" alt="">{{ auth('admin')->user()->user_name ? auth('admin')->user()->user_name : "Admin" }}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="{{ route('admin.profile') }}">Profile</a></li>
                        <li><a href="{{ route('admin.change-password') }}">Change Password</a></li>
                        <li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->