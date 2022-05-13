<?php

use App\Http\Controllers\WebDavController;
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

Route::addRoute('OPTIONS', '/{any}', [WebDavController::class, 'options'])->where('any', '.*');
Route::addRoute('PROPFIND', '/{any}', [WebDavController::class, 'propfind'])->where('any', '.*');
