<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/chat/chat', 'ChatController@chat')->name('chat.chat');
Auth::routes();





Route::middleware('auth')->group(function () {
    //ログイン後に行くページ
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});



Route::name('pets.')//nameをuse
    ->prefix('pets') //URLをuse
    ->middleware('auth')
    ->group(function () {

    Route::get('{pet}', 'PetController@show')->name('show')
    ->where('pet', '[0-9]+');

    Route::get('create', 'PetController@create')->name('create');
    Route::post('store', 'PetController@store')->name('store');
    Route::get('{pet}/edit', 'PetController@edit')->name('edit');
    Route::put('{pet}/update', 'PetController@update')->name('update');
    Route::delete('{pet}/destroy', 'PetController@destroy')->name('destroy');

    //     //申請取り消し
    // Route::delete('{want}/aiuo/destroy', 'PetController@want_destroy')->name('want_delete')
    // ->where('pet', '[0-9]+');

});

Route::name('want.')//nameをuse
    ->prefix('want') //URLをuse
    ->middleware('auth')
    ->group(function () {

    //申請リクエスト
    Route::post('{pet}/create', 'WantController@create')->name('create')
    ->where('pet', '[0-9]+');

    //ペット申請保存
    Route::post('{pet}store', 'WantController@store')->name('store')
    ->where('pet', '[0-9]+');

    //ペット申請編集
    Route::post('{want}edit', 'WantController@edit')->name('edit')
    ->where('want', '[0-9]+');

    //ペット申請更新
    Route::put('{want}/update', 'WantController@update')->name('update')
    ->where('want', '[0-9]+');

    //申請取り消し
    Route::delete('{want}/destroy', 'WantController@destroy')->name('destroy')
    ->where('want', '[0-9]+');

    //申請者詳詳細画面
    Route::post('{want}/show', 'WantController@show')->name('show')
    ->where('want', '[0-9]+');

    });

    Route::name('reaction.')//nameをuse
    ->prefix('reaction') //URLをuse
    ->middleware('auth')
    ->group(function () {

    //ペット申請保存
    Route::post('store', 'ReactionController@store')->name('store');

    //マッチング取消
    Route::delete('{pet}/destory', 'ReactionController@destroy')->name('destroy');

    });


    Route::name('chat.')//nameをuse
    ->prefix('chat') //URLをuse
    ->middleware('auth')
    ->group(function () {

    Route::post('{pet}/show', 'ChatController@show')->name('show');

    });








