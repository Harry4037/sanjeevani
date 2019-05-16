@extends('layouts.operator.app')

@section('content')
<style>
    .left_m{
        width: 290px;
        background-color: #abaee2;
        color: white;
        font-size: 20px;
        padding: 10px;
        border-radius: 8px;
        margin: 7px;
    }
    .right_m{
        width: 290px;
        background-color: #eaeaea;
        color: black;
        font-size: 20px;
        padding: 10px;
        border-radius: 8px;
        float: right;
        text-align: right;
        margin: 7px;
    }
</style>
<div class="">
    <div class="row" id="content_screen">
        <div class="col-sm-6 col-md-offset-3">
            <div class="panel">
                <div class="panel-body" id="message_container" style="min-height: 580px;">

                </div>
                <div class="panel-footer">
                    <textarea style="width: auto !important;" cols="58" rows="4" id="typed_message"></textarea>
                    <input type="submit" value="Send" name="send_message" id="send_message" class="btn btn-success" style="margin-top: 60px;">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    var loggedInUser = '';
    firebase.auth().onAuthStateChanged(function (user) {
        if (user) {
            loggedInUser = user;

            db.collection('chat_user').orderBy('time_stamp')
                    .onSnapshot(function (snapshot) {
                        var userList = '';
                        snapshot.docChanges().forEach(function (change) {
                            console.log(change.type);
                            var username = '';
                            if (change.doc.data().user_name) {
                                username = change.doc.data().user_name;
                            }
                            if (change.type === "added") {
                                userList += '<li class="user" id="' + change.doc.id + '" data-id="' + change.doc.data().user_id + '">\n\
                                        <a href="javascript:void(0);" class="user_tab">' + username + '</a></li>';
                            }
                            if (change.type === "removed") {
                                $('#' + change.doc.id).remove();
                            }

                        });
                        $("#chat_user_list").prepend(userList);
                    });


//            db.collection('rindex_support').get().then(function (querySnapshot) {
//                var userList = '';
//                querySnapshot.forEach(function (doc) {
//                    userList += '<li class="user" data-id="' + doc.id + '"><a href="#" >' + doc.id + '</a></li>';
//                });
//                $("#chat_user_list").html(userList);
//            });

        } else {
            alert("You are not connected with chat server.");
        }

    });
    $(document).on('click', '.user', function () {
        var _th = $(this);
        _th.addClass("active");
        var user_id = _th.data('id');
        var user_collection = 'Customer_' + user_id;
        $("#message_container").html("");
//        db.collection('chat_user').where("user_id", '==', user_id.toString()).get().then(function (querySnapshot) {
//            querySnapshot.forEach(function (doc) {
//                console.log(doc.data());
//            });
//        });
        realTime(user_collection);
    });

    function realTime(user_collection) {
        db.collection('rindex_support/' + user_collection + '/Customer_Chat').orderBy('timeStamp')
                .onSnapshot(function (snapshot) {
                    var newMessage = '';
                    snapshot.docChanges().forEach(function (change) {
//                        if (change.type === "added") {
                        if (change.doc.data().senderID != loggedInUser.uid) {
                            newMessage += '<div class="left_m">' + change.doc.data().messege + '</div>'
                        } else {
                            newMessage += '<div class="right_m">' + change.doc.data().messege + '</div>'
                        }
//                        }
                    });
                    $("#message_container").append(newMessage);
                });
    }

    $(document).on('click', '#send_message', function () {
        var message = $("#typed_message").val();
        var timeStamp = new Date().getTime();
        var receiverID = 189;
        console.log(message);
        if (message == '') {
            alert("message missing");
            return false;
        } else {
            db.collection('rindex_support/Customer_189/Customer_Chat').add({
                chatID: '1',
                messege: message,
                receiverID: receiverID.toString(),
                senderID: loggedInUser.uid,
                showDate: true,
                timeStamp: timeStamp.toString(),
            })
                    .then(function (docRef) {
                        $("#typed_message").val("");
                        console.log("Document written with ID: ", docRef.id);
                    })
                    .catch(function (error) {
                        console.error("Error adding document: ", error);
                    });
        }
    });

    $(document).on('keyup', '#typed_message', function (e) {
        if (e.which == 13) {
            $("#send_message").trigger("click");
        }
    });
</script>
@endsection
<!--<div class="incoming_msg">
    <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
    <div class="received_msg">
        <div class="received_withd_msg">
            <p>Test which is a new approach to have all
                solutions</p>
            <span class="time_date"> 11:01 AM    |    June 9</span></div>
    </div>
</div>-->