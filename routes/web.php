<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use App\Http\Controllers\AdminController;
Route::get('/', [TourController::class, 'index']);
Route::get('/tours', [TourController::class, 'index']);
Route::get('/tours/{id}', [TourController::class, 'show']);
Route::post('/tours/{id}/apply', [TourController::class, 'apply']);
Route::get('/request', function () {
    return view('request');
});
Route::post('/request', [TourController::class, 'request']);
Route::get('/chat/{token}', [TourController::class, 'clientChat']);
Route::post('/chat/{token}', [TourController::class, 'clientSend']);
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'auth']);
Route::get('/admin/logout', function () {
    auth()->logout();
    return redirect('/admin/login');
});
Route::middleware(['admin'])->group(function () {
Route::get('/admin/bookings', [AdminController::class, 'bookings']);
Route::get('/admin/bookings/{id}/done', [TourController::class, 'done']);
Route::get('/admin/bookings/{id}/cancel', [TourController::class, 'cancel']);
Route::get('/admin/bookings/{id}/delete', [AdminController::class, 'deleteBooking']);
Route::get('/admin/requests/{id}/done', [TourController::class, 'requestDone']);
Route::get('/admin/requests/{id}/cancel', [TourController::class, 'requestCancel']);
Route::get('/admin/requests/{id}/delete', [AdminController::class, 'deleteRequest']);
Route::get('/admin/chats', [AdminController::class, 'chats']);
Route::get('/admin/livechat/{type}/{id}', [AdminController::class, 'liveChat']);
Route::post('/admin/livechat/{type}/{id}', [AdminController::class, 'liveSend']);
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
Route::get('/test-email', [AdminController::class, 'testEmail']);
});
 
 