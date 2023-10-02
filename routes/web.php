<?php

use App\Http\Controllers\CasController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\MetametaController;
use App\Http\Controllers\UserController;
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

Route::get('/cas/login', [CasController::class, 'login'])->name('cas.login');

Route::middleware('cas.verify')->group(function () {
    Route::get('language/{lang}', [LanguageController::class, 'language'])->name('language');
    Route::get('/cas/info', [CasController::class, 'info'])->name('cas.info');
    Route::post('/cas/logout', [CasController::class, 'logout'])->name('cas.logout');

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('comments', CommentController::class);
    Route::resource('metameta', MetametaController::class);
    Route::resource('users', UserController::class);

    Route::group([
        'prefix'     => 'memos',
        'controller' => MemoController::class,
        'as'         => 'memos.',
    ],function (){
        Route::post('/add/{metametaId?}', 'addMemo')->name('add');
        Route::get('/', 'listMemo')->name('list_memo');
        Route::post('/edit/{id?}', 'editMemo')->name('edit');
        Route::get('/delete/{id?}', 'destroyMemo')->name('delete');
    });

    Route::group([
        'prefix'     => 'metameta',
        'controller' => MetametaController::class,
        'as'         => 'metameta.',
    ],function (){
        Route::delete('delete/{id?}', 'delete')->name('delete');
        Route::post('/{id?}/edit/upload', 'upload')->name('upload_file');
        Route::delete('/{id?}/file', 'deleteFile')->name('delete_file');
        Route::post('/settings','updateSettings')->name('update_settings');
        // Comment
        Route::post('/{metametaId?}/comment/add', 'addComment')->name('add_comment');
        Route::get('/{metametaId?}/comment/{elementId?}', 'listComment')->name('list_comment');
        Route::post('/{metametaId?}/comment/edit/{id?}', 'editComment')->name('edit_comment');
        Route::get('/{metametaId?}/comment/delete/{id?}', 'deleteComment')->name('delete_comment');
        //contact
        Route::post('/contact/add', 'addContact')->name('add_contact');
        Route::post('/contact/edit', 'editContact')->name('edit_contact');
        Route::get('/contact/delete', 'destroyContact')->name('destroy_contact');
        //author
        Route::post('/author/add', 'addAuthor')->name('add_author');
        Route::post('/author/edit', 'editAuthor')->name('edit_author');
        Route::get('/author/delete', 'destroyAuthor')->name('destroy_author');
        //data_application
        Route::post('/data_application/add', 'addDataApplication')->name('add_data_application');
        Route::post('/data_application/edit', 'editDataApplication')->name('edit_data_application');
        Route::get('/data_application/delete', 'destroyDataApplication')->name('destroy_data_application');
    });
});

// Public access file with sanctum token
Route::middleware(['auth:sanctum'])->get('file/{id?}', [MetametaController::class,'previewFile'])->name('preview_file');
