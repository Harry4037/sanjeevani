<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Navigation</h3>
        <div class="ln_solid"></div>
        <ul class="nav side-menu sidebar-scroll">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
            </li>
            <li>
                <!--                @if(in_array(Route::currentRouteName(), ['admin.room.add','admin.room.edit']))
                                 {{ "class=current-page" }}
                                 @endif-->

                <a href="#"><i class="fa fa-university"></i>Users</a>
            </li>

        </ul>
    </div>
</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('operator.logout') }}">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>
<!-- /menu footer buttons -->