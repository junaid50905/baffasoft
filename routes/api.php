<?php

use Vanguard\Http\Controllers\Api\MembersDataController;
use Vanguard\Http\Controllers\Api\MembersController;
use Vanguard\Http\Controllers\Api\CompanyOwnerController;
use Vanguard\Http\Controllers\Api\RenewMemberController;
use Vanguard\Http\Controllers\Api\GatePassController;
use Vanguard\Http\Controllers\Api\IdCardsController;
use Vanguard\Http\Controllers\Api\ElectionController;
use Vanguard\Http\Controllers\Api\TrainingController;
use Vanguard\Http\Controllers\Api\VoterController;

Route::get('/agent', function () {
    return request()->userAgent();
});
Route::post('login', 'Auth\AuthController@token');
Route::post('member_login', 'Auth\AuthController@member_token');
Route::post('login/social', 'Auth\SocialLoginController@index');
Route::post('logout', 'Auth\AuthController@logout');

Route::post('register', 'Auth\RegistrationController@index')->middleware('registration');

Route::group(['middleware' => ['guest', 'password-reset']], function () {
    Route::post('password/remind', 'Auth\Password\RemindController@index');
    Route::post('password/reset', 'Auth\Password\ResetController@index');
});

Route::group(['middleware' => ['auth', 'registration']], function () {
    Route::post('email/resend', 'Auth\VerificationController@resend');
    Route::post('email/verify', 'Auth\VerificationController@verify');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('me', 'Profile\DetailsController@index');
    Route::patch('me/details', 'Profile\DetailsController@update');
    Route::patch('me/details/auth', 'Profile\AuthDetailsController@update');
    Route::post('me/avatar', 'Profile\AvatarController@update');
    Route::delete('me/avatar', 'Profile\AvatarController@destroy');
    Route::put('me/avatar/external', 'Profile\AvatarController@updateExternal');
    Route::get('me/sessions', 'Profile\SessionsController@index');

    Route::group(['middleware' => 'two-factor'], function () {
        Route::put('me/2fa', 'Profile\TwoFactorController@update');
        Route::post('me/2fa/verify', 'Profile\TwoFactorController@verify');
        Route::delete('me/2fa', 'Profile\TwoFactorController@destroy');
    });

    Route::get('stats', 'StatsController@index');

    Route::apiResource('users', 'Users\UsersController')->except('show');
    Route::get('users/{userId}', 'Users\UsersController@show');

    Route::post('users/{user}/avatar', 'Users\AvatarController@update');
    Route::put('users/{user}/avatar/external', 'Users\AvatarController@updateExternal');
    Route::delete('users/{user}/avatar', 'Users\AvatarController@destroy');

    Route::group(['middleware' => 'two-factor'], function () {
        Route::put('users/{user}/2fa', 'Users\TwoFactorController@update');
        Route::post('users/{user}/2fa/verify', 'Users\TwoFactorController@verify');
        Route::delete('users/{user}/2fa', 'Users\TwoFactorController@destroy');
    });

    Route::get('users/{user}/sessions', 'Users\SessionsController@index');

    Route::get('/sessions/{session}', 'SessionsController@show');
    Route::delete('/sessions/{session}', 'SessionsController@destroy');

    Route::apiResource('roles', 'Authorization\RolesController')->except('show');
    Route::get('/roles/{roleId}', 'Authorization\RolesController@show');

    Route::get("roles/{role}/permissions", 'Authorization\RolePermissionsController@show');
    Route::put("roles/{role}/permissions", 'Authorization\RolePermissionsController@update');

    Route::apiResource('permissions', 'Authorization\PermissionsController');

    Route::get('/settings', 'SettingsController@index');

    Route::get('/countries', 'CountriesController@index');
});
Route::prefix('members')->name('members.')->group(function () {
    Route::post('/create', [MembersController::class, 'create']);
    Route::get('/1', [MembersController::class, 'show']);
    Route::get('/countries', [MembersDataController::class, 'countries']);
});
Route::post('members', [MembersController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {

Route::prefix('members')->name('members.')->group(function () {
    Route::get('/', [MembersController::class, 'index']);
    Route::get('/due_members', [MembersController::class, 'due_members']);
    Route::get('/{member}/company_owners', [CompanyOwnerController::class, 'index']);
    Route::get('/{member}/deleted_company_owners', [CompanyOwnerController::class, 'deleted_company_owners']);
    Route::get('/verified_organizations', [MembersController::class, 'getAllVerifiedOrganizationName']);
    Route::get('/organizations', [MembersController::class, 'getAllOrganizationName']);
    Route::get('/organizations_for_election', [MembersController::class, 'getAllOrganizationNameForElection']);
    Route::get('/{member}/active_id_card', [MembersController::class, 'activeIdCard']);
//        Route::get('/renewal', [MembersController::class, 'allRenewalMembers']);
//        Route::get('/renewal/{renewal_member}', [MembersController::class, 'renewalMember']);
    Route::get('/voucher/{member}', [MembersController::class, 'voucher']);
    Route::post('/save_short_member', [MembersController::class, 'save_short_member']);
    Route::get('/{member}/edit', [MembersController::class, 'edit']);
    Route::get('/{member}/notifications', [MembersController::class, 'notifications']);
    Route::post('/{member}', [MembersController::class, 'update']);
//        Route::post('/renew/{member}', [MembersController::class, 'renew']);
    Route::post('/approval/{member}', [MembersController::class, 'approval']);
    Route::get('/approveMember/{member}', [MembersController::class, 'approveMember']);
    Route::get('/bannedMember/{member}', [MembersController::class, 'bannedMember']);
    Route::get('/activeMember/{member}', [MembersController::class, 'activeMember']);
    Route::post('/assign_privilege/{member}', [MembersController::class, 'assign_privilege']);
    Route::put('/update_balance/{member}', [MembersController::class, 'update_balance']);
    Route::delete('/{member}', [MembersController::class, 'destroy']);
    Route::get('/check_company_uniqueness', [MembersController::class, 'check_company_uniqueness']);
});
Route::apiResource('renew_member', 'RenewMemberController');
//Route::get('/renew_member/approveMember/{renew_member}', [RenewMemberController::class, 'approveMember']);
//Route::get('/renew_member/activeMember/{renew_member}', [RenewMemberController::class, 'activeMember']);
Route::get('/renew_member/company_owners/{renew_member}', [CompanyOwnerController::class, 'renew_member_company_owners']);
Route::get('/renew_member/check_renewal_fees/{renew_member}', [RenewMemberController::class, 'check_renewal_fees']);
Route::get('/renew_member/change_company_name/{renew_member}', [RenewMemberController::class, 'change_company_name']);
Route::post('/renew_member/set_company_structure_charge/{renew_member}', [RenewMemberController::class, 'setCompanyStructureCharge']);
Route::get('/structure_member', [RenewMemberController::class, 'StructureMember']);


    Route::apiResource('company_owner', 'CompanyOwnerController');
    Route::get('/company_owner/active/{company_owner}/{renew_member}', [CompanyOwnerController::class, 'activate_company_owners']);

//Route::get('/member/assign_privilege',[MembersController::class,'assign_privilege']);
//Route::apiResource('photos', \Vanguard\Http\Controllers\Api\GatePassController::class);
Route::apiResource('gate_pass', 'GatePassController'); // Same as above without create and edit method
Route::get('/saved_gatepass', [GatePassController::class, 'saved_gatepass']);
Route::post('/gate_pass/{gate_pass}/update', [GatePassController::class, 'update_all']);
Route::get('/check_mawb_gate_pass', [GatePassController::class, 'check_mawb']);
Route::get('/member_gate_pass/{member}', [GatePassController::class, 'member_gate_pass']);
Route::get('/gate_pass_collection', [GatePassController::class, 'money_collection']);
Route::apiResource('money_collection', 'MoneyCollectionController'); // Same as above without create and edit method

Route::apiResource('id_cards', 'IdCardsController'); // Same as above without create and edit method
Route::get('id_card_year', [IdCardsController::class, 'id_card_year']);
Route::post('id_card_year', [IdCardsController::class, 'save_id_card_year']);
Route::get('all_id_card_status', [IdCardsController::class, 'all_id_card_status']);
Route::get('generate_id_card_number/{idCard}', [IdCardsController::class, 'generate_id_card_number']);
Route::get('accounts_id_cards', [IdCardsController::class, 'accounts_id_cards']);
Route::get('member_id_cards/{id}', [IdCardsController::class, 'member_id_cards']);
Route::get('member_id_cards', [IdCardsController::class, 'manager_report']);
//    Route::get('member_id_card_receipts/{member}', [IdCardsController::class, 'member_id_card_receipts']);

Route::prefix('id_cards')->name('id_cards.')->group(function () {
    Route::put('/comment/{id_card}', [IdCardsController::class, 'comment']);
    Route::delete('/comment/{id_card}', [IdCardsController::class, 'delete_comment']);
    Route::put('/update_id_card_number/{id_card}', [IdCardsController::class, 'update_id_card_number']);
    Route::put('/update_proximity_number/{id_card}', [IdCardsController::class, 'update_proximity_number']);
    Route::put('/update_delivered/{id_card}', [IdCardsController::class, 'update_delivered']);
    Route::get('/manager/report', [IdCardsController::class, 'manager_report']);
    Route::put('/verification/{id_card}', [IdCardsController::class, 'verification']);
    Route::put('/verification/accounts/{id_card}', [IdCardsController::class, 'accounts_verify']);
    //Route::post('/verification/accept_by_director/{verification}', [IdCardsController::class, 'accept_by_director']);
    Route::post('/verification/accepts_by_director', [IdCardsController::class, 'accepts_by_director']);
    Route::post('/verification/manager_note/{verification}', [IdCardsController::class, 'manager_note']);
    Route::put('/verification/member_message/{verification}', [IdCardsController::class, 'member_message']);
    Route::put('id_card_choose_by_member/{id_card}', [IdCardsController::class, 'id_card_choose_by_member']);
    Route::post('/{id_card}/update', [IdCardsController::class, 'update_all']);
    Route::get('/active_years/all', [IdCardsController::class, 'getActiveYears']);
    Route::get('/cancel/all', [IdCardsController::class, 'cancel_index']);
    Route::get('/cancel/{id_card_cancel}', [IdCardsController::class, 'cancel_id_card']);
    Route::put('/cancel/{id_card_cancel}', [IdCardsController::class, 'update_cancel_id_card']);
    Route::post('/cancel/{id_card}', [IdCardsController::class, 'save_cancel_id_card']);
    Route::get('/reissue/all', [IdCardsController::class, 'reissue_index']);
    Route::get('/reissue/{id_card_reissue}', [IdCardsController::class, 'reissue_id_card']);
    Route::put('/reissue/{id_card_reissue}', [IdCardsController::class, 'update_reissue_id_card']);
    Route::post('/reissue/{id_card}', [IdCardsController::class, 'save_reissue_id_card']);

});

Route::apiResource('election', 'ElectionController');

Route::get('/election/all/active', [ElectionController::class, 'index_active']);
//Route::get('/election/{election}/casting_report', [ElectionController::class, 'casting_report']);
Route::get('/election_casting_report', [ElectionController::class, 'casting_report']);

Route::apiResource('voter', 'VoterController');
//Route::get('/election/{election_id}/voter/{bar_code}', [VoterController::class, 'edit']);
Route::get('/election/voter/{bar_code}', [VoterController::class, 'edit']);

Route::apiResource('training', 'TrainingController');
Route::get('/training_names/all', [TrainingController::class, 'training_names']);
Route::get('/training_names/{name}', [TrainingController::class, 'check_training_name']);
Route::get('/training_names/{id}/{visibility}', [TrainingController::class, 'update_training_name']);







//Route::resource('monkeys', 'MonkeysController', [
//    'except' => ['edit', 'create']
//]);
Route::get('all_users', 'Users\UsersController@userList');

}); // auth:sanctum


Route::get('guard', function () {
    if (Auth::guard('api')->check())
        return '1';
//        return Auth::guard('front')->user();
//        return auth()->guard('front')->user();
    elseif (Auth::guard('web')->check())   // OR Auth::check()
        return '2';// Auth::guard('web')->user();  // OR // auth()->user();
    elseif (Auth::check())   // OR Auth::check()
        return auth()->guard('web')->user();//'3'; //Auth::user();  // OR // auth()->user();
    else
        return 'Not Login';
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request::user();
});

//Route::middleware(['auth:sanctum'])->get('/member', function(){
//    return auth()->user();
//});
