<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
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

Route::get('/', function () {
    //return view('welcome');
    $a = 5 + 8;
    return $a;
});

/*Route::get('/home/{prenom}', function(){
    //return 'Bienvenue '. request('prenom');// $_GET['prenom'];
    $prenom = request('prenom');
    //return "Bienvenue $prenom";// $_GET['prenom'];
    return view('home',['p'=>$prenom]);
});
*/
Route::get('/contact', function(){
    return view('contact');
});

Route::get('/about', function(){
    return view('about');
});

Route::get('/login', function(){
    return view('login');
});

Route::get('/register', 'App\Http\Controllers\UtilisateurController@afficherFormulaire');

Route::post('/register', 'App\Http\Controllers\UtilisateurController@traiterFormulaire');

Route::get('/utilisateurs', function(){
    $u = App\Models\Utilisateur::all();
    return view('utilisateurs', ['liste_uti'=> $u]);
});

/* 
--------------------------------
--        Application         --
--------------------------------
*/
Route::get('/admin/categories', 'App\Http\Controllers\CategoriesController@displayCategories');
Route::get('/admin/categories/add', 'App\Http\Controllers\CategoriesController@addCategory');
Route::get('/admin/categories/update', 'App\Http\Controllers\CategoriesController@updateCategory');
Route::get('/admin/categories/delete', 'App\Http\Controllers\CategoriesController@deleteCategory');

Route::get('/home','App\Http\Controllers\CategoriesController@getCategories');

/* Article */
Route::get('/admin/items', 'App\Http\Controllers\ArticleController@displayItems');
Route::post('/admin/items/add', 'App\Http\Controllers\ArticleController@addItem');
//Route::post('/admin/items', 'App\Http\Controllers\ArticleController@addItem');
Route::post('/admin/items/update', 'App\Http\Controllers\ArticleController@updateItem');
Route::get('/admin/items/delete', 'App\Http\Controllers\ArticleController@deleteItem');

Route::get('/items/{id}', 'App\Http\Controllers\ArticleController@displayItemsByCategory');

Route::get('/addToCart/{id}', 'App\Http\Controllers\CartController@add');
Route::get('/cart', 'App\Http\Controllers\CartController@displayCart');
Route::get('/cart/delete/{id}', 'App\Http\Controllers\CartController@deleteCart');