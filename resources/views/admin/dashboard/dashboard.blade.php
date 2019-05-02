@extends('layouts.admin.app')

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

    <div class="row">
        <div class="panel">
            <div class="panel-heading"><h3>Inventory</h3></div>
            <div class="panel-body">
                <form method="post" class="inline" id="inventory_form" name="inventory_form" action="{{ route('admin.dashboard.inventory') }}">
                    <div class="form-group col-md-2">
                        <label>Resort</label>
                        <select class="form-control" name="resort_id" id="resort_id">
                            <option value="">--select otpion--</option>
                            @if($resorts)
                            @foreach($resorts as $resort)
                            <option value="{{ $resort->id }}">{{ $resort->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Room Type</label>
                        <select class="form-control" name="resort_room_id" id="resort_room_id">
                            <option value="">--select otpion--</option>
                            @if($roomTypes)
                            @foreach($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label>CheckIn Date</label>
                        <input readonly="true" type="text" class="form-control" name="check_in_date" id="check_in_date">
                    </div>
                    <div class="form-group col-md-2">
                        <label>CheckOut Date</label>
                        <input readonly="true" type="text" class="form-control" name="check_out_date" id="check_out_date">
                    </div>
                    <div class="form-group col-md-1">
                        <label></label>
                        <input type="submit" class="form-control btn btn-success" value="Submit">
                    </div>
                </form>
                <div id="invantory_detail"></div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
    localStorage.clear();

    $(document).ready(function () {
        $('#check_in_date').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        });
        $('#check_out_date').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            singleClasses: "picker_2",
            locale: {
                format: 'YYYY/M/DD hh:mm:ss A'
            }
        });

        $("#inventory_form").validate({
//            ignore: [],
            rules: {
                resort_id: {
                    required: true
                },
                resort_room_id: {
                    required: true
                },
                check_in_date: {
                    required: true
                },
                check_out_date: {
                    required: true,
                },
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        $("#invantory_detail").html(response);
                    },
                    error: function () {
                        console.log("error");
                    }
                });
            }
        });

    });
</script>
@endsection
