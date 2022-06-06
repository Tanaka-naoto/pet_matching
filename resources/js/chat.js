$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    $('.messageInputForm_input').keypress(function (event) {
        if(event.which === 13){
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/chat/chat',
                data: {
                    chat_room_id: chat_room_id,
                    user_id: user_id,
                    message: $('.messageInputForm_input').val(),
                },

            })

            .done(function(data){
                //console.log(data);
                event.target.value = '';
            });

        }
    });


    window.Echo.channel('ChatRoomChannel')
    .listen('ChatPusher', (e) => {
        console.log(e, e.message.user_id);
        if(e.message.user_id === user_id){
            console.log(true);
        $('.messages').append(

            '<p class="text-xs text-right">' + current_user_name + '</p><li class="commonmessage self auth">'
            + e.message.message + '</li>');
        }else{
            console.log(false);
        $('.messages').append(

            '<p class="text-xs">' + chat_room_user_name + '</p><li class="commonmessage other">'
            + e.message.message + '</li>');
        }
    });

    // window.Echo.channel('ChatRoomChannel')
    // .listen('ChatPusher', (e) => {
    //     console.log(e, e.message.user_id);
    //     if(e.message.user_id === user_id){
    //         console.log(true);
    //     $('.messages').append(
    //         '<div class="message"><span>' + current_user_name +
    //         ':</span><div class="commonMessage"><div>' +
    //         e.message.message + '</div></div></div>');
    //     }else{
    //         console.log(false);
    //     $('.messages').append(
    //         '<div class="message"><span>' + chat_room_user_name +
    //         ':</span><div class="commonMessage"><div>' +
    //         e.message.message + '</div></div></div>');
    //     }
    // });


});
