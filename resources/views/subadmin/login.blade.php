@extends('layouts.admin.login')

@section('content')

<div class="animate form login_form">
    <section class="login_content">
        <form action="{{ route('subadmin.login') }}" method="post" id="login-form">
            {{ csrf_field() }}
            <h1>Admin Login</h1>
            @include('errors.errors-and-messages')
            <div class="form-group">
                <input type="text" class="form-control"  name="email_id" placeholder="Email*"  />
            </div>
            <div class="form-group">
                <input type="password" class="form-control"  placeholder="Password*" name="password" />
            </div>
            <div class="form-group">
                <input class="btn btn-success submit" type="submit" value="Log in">
                <a class="reset_pass" href="#signup">Lost your password?</a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                    <img style="width: 150px;" src="{{asset("img/logo.png") }}" >
                    <p>©2018 All Rights Reserved. Rindex.</p>
                </div>
            </div>
        </form>
    </section>
</div>

<!-- Forget Password -->
<div id="register" class="animate form registration_form">
    <section class="login_content">
        <form method="POST" action="{{ route('subadmin.password.email') }}" id="forget-form">
            {{ csrf_field() }}
            <h1>Forget Password</h1>

            <div class="form-group">
                <input name="email_id" type="email" class="form-control" placeholder="Email" />
            </div>
            <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-success submit" >
                <a class="pull-right" href="#signin"><u>Back to Login</u></a>
            </div>

            <div class="clearfix"></div>

            <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                    <h1><i class="fa fa-anchor"></i> Sanjeevani</h1>
                    <p>©2018 All Rights Reserved. Sanjeevani.</p>
                </div>
            </div>
        </form>
    </section>
</div>
<script>

    $(document).ready(function () {
        $("#login-form").validate({
            rules: {
                email_id: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            }
        });

        $("#forget-form").validate({
            rules: {
                email: {
                    required: true
                }
            }
        });
    });

</script>
@endsection