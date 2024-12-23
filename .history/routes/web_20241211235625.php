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
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\ClientsReportController;
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

Route::post('/change-language', function (\Illuminate\Http\Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('change-language');
//the login page in the home or start page:
Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::middleware(['status'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
Route::resource('roles',RoleController::class);
//this group of routes the role middleware is applied to them (can only be accessed by admins)
Route::group(['middleware' => ['role:Admin']], function() {
    Route::resource('users',UserController::class);
});
    Route::get('/invoices_report',[InvoicesReportController::class,'index']);
    Route::post('/Search_invoices',[InvoicesReportController::class,'search_invoices']);

    Route::get('/clients_report',[ClientsReportController::class,'index']);
    Route::post('/Search_customers',[ClientsReportController::class,'search_clients']);

Route::resource('invoices', InvoicesController::class);
Route::get('/MarkAsRead_all',[InvoicesController::class,'mark_all']);

Route::get('/MarkAsRead/{id}',[InvoicesController::class,'mark']);

Route::resource('Archive', InvoiceArchiveController::class)->middleware('permission:Archived Invoices');

Route::get('/Print_invoice/{id}',[InvoicesController::class,'Print_invoice'])->middleware('permission:Copy Invoice');

Route::get('Invoice_Paid',[InvoicesController::class,'Invoice_Paid'])->middleware('permission:Paid Invoices');

Route::get('Invoice_UnPaid',[InvoicesController::class,'Invoice_UnPaid'])->middleware('permission:UnPaid Invoices');

Route::get('Invoice_Partial',[InvoicesController::class,'Invoice_Partial'])->middleware('permission:Partially Paid Invoices');

Route::resource('sections', SectionsController::class);

Route::resource('products', ProductsController::class);

Route::get('/section/{id}',[InvoicesController::class,'getProducts']);

Route::get('/invoicesDetails/{id}',[InvoicesDetailsController::class,'index']);

Route::resource('/InvoiceAttachments',InvoicesAttachmentsController::class);

//route for showing file in drive:
Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'open_file']);

//route for downloading file
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'get_file']);

//route for deleting file
Route::post('delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');

Route::get('/{page}', [AdminController::class,'index']);

Route::get('edit_invoice/{id}',[InvoicesController::class,'edit']);

Route::get('/Status_show/{id}',[InvoicesController::class,'show'])->name('Status_show');

Route::post('Status_Update/{id}',[InvoicesController::class,'Status_Update'])->name('Status_Update')->middleware('permission:Change Payment Status');










