<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Navigation</h3>
        <ul class="nav side-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}"><i class="fa fa-users"></i> Dashboard</a>
            </li>
            <li><a><i class="fa fa-users"></i> User Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li><a href="{{ route('admin.staff.index') }}">Staff</a></li>
                    <!--<li><a href="index3.html">Dashboard3</a></li>-->
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.resort.index') }}"><i class="fa fa-home"></i> Resort Management</a>
            </li>
            <li>
                <a href="{{ route('admin.nearby.index') }}"><i class="fa fa-car"></i> Nearby Place Management</a>
            </li>
            <li>
                <a href="{{ route('admin.banner.index') }}"><i class="fa fa-flag-checkered"></i> Banner Management</a>
            </li>
            <li>
                <a href="{{ route('admin.service.index') }}"><i class="fa fa-gears"></i> Services Management</a>
            </li>
            <li>
                <a href="{{ route('admin.jobs.index') }}"><i class="fa fa-hand-scissors-o"></i> Request Management</a>
            </li>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('admin.logout') }}">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>
<!-- /menu footer buttons -->