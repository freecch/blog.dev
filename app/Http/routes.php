<?php

use App\Post;
use App\User;
use App\Role;
use App\Country;

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

Route::get('read', function() { 
    
    $posts = Post::all();

    /*
    $posts = Post::where('is_admin', 0)
                ->orderBy('id', 'desc')
                ->take(2)
                ->get();
    */

    // $post = Post::find(102);

    // $post = Post::where('is_admin' ,0) -> first();

    // return $post->title;

    return $posts;

    /*
    foreach ($posts as $post) {
        echo $post->id . ": " . $post->title . "<br>\n";
    }
    */
});

Route::get('insert/{title}/{fulltext}', function($title, $fulltext) {

    $post = new Post;

    $post->title = "$title";
    $post->fulltext = "$fulltext";

    $post->save();
});

Route::get('update/{id}/{title}/{fulltext}', function($id, $title, $fulltext) {
    /*
    $post = Post::find($id);
    $post->title = "$title";
    $post->fulltext = "$fulltext";
    $post->save();
    */

    Post::where('id', $id)->where('is_admin', 0)
        ->update([
            'title' => $title,
            'fulltext' => $fulltext
        ]);
});

Route::get('create', function() {

    Post::create([
        'title' => 'test106',
        'fulltext' => 'content106'
    ]);
    
});

/*
Route::get('insert', function() {
    // DB::insert('INSERT INTO posts(title, `fulltext`) VALUES ("xxxx", "yyyy")');
    DB::insert('INSERT INTO posts(title, `fulltext`) VALUES (?, ?)', ['zzzz', 'aaaa']);
});

Route::get('read', function() { 
    // $results = DB::select('SELECT * FROM posts WHERE id = 1');
    $results = DB::select('SELECT * FROM posts WHERE id = ?', [2]);
    // return $results;
    foreach ($results as $result) {
        // return $result->title;
        // echo $result->title . "<br>\n";
        // echo $result->fulltext . "<br>\n";
        var_dump($results);
    }
});

Route::get('update', function() {
    $sql = DB::update('UPDATE posts SET title = "Nice Wether" WHERE id = ?', [1]);
    var_dump($sql);
});

Route::get('delete', function() {
    $sql = DB::delete('DELETE FROM posts WHERE id = ?', [2]);
    var_dump($sql);
});
*/

/*
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

Route::get('/demo', function () {
    // return view('welcome');
    return "Hello, World";
});
*/

// Route::get('/post/{id}', 'PostsController@index');

Route::resource('posts', 'PostsController');

Route::get('contact', 'PostsController@showContact');

Route::get('/post/{category}/{date}/{id}', 'PostsController@showPost');

Route::get('/delete/{id}', function($id) {
// Route::get('/delete', function() {

        $post = Post::find($id);
        $post->delete();
        // Post::destroy([101, 103, 105]);
});

Route::get('readall', function() {
    $posts = Post::withTrashed()->get();
    return $posts;
});

Route::get('onlytrash', function() {
    $posts = Post::onlyTrashed()->get();
    return $posts;
});

Route::get('restore', function() {

    Post::onlyTrashed()->restore();

});

Route::get('forcedelete/{id}', function($id) {

    Post::onlyTrashed()->forceDelete();
    
});

Route::get('user/{userid}/post', function($userid) {
    
    return User::find($userid)->post->title;
});

Route::get('user/{userid}/posts', function($userid) {
    
    $user = User::find($userid);

    foreach ($user->posts as $post) {
        echo $post->title . "<br>\n";
    }
});

Route::get('post/{postid}/user', function($postid) {
    
    return Post::find($postid)->user->name;
});

Route::get('user/{userid}/role', function($userid) {

// 取用roles屬性
/*    
    $user = User::find($userid);
    echo $user->name . " Your Privilege: <br>\n";
    foreach ($user->roles as $role) {
        echo $role->name . "<br>\n";
    }
*/
    // 呼叫roles()方法
    $role = User::find($userid)->roles()->orderBy('id', 'desc')->get();
    return $role;
});

Route::get('role/{roleid}/user', function($roleid) {
    
    $user = Role::find($roleid)
        ->users()
        ->orderBy('id', 'desc')
        ->get();

    return $user;
});

Route::get('country/{countryid}/posts', function($countryid) {
    
    $country = Country::find($countryid);

    foreach ($country->posts as $post) {
        echo $post->title . "<br>\n";
    }
});

Route::get('user/{userid}/photo', function($userid) {
    
    $user = User::find($userid);

    foreach ($user->photos as $photo) {
        return $photo;
        // echo $photo->path;
    }
});

Route::get('post/{postid}/photos', function($postid) {

    $post = Post::findOrFail($postid);
    echo "文章標題︰" . $post->title . "<br>\n";

    echo "圖片路徑︰" . "<br>\n";
    foreach ($post->photos as $photo) {
        echo $photo->path . "<br>\n";
    }
});