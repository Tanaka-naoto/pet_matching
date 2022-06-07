<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Want;
use App\Models\Reaction;
use App\Models\User;
use App\Models\ChatRoomUser;
use Illuminate\Http\Request;
use App\Http\Requests\SellRequest;
use App\Http\Requests\WantRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('Pets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellRequest $sellrequest)
    {
        $user = Auth::user();
        $pet = new Pet();

        $pet->name = $sellrequest->input('name');
        $pet->age = $sellrequest->input('age');
        $pet->sex = $sellrequest->input('sex');
        $pet->background = $sellrequest->input('background');
        $pet->kinds = $sellrequest->input('kinds');
        $pet->user_id = $user->id;

        //画像保存
        $file_name = $sellrequest->file('image')->getClientOriginalName();
        $name = date('Ymd_His').'_'.$file_name;
        $file = request()->file('image')->move('storage/pets',$name);
        $pet->image_url = $name;

        $pet->save();

         return redirect()
            ->route('home')
            ->with('message', '引き渡すペットを公開しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Pet $pet)
    {

        // $got_reaction_iddesu = Reaction::where('to_user_id', $pet->user_id )->get();//to_user_idが自分になる


        $got_reaction_ids = Reaction::where('to_user_id', $pet->user_id )
        ->where('pet_id', $pet->id)
        ->pluck('from_user_id');//to_user_idが自分になる

        // dd($got_reaction_ids);
        //自分を好きな人いる？😛　　😍もし自分のことを好きなユーザーがいれば　　
        if(Reaction::where('to_user_id', $pet->user_id)->where('pet_id', $pet->id)->exists())  {

            // dd("申請者がいます");
            //マッチしたユーザーを表示させる為の処理
            //1.自分のことを好きなユーザーを取得する
            $got_reaction_ids = Reaction::where('to_user_id', $pet->user_id )
            ->where('pet_id', $pet->id)
            ->pluck('from_user_id');//to_user_idが自分になる


            //2🥰 自分のことを好きなユーザーから自分も好きなユーザーを取得
            $matching_users = Reaction::whereIn('to_user_id', $got_reaction_ids)
            ->where('from_user_id', $pet->user_id)
            ->where('pet_id', $pet->id)
            ->get(); //自分も好きなユーザー

            //相思相愛のユーザー

            //自分も好きな人いる？😛　＝相思相愛　マッチングが成立している
            if( Reaction::whereIn('to_user_id', $got_reaction_ids)->where('from_user_id', $pet->user_id)->where('pet_id', $pet->id)->exists()) {
                // dd("マッチングしています");
                $flag = true;
                // dd($matching_users);
            //matching_usersは、配列のため、foreachで回し単数の値へ変換
            foreach($matching_users as $matching_user) {

                $matching_id = $matching_user->to_user_id;

            }
            $matching_user = User::find($matching_id);
            // dd($matching_user);

            return view('Pets.show',compact('pet','matching_user', 'matching_id','flag'));

            //自分も好きなユーザーはいない
            }else {

                // dd("貴方のことを好きなユーザーはいますが貴方はその人のことを好きではありません");
                $flag = false;
                return view('Pets.show', compact('pet','flag'));
            }


        //自分のことが好きなユーザーがいなければ
        }else {

            // dd("マッチングしていません");
                $flag = false;

             return view('Pets.show', compact('pet','flag'));

        }


 // dd($matching_id);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        $this->authorize('update', $pet);

        return view('Pets.edit',compact('pet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(SellRequest $sellrequest, Pet $pet)
    {

        $this->authorize('update', $pet);

        $user = Auth::user();
        $pet->name = $sellrequest->input('name');
        $pet->age = $sellrequest->input('age');
        $pet->sex = $sellrequest->input('sex');
        $pet->background = $sellrequest->input('background');
        $pet->kinds = $sellrequest->input('kinds');
        $pet->user_id = $user->id;

        //画像保存
        $file_name = $sellrequest->file('image')->getClientOriginalName();
        $name = date('Ymd_His').'_'.$file_name;
        $file = request()->file('image')->move('storage/pets',$name);
        $pet->image_url = $name;

        $pet->update();

        return redirect()
            ->route('pets.show', compact('pet'))
            ->with('message', '変更を保存しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        $this->authorize('delete', $pet);


        Storage::delete('public/storage/pets/'.$pet->image_url);

        //wantを削除
        $pet->wants()->delete();

        //reactionを削除
        Reaction::where('pet_id', $pet->id)->delete();

        //chat_room_usersを削除
        ChatRoomUser::where('pet_id', $pet->id)->delete();

        //chat_messageを削除
        $pet->chat_messages()->delete();

        //chat_roomを削除
        $pet->room()->delete();

        //投稿を削除
        $pet->delete();

        return redirect()
            ->route('home')
            ->with('message', '引き渡し公開を取り消しました');
    }

    public function want(Pet $pet) {

        // dd($pet->id);
        return view('Pets.want',compact('pet'));
    }

    //ほしい申請取消し
    // public function want_destroy(Pet $pet) {

    //     $user = Auth::user();
    //     $unko = Want::where('user_id', $user->id)->where('pet_id', $pet->id)->get();

    //     $unko->delete();

    //     return redirect()
    //         ->route('home')
    //         ->with('message', '申請を取り消しました');
    // }

    public function requested(WantRequest $want_request) {

        $want = new Want();
        $user = Auth::user();

        // $pet_id = $want_request->input('pet_id');
        // $requestUser = Want::where('user_id', $user->id)->where('pet_id', $pet_id)->get();

        //存在していない場合


            $want->can_keep_reson = $want_request->input('can_keep_reson');
            $want->keep_after = $want_request->input('keep_after');
            $want->user_id = $user->id;
            $want->pet_id = $want_request->input('pet_id');
            $want->save();

        return view('Pets.show',compact('want'))
            ->with('申請リクエストを送信しました');
    }
}
