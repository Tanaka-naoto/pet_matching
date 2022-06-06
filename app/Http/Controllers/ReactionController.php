<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    public function store(Request $request) {

        $reaction = Reaction::create([
            'to_user_id' => $request->input('to_user_id'),
            'from_user_id' => Auth::id(),
            'pet_id' => $request->input('pet_id'),
        ]);

        $pet =  $request->input('pet_id');

        return redirect()
            ->route('pets.show', compact('pet'));

    }


    public function destroy(Pet $pet) {



        $delete_matching = Reaction::where('pet_id', $pet->id)
                                    ->where('from_user_id', Auth::id())->delete();
        return redirect()
                ->route('pets.show', compact('pet'));

    }
}
