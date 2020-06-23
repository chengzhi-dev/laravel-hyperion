<?php

namespace App\Http\Controllers;

use App\GroupInsurance;
use App\UserReinsurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\JWTManager as JWT;

class GroupInsuranceController extends BaseController
{
    function __construct()
    {
        \Config::set('auth.model', UserReinsurance::class);
        \Config::set('jwt.user', UserReinsurance::class);
        \Config::set('auth.providers', ['users' => [
                'driver' => 'eloquent',
                'model' => UserReinsurance::class,
            ]]);
    }
    
    /*
     * create group for Insurance company
     */
    public function create_group(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255|unique:groups_cedants',
        ]);

        if($validator->fails()){
            //return response()->json($validator->errors()->toJson(), 400);
            return $this->sendError('Validation Error', $validator->errors(), 400);
        }
        
        //echo '<pre>'; print_r('here'); exit;

        $group = GroupInsurance::create([
            'name' => $request->get('name'),
        ]);

        $group_id = '';
        if(isset($group->_id) && $group->_id != '')
        {
            $group_id = $group->_id;
        }

        $result['group_id'] = $group_id;
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'Group created successfully', 200);
    }

    /*
     * update group for Insurance company
     */
    public function update_group(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255|unique:groups_cedants,name,'. $request->group_id,
        ]);

        if($validator->fails()){
            //return response()->json($validator->errors()->toJson(), 400);
            return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $group = GroupInsurance::find($request->group_id);
        if($group != null || $group != '')
        {
            $group->name = $request->get('name');
            $group->updated_at = date('Y-m-d H:i:s');
            $group->save();
        }

        $result['group_id'] = $request->group_id;
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'Group updated successfully', 200);
    }


}
