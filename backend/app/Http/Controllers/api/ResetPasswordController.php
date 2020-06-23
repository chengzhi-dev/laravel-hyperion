<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\UserReinsurance;
use App\UserReinsuranceCedant;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;


    // protected function sendResetResponse(Request $request, $response)
    // {
    //     return response(['message' => trans($response)]);
    // }

    // protected function sendResetFailedResponse(Request $request, $response)
    // {
    //     return response(['error' => trans($response)], 422);
    // }


    // protected function resetPassword($user , $password){
    //     $user->password = Hash::make($password) ;
    //     $user->save();

    //     event(new PasswordReset($user));
    // }


    /*
     * Reset Password for reinsurance company
     */
    public function resetReins(Request $request)
    {
        \Config::set('auth.model', UserReinsurance::class);
        \Config::set('jwt.user', UserReinsurance::class);
        \Config::set('auth.providers', ['users' => [
                'driver' => 'eloquent',
                'model' => UserReinsurance::class,
            ]]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password_confirmation' => 'required_with:password|same:password',
            'password' => 'required',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 400);
        }


        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $user->password = Hash::make($password) ;
                $user->save();
                event(new PasswordReset($user)) ;
            }
        );

        if ($response == Password::PASSWORD_RESET) {

            $result['email'] = $request->input('email');

            return $this->sendResponse($result, 'user_updated_success', 200);
        } else {
            return $this->sendError('authorization_token_expired', '', 400);
        }

    }

    /*
     * Reset Password for insurance company
     */
    public function resetIns(Request $request)
    {
        \Config::set('auth.model', UserReinsuranceCedant::class);
        \Config::set('jwt.user', UserReinsuranceCedant::class);
        \Config::set('auth.providers', ['users' => [
                'driver' => 'eloquent',
                'model' => UserReinsuranceCedant::class,
            ]]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password_confirmation' => 'required_with:password|same:password',
            'password' => 'required',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $user->password = Hash::make($password) ;
                $user->save();
                event(new PasswordReset($user)) ;
            }
        );
        
        if ($response == Password::PASSWORD_RESET) {

            $result['email'] = $request->input('email');
            
            return $this->sendResponse($result, 'user_updated_success', 200);
        } else {
            return $this->sendError('authorization_token_expired', '', 400);
        }

    }


}
