@extends('layouts.app')

@section('content')

<main class="container">
    <div class="bg-light p-5 mb-4 rounded text-center">
        <h1>申請リクエストを送りました。</h1>
        <p>ユーザーから承諾を祈りましょう</p>

        <form action="{{ route('pets.show', $want->pet_id) }}" method="post">
            <input type="hidden" value="$want" name="want">
            <button class="btn btn-primary" >戻る</button>
        </form>
    </div>
    <p class="mt-2">ココにサイトの文章が入ります。</p>
</main>

@endsection
