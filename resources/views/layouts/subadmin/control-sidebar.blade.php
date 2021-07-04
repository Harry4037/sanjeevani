<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Navigation</h3>
        <div class="ln_solid"></div>
        <ul class="nav side-menu sidebar-scroll">
            <li>
                <a href="{{ route('subadmin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
            </li>
            @if($allowed_menus)
            @foreach($allowed_menus as $menu)
            <li  @if(in_array(Route::currentRouteName(), [ $menu->page_url ]))
                  {{ "class=current-page" }}
                  @endif
                  >
                  <a href="{{ route( $menu->page_url ) }}"><i class="{{ $menu->image_path }}"></i>{{ $menu->display_name }}</a>
            </li>
            @endforeach
            @endif
        </ul>
    </div>
</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('subadmin.logout') }}">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>
<!-- /menu footer buttons -->