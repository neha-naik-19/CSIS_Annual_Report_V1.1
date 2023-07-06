<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/login', function () {
//     return view('login');
// });

Route::get('/login-alert', function () {
    return view('auth.loginalert');
});

/* Page Expired Route */
// Route::get('/CS-IS/login-expire', function () {
//     return view('pageexpired');
// });

Auth::routes();

// LOGIN
Route::get('login/{website}', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider']);
Route::get('login/{website}/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);
//

// HOME
Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('department', [App\Http\Controllers\HomeController::class, 'displayDepartment']);
Route::post('postdepartmentid', [App\Http\Controllers\HomeController::class, 'postdepartmentid']);
Route::get('displayDepartmentForEveryYear', [App\Http\Controllers\HomeController::class, 'displayDepartmentForEveryYear']);
//

// PUBLICATION - ADD
Route::get('/publication/add',   [App\Http\Controllers\Publication\AddController::class, 'index'])->name('publication.add');
Route::get('showarticle', [App\Http\Controllers\Publication\AddController::class, 'showarticle']);

Route::post('gettitle', [App\Http\Controllers\Publication\AddController::class, 'get_title_data']);
Route::get('check_title_duplication', [App\Http\Controllers\Publication\AddController::class, 'check_dup_title']);

Route::post('getconference', [App\Http\Controllers\Publication\AddController::class, 'get_conference_data']);
Route::get('check_conference_duplication', [App\Http\Controllers\Publication\AddController::class, 'check_dup_conference']);
Route::post('writetodb', [App\Http\Controllers\Publication\AddController::class, 'store']);
//


// PUBLICATION - EDIT
Route::get('/publication/view-edit',  [App\Http\Controllers\Publication\EditController::class, 'index'])->name('publication.edit');
Route::get('editviewauthorsearch', [App\Http\Controllers\Publication\EditController::class, 'showauthor']);
Route::post('displaysearch',[App\Http\Controllers\Publication\EditController::class, 'getsearchresult']);
Route::post('deletesearch/{id}', [App\Http\Controllers\Publication\EditController::class, 'deleterecord']);
//


// PUBLICATION - UPDATE
Route::get('/publication/update',  [App\Http\Controllers\Publication\UpdateController::class, 'index'])->name('publication.update');
Route::post('updatetodb', [App\Http\Controllers\Publication\UpdateController::class, 'store']);
//


// PUBLICATION - BIBTEX
Route::get('/publication/bibtex', [App\Http\Controllers\Publication\BibtexController::class, 'index'])->name('publication.bibtex');
Route::post('getfiledata', [App\Http\Controllers\Publication\BibtexController::class, 'get_file_data']);
Route::get('parsebibdata', [App\Http\Controllers\Publication\BibtexController::class, 'parse_bib_data']);
Route::post('writebibtodb', [App\Http\Controllers\Publication\BibtexController::class, 'store']);
Route::get('check_title_duplication_bib', [App\Http\Controllers\Publication\AddController::class, 'check_dup_title']);
Route::get('check_conference_duplication_bib', [App\Http\Controllers\Publication\AddController::class, 'check_dup_conference']);
//

// PUBLICATION - PRINT
Route::get('/publication/print', [App\Http\Controllers\Publication\PrintController::class, 'index'])->name('publication.print');
Route::get('printauthorsearch', [App\Http\Controllers\Publication\PrintController::class, 'showauthor']);
Route::post('printrequest',[App\Http\Controllers\Publication\PrintController::class, 'getprintfromjs']);
Route::get('dynamic_pdf/pdf', [App\Http\Controllers\Publication\PrintController::class, 'loadpdf']);
Route::get('dynamic_word/wordexport', [App\Http\Controllers\Publication\PrintController::class, 'createworddocx']);
//


