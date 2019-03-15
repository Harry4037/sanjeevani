@extends('layouts.admin.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('errors.errors-and-messages')
        <div class="x_panel">
            <div class="x_title">
                <div style="display: none;" class="alert msg" role="alert"></div>
                <h2>{{$user->first_name}}'s Payment</h2>
                <div class="pull-right">
                    <a class="btn btn-info" href="{{ route('admin.users.index') }}">Back</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon">
                                <i class="fa fa-inr"></i>
                            </div>
                            <div class="count">
                                {{number_format($total,0)}}
                            </div>
                            <h3>Total Order</h3>
                        </div>
                    </div>

                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon">
                                <i class="fa fa-inr"></i>
                            </div>
                            <div class="count">
                                {{number_format($paid,0)}}
                            </div>
                            <h3>Total Paid</h3>
                        </div>
                    </div>

                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                            <div class="icon">
                                <i class="fa fa-inr"></i>
                            </div>
                            <div class="count" id="total_outstanding_amount">
                                {{number_format($outstanding ,0)}}
                            </div>
                            <h3>Total Outstanding</h3>
                        </div>
                    </div>
                </div>

                @if($outstanding > 0)
                <hr>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <h3 class="text-center">Pay Outstanding</h3>
                        <form action="{{route('admin.users.pay_outstanding')}}" id="paymentForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="hidden" name="resort_id" value="{{$resort->id}}">
                            <input type="hidden" id="total_amount" name="total_amount" value="{{$total}}">
                            <input type="hidden" id="paid" name="paid" value="{{$paid}}">
                            <div class="form-group">
                                <label for="">Discount (%)</label>
                                <input type="number" id="discount" name="discount" class="form-control" value="{{ $user->discount ? $user->discount : 0 }}">
                            </div>
                            <div class="form-group">
                                <label for="">Discounted Amount</label>
                                <input readonly type="number" id="discount_amount" name="discount_amount" class="form-control" value="{{ $discountPrice }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="">Amount</label>
                                <input type="number" id="amount" name="amount" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for=""></label>
                                <button type="submit" class="btn btn-success pull-right">Pay</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
    $(document).on("keyup click", "#amount", function(){
       var amount_n = parseFloat($("#amount").val());
       if(amount_n < 0){
           $("#amount").val(0)
           return false;
       }else{
           return true;
       }
   });
   
   $(document).on("keyup click", "#discount", function(){
       var discount = parseFloat($("#discount").val());
       var total_amount = parseFloat($("#total_amount").val());
       var paid = parseFloat($("#paid").val());
       if(discount < 0){
           $("#discount").val(0)
           return false;
       }else if(discount <= 100){
           var dis_price = parseFloat((total_amount - (total_amount * (discount/100))).toFixed(0));
           var max_limit = dis_price - paid;
           $("#discount_amount").val(dis_price);
           $("#total_outstanding_amount").html(max_limit);
           $("#amount").rules("remove", "max");
           $("#amount").rules("add", {max: max_limit });
       }else{
           return false;
       }
   });
   
    jQuery.validator.addMethod("lessamount", function (value, element) {
       var dis_amount = parseFloat($("#discount_amount").val());
       var paid = parseFloat($("#paid").val());
        return dis_amount > paid;
    }, "Discounted price not less than total paid amount");
    
    $("#paymentForm").validate({
    ignore: [],
            rules:{
            amount: {
            required: true,
                    number:true,
                    max:{{$outstanding}},
            },
            discount: {
            required: true,
                    number:true,
                    min: 0,
                    max: 100,
                    lessamount: true
            },
            },
            messages:{
            amount:{
            required:"Please enter the amount.",
                    number:"Please enter a valid amount.",
//                    max:"Amount can't be more than {{$discountPrice}}.",
            },
            },
            submitHandler: function (form) {

            let btn = $(form).find('button[type="submit"]');
            btn.text('Please Wait . . .').attr('disabled', 'disabled');
            $.ajax({
            url: form.action,
                    type:"POST",
                    data: $(form).serialize(),
                    success: function (response) {

                    btn.text('Pay').removeAttr('disabled');
                    if (response.status_code == 200) {
                    $(form).get(0).reset();
                    window.location.reload();
                    } else {
                    $(".msg").html(response.message);
                    $(".msg").removeClass("alert-success");
                    $(".msg").addClass("alert-danger");
                    $(".msg").css("display", "block");
                    }
                    setTimeout(function () {
                    $(".msg").fadeOut();
                    }, 2000);
                    },
                    error:function(){
                    btn.text('Pay').removeAttr('disabled');
                    }
            });
            }
    });
    });
</script>
@endsection