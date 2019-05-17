@extends('layouts.operator.app')

@section('content')
<style>

    .mesgs {
        float: left;
        padding: 55px 15px 40px 20px;
        width: 60%;
        text-align: center;
        border: 1px solid black;
        margin-left: 200px;
    }

    img{ max-width:100%;}
    .inbox_people {
        background: #f8f8f8 none repeat scroll 0 0;
        float: left;
        overflow: hidden;
        width: 40%; border-right:1px solid #c4c4c4;
    }
    .inbox_msg {
        border: 1px solid #c4c4c4;
        clear: both;
        overflow: hidden;
    }
    .top_spac{ margin: 20px 0 0;}


    .recent_heading {float: left; width:40%;}
    .srch_bar {
        display: inline-block;
        text-align: right;
        width: 60%; padding;
    }
    .headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

    .recent_heading h4 {
        color: #05728f;
        font-size: 21px;
        margin: auto;
    }
    .srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
    .srch_bar .input-group-addon button {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        padding: 0;
        color: #707070;
        font-size: 18px;
    }
    .srch_bar .input-group-addon { margin: 0 0 0 -27px;}

    .chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
    .chat_ib h5 span{ font-size:13px; float:right;}
    .chat_ib p{ font-size:14px; color:#989898; margin:auto}
    .chat_img {
        float: left;
        width: 11%;
    }
    .chat_ib {
        float: left;
        padding: 0 0 0 15px;
        width: 88%;
    }

    .chat_people{ overflow:hidden; clear:both;}
    .chat_list {
        border-bottom: 1px solid #c4c4c4;
        margin: 0;
        padding: 18px 16px 10px;
    }
    .inbox_chat { height: 550px; overflow-y: scroll;}

    .active_chat{ background:#ebebeb;}

    .incoming_msg_img {
        display: inline-block;
        width: 6%;
    }
    .received_msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
    }
    .received_withd_msg p {
        background: #ebebeb none repeat scroll 0 0;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
        text-align: left;
    }
    .time_date_incoming {
        color: #747474;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
        float: left;
    }
    .time_date_outgoing {
        color: #747474;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
        float: right;
    }
    /*.received_withd_msg { width: 57%;}*/


    .sent_msg p {
        background: #05728f none repeat scroll 0 0;
        border-radius: 3px;
        font-size: 14px;
        margin: 0; color:#fff;
        padding: 5px 10px 5px 12px;
        width:100%;
        text-align: right;
    }
    .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
    .sent_msg {
        float: right;
        width: 46%;
    }
    .input_msg_write input {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        color: #4c4c4c;
        font-size: 15px;
        min-height: 48px;
        width: 100%;
    }

    .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
    .msg_send_btn {
        background: #05728f none repeat scroll 0 0;
        border: medium none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        font-size: 17px;
        height: 33px;
        position: absolute;
        right: 0;
        top: 11px;
        width: 33px;
    }
    .messaging { padding: 0 0 50px 0;}
    .msg_history {
        height: 516px;
        overflow-y: auto;
    }
</style>
<div class="">
    <div class="row" id="content_screen">
        <div class="mesgs">
            <div id="chat_with" style="margin-top: -42px;margin-bottom: 22px;border-bottom: 1px solid black;"></div>
            <div class="msg_history"></div>
            <div class="type_msg">
                <button type="button" class="btn btn-info" id="join_chat" style="text-align: center;">Join Chat</button>
                <div class="input_msg_write" style="display: none;">
                    <input type="text" class="write_msg" placeholder="Type a message" />
                    <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    var loggedInUser = '';
    var receiverID = '';
    var unsubscribe = '';
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
                                userList += '<li class="user" id="' + change.doc.id + '" data-id="' + change.doc.data().user_id + '" data-username="' + username + '">\n\
                                        <a href="javascript:void(0);" class="user_tab">' + username + '</a></li>';
                            }
                            if (change.type === "removed") {
                                $('#' + change.doc.id).remove();
                                $(".chat_with").html('');
                                $(".msg_history").html('');
                                $(".msg_history").html("User has end the chat.");
                                $(".input_msg_write").css("display", "none");
                                $("#join_chat").css("display", "block");
                                receiverID = '';
                            }

                        });
                        $("#chat_user_list").prepend(userList);
                    });
        } else {
            alert("You are not connected with chat server.");
        }

    });
    $(document).on('click', '.user', function () {
        $("#chat_user_list").find("li").removeClass("active");
        var _th = $(this);
        _th.addClass("active");
        var user_id = _th.data('id');
        var user_name = _th.data('username');
        var user_collection = 'Customer_' + user_id;
        receiverID = user_id;
        $(".msg_history").html("");
        $("#chat_with").html("<h4>Chat with " + user_name + "</h4>");
        if (unsubscribe != '') {
            unsubscribe();
        }
//        db.collection('chat_user').where("user_id", '==', user_id.toString()).get().then(function (querySnapshot) {
//            querySnapshot.forEach(function (doc) {
//                console.log(doc.data());
//            });
//        });
        realTime(user_collection);
    });

    function realTime(user_collection) {
        unsubscribe = db.collection('rindex_support/' + user_collection + '/Customer_Chat').orderBy('timeStamp')
                .onSnapshot(function (snapshot) {
                    var newMessage = '';
                    snapshot.docChanges().forEach(function (change) {
                        var timeAgo = timeSince(change.doc.data().timeStamp);
                        if (change.doc.data().senderID != loggedInUser.uid) {
                            newMessage += '<div class="incoming_msg">'
                                    + '<div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"></div>'
                                    + '<div class="received_msg">'
                                    + '<div class="received_withd_msg">'
                                    + '<p>' + change.doc.data().messege + '</p>'
                                    + '<span class="time_date_incoming">'+timeAgo+' ago</span>'
                                    + '</div>'
                                    + '</div>'
                                    + '</div>';
                        } else {
                            newMessage += '<div class="outgoing_msg">'
                                    + '<div class="sent_msg">'
                                    + '<p>' + change.doc.data().messege + '</p>'
                                    + '<span class="time_date_outgoing">'+timeAgo+' ago</span>'
                                    + '</div>'
                                    + '</div>';
                        }
                    });
                    $(".msg_history").append(newMessage);
                    $(".msg_history").scrollTop($(".msg_history")[0].scrollHeight);
                });
    }

    $(document).on('click', '.msg_send_btn', function () {
        if (receiverID != '') {
            var message = $(".write_msg").val();
            var timeStamp = new Date().getTime();

            console.log(receiverID + '==> recever ID.');
            console.log(message);
            if (message == '') {
                alert("message missing");
                return false;
            } else {
                $(".write_msg").val("");
                db.collection('rindex_support/Customer_' + receiverID + '/Customer_Chat').add({
                    chatID: '1',
                    messege: message,
                    receiverID: receiverID.toString(),
                    senderID: loggedInUser.uid,
                    showDate: true,
                    timeStamp: timeStamp.toString(),
                })
                        .then(function (docRef) {
                            console.log("Document written with ID: ", docRef.id);
                        })
                        .catch(function (error) {
                            console.error("Error adding document: ", error);
                        });
            }
        } else {
            alert("Please select user.");
        }
    });

    $(document).on('keyup', '.write_msg', function (e) {
        if (e.which == 13) {
            $(".msg_send_btn").trigger("click");
        }
    });

    $(document).on('click', '#join_chat', function () {
        if (receiverID == '') {
            alert("Please select user.");
        } else {
            $("#join_chat").css("display", "none");
            $(".input_msg_write").css("display", "block");
        }
    });

    function timeSince(date) {

        var seconds = Math.floor((new Date() - date) / 1000);

        var interval = Math.floor(seconds / 31536000);

        if (interval > 1) {
            return interval + " years";
        }
        interval = Math.floor(seconds / 2592000);
        if (interval > 1) {
            return interval + " months";
        }
        interval = Math.floor(seconds / 86400);
        if (interval > 1) {
            return interval + " days";
        }
        interval = Math.floor(seconds / 3600);
        if (interval > 1) {
            return interval + " hours";
        }
        interval = Math.floor(seconds / 60);
        if (interval > 1) {
            return interval + " minutes";
        }
        return Math.floor(seconds) + " seconds";
    }
//    var aDay = 24 * 60 * 60 * 1000
//    console.log(timeSince(new Date(Date.now() - aDay)));
//    console.log(timeSince(new Date(Date.now() - aDay * 2)));
</script>
@endsection
