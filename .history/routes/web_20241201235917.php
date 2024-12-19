<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Models\Invoices;

/*0
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//the login page in the home or start page:
Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
//to disable registration:
//Auth::routes(['register'=>false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('roles',RoleController::class);
//this group of routes the auth middleware is applied to them
Route::group(['middleware' => ['role:Admin']], function() {
    Route::resource('users',UserController::class);
    });


Route::resource('invoices', InvoicesController::class);

Route::resource('Archive', InvoiceArchiveController::class)->middleware('Archived Invoices');

Route::get('/Print_invoice/{id}',[InvoicesController::class,'Print_invoice'])->middleware('permission:Copy Invoice');

Route::get('Invoice_Paid',[InvoicesController::class,'Invoice_Paid'])->middleware('permission:Paid Invoices');

Route::get('Invoice_UnPaid',[InvoicesController::class,'Invoice_UnPaid'])->middleware('permission:UnPaid Invoice');

Route::get('Invoice_Partial',[InvoicesController::class,'Invoice_Partial'])->middleware('permission:Partially Paid Invoice');

/Route::resource('sections', SectionsController::class);

/Route::resource('products', ProductsController::class);

Route::get('/section/{id}',[InvoicesController::class,'getProducts']);

Route::get('/invoicesDetails/{id}',[InvoicesDetailsController::class,'index']);

/Route::resource('/InvoiceAttachments',InvoicesAttachmentsController::class);

//route for showing file in drive:
Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'open_file']);

//route for downloading file
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'get_file']);

//route for deleting file
Route::post('delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');

Route::get('/{page}', [AdminController::class,'index']);

Route::get('edit_invoice/{id}',[InvoicesController::class,'edit']);

Route::get('/Status_show/{id}',[InvoicesController::class,'show'])->name('Status_show');

Route::post('Status_Update/{id}',[InvoicesController::class,'Status_Update'])->name('Status_Update');






