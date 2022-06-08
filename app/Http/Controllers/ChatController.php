<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Models\ChatRoom;
use App\Models\Pet;
use App\Models\ChatRoomUser;
use App\Models\ChatMessage;
use App\Models\User;
use App\Events\ChatPusher;

use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public static function show(Pet $pet, Request $request) {

        // dd($pet->id);
        $matching_user_id = $request->user_id;

        // 自分の持っているチャットルームを取得
        $current_user_chat_rooms = ChatRoomUser::where('user_id', Auth::id())
        ->pluck('chat_room_id');

        // 自分の持っているチャットルームからチャット相手のいるルームを探す
        $chat_room_id = ChatRoomUser::whereIn('chat_room_id', $current_user_chat_rooms)
            ->where('user_id', $matching_user_id)
            //投稿に応じたチャットルームを探す
            ->where('pet_id', $pet->id)
            ->pluck('chat_room_id');

        // dd($chat_room_id);
        // なければ作成する
        if ($chat_room_id->isEmpty()){

            ChatRoom::create(); // チャットルーム作成

            $latest_chat_room = ChatRoom::orderBy('created_at', 'desc')->first(); // 最新チャットルームを取得
            // dd($latest_chat_room);
            $chat_room_id = $latest_chat_room->id;

            ChatRoomUser::create (
            [
                'chat_room_id' => $chat_room_id,
                'user_id' => Auth::id(),
                //追加
                'pet_id' => $pet->id
            ]
        );

            ChatRoomUser::create (
            [
                'chat_room_id' => $chat_room_id,
                'user_id' => $matching_user_id,
                //追加
                'pet_id' => $pet->id
            ]
        );

        //追加
        $pet->chat_room_id = $chat_room_id;
        $pet->save();
        }

        if(is_object($chat_room_id)){

            $chat_room_id = $chat_room_id->first();
        }

        //matchingしたユーザー情報を取得
        $chat_room_user = User::findOrFail($matching_user_id);

        //matchingしたユーザーの名前を取得
        $chat_room_user_name = $chat_room_user->name;

        $chat_messages = ChatMessage::where('chat_room_id', $chat_room_id)
        ->orderby('created_at')
        ->get();

        return view('Chat.show',
        compact('chat_room_id', 'chat_room_user',
        'chat_messages','chat_room_user_name'));
    }

    // この行から下を追加します。
    //Chat.jsからの情報を受け取る
    public static function chat(Request $request){

        $chat = new ChatMessage();
        $chat->chat_room_id = $request->chat_room_id;
        $chat->user_id = $request->user_id;
        $chat->message = $request->message;
        $chat->save();

        event(new ChatPusher($chat));
    }
}
