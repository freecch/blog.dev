<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'Page: about';
});

Route::get('/contact', function () {
    return 'Page: contact';
});

Route::get('/post/{id}/{name}', function ($id, $name) {
    return "Page: Contact: " . $id . ", Name: " . $name;
});

Route::get('/admin/posts/demo', array("as" => "admin.demo", function () {
    return "Page: admin demo";
}));

/*
Route::get('/demo', function () {
    // return view('welcome');
    return "Hello, World";
});
*/
