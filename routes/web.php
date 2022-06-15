<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//User Chat Routes
Route::middleware('auth')->group(function(){
    Route::get('messages/{id?}', [App\Http\Controllers\MessagesController::class, 'index'])->name('chat.index');
    Route::post('/sendMessage', [App\Http\Controllers\MessagesController::class, 'send'])->name('send.message');
    Route::post('/updateSettings', [App\Http\Controllers\MessagesController::class, 'updateSettings'])->name('avatar.update');
    Route::post('/chat/auth', [App\Http\Controllers\MessagesController::class, 'pusherAuth'])->name('pusher.auth');
    Route::post('messages/getContacts', [App\Http\Controllers\MessagesController::class, 'getContacts'])->name('contacts.get');
    Route::post('/messages/updateContacts', [App\Http\Controllers\MessagesController::class, 'updateContactItem'])->name('contacts.update');

    /**
     * Set active status
     */
    Route::post('messages/setActiveStatus', [App\Http\Controllers\MessagesController::class, 'setActiveStatus'])->name('activeStatus.set');
    Route::post('messages/favorites', [App\Http\Controllers\MessagesController::class, 'getFavorites'])->name('favorites');
    /**
     * Get shared photos
     */
    Route::post('messages/shared', [App\Http\Controllers\MessagesController::class, 'sharedPhotos'])->name('shared');
    Route::post('messages/idInfo', [App\Http\Controllers\MessagesController::class, 'idFetchData']);
    Route::post('messages/fetchMessages', [App\Http\Controllers\MessagesController::class, 'fetch'])->name('fetch.messages');
    /**
     * Make messages as seen
     */
    Route::post('messages/makeSeen', [App\Http\Controllers\MessagesController::class, 'seen'])->name('messages.seen');
    /**
     * Search in messenger
     */
    Route::post('messages/search', [App\Http\Controllers\MessagesController::class, 'search'])->name('search');
    /**
     * Update Settings
     */
    Route::post('messages/updateSettings', [App\Http\Controllers\MessagesController::class, 'updateSettings'])->name('avatar.update');
    /**
     * Delete Conversation
     */
    Route::post('messages/deleteConversation', [App\Http\Controllers\MessagesController::class, 'deleteConversation'])->name('conversation.delete');
    /**
     * Download attachments route to create a downloadable links
     */
    Route::get('/download/{fileName}', [App\Http\Controllers\MessagesController::class, 'download'])->name(config('chat.attachments.download_route_name'));

});

