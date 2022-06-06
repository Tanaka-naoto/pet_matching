@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3">
<link href="{{ asset('css/forumu.css') }}" rel="stylesheet">

@endsection


@section('content')
<?php
    // dd($want->reaction);
    // dd($pet->room);
?>
@if(session('message'))

    <div class="alert alert-success">{{session('message')}}</div>

@endif

<div class="album py-5 bg-light">

    <div class="container">

        <div class="col">
          <div class="card shadow-sm">
            <div style="width: 100%; height: 225px;  background: url({{asset('storage/pets/'.$pet->image_url)}})no-repeat center center; background-size:cover;"></div>
            <div class="card-body">
                <img src="{{$pet->user->image_url}}" class="rounded-circle" alt="" style="width: 45px; height: 45px">
                <span>{{$pet->user->name}}</span>
                <p class="card-text">{{ $pet->background }}</p>
              <div class="d-flex justify-content-between align-items-center">

            @can('update', $pet)
                <div class="btn-group">
                    <form method="post" action="{{ route('pets.destroy', $pet) }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-outline-secondary" onclick="return confirm('本当に削除しますか？')" style="margin-left: 10px">削除</button>
                    </form>


                    <a href="{{ route('pets.edit', $pet) }}">
                        <button type="button" class="btn btn-sm btn-outline-secondary">編集</button>
                    </a>
                </div>
            @endcan
                <small class="text-muted">{{$pet->created_at->diffForHumans()}}</small>
              </div>

        <!-- 自分のことを好きなユーザーがいなければ❓ -->
        @if($flag == false)

           <div>誰ともマッチングしていません</div>

        @else

              <!--投稿主だった場合 -->
            @if(Auth::id() == $pet->user_id)
                <div>{{$matching_user->name}}</div>
                <input type="image" src="{{$matching_user->image_url}}" alt="送信する" class="rounded-circle requester_image" style="width: 45px; height: 45px">

                <form method="post" action="{{ route('reaction.destroy', $pet) }}">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger" onclick="return confirm('本当に削除しますか？')" style="margin-left: 10px">マッチング取消</button>
                </form>

                <form  action="{{ route('chat.show',$pet) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success">チャットする</button>
                    <input type="hidden" name="user_id" value="{{$matching_user->id}}">
                </form>

                <!--マッチしたユーザーだった場合 -->
            @elseif(Auth::id() == $matching_id)
            <h1>投稿者とマッチングできました！！！！！</h1>
                <div>{{$pet->user->name}}</div>
                <form  action="{{ route('chat.show',$pet) }}" method="post" class="chat_form">
                    @csrf
                    <input type="image" src="{{$pet->user->image_url}}" alt="送信する" class="rounded-circle requester_image" style="width: 45px; height: 45px">
                    <button type="submit" class="btn btn-success">チャットする</button>
                    <input type="hidden" name="user_id" value="{{ $pet->user_id }}">
                </form>

            @else <div>すでにマッチングしているユーザーがいますが申請できます</div>
            {{-- <input type="image" src="{{$matching_user->image_url}}" alt="送信する" class="rounded-circle requester_image" style="width: 45px; height: 45px"> --}}
            <img src="{{$matching_user->image_url}}" class="rounded-circle" alt="" style="width: 45px; height: 45px">
            @endif
        @endif


              <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                    申請者一覧
                </button>
                <div class="collapse show" id="home-collapse">

                     <!-- パターン2 -->
                  <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                    @foreach ($pet->wants as $want)
                        @if($want->user_id == Auth::id())
                            <div>
                                あなた
                            </div>
                        @endif

                        <form method="post" action="{{ route('want.show', $want) }}" class="osikko">
                            @csrf
                                <input type="hidden" name="petnoid" value="{{ $pet->id }}">
                                <input type="image" src="{{$want->user->image_url}}" alt="送信する" class="rounded-circle requester_image" style="width: 45px; height: 45px">
                        </form>


                        <p>{{$want->user->name}}</p>
                        @if($want->user_id == Auth::id())
                            <form method="post" action="{{ route('want.destroy', $want) }}" style="display: inline-block">
                                <input type="hidden" name="pet" value="{{$pet->id}}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-primary" onclick="return confirm('本当に取消ますか？')">申請取消し</button>
                            </form>
                        @endif

                    @endforeach
                    </ul>

                </div>
              </li>

            @if(!($pet->wants->where('user_id', Auth::id())->isEmpty()) ||  Auth::id() == $pet->user_id )

            @else
            <form method="post" action="{{ route('want.create', $pet) }}">
                @csrf
                <button class="btn btn-primary w-100">育児申請</button>
            </form>
            @endif

            </div>
          </div>
        </div>



    </div>

</div>



 {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> --}}
@endsection
