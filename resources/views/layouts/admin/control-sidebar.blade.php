<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a><i class="fa fa-users"></i> User Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.users.listing') }}">Users</a></li>

                    <li><a href="{{ route('admin.add.user') }}">Add New User</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-bullhorn"></i> Ad Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.ad_listing') }}">Ad</a></li>

                    <li><a href="{{ route('admin.add_ad') }}">Add New Ad</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-bars"></i> Category Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.category_listing') }}">Categories</a></li>

                    <li><a href="{{ route('admin.add_category') }}">Add New Category</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-glass"></i> Brand Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.brand_listing') }}">Brands</a></li>

                    <li><a href="{{ route('admin.add_brand') }}">Add New Brand</a></li>
                </ul>
            </li>

            <li><a><i class="fa fa-cube"></i> Product Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.product_listing') }}">Products</a></li>

                    <li><a href="{{ route('admin.add_product') }}">Add New Product</a></li>

                    <li><a href="{{ route('admin.attribute.listing') }}">Manage Attributes</a></li>
                </ul>
            </li>

            <li><a><i class="fa fa-tasks"></i> CMS Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.page.listing') }}">Pages</a></li>

                    <li><a href="{{ route('admin.add.page') }}">Add New Page</a></li>
                    <li><a href="{{ route('admin.email.templates') }}">Email Templates</a></li>
                    <li><a href="{{ route('admin.faqs') }}">Manage FAQs</a></li>
                </ul>
            </li>

            <li><a><i class="fa fa-university"></i> Banner Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.banner.listing') }}">Banners</a></li>

                    <li><a href="{{ route('admin.add.banner') }}">Add New Banner</a></li>
                </ul>
            </li>

            <li><a href="{{ route('admin.message.listing') }}"><i class="fa fa-phone"></i> Contact Us </a>
            </li>

            <li><a href="{{ route('admin.newsletter.listing') }}"><i class="fa fa-newspaper-o"></i> Newsletter Management </a>
            </li>

            <li><a><i class="fa fa-map-marker"></i> Location Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.country.listing') }}">Countries</a></li>

                    <li><a href="{{ route('admin.state.listing') }}">States</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-comments"></i> Review Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.review.listing') }}">Reviews</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-shopping-cart"></i> Order Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.orders.listing') }}">Orders</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-money"></i> Payment Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.payments.listing') }}">Payment Gateway - Stripe</a></li>
                    <li><a href="{{ route('admin.payments.listing') }}?order_payment_type=is_aud_wallet">AUD Coins</a></li>
                    <li><a href="{{ route('admin.payments.listing') }}?order_payment_type=is_digi_wallet">DIGI Coins</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-flag"></i> Reports Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('admin.reports.user') }}">User Report</a></li>
                    <li><a href="{{ route('admin.reports.order') }}">Order Report</a></li>
                </ul>
            </li>
        </ul>
    </div>
    

</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
   <!--  <a data-toggle="tooltip" data-placement="top" title="Settings">
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