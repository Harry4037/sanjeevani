@extends('layouts.admin.app')

@section('content')

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		@include('errors.errors-and-messages')
		<div class="x_panel">
			<div class="x_title">
				<div style="display: none;" class="alert msg" role="alert"></div>
				<h2>{{$user->first_name}}'s Payment</h2>
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
								{{number_format($total,2)}}
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
								{{number_format($paid,2)}}
							</div>
							<h3>Total Paid</h3>
						</div>
					</div>

					<div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="tile-stats">
							<div class="icon">
								<i class="fa fa-inr"></i>
							</div>
							<div class="count">
								{{number_format($outstanding ,2)}}
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
							<div class="form-group">
								<label for="">Amount</label>
								<input type="text" name="amount" class="form-control">
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

		$("#paymentForm").validate({
			ignore: [],
			rules:{
				amount: {
					required: true,
					number:true,
					max:{{$outstanding}}
				},
			},

			messages:{
				amount:{
					required:"Please enter the amount.",
					number:"Please enter a valid amount.",
					max:"Amount can't be more than {{$outstanding}}.",
				},
			},
			submitHandler: function (form) {

				let btn = $(form).find('button[type="submit"]');

				btn.text('Please Wait . . .').attr('disabled','disabled');

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