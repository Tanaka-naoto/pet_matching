@extends('layouts.app')
@section('css')
<link href="{{ asset('css/forumu.css') }}" rel="stylesheet">
@endsection


@section('content')

<?php
    // dd($want->reaction->where('pet_id', $pet));
?>
<div class="container marketing mt-3">

    <img src="{{asset('storage/images/'.$want->user->image_url)}}" class="rounded-circle" alt="" style="width: 55px; height: 55px">
    <div class="text-center">{{$want->user->name}}</div>
    <div class="box30">
        <div class="box-title">飼える根拠</div>
        <p>{{ $want->can_keep_reson }}</p>
    </div>

    <div class="box30">
        <div class="box-title">飼った後どうするか</div>
        <p>{{ $want->keep_after }}</p>
    </div>

    <div class="wrp d-flex">
        <a href="{{ route('pets.show', $pet) }}">
            <button class="btn btn-primary">戻る</button>
        </a>
    @can('update', $want)<!-- Policy-->
        <span class="ml2">
            <form  method="post" action="{{ route('want.edit', $want) }}">
                @csrf
                <input type="hidden" name="pet_id" value="{{ $pet }}">
                <button class="btn btn-danger" style="margin-left: 4px">編集</button>
            </form>
        </span>
    @endcan
            <?php
                // dd($flag);
            ?>

        <!-- 投稿者かつまだマッチングしていない場合にボタンを表示-->
        @if(Auth::id() == $want->pet->user_id  && $flag == false)

            <span style="margin-left: auto">
                <form  method="post" action="{{ route('reaction.store') }}">
                    @csrf
                    <input type="hidden" name="pet_id" value="{{ $pet }}">
                    <input type="hidden" name="to_user_id" value="{{$want->user_id}}">
                    <button class="btn btn-danger" style="background: #ff0e99; border-radius: 1.25rem">マッチングしてチャットする</button>
                </form>
            </span>
        @endif




    </div>


    {{-- <p>{{$want->pet->user->id}}</p> --}}



</div>



@endsection
