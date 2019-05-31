<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>Navigation</h3>
    <div class="ln_solid"></div>
    <ul class="nav side-menu sidebar-scroll">
      <li>
        <a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a>
      </li>
      <li @if(in_array(Route::currentRouteName(), ['admin.room.add','admin.room.edit']))
      {{ "class=current-page" }}
      @endif
      >
      <a href="{{ route('admin.room.index') }}"><i class="fa fa-university"></i>Room Type Management</a>
    </li>
    <li @if(in_array(Route::currentRouteName(), ['admin.resort.add','admin.resort.edit']))
    {{ "class=current-page" }}
    @endif
    >
    <a href="{{ route('admin.resort.index') }}"><i class="fa fa-home"></i>Resort Management</a>
  </li>
  <li @if(in_array(Route::currentRouteName(), ['admin.nearby.add', 'admin.nearby.edit']))
  {{ "class=current-page" }}
  @endif>
  <a href="{{ route('admin.nearby.index') }}"><i class="fa fa-map"></i>Nearby Place Management</a>
</li>
<li @if(in_array(Route::currentRouteName(), ['admin.users.booking-create', 'admin.users.booking', 'admin.staff.edit', 'admin.staff.add','admin.staff.index','admin.users.add','admin.users.edit','admin.users.detail']))
{{ "class=active" }}
@endif>
<a><i class="fa fa-users"></i> User Management <span class="fa fa-chevron-down"></span></a>
<ul class="nav child_menu"  
@if(in_array(Route::currentRouteName(), ['admin.subadmin.edit', 'admin.subadmin.add', 'admin.subadmin.index', 'admin.users.booking-create', 'admin.users.booking', 'admin.staff.edit', 'admin.staff.add','admin.staff.index','admin.users.add','admin.users.edit','admin.users.detail']))
{{ "style=display:block;" }}
@endif
>
<li @if(in_array(Route::currentRouteName(), ['admin.users.booking-create', 'admin.users.booking', 'admin.users.add','admin.users.edit','admin.users.detail']))
{{ "class=current-page" }}
@endif

><a href="{{ route('admin.users.index') }}">Users</a></li>
<li @if(in_array(Route::currentRouteName(), ['admin.staff.edit', 'admin.staff.add','admin.staff.index']))
{{ "class=current-page" }}
@endif
><a href="{{ route('admin.staff.index') }}">Staff</a></li>
<li @if(in_array(Route::currentRouteName(), ['admin.subadmin.edit', 'admin.subadmin.add', 'admin.subadmin.index']))
{{ "class=current-page" }}
@endif
><a href="{{ route('admin.subadmin.index') }}">Sub Admin</a></li>
<li @if(in_array(Route::currentRouteName(), ['admin.operator.edit', 'admin.operator.add', 'admin.operator.index']))
{{ "class=current-page" }}
@endif
><a href="{{ route('admin.operator.index') }}">Operator</a></li>
</ul>
</li>
<li @if(in_array(Route::currentRouteName(), ['admin.banner.add', 'admin.banner.edit']))
{{ "class=current-page" }}
@endif
>
<a href="{{ route('admin.banner.index') }}"><i class="fa fa-flag-checkered"></i>Banner Management</a>
</li>
<li  @if(in_array(Route::currentRouteName(), ['admin.service.add', 'admin.service.edit']))
{{ "class=current-page" }}
@endif

>
<a href="{{ route('admin.service.index') }}"><i class="fa fa-gears"></i>Services Management</a>
</li>
<li>
  <a href="{{ route('admin.order-request.index') }}"><i class="fa fa-hand-scissors-o"></i>Service Request Management</a>
</li>
<li>
  <a href="{{ route('admin.amenity-request.index') }}"><i class="fa fa-hand-scissors-o"></i>Amenity Request Management</a>
</li>
<li>
  <a href="{{ route('admin.activity-request.index') }}"><i class="fa fa-hand-scissors-o"></i>Activity Request Management</a>
</li>
<li  @if(in_array(Route::currentRouteName(), ['admin.activity.add', 'admin.activity.edit']))
{{ "class=current-page" }}
@endif
>
<a href="{{ route('admin.amenity.index') }}"><i class="fa fa-bars"></i>Amenity Management</a>
</li>
<li  @if(in_array(Route::currentRouteName(), ['admin.activity.add', 'admin.activity.edit']))
{{ "class=current-page" }}
@endif
>
<a href="{{ route('admin.activity.index') }}"><i class="fa fa-bars"></i>Activity Management</a>
</li>
<li  @if(in_array(Route::currentRouteName(), ['admin.offer.add', 'admin.offer.edit']))
{{ "class=current-page" }}
@endif
>
<a href="{{ route('admin.offer.index') }}"><i class="fa fa-gift"></i>Offer Management</a>
</li>
<li  @if(in_array(Route::currentRouteName(), ['admin.healthcare.add', 'admin.healthcare.edit']))
{{ "class=current-page" }}
@endif
>
<a href="{{ route('admin.healthcare.index') }}"><i class="fa fa-plus"></i>Healthcare Management</a>
</li>
<li  @if(in_array(Route::currentRouteName(), ['admin.cms.edit']))
{{ "class=current-page" }}
@endif
>
<a href="{{ route('admin.cms.index') }}"><i class="fa fa-reorder"></i>CMS Management</a>
</li>
<li  @if(in_array(Route::currentRouteName(), ['admin.sos.view']))
{{ "class=current-page" }}
@endif
>
<a href="{{ route('admin.sos.index') }}"><i class="fa fa-plus-square"></i>SOS Management</a>
</li>

<li @if(in_array(Route::currentRouteName(), ['admin.meal.edit', 'admin.meal.add','admin.meal.index', 'admin.meal-category.add', 'admin.meal-category.edit', 'admin.meal-package.edit', 'admin.meal-package.add']))
{{ "class=active" }}
@endif>
<a><i class="fa fa-cutlery"></i>Restaurant Management<span class="fa fa-chevron-down"></span></a>
<ul class="nav child_menu"  
@if(in_array(Route::currentRouteName(), ['admin.meal.edit', 'admin.meal.add','admin.meal.index', 'admin.meal-category.add', 'admin.meal-category.edit', 'admin.meal-package.edit', 'admin.meal-package.add']))
{{ "style=display:block;" }}
@endif
>
<li @if(in_array(Route::currentRouteName(), ['admin.meal-category.add','admin.meal-category.edit']))
{{ "class=current-page" }}
@endif

><a href="{{ route('admin.meal-category.index') }}">Meal Category Management</a>
</li>
<li @if(in_array(Route::currentRouteName(), ['admin.meal.edit', 'admin.meal.add']))
{{ "class=current-page" }}
@endif
><a href="{{ route('admin.meal.index') }}">Meal Management</a>
</li>
<li @if(in_array(Route::currentRouteName(), ['admin.meal-package.edit', 'admin.meal-package.add']))
{{ "class=current-page" }}
@endif
><a href="{{ route('admin.meal-package.index') }}">Meal Package Management</a>
</li>
</ul>
</li>
<li  @if(in_array(Route::currentRouteName(), ['admin.order.index']))
{{ "class=current-page" }}
@endif
>
<a href="{{ route('admin.order.index') }}"><i class="fa fa-shopping-basket"></i>Order Management</a>
</li>
<li  @if(in_array(Route::currentRouteName(), ['admin.notification.index']))
{{ "class=current-page" }}
@endif
>
<a href="{{ route('admin.notification.index') }}"><i class="fa fa-newspaper-o"></i>Notification Management</a>
</li>
<li  @if(in_array(Route::currentRouteName(), ['admin.healthcare.booking']))
{{ "class=current-page" }}
@endif
>
<a href="{{ route('admin.healthcare.booking') }}"><i class="fa fa-newspaper-o"></i>Healthcare Bookings</a>
</li>
</ul>
</div>
</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
<!--   <a data-toggle="tooltip" data-placement="top" title="Settings">
    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="FullScreen">
    <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="Lock">
    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
  </a> -->
  <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('admin.logout') }}">
    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
  </a>
</div>
<!-- /menu footer buttons -->