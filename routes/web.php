<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProudectsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);   //->name('home')->middleware('auth')
///// Invoices
Route::resource('invoices', 'InvoicesController');
Route::get('/edit_invoices/{id}', 'InvoicesController@edit');
Route::get('/section/details/{id}', 'InvoicesController@getproduct');
Route::get('/status_show/{id}', 'InvoicesController@show')->name('status_show');
Route::post('/status_update/{id}', 'InvoicesController@status_update')->name('status_update');
Route::get('paid_bills', 'InvoicesController@paid_bills');
Route::get('unpaid_bills', 'InvoicesController@unpaid_bills');
Route::get('partially', 'InvoicesController@partially');
Route::resource('Archive', 'ArchiveController');

////// Invoices Details
Route::get('/InvoicesDetails/{id}', 'InvoicesDetailsController@InvoicesDetails');

/////// Invoices Attachment
Route::get('/download/{file_name}', 'InvoiceAttachmentsController@get_file');
Route::resource('InvoiceAttachments', 'InvoiceAttachmentsController');
Route::post('delete_file', 'InvoiceAttachmentsController@destroy')->name('delete_file');


/////// section
Route::resource('sections', 'SectionController');
/////// Proudects
Route::resource('proudects', 'ProudectsController');

Route::resource('users', 'usersController');
Route::resource('Role', 'RolesController');



////////////////////////////////////////////////
Route::get('/{page}', [App\http\Controllers\AdminController::class, 'index']);
