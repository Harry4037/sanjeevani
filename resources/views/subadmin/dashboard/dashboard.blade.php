@extends('layouts.subadmin.app')

@section('content')

<div class="">
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count">{{ $activeUser }}</div>
                <h3>Active User</h3>
                <!--<p>Lorem ipsum psdea itgum rixt.</p>-->
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count">{{ $inactiveUser }}</div>
                <h3>Inactive User</h3>
                <!--<p>Lorem ipsum psdea itgum rixt.</p>-->
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count">{{ $activeStaff }}</div>
                <h3>Active Staff</h3>
                <!--<p>Lorem ipsum psdea itgum rixt.</p>-->
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count">{{ $inactiveStaff }}</div>
                <h3>Inactive Staff</h3>
                <!--<p>Lorem ipsum psdea itgum rixt.</p>-->
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
localStorage.clear();
</script>
@endsection