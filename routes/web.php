<?php

use Vanguard\Http\Controllers\Web\Member\MemberDetailsController;
use Vanguard\Http\Controllers\Web\Member\MembersController;
//use Vanguard\Http\Controllers\Web\PrintController AS PrintController;

use Vanguard\App\Http\Controllers\Web\Member\CodeController;



// Route::get('/code','CodeController@index');
// Route::get('/create','CodeController@create');
// Route::post('/post','CodeController@store');

/**
 * Authentication
 */
Route::get('/', 'Member\LoginController@show');
Route::get('login', 'Member\LoginController@show')->name('member.login');
Route::post('login', 'Member\LoginController@login');
Route::get('logout', 'Member\LoginController@member_logout');
Route::get('register', 'Member\RegisterController@show');
Route::post('register', 'Member\RegisterController@register');

Route::get('mems', function () {
//    return  URL::to('/');
//    return  asset('');
//    return  url('');
    return \Illuminate\Support\Str::random(60);
    return base_path();
    //    return \Vanguard\Member::all();
});
//Route::get('mem/{id}', function($id) {
//    return \Vanguard\Member::find($id);
//});

Route::prefix('member-details')->name('member-details.')->group(function () {
    Route::get('/', [MemberDetailsController::class, 'index'])->name('index');
    Route::get('new', [MemberDetailsController::class, 'create'])->name('new');
    Route::post('create', [MemberDetailsController::class, 'store'])->name('store');
    Route::get('{memberDetail}', [MemberDetailsController::class, 'show'])->name('show');
    Route::get('edit/{memberDetail}', [MemberDetailsController::class, 'edit'])->name('edit');
    Route::put('edit/{memberDetail}', [MemberDetailsController::class, 'update'])->name('update');
    Route::delete('{memberDetail}', [MemberDetailsController::class, 'destroy'])->name('delete');
    Route::post('{member}/change_pass', [MemberDetailsController::class, 'change_pass'])->name('change_pass');

});

Route::get('admin/login', 'Auth\LoginController@show');
Route::post('admin/login', 'Auth\LoginController@login');
Route::get('admin/logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::group(['middleware' => ['registration', 'guest']], function () {
    Route::get('admin/register', 'Auth\RegisterController@show');
    Route::post('admin/register', 'Auth\RegisterController@register');
});

Route::emailVerification();

Route::group(['middleware' => ['password-reset', 'guest']], function () {
    Route::resetPassword();
});

/**
 * Two-Factor Authentication
 */
Route::group(['middleware' => 'two-factor'], function () {
    Route::get('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@show')->name('auth.token');
    Route::post('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@update')->name('auth.token.validate');
});

/**
 * Social Login
 */
Route::get('auth/{provider}/login', 'Auth\SocialAuthController@redirectToProvider')->name('social.login');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

/**
 * Impersonate Routes
 */
Route::group(['middleware' => 'auth'], function () {
    Route::impersonate();
});

/**
 * Sanaulla: I change 'auth' -> 'auth:web'
 */

Route::group(['middleware' => ['auth:web', 'verified']], function () {

    /**
     * Dashboard
     */

    Route::get('admin/', 'DashboardController@index')->name('dashboard');

    /**
     * User Profile
     */

    Route::group(['prefix' => 'profile', 'namespace' => 'Profile'], function () {
        Route::get('admin/', 'ProfileController@show')->name('profile');
        Route::get('member/{member}', 'ProfileController@show_member')->name('member_profile');
        Route::get('activity', 'ActivityController@show')->name('profile.activity');
        Route::put('details', 'DetailsController@update')->name('profile.update.details');

        Route::post('admin/avatar', 'AvatarController@update')->name('profile.update.avatar');
        Route::post('admin/avatar/external', 'AvatarController@updateExternal')
            ->name('profile.update.avatar-external');

        Route::put('admin/login-details', 'LoginDetailsController@update')
            ->name('profile.update.login-details');

        Route::get('admin/sessions', 'SessionsController@index')
            ->name('profile.sessions')
            ->middleware('session.database');

        Route::delete('admin/sessions/{session}/invalidate', 'SessionsController@destroy')
            ->name('profile.sessions.invalidate')
            ->middleware('session.database');
    });

    /**
     * Two-Factor Authentication Setup
     */

    Route::group(['middleware' => 'two-factor'], function () {
        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('two-factor.enable');

        Route::get('two-factor/verification', 'TwoFactorController@verification')
            ->name('two-factor.verification')
            ->middleware('verify-2fa-phone');

        Route::post('two-factor/resend', 'TwoFactorController@resend')
            ->name('two-factor.resend')
            ->middleware('throttle:1,1', 'verify-2fa-phone');

        Route::post('two-factor/verify', 'TwoFactorController@verify')
            ->name('two-factor.verify')
            ->middleware('verify-2fa-phone');

        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('two-factor.disable');
    });


    /**
     * User Management
     */
    Route::resource('admin/users', 'Users\UsersController')
        ->except('update')->middleware('permission:users.manage');

    Route::group(['prefix' => 'admin/users/{user}', 'middleware' => 'permission:users.manage'], function () {
        Route::put('admin/update/details', 'Users\DetailsController@update')->name('users.update.details');
        Route::put('admin/update/login-details', 'Users\LoginDetailsController@update')
            ->name('users.update.login-details');

        Route::post('admin/update/avatar', 'Users\AvatarController@update')->name('user.update.avatar');
        Route::post('admin/update/avatar/external', 'Users\AvatarController@updateExternal')
            ->name('user.update.avatar.external');

        Route::get('admin/sessions', 'Users\SessionsController@index')
            ->name('user.sessions')->middleware('session.database');

        Route::delete('admin/sessions/{session}/invalidate', 'Users\SessionsController@destroy')
            ->name('user.sessions.invalidate')->middleware('session.database');

        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('user.two-factor.enable');
        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('user.two-factor.disable');

        // user profile update
        Route::get('update-profile', 'Users\SessionsController@updateProfileShow')
            ->name('user.update.profile.show')->middleware('session.database');
        Route::post('update-profile', 'Users\SessionsController@updateProfile')
            ->name('user.update.profile')->middleware('session.database');
        
    });

    /**
     * Roles & Permissions
     */
    Route::group(['namespace' => 'Authorization'], function () {
        Route::resource('admin/roles', 'RolesController')->except('show')->middleware('permission:roles.manage');

        Route::post('admin/permissions/save', 'RolePermissionsController@update')
            ->name('permissions.save')
            ->middleware('permission:permissions.manage');

        Route::resource('permissions', 'PermissionsController')->middleware('permission:permissions.manage');
    });


    /**
     * Settings
     */

    Route::get('admin/settings', 'SettingsController@general')->name('settings.general')
        ->middleware('permission:settings.general');

    Route::post('admin/settings/general', 'SettingsController@update')->name('settings.general.update')
        ->middleware('permission:settings.general');

    Route::get('admin/settings/auth', 'SettingsController@auth')->name('settings.auth')
        ->middleware('permission:settings.auth');

    Route::post('admin/settings/auth', 'SettingsController@update')->name('settings.auth.update')
        ->middleware('permission:settings.auth');

    if (config('services.authy.key')) {
        Route::post('admin/settings/auth/2fa/enable', 'SettingsController@enableTwoFactor')
            ->name('settings.auth.2fa.enable')
            ->middleware('permission:settings.auth');

        Route::post('admin/settings/auth/2fa/disable', 'SettingsController@disableTwoFactor')
            ->name('settings.auth.2fa.disable')
            ->middleware('permission:settings.auth');
    }

    Route::post('admin/settings/auth/registration/captcha/enable', 'SettingsController@enableCaptcha')
        ->name('settings.registration.captcha.enable')
        ->middleware('permission:settings.auth');

    Route::post('admin/settings/auth/registration/captcha/disable', 'SettingsController@disableCaptcha')
        ->name('settings.registration.captcha.disable')
        ->middleware('permission:settings.auth');

    Route::get('admin/settings/notifications', 'SettingsController@notifications')
        ->name('settings.notifications')
        ->middleware('permission:settings.notifications');

    Route::post('admin/settings/notifications', 'SettingsController@update')
        ->name('settings.notifications.update')
        ->middleware('permission:settings.notifications');

    /**
     * Activity Log
     */

    Route::get('admin/activity', 'ActivityController@index')->name('activity.index')
        ->middleware('permission:users.activity');

    Route::get('admin/activity/user/{user}/log', 'ActivityController@index')->name('activity.user')
        ->middleware('permission:users.activity');
});


/**
 * Installation
 */

Route::group(['prefix' => 'install'], function () {
    Route::get('/', 'InstallController@index')->name('install.start');
    Route::get('requirements', 'InstallController@requirements')->name('install.requirements');
    Route::get('permissions', 'InstallController@permissions')->name('install.permissions');
    Route::get('database', 'InstallController@databaseInfo')->name('install.database');
    Route::get('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('install-app', 'InstallController@install')->name('install.install');
    Route::get('complete', 'InstallController@complete')->name('install.complete');
    Route::get('error', 'InstallController@error')->name('install.error');
});


//Route::get('admin/members', 'Users\UsersController@memberList')->name('admin.members');

Route::get('member/', 'Member\MembersController@index')->name('member.dashboard');
//Route::get('member/gate_pass', function () {
//    return view('member.gate_pass');
//});

//    Route::get('member/gate_pass', function () {
//        if(Auth::guard('front')->guest()){
//            return '1';
//        }else{
//            return '2';
//        }
//    });

//Route::get('member/gate_pass', 'Member\MembersController@index')->name('member.dashboard');

Route::get('guard', function () {
    if (Auth::guard('front')->check())
//        return Auth::guard('front')->user();
        return auth()->guard('front')->user();
    elseif (Auth::guard('web')->check())   // OR Auth::check()
        return Auth::guard('web')->user();  // OR // auth()->user();
    else
        return 'Not Login';
});

Route::middleware('auth')->get('/test_auth', function(Request $request) {
    return $request->user();
});

Route::get('file-import-export', [MembersController::class, 'fileImportExport']);
Route::post('file-import', [MembersController::class, 'fileImport'])->name('file-import');
Route::get('file-export', [MembersController::class, 'fileExport'])->name('file-export');

//Route::get('/print_membership_id_card/{id_card}', [PrintController::class,'membership_id_card']);
//Route::get('/print_id_card/{id_card}', [PrintController::class,'id_card']);
//Route::get('/print_money_receipt/{money_collection}', [PrintController::class,'money_receipt']);

Route::controller(PrintController::class)->group(function () {
    Route::get('/print_membership_id_card/{id_card}', 'membership_id_card');
    Route::get('/print_id_card/{id_card}', 'id_card');
    Route::get('/print_voter/{voter}', 'voter');
    Route::get('/print_money_receipt/{money_collection}', 'money_receipt');
    Route::get('/print_member_money_receipt/{money_collection}', 'member_money_receipt');
    Route::get('/print_member/{member}', 'print_member');
    Route::get('/print_renew_member/{renew_member}', 'print_renew_member');
});


Route::get('/admin/{any}', function ($any) {        // For Admin
    return view('vue.admin');
//        return View::make('vue.admin');
})->where('any', '.*')->middleware('auth:web');
Route::get('/election/{any}', function ($any) {        // For Admin
    return view('vue.election');
//        return View::make('vue.admin');
})->where('any', '.*')->middleware('auth:web');
Route::get('/members/{any}', function ($any) {      // For Registration
    return view('vue.index');
})->where('any', '.*');
//Route::group(['middleware' => ['auth']], function () {
    Route::get('/member/{any}', function ($any) {       // For Member
        return view('vue.member');
    })->where('any', '.*')->middleware('auth:front');
//});
Route::get('/vue/{any}', function ($any) {          // For Practice
    return view('vue.index');
})->where('any', '.*');
Route::get('/print/{any}', function ($any) {        // For Print
    return view('vue.print');
})->where('any', '.*')->middleware('auth:web');


