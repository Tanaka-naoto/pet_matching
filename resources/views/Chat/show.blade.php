@extends('layouts.app')


@section('content')

<div class="chatPage">
  <header class="header">

    <div class="chatPartner">
        <div>相手</div>
        <div class="chatPartner_img"><img src="{{asset('storage/images/'.$chat_room_user->image_url)}}"></div>
      <div class="chatPartner_name">{{ $chat_room_user -> name }}</div>
    </div>


  </header>
  <div class="container">

    <div class="messagesArea messages">

        @foreach($chat_messages as $message)
            @if($message->user_id == Auth::id())
                <p class="text-xs text-right">{{Auth::user()->name}}</p>
            @else
                <p class="text-xs">{{$chat_room_user_name}}</p>
            @endif

            @if($message->user_id == Auth::id())

                <li class="commonmessage self auth" >
                    {{$message->message}}
                </li>
            @else
                <li class="commonmessage other" >
                    {{$message->message}}
                </li>
            @endif
        @endforeach

    </div>

    {{-- <div class="bg_2">
        <div class="bg_rgba">
            <div class="bg_text">background-image</div>
        </div>
    </div> --}}


    <form class="messageInputForm">
        <div class="msg_wrp">
            <textarea type="text" data-behavior="chat_message" class="col-8 messageInputForm_input" placeholder="メッセージを入力..."></textarea>
        </div>


      </form>


  </div>

</div>

<script>
var chat_room_id = {{ $chat_room_id }};
var user_id = {{ Auth::user()->id }};
var current_user_name = "{{ Auth::user()->name }}";
var chat_room_user_name = "{{ $chat_room_user_name }}";
</script>

<script src="{{ asset('js/app.js') }}"></script>

@endsection

