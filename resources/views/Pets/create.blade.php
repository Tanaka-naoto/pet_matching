@extends('layouts.app')

@section('content')

<div class="container">
    <main>
      <div class="py-5 text-center">
        <h2>ペット引き渡しフォーム</h2>
      </div>

        <!-- エラーメッセージ-->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors ->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
                @if(empty($errors->first('image')))
                    <li>画像ファイルがあれば再度選択してください</li>
                @endif
            </ul>
        </div>
    @endif

    @if(session('message'))
        <div class="alert alert-success">{{session('message')}}</div>
    @endif

        <div class="col-md-7 col-lg-8 mx-auto">

            <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data">
                @csrf

            <div class="row g-3">

              <div class="col-sm-6">
                <label for="givenName" class="form-label">ペットのお名前</label>
                <input type="text" class="form-control" id="givenName" placeholder="ポチ" name="name" value="" required>
               </div>

               <hr class="my-4">
              <div class="col-sm-6">
                <label for="image" class="col-md-4 col-form-label">{{ __('ペットの画像') }}</label>
                    <input id="image" type="file" class="form-control" name="image"  accept="image/jpeg, image/png" required >
            </div>

            <hr class="my-4">

            <div class="col-12">
                <label for="givenName" class="form-label">手放す理由
                </label>
                <textarea type="text" rows="10" class="form-control" name="background" id="givenName" placeholder="" value="" required></textarea>
            </div>

            <hr class="my-4">
            <div class="col-4">
                <label for="givenName" class="form-label">ペットの年齢</label>
                <input type="number" class="form-control" name="age" id="givenName" placeholder="" value="" required>
              </div>

              <hr class="my-4">
               <!-- 性別 -->
               <div class="col-sm-6">
                <label for="image" class="col-md-4 col-form-label">性別</label>

                <div class="col-md-6 col-form-label">
                    <input class="form-check-input" name="sex" value="0" type="radio" id="inlineRadio1" checked>
                    <label class="form-check-label" for="inlineRadio1" style="margin-right: 3%">オス</label>

                    <input class="form-check-input" name="sex" value="1" type="radio" id="inlineRadio2">
                    <label class="form-check-label" for="inlineRadio2">メス</label>

                </div>
            </div>
              <hr class="my-4">
              <div class="col-sm-6">
                <label for="givenName" class="form-label">ペットの種類</label>
                <input type="text" class="form-control" id="givenName" name="kinds" placeholder="犬、猫、金魚、鳥など" value="" required>
              </div>
            <button class="w-100 btn btn-primary btn-lg" type="submit">申請</button>
          </form>
        </div>
    </main>
</div>
@endsection
