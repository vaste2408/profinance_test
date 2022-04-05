<?php

use App\Models\UrlModel;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/short/{url}', function ($url) {
    $restoredUrl = (new UrlModel($url))->restoreShortUrl($url);
    if ($restoredUrl) {
        header("Location: $restoredUrl");
        exit;
    }
    return redirect('404');
});
