<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('get_cedant_details/{cedants_id}', 'CedantController@get_cedant_details');

//reinsurance company routes
Route::group(['prefix' => 'reins'], function(){
    Route::post('login_user', 'UserReinsuranceController@login_user');
    Route::post('login_admin', 'AdminReinsuranceController@login_admin');

    //Forgot Password
    Route::post('password_email', 'api\ForgotPasswordController@getResetTokenReins');
    Route::post('password_reset', 'api\ResetPasswordController@resetReins');

    Route::get('get_profiles', 'ReinsuranceController@get_profiles');
    Route::get('get_roles', 'ReinsuranceController@get_roles');
    Route::get('get_countries', 'ReinsuranceController@get_countries');
    Route::get('get_regions', 'ReinsuranceController@get_regions');
    Route::get('get_currencies', 'ReinsuranceController@get_currencies');
    Route::get('get_cedant_types', 'ReinsuranceController@get_cedant_types');
    Route::get('get_groups', 'ReinsuranceController@get_groups');
    Route::get('get_branch_categories', 'ReinsuranceController@get_branch_categories');

    //functions which require token authentication after login routes
    Route::group(['middleware' => ['jwt.verify']], function () {

        Route::post('create_payment_method', 'ReinsuranceController@create_payment_method');
        Route::post('update_payment_method', 'ReinsuranceController@update_payment_method');
        Route::get('list_payment_methods', 'ReinsuranceController@list_payment_methods');

        Route::post('create_representation', 'ReinsuranceController@create_representation');
        Route::post('update_representation', 'ReinsuranceController@update_representation');
        Route::get('list_representations', 'ReinsuranceController@list_representations');

        Route::post('create_gender', 'ReinsuranceController@create_gender');
        Route::post('update_gender', 'ReinsuranceController@update_gender');
        Route::get('list_gender', 'ReinsuranceController@list_gender');

        Route::post('create_civility', 'ReinsuranceController@create_civility');
        Route::post('update_civility', 'ReinsuranceController@update_civility');
        Route::get('list_civility', 'ReinsuranceController@list_civility');

        Route::post('create_region', 'ReinsuranceController@create_region');
        Route::post('update_region', 'ReinsuranceController@update_region');
        Route::get('list_regions', 'ReinsuranceController@get_regions');

        Route::post('create_user', 'UserReinsuranceController@create_user');
        Route::post('update_user', 'UserReinsuranceController@update_user');
        Route::get('view_user/{user_id}', 'UserReinsuranceController@view_user');
        Route::get('list_users/{reinsurances_id}', 'UserReinsuranceController@list_users');
        Route::post('logout', 'UserReinsuranceController@logout');

        Route::post('create_profile', 'UserReinsuranceController@create_profile');
        Route::post('update_profile', 'UserReinsuranceController@update_profile');

        Route::post('create_role', 'UserReinsuranceController@create_role');
        Route::post('update_role', 'UserReinsuranceController@update_role');

        Route::post('create_country', 'ReinsuranceController@create_country');
        Route::post('update_country', 'ReinsuranceController@update_country');

        Route::post('create_group', 'GroupInsuranceController@create_group');
        Route::post('update_group', 'GroupInsuranceController@update_group');

        Route::post('create_insurance_type', 'ReinsuranceController@create_insurance_type');
        Route::post('update_insurance_type', 'ReinsuranceController@update_insurance_type');

        Route::post('create_cedant', 'ReinsuranceController@create_cedant');
        Route::post('update_cedant', 'ReinsuranceController@update_cedant');

        Route::post('create_cedant_user', 'ReinsuranceController@create_cedant_user');
        Route::post('update_cedant_user', 'ReinsuranceController@update_cedant_user');
        Route::get('list_cedant_users/{cedants_id}', 'ReinsuranceController@list_cedant_users');
        Route::get('list_all_cedants_users', 'ReinsuranceController@list_all_cedants_users');

        //Route::get('check_premium_slip/{validation_status}/{premium_slip_id}', 'ReinsuranceController@check_premium_slip');
        Route::post('update_premium_slip', 'ReinsuranceController@update_premium_slip');
        Route::get('list_premium_slips/{reinsurances_id}', 'ReinsuranceController@list_premium_slips');
        Route::get('view_premium_slip/{premium_slip_id}', 'ReinsuranceController@view_premium_slip');
        Route::post('check_cases_premium_slip', 'ReinsuranceController@check_cases_premium_slip');
        Route::get('check_final_premium_slip/{validation_status}/{premium_slip_id}', 'ReinsuranceController@check_final_premium_slip');
        Route::get('check_final_validation_premium_slips/{reinsurances_id}', 'ReinsuranceController@check_final_validation_premium_slips');
        Route::get('list_cedant_validated_premium_slips/{reinsurances_id}/{cedants_id}', 'ReinsuranceController@list_cedant_validated_premium_slips');

        Route::get('list_claim_slips/{reinsurances_id}', 'ReinsuranceController@list_claim_slips');
        Route::get('view_claim_slip/{claim_slip_id}', 'ReinsuranceController@view_claim_slip');
        Route::post('check_cases_claim_slip', 'ReinsuranceController@check_cases_claim_slip');
        Route::get('check_final_claim_slip/{validation_status}/{claim_slip_id}', 'ReinsuranceController@check_final_claim_slip');
        Route::get('check_final_validation_claim_slips/{reinsurances_id}', 'ReinsuranceController@check_final_validation_claim_slips');
        Route::get('list_cedant_validated_claim_slips/{reinsurances_id}/{cedants_id}', 'ReinsuranceController@list_cedant_validated_claim_slips');

        Route::get('list_premium_big_risk_slips/{reinsurances_id}', 'ReinsuranceController@list_premium_big_risk_slips');
        Route::get('list_premium_regularization_slips/{reinsurances_id}', 'ReinsuranceController@list_premium_regularization_slips');
        Route::get('list_claim_cash_call_slips/{reinsurances_id}', 'ReinsuranceController@list_claim_cash_call_slips');

        Route::post('save_credit_note', 'ReinsuranceController@save_credit_note');
        Route::post('save_debit_note', 'ReinsuranceController@save_debit_note');

        Route::get('list_cedants/{reinsurances_id}', 'ReinsuranceController@list_cedants');

        Route::get('getAuthenticatedUser', 'UserReinsuranceController@getAuthenticatedUser');

        Route::post('create_branch', 'ReinsuranceController@create_branch');
        Route::post('update_branch', 'ReinsuranceController@update_branch');
        Route::get('list_branches', 'ReinsuranceController@list_branches');
        Route::get('list_life_branches', 'ReinsuranceController@list_life_branches');
        Route::get('list_not_life_branches', 'ReinsuranceController@list_not_life_branches');

        Route::post('create_branch_capital', 'ReinsuranceController@create_branch_capital');
        Route::post('update_branch_capital', 'ReinsuranceController@update_branch_capital');
        Route::get('list_branch_capital', 'ReinsuranceController@list_branch_capital');

        Route::post('create_branch_commission', 'ReinsuranceController@create_branch_commission');
        Route::post('update_branch_commission', 'ReinsuranceController@update_branch_commission');
        Route::get('list_branch_commission', 'ReinsuranceController@list_branch_commission');

        Route::post('create_sub_branch', 'ReinsuranceController@create_sub_branch');
        Route::post('update_sub_branch', 'ReinsuranceController@update_sub_branch');
        Route::get('list_sub_branches', 'ReinsuranceController@list_sub_branches');

        Route::post('create_sub_branch_capital', 'ReinsuranceController@create_sub_branch_capital');
        Route::post('update_sub_branch_capital', 'ReinsuranceController@update_sub_branch_capital');
        Route::get('list_sub_branch_capital', 'ReinsuranceController@list_sub_branch_capital');

        Route::post('create_sub_branch_commission', 'ReinsuranceController@create_sub_branch_commission');
        Route::post('update_sub_branch_commission', 'ReinsuranceController@update_sub_branch_commission');
        Route::get('list_sub_branch_commission', 'ReinsuranceController@list_sub_branch_commission');

        Route::post('add_comment', 'ReinsuranceController@add_comment');
        Route::post('update_comment', 'ReinsuranceController@update_comment');

        Route::post('add_note_comment', 'ReinsuranceController@add_note_comment');
        Route::post('update_note_comment', 'ReinsuranceController@update_note_comment');

        Route::get('view_justification_files/{claim_slip_id}/{case_id}', 'ReinsuranceController@view_justification_files');

        Route::get('view_premium_comments/{premium_slip_id}/{case_id}', 'ReinsuranceController@view_premium_comments');
        Route::get('view_claim_comments/{claim_slip_id}/{case_id}', 'ReinsuranceController@view_claim_comments');
        Route::get('view_note_comments/{note_id}', 'ReinsuranceController@view_note_comments');

        Route::get('view_note/{note_id}', 'ReinsuranceController@view_note');

        Route::get('list_debit_notes/{reinsurances_id}', 'ReinsuranceController@list_debit_notes');
        Route::get('list_credit_notes/{reinsurances_id}', 'ReinsuranceController@list_credit_notes');
        Route::get('check_final_note/{validation_status}/{note_id}', 'ReinsuranceController@check_final_note');
        Route::get('check_final_payment_note/{payment_status}/{note_id}', 'ReinsuranceController@check_final_payment_note');
        Route::post('final_validate_note', 'ReinsuranceController@final_validate_note');

        Route::post('edit_credit_note', 'ReinsuranceController@edit_credit_note');

        Route::get('warning_premium_iard_calculation/{premium_slip_id}', 'ReinsuranceController@warning_premium_iard_slip_calculation');
        Route::get('warning_premium_iard_coinsurance/{premium_slip_id}', 'ReinsuranceController@warning_premium_iard_slip_coinsurance');
        Route::get('warning_premium_life_calculation/{premium_slip_id}', 'ReinsuranceController@warning_premium_life_slip_calculation');
        Route::get('warning_premium_life_coinsurance/{premium_slip_id}', 'ReinsuranceController@warning_premium_life_slip_coinsurance');

        Route::get('warning_claim_life_calculation/{claim_slip_id}', 'ReinsuranceController@warning_claim_life_slip_calculation');
        Route::get('warning_claim_check/{claim_slip_id}', 'ReinsuranceController@warning_claim_check');

        Route::post('add_invoice_note_files', 'ReinsuranceController@add_invoice_note_files');

    });

});

//insurance company routes
Route::group(['prefix' => 'ins'], function(){
    Route::post('login_user', 'UserCedantController@login_user');

    //Forgot Password
    Route::post('password_email', 'api\ForgotPasswordController@getResetTokenIns');
    Route::post('password_reset', 'api\ResetPasswordController@resetIns');

    Route::get('get_cedant_roles', 'CedantController@get_roles');

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('create_user', 'UserCedantController@create_user');
        Route::post('update_user', 'UserCedantController@update_user');
        Route::get('list_users/{cedants_id}', 'UserCedantController@list_users');
        Route::post('logout', 'UserCedantController@logout');

        Route::post('create_premium_slip', 'CedantController@create_premium_slip');
        Route::post('update_premium_slip', 'CedantController@update_premium_slip');
        Route::get('check_premium_slip/{approval_status}/{premium_slip_id}', 'CedantController@check_premium_slip');
        Route::get('list_premium_slips/{cedants_id}', 'CedantController@list_premium_slips');
        Route::get('view_premium_slip/{premium_slip_id}', 'CedantController@view_premium_slip');

        Route::get('list_premium_big_risk_slips/{cedants_id}', 'CedantController@list_premium_big_risk_slips');
        Route::get('list_premium_regularization_slips/{cedants_id}', 'CedantController@list_premium_regularization_slips');
        Route::get('list_claim_cash_call_slips/{cedants_id}', 'CedantController@list_claim_cash_call_slips');

        Route::post('create_claim_slip', 'CedantController@create_claim_slip');
        Route::post('update_claim_slip', 'CedantController@update_claim_slip');
        Route::get('check_claim_slip/{approval_status}/{claim_slip_id}', 'CedantController@check_claim_slip');
        Route::get('list_claim_slips/{cedants_id}', 'CedantController@list_claim_slips');
        Route::get('view_claim_slip/{claim_slip_id}', 'CedantController@view_claim_slip');

        Route::get('getAuthenticatedUser', 'UserCedantController@getAuthenticatedUser');

        Route::post('add_comment', 'CedantController@add_comment');
        Route::post('update_comment', 'CedantController@update_comment');

        Route::post('add_note_comment', 'CedantController@add_note_comment');
        Route::post('update_note_comment', 'CedantController@update_note_comment');

        Route::get('view_note_comments/{note_id}', 'CedantController@view_note_comments');

        Route::post('add_justification_files', 'CedantController@add_justification_files');

        Route::get('list_debit_notes/{cedants_id}', 'CedantController@list_debit_notes');
        Route::get('list_credit_notes/{cedants_id}', 'CedantController@list_credit_notes');
        Route::get('check_final_note/{approval_status}/{note_id}', 'CedantController@check_final_note');

    });
});


