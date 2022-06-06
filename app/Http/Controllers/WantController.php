<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Want;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\WantRequest;
use App\Models\Reaction;

class WantController extends Controller
{

    public function show(Request $request, Want $want) {


        $got_reaction_ids = Reaction::where('to_user_id', $want->pet->user_id )
        ->where('pet_id', $want->pet->id)
        ->pluck('from_user_id');//to_user_idが自分になる


        // $matching_users = Reaction::whereIn('to_user_id', $got_reaction_ids)
        // ->where('from_user_id', $want->pet->user_id)
        // ->where('pet_id', $want->pet->id)
        // ->get();

        $pet = $request->input('petnoid');


        if(Reaction::whereIn('to_user_id', $got_reaction_ids)
        ->where('from_user_id', $want->pet->user_id)
        ->where('pet_id', $want->pet->id)->exists()) {
            $flag = true;
            // dd("マッチングしています");
            // dd($flag);

            return view('Want.show',compact('want', 'pet','flag'));

        }else {

            // dd("マッチングしていません");
            $flag = false;
            // dd($flag);
        return view('Want.show',compact('want', 'pet','flag'));
        }


    }



    public function create(Pet $pet) {

        return view('Want.create', compact('pet'));
    }


    public function store(WantRequest $want_request, Pet $pet) {

        $want = new Want();
        $reaction = new Reaction();
        $user = Auth::user();

        //申請テーブル
        $want->can_keep_reson = $want_request->input('can_keep_reson');
        $want->keep_after = $want_request->input('keep_after');
        $want->user_id = $user->id;
        $want->pet_id = $pet->id;

        //リアクションテーブル
        $reaction = Reaction::create([
            'to_user_id' => $want_request->input('to_user_id'),
            'from_user_id' => Auth::id(),
            'pet_id' => $pet->id,
        ]);

        $want->save();


        // $pet = $want_request->input('pet_id');

        return redirect()
        ->route('pets.show', compact('pet'))
        ->with('申請リクエストを送信しました');

        // return view('Pets.show', compact('pet'))
        //     ->with('message','申請リクエストを送信しました');

    }

    public function edit(Request $request, Want $want) {

        $this->authorize('update', $want);

        $pet = $request->input('pet_id');


        return view('Want.edit', compact('want', 'pet'));
    }

    // public function update(Request $want_request, Want $requester) {

    //     $this->authorize('update', $requester);
    //     $user = Auth::user();


    //     $requester->can_keep_reson = $want_request->input('can_keep_reson');
    //     $requester->keep_after = $want_request->input('keep_after');
    //     $requester->user_id = $user->id;
    //     $requester->pet_id = $want_request->input('pet_id');

    //     $requester->save();
    //     $pet =  $want_request->input('pet_id');

    //     // return redirect()
    //     // ->route('want.show', compact('requester'))
    //     // ->with('message', '申請リクエストを編集しました');

    //     return view('Want.show', compact('requester', 'pet'))
    //         ->with('message', '申請リクエストを編集しました');

    // }

    public function update(Request $want_request, Want $want) {

        $this->authorize('update', $want);
        $user = Auth::user();

        $want->can_keep_reson = $want_request->input('can_keep_reson');
        $want->keep_after = $want_request->input('keep_after');
        $want->user_id = $user->id;
        $want->pet_id = $want_request->input('pet_id');

        $want->update();
        $pet =  $want_request->input('pet_id');

        // return redirect()
        // ->route('want.show', compact('want'))
        // ->with('message', '申請リクエストを編集しました');

        return view('Want.show', compact('want', 'pet'))
            ->with('message', '申請リクエストを編集しました');

    }

    public function destroy(Request $request, Want $want) {

        $this->authorize('delete', $want);

        $pet = $request->input('pet');

        //追加　wantに紐づいたreactionテーブルを削除
        $wanter_reactions = $want->reaction->where('pet_id', $pet);
        foreach($wanter_reactions as $wanter_reaction) {

            $wanter_reaction->delete();
            // dd("正常に削除されました。");
        }


        $want->delete();

        return redirect()
            ->route('pets.show',compact('pet'))
            ->with('message', '申請リクエスト取り消しました');

    }


}
