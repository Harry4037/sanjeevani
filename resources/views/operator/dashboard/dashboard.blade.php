@extends('layouts.operator.app')

@section('content')

<div class="">
    <div class="row" id="content_screen">

    </div>

</div>
@endsection

@section('script')
<script>
    var token = "{{ $token }}";
    $("#content_screen").html("Connecting....");
    firebase.auth().signInWithCustomToken(token).catch(function (error) {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;

        $("#content_screen").html(errorMessage);

    }).then(function (data) {
        $("#content_screen").html("connected to chatting server.");
    });

</script>
@endsection
