<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
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


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('tables', function () {
		return view('teacher.index');
	})->name('tables');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');

Route::resource('/teacher',\App\Http\Controllers\TeacherController::class);
Route::post('/teacher/ajax',[\App\Http\Controllers\TeacherController::class,'getTeachersJson'])->name('teacher.getTeachers');

Route::resource('/students',\App\Http\Controllers\StudentController::class);
Route::post('/student/ajax',[\App\Http\Controllers\StudentController::class,'getStudentsJson'])->name('student.getStudents');
Route::resource('/users',\App\Http\Controllers\UserController::class);
Route::post('/user/ajax',[\App\Http\Controllers\UserController::class,'getUsersJson'])->name('user.getUsers');
Route::get('/users/{user}/approveTeacher',[\App\Http\Controllers\UserController::class,'approveUserAsTeacher'])->name('user.approveTeacher');
Route::get('/users/{user}/approveStudent',[\App\Http\Controllers\UserController::class,'approveUserAsStudent'])->name('user.approveStudent');

