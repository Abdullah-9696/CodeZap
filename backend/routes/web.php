<?php



use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SkillController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\CourseControllers;
use App\Http\Controllers\SkillControllers;
// ---------------- Homepage Redirect ----------------
Route::get('/', fn()=>redirect()->route('login'));

// ---------------- Auth Routes ----------------
Route::get('register', fn()=>view('auth.register'))->name('register');
Route::post('register', [AuthController::class,'register'])->name('register.submit');

Route::get('login', fn()=>view('auth.login'))->name('login');
Route::post('login', [AuthController::class,'login'])->name('login.submit');
Route::post('logout', [AuthController::class,'logout'])->name('logout');

// ---------------- Forgot Password (Direct Change) ----------------
Route::get('forgot-password', [AuthController::class,'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class,'resetPasswordDirect'])->name('password.update.direct');
Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change.password.form');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password');
});
// ---------------- Socialite Routes ----------------
Route::get('login/google', [SocialController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [SocialController::class, 'handleGoogleCallback']);
Route::get('login/facebook', [SocialController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [SocialController::class, 'handleFacebookCallback']);
Route::get('login/twitter', [SocialController::class, 'redirectToTwitter'])->name('login.twitter');
Route::get('login/twitter/callback', [SocialController::class, 'handleTwitterCallback']);

// ---------------- Admin Routes ----------------
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('skills', SkillController::class);
});

// ---------------- User Routes (Frontend) ----------------
Route::get('/home', function () {
    return view('app'); // Loads React SPA
})->name('home')->middleware('auth');
// Updated to use Admin\CourseController
Route::get('courses', [CourseControllers::class, 'index'])->name('courses.index'); // No middleware if public
Route::get('skills', [SkillControllers::class, 'index'])->name('skills.index');

// ---------------- Profile JSON Routes (no /api prefix) ----------------
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::post('/api//profile/update', [ProfileController::class, 'updateProfile']);
});