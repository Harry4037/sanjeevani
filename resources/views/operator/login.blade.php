@extends('layouts.operator.login')

@section('content')

<div class="animate form login_form">
    <section class="login_content">
        <form action="{{ route('operator.login') }}" method="post" id="login-form">
            {{ csrf_field() }}
            <h1>Operator Login</h1>
            @include('errors.errors-and-messages')
            <div id="err_msg"></div>
            <div class="form-group">
                <input type="text" class="form-control"  name="email_id" placeholder="Email*"  />
            </div>
            <div class="form-group">
                <input type="password" class="form-control"  placeholder="Password*" name="password" />
            </div>
            <div class="form-group">
                <input class="btn btn-success submit" type="submit" value="Log in">
                <!--<a class="reset_pass" href="#signup">Lost your password?</a>-->
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
            },
            submitHandler: function (form) {
                let btn = $(form).find('input[type="submit"]');

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    beforeSend: function () {
                        btn.val('loading . . .').attr('disabled', 'disabled');
                    },
                    success: function (response) {
                        if (response.auth) {
                            var token = response.token;
                            firebase.auth().signInWithCustomToken(token).catch(function (error) {
                                btn.val('Log in').removeAttr('disabled');
                                // Handle Errors here.
                                var errorCode = error.code;
                                var errorMessage = error.message;

                                $(".msg").html(errorMessage);
                                $(".msg").removeClass("alert-success");
                                $(".msg").addClass("alert-danger");
                                $(".msg").css("display", "block");

                            }).then(function (data) {
                                btn.val('Log in').removeAttr('disabled');
                                window.location.href = response.intended;
                            });

                        } else {
                            $(".msg").html("Invalid login details.");
                            $(".msg").removeClass("alert-success");
                            $(".msg").addClass("alert-danger");
                            $(".msg").css("display", "block");

                            setTimeout(function () {
                                $(".msg").fadeOut();
                            }, 2000);
                        }
                    },
                    error: function (xhr) {
                        btn.val('Log in').removeAttr('disabled');
                        $(".msg").html("Invalid login details.");
                        $(".msg").removeClass("alert-success");
                        $(".msg").addClass("alert-danger");
                        $(".msg").css("display", "block");

                        setTimeout(function () {
                            $(".msg").fadeOut();
                        }, 2000);
                    }
                });
            }
        });

    });

</script>
@endsection