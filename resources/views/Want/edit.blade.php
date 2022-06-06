@extends('layouts.app')

@section('content')

<div class="container">
    <main>
      <div class="py-5 text-center">
        <h2>ペット育児決意フォーム編集</h2>
      </div>

        <!-- エラーメッセージ-->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors ->all() as $error)
                    <li>{{$error}}</li>
                @endforeach

            </ul>
        </div>
    @endif

    @if(session('message'))
        <div class="alert alert-success">{{session('message')}}</div>
    @endif

        <div class="col-md-7 col-lg-8 mx-auto">

            <form method="POST" action="{{ route('want.update',$want) }}">
                @csrf
                @method('put')
                <input type="hidden" name="pet_id" value="{{$pet}}">
            <div class="row g-3">

            <div class="col-12">
                <label for="givenName" class="form-label">飼える根拠
                </label>
                <textarea type="text" rows="10" class="form-control" name="can_keep_reson" id="givenName" placeholder="" value="" required>{{old('can_keep_reson',$want->can_keep_reson)}}</textarea>
            </div>

            <div class="col-12">
                <label for="givenName" class="form-label">飼った後どう育てるか
                </label>
                <textarea type="text" rows="10" class="form-control" name="keep_after" id="givenName" placeholder="" value="" required>{{old('keep_after',$want->keep_after)}}</textarea>
            </div>
            <button class="w-100 btn btn-primary btn-lg">引き渡し申請</button>
          </form>
        </div>
    </main>
</div>
@endsection
