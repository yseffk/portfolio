<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$adminBlogGroupData = [
    'namespace' => 'App\Http\Controllers\Api\Admin',
    'prefix' => 'admin/blog',
    //'middleware' => 'permission:admin'
    'middleware' => 'jwt.auth'
];

$authGroupData = [
    'namespace' => 'App\Http\Controllers\Api\Auth',
    'prefix' => 'auth',
];

$blogShowGroupData = [
    'namespace' => 'App\Http\Controllers\Api',
    'prefix' => 'blog',
];

// Auth routing
Route::group($authGroupData, function () {
    Route::get('/login/{social}', ['uses' => 'LoginController@loginSocial', 'as' => 'auth.login-social', 'middleware' => 'guest']);
    Route::get('/login/{social}/callback', ['uses' => 'LoginController@callbackSocial', 'as' => 'auth.login-social-callback', 'middleware' => 'guest']);
    Route::post('/login/{social}/get-token', ['uses' => 'LoginController@getToken', 'as' => 'auth.login-social-get-token', 'middleware' => 'guest']);
    Route::post('/login', ['uses' => 'LoginController@login', 'as' => 'auth.login', 'middleware' => 'guest']);
    Route::post('/logout', ['uses' => 'LoginController@logout', 'as' => 'auth.logout', 'middleware' => 'jwt.auth']);
    Route::post('/refresh', ['uses' => 'LoginController@refresh', 'as' => 'auth.refresh', 'middleware' => 'jwt.auth']);
    Route::post('/register', ['uses' => 'RegisterController@register', 'as' => 'auth.register', 'middleware' => 'guest']);
});


Route::group($blogShowGroupData, function () {

    Route::resource('posts', 'BlogPostController')
        ->only(
            'show' // return post by slug && item collection
        )->names('blog.posts');

    Route::resource('items', 'BlogItemController')
        ->only(
            'show' // return item by id && attach collection
        )->names('blog.items');

    Route::resource('item-attachments', 'BlogItemAttachmentController')
        ->only(
            'show' // return attach by id
        )->names('blog.item-attachments');

});

Route::group($adminBlogGroupData, function () {
    Route::resource('posts', 'BlogPostController')
        ->except('edit', 'create', 'index')
        ->names('blog.admin.posts');

    Route::resource('items', 'BlogItemController')
        ->except('edit', 'create')
        ->names('blog.admin.items');

    Route::resource('item-attachments', 'BlogItemAttachmentController')
        ->except('edit', 'create')
        ->names('blog.admin.item-attachments');
});
