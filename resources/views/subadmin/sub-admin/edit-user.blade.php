@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Staff </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>

                <form class="form-horizontal form-label-left" action="{{ route('admin.subadmin.edit', $user->id) }}" method="post" id="editSubadminForm">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ $user->user_name }}" type="text" class="form-control" placeholder="Name" name="name" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input value="{{ $user->email_id }}" type="text" class="form-control" placeholder="Email" name="email" id="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resort Name</label>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Menu's</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <p style="padding: 5px;">
                                @if($menus)
                                @foreach($menus as $menu)
                                <input class="flat" type="checkbox" name="menu_ids[]" value="{{ $menu->id }}"
                                       @if(in_array($menu->id, $userAuthorityMapping))
                                       {{ "checked" }}
                                       @endif
                                       >{{ $menu->display_name }}
                                <br>
                                @endforeach
                                @endif
                            <p>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-4">
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#addStaffForm").validate({
            rules: {
                staff_name: {
                    required: true
                },
                staff_mobile_no: {
                    required: true
                },
                staff_email: {
                    required: true
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
                    required: true
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
                success: function (res) {
                    $("#amenity_list_div").html(res);
                }
            });
        });
    });
</script>

@endsection