<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use App\Http\Controllers\AdminController;
Route::get('/', [TourController::class, 'index']);
Route::get('/tours', [TourController::class, 'index']);
Route::get('/tours/{id}', [TourController::class, 'show']);
Route::post('/tours/{id}/apply', [TourController::class, 'apply']);
Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'auth']);
// Route::get('/admin/bookings', [TourController::class, 'bookings']);
Route::get('/admin/bookings/{id}/done', [TourController::class, 'done']);
Route::get('/admin/bookings/{id}/cancel', [TourController::class, 'cancel']);
Route::get('/request', function () {
   return view('request');
});
Route::post('/request', [TourController::class, 'request']);
Route::get('/chat/{token}', [TourController::class, 'clientChat']);
Route::post('/chat/{token}', [TourController::class, 'clientSend']);
//Route::get('/admin/chat/{token}', [AdminController::class, 'chatByToken']);
//Route::post('/admin/chat/{token}', [AdminController::class, 'sendMessage']);
Route::middleware(['auth'])->group(function () {
   Route::get('/admin/requests/{id}/done', [TourController::class, 'requestDone']);
Route::get('/admin/requests/{id}/cancel', [TourController::class, 'requestCancel']);
Route::get('/admin/bookings', [AdminController::class, 'bookings']);
Route::get('/test-email', [AdminController::class, 'testEmail']);
Route::get('/admin/chats', [AdminController::class, 'chats']);
Route::get('/admin/livechat/{id}', [AdminController::class, 'liveChat']);
Route::post('/admin/livechat/{id}', [AdminController::class, 'liveSend']);
Route::get('/admin/email/{id}', [AdminController::class, 'email']);
Route::post('/admin/email/{id}', [AdminController::class, 'sendEmail']);
Route::get('/admin/tours', [AdminController::class, 'tours']);
Route::get('/admin/tours/create', [AdminController::class, 'createTour']);
Route::post('/admin/tours/store', [AdminController::class, 'storeTour']);
Route::get('/admin/tours/edit/{id}', [AdminController::class, 'editTour']);
Route::post('/admin/tours/update/{id}', [AdminController::class, 'updateTour']);
Route::get('/admin/tours/delete/{id}', [AdminController::class, 'deleteTour']);
Route::get('/admin/categories', [AdminController::class,'categories']);
Route::get('/admin/categories/create', [AdminController::class,'createCategory']);
Route::post('/admin/categories/store', [AdminController::class,'storeCategory']);
Route::get('/admin/categories/edit/{id}', [AdminController::class,'editCategory']);
Route::post('/admin/categories/update/{id}', [AdminController::class,'updateCategory']);
Route::get('/admin/categories/delete/{id}', [AdminController::class,'deleteCategory']);
});
 
 