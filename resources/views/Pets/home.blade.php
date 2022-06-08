@extends('layouts.app')

@section('css')
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"> --}}
    <link href="{{ asset('css/forumu.css') }}" rel="stylesheet">
@endsection

@section('content')

@if(session('message'))

    <div class="alert alert-success">{{session('message')}}</div>

@endif


  <!-- カルーセル
    ================================================== -->
  <main>
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
      <!-- インジケータ -->
    <div class="carousel-indicators">
      <button type="button" id="gazou1" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="スライド 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="スライド 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="スライド 3"></button>
    </div>
      <div class="carousel-inner">

        <!-- 1 -->
        <div class="carousel-item active" id="TopVisual_1">

          <div class="container">
            <div class="carousel-caption text-start">
              <h1 class="title">ペットマッチング</h1>
              <p class="subtitle">ペットは大切な家族です。よく考えて利用しましょう</p>
              <p><a class="btn btn-primary" href="#">本日登録</a></p>
            </div>
          </div>
        </div>

        <!-- 2 -->
        <div class="carousel-item" id="TopVisual_2" >

          <div class="container">
            <div class="carousel-caption">
              <h1 class="title">ペットマッチング</h1>
              <p class="subtitle">引き取った後は必ずしっかりと育てましょう</p>
              <p><a class="btn btn-primary" href="#">もっと学ぼう</a></p>
            </div>
          </div>
        </div>

        <!-- 3 -->
        <div class="carousel-item" id="TopVisual_3" >

          <div class="container">
            <div class="carousel-caption text-end">
              <h1 class="title">ペット問題解決アプリ</h1>
              <p class="subtitle">ペットが幸せになることをの望みましょう</p>
              <p><a class="btn btn-primary" href="#">ギャラリーを閲覧</a></p>
            </div>
          </div>
        </div>

      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">前へ</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">次へ</span>
      </button>
    </div><!-- /.carousel -->

    <!-- マーケティングメッセージングとフィーチャー
      ================================================== -->
    <!-- 残りのページを別のコンテナで囲んで、すべてのコンテンツを中央に配置 -->
    <div class="container marketing">
      <!-- カルーセルの下にある3列のテキスト -->



      <div class="row">
        @foreach($pets as $pet)
            <div class="col-lg-4">

            {{-- <svg style="background: url({{$pet->image_url}}); " class="pet-image bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                <title>一般的なプレースホルダ画像</title>

                <rect fill="#777" width="100%" height="100%" style="background: url({{$pet->image_url}}"/>
            </svg> --}}

            <div class="pet-image bd-placeholder-img rounded-circle" width="140" height="140" style="background: url({{asset('storage/pets/'.$pet->image_url)}})no-repeat center center; background-size:cover; width: 140px; height: 140px; margin: 0 auto;" preserveAspectRatio="xMidYMid slice"></div>

            {{-- <div style="width: 200px; height: 200px; background: url({{$pet->image_url}});"></div> --}}

            <h2>{{$pet->name}}</h2>
            <p class="text-left">{{ $pet->age }}歳</p>
            @if($pet->sex == 0)
            <p>オス</p>
            @else
            <p>メス</p>
            @endif
            <p>{{Str::limit($pet->background, 40, '..')}}</p>
            <p><a class="btn btn-secondary" href="{{ route('pets.show', $pet) }}">詳細を見る &raquo;</a></p>
            </div><!-- /.col-lg-4 -->
        @endforeach
      </div><!-- /.row -->



  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> --}}

@endsection
