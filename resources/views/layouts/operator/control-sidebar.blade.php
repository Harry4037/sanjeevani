<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <!--        <div class="ln_solid"></div>-->
        <ul class="nav side-menu sidebar-scroll" id="chat_user_list">

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
<style>
    .user{
        text-shadow: rgba(0, 0, 0, 0.25) 0 -1px 0;
        background: linear-gradient(#334556, #2C4257), #2A3F54;
        box-shadow: rgba(0, 0, 0, 0.25) 0 1px 0, inset rgba(255, 255, 255, 0.16);
    }
    .blink{
        width:100px;
        height: 20px;
        background-color: magenta;
        padding: 10px;	
        text-align: center;
        line-height: 20px;
    }
    .blink span{
        font-size: 25px;
        font-family: cursive;
        color: white;
        animation: blink 1s linear infinite;
    }
    @keyframes blink{
        0%{opacity: 0;}
        50%{opacity: .5;}
        100%{opacity: 1;}
    }
</style>