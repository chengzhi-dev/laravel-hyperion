<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use App\UserReinsurance;
use App\UserReinsuranceCedant;
use App\Notifications\MailResetPasswordNotification ;

use Illuminate\Support\Facades\Notification;

class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    // protected function sendResetLinkResponse(Request $request, $response)
    // {
    //     return response(['message'=> $response]);

    // }


    // protected function sendResetLinkFailedResponse(Request $request, $response)
    // {
    //     return response(['error'=> $response], 422);

    // }

    /*
     * get Reset Password Token for reinsurance company
     */
    public function getResetTokenReins(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'email' => 'required|email'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }


            $user = UserReinsurance::where('email', $request->input('email'))->first();
            if (!$user) {
                return $this->sendError('Email not recognized in the database', '', 400);
            }
            $token = $this->broker()->createToken($user);

            try {

                Notification::send($user, new MailResetPasswordNotification($token,'rins',$request->input('email')));
                return $this->sendResponse(null,'Reset password email sent successfully', 200);

            } catch (\Throwable $th) {
                return $this->sendError('Something went wrong. Please try again.',$th, 400);
            }




    }



     /*
     * get Reset Password Token for insurance company
     */
    public function getResetTokenIns(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'email' => 'required|email'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }


            $user = UserReinsuranceCedant::where('email', $request->input('email'))->first();
            if (!$user) {
                return $this->sendError('Email not recognized in the database', '', 400);
            }
            $token = $this->broker()->createToken($user);

            try {

                Notification::send($user, new MailResetPasswordNotification($token,'ins',$request->input('email')));
                return $this->sendResponse([],'Reset password email sent successfully', 200);

            } catch (\Throwable $th) {
                return $this->sendError('Something went wrong. Please try again.',$th, 400);
            }

    }



}
