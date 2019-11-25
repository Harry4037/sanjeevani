@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Staff </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>

                <form class="form-horizontal form-label-left" action="{{ route('admin.staff.edit', $user->id) }}" method="post" id="addStaffForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ $user->user_name }}" type="text" class="form-control" placeholder="Name" name="staff_name" id="staff_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mobile No.*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input readonly="true" value="{{ $user->mobile_number }}" type="text" class="form-control" placeholder="Mobile No." name="staff_mobile_no" id="staff_mobile_no">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ $user->email_id }}" type="text" class="form-control" placeholder="Email" name="staff_email" id="staff_email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Profile Pic</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control" type="file" name="profile_pic" id="profile_pic" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Profile preview</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <img class="img-rounded" style="width: 100px; height: 100px;" src="{{ $user->profile_pic_path }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Name*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" name="resort_id" id="resort_id">
                                <option value="">Choose option</option>
                                @if($resorts)
                                @foreach($resorts as $resort)
                                <option value="{{ $resort->id }}"
                                        @if(isset($userBooking->resort->id) && ($userBooking->resort->id == $resort->id))
                                        {{ "selected" }}
                                        @endif
                                        >{{ $resort->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address*</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ $user->address1 }}" type="text" class="form-control" placeholder="Address" name="staff_address" id="staff_address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">State*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="state" id="state">
                                <option value="">Choose option</option>
                                @if($states)
                                @foreach($states as $state)
                                <option value="{{ $state->id }}"
                                        @if(isset($selectedCity->state->id) && $selectedCity->state->id == $state->id)
                                        {{ "selected" }}
                                        @endif
                                        >{{ $state->state }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">City*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="city" id="city">
                                <option value="">Choose option</option>
                                @if($userCites)
                                @foreach($userCites as $userCity)
                                <option value="{{ $userCity->id }}" 
                                        @if(isset($selectedCity->id) && $selectedCity->id == $userCity->id))
                                        {{ "selected" }}
                                        @endif
                                        >{{ $userCity->city }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pincode*</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $user->pincode }}" type="text" class="form-control" name="pin_code" id="pin_code" placeholder="Pincode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Allowed For</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p style="padding: 5px;">
                                <input class="flat" type="checkbox" name="is_service_authorise" 
                                       @if($user->is_service_authorise)
                                       {{ "checked" }}
                                       @endif
                                       >Services & Issues
                                       <input class="flat" type="checkbox" name="is_meal_authorise"
                                       @if($user->is_meal_authorise)
                                       {{ "checked" }}
                                       @endif
                                       >Meal Orders
                                       <input class="flat" type="checkbox" name="is_booking"
                                       @if($user->is_booking)
                                       {{ "checked" }}
                                       @endif
                                       >Create User Booking
                            <p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Amenities Allowed For</label>
                        <div class="col-md-6 col-sm-6 col-xs-6" id="amenity_list_div">
                            <p style="padding: 5px;">
                                @if($selectedResortAmenities)
                                @foreach($selectedResortAmenities as $selectedResortAmenity)
                                <input class="flat" type="checkbox" name="amenity_ids[]" value="{{ $selectedResortAmenity->id }}"
                                       @if(in_array($selectedResortAmenity->id, $authoriseAmenity))
                                       {{ "checked" }}
                                       @endif
                                       >{{ $selectedResortAmenity->name }}
                                       @endforeach
                                       @endif
                            </p>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-4">
                            <a  class="btn btn-default" href="{{ route('admin.staff.index') }}">Cancel</a>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
<script>
    $(document).ready(function () {

        if ($("input.flat")[0]) {
            $(document).ready(function () {
                $('input.flat').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    radioClass: 'iradio_flat-green'
                });
            });
        }

        $("#addStaffForm").validate({
            rules: {
                staff_name: {
                    required: true
                },
                staff_mobile_no: {
                    required: true,
                    number: true,
                    maxlength: 10,
                    minlength: 10,
                },
                staff_email: {
                    required: true,
                    email: true
                },
                resort_id: {
                    required: true
                },
                staff_address: {
                    required: true
                },
                state: {
                    required: true
                },
                city: {
                    required: true
                },
                pin_code: {
                    required: true,
                    number: true,
                    maxlength: 6,
                    minlength: 6,
                },
            }
        });

        $(document).on("change", "#resort_id", function () {
            var resort_id = $("#resort_id :selected").val();
            $.ajax({
                url: _baseUrl + '/admin/staff/amenity-list',
                type: 'post',
                data: {resort_id: resort_id},
                dataType: 'html',
                beforeSend: function () {
                    $(".overlay").show();
                },
                success: function (res) {
                    $("#amenity_list_div").html(res);
                    $(".overlay").hide();
                }
            });
        });
    });
</script>

@endsection