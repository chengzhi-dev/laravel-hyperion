<?php

namespace App\Http\Controllers;

use App\UserReinsuranceCedant;
use App\UserCedantRole;
use App\ReinsuranceCedant;
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

class UserCedantController extends BaseController
{   
    function __construct()
    {
        \Config::set('auth.model', UserReinsuranceCedant::class);
        \Config::set('jwt.user', UserReinsuranceCedant::class);
        \Config::set('auth.providers', ['users' => [
                'driver' => 'eloquent',
                'model' => UserReinsuranceCedant::class,
            ]]);
    }
    
    /*
     * create user for insurance company
     */
    public function create_user(Request $request)
    {
        $client_ip = $this->getIp();
        $validator = Validator::make($request->all() , [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users_cedants',
            'password' => 'required|min:8',
            'cedants_id' => 'required',
            'users_cedants_role_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400); 
        }

        $signature_path = '';
        if(isset($_FILES["signature"]["name"]))
        { 
            foreach($_FILES["signature"]["error"] as $key=>$error) 
            { 
               if($error == 0)
               {
                    $tmp_name = $_FILES["signature"]["tmp_name"][$key];
                    $name = str_replace(' ', '_', $_FILES["signature"]["name"][$key]);                
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')   
                    { 
                        $name = 'profile_'.time().'.'.$ext;
                        $path = public_path().'/images/cedant_user';
                        $path2 = 'images/cedant_user';
                        $final_file_path = $path."/".$name;
                        $final_file_path2 = $path2."/".$name;
                        if(!file_exists($path))
                        {
                            mkdir($path, 0777, true);                            
                        }                                           

                        if(move_uploaded_file($tmp_name, $final_file_path))
                        {
                            $signature_path = $final_file_path2;
                        }
                    }                    
               }
            }            
        }
        
        $user = UserReinsuranceCedant::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'status' => $request->get('status'),
            'cedants_id' => $this->convertObjectId($request->get('cedants_id')),
            'users_cedants_role_id' => $this->convertObjectId($request->get('users_cedants_role_id')),
            'signature' => $signature_path,
            'ip_address' => $client_ip
        ]);
        
        $user_id = '';
        if(isset($user->_id) && $user->_id != '')
        {
            $user_id = $user->_id;
        }
        
        $result['user_id'] = $user_id;  
        return $this->sendResponse($result, 'User created successfully', 200);
    }
    
    /*
     * update user for insurance company
     */
    public function update_user(Request $request)
    {
        $client_ip = $this->getIp();
        $validator = Validator::make($request->all() , [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users_cedants,email,'. $request->user_id. ',_id', 
            'password' => 'nullable|min:8',
            'cedants_id' => 'required',
            'users_cedants_role_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400); 
        }

        $signature_path = '';
        if(isset($_FILES["signature"]["name"]))
        { 
            foreach($_FILES["signature"]["error"] as $key=>$error) 
            { 
               if($error == 0)
               {
                    $tmp_name = $_FILES["signature"]["tmp_name"][$key];
                    $name = str_replace(' ', '_', $_FILES["signature"]["name"][$key]);                
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')   
                    { 
                        $name = 'profile_'.time().'.'.$ext;
                        $path = public_path().'/images/cedant_user';
                        $path2 = 'images/cedant_user';
                        $final_file_path = $path."/".$name;
                        $final_file_path2 = $path2."/".$name;
                        if(!file_exists($path))
                        {
                            mkdir($path, 0777, true);                            
                        }                                           

                        if(move_uploaded_file($tmp_name, $final_file_path))
                        {
                            $signature_path = $final_file_path2;
                        }
                    }                    
               }
            }            
        }
        
        $user = UserReinsuranceCedant::find($request->user_id);
        if($user != null || $user != '')
        {
            $user->username = $request->get('username');
            $user->email = $request->get('email');
            if($request->get('password') != '' && $request->get('password') != null)
            {
                $user->password = Hash::make($request->get('password'));
            }
            $user->status = $request->get('status');
            $user->cedants_id = $this->convertObjectId($request->get('cedants_id'));
            if($signature_path != '')
            {
                $user->signature = $signature_path;
            }
            $user->users_cedants_role_id = $this->convertObjectId($request->get('users_cedants_role_id'));
            $user->ip_address = $client_ip;
            $user->updated_at = date('Y-m-d H:i:s');
            $user->save();
        }
        
        $result['user_id'] = $request->user_id;  
        return $this->sendResponse($result, 'User updated successfully', 200);
    }
    
    /*
     * List of insurance users 
     */
    public function list_users(Request $request)
    {
        $user = JWTAuth::user();
        $loggedin_email = $user->email;
        $list_users = UserReinsuranceCedant::where('cedants_id','=',$this->convertObjectId($request->cedants_id))->where('email','!=',$loggedin_email)->orderBy('created_at', 'desc')->get();
        
        $return_array = array();
        if(!empty($list_users))
        {
            $i=0;
            foreach($list_users as $list_user)
            {
                $role_id = (string)$list_user->users_cedants_role_id;
                $role_data = UserCedantRole::find($role_id);
                $role_name = '';
                if($role_data != '')
                {
                    $role_name = $role_data->name;
                }   
                
                //echo '<pre>'; print_r($list_user); exit;
                $return_array[$i]['id'] = $list_user->_id;
                $return_array[$i]['username'] = $list_user->username;
                $return_array[$i]['email'] = $list_user->email;
                $return_array[$i]['status'] = $list_user->status;
                $return_array[$i]['users_cedants_role_id'] = $role_id;
                $return_array[$i]['users_cedants_role_name'] = $role_name;
                $return_array[$i]['signature'] = $list_user->signature;
                $return_array[$i]['created_at'] = $list_user->created_at;
                $i++;
            }
        }
        return $this->sendResponse($return_array, 'List of insurance users', 200); 
    }
    
    /*
     * login user for insurance company(cedant)
     */
    public function login_user(Request $request)
    {
        $credentials = $request->all();

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->sendError('Invalid credentials', [], 400);
            }
        } catch (JWTException $e) {
            return $this->sendError('Could not create token', [], 500);
        }

        $user = JWTAuth::user();
        $userDetail = array();
        if($user != '' && isset($user->status) && $user->status == 1)
        {
            $userDetail['id'] = $user->_id;
            $userDetail['username'] = $user->username;
            $userDetail['email'] = $user->email;
            $cedants_id = (string)$user->cedants_id;
            $userDetail['cedants_id'] = $cedants_id;
            $users_cedants_role_id = (string)$user->users_cedants_role_id;
            $userDetail['users_cedants_role_id'] = $users_cedants_role_id; 
            $userDetail['signature'] = $user->signature;            
        }
        else if($user != '' && isset($user->status) && $user->status == 0)
        {
            return $this->sendError('User is inactive.', [], 400);
        }
        else
        {
            return $this->sendError('User doesnot exist.', [], 400);
        }
        
        $result['token'] = $token; 
        $result['userDetail'] = $userDetail;
        return $this->sendResponse($result, 'User logged in successfully');
    }
    
    /*
     * logout user or destroy the valid token
     */
    public function logout( Request $request ) {

        $token = $request->header('Authorization');

        try {
            JWTAuth::parseToken()->invalidate($token);

            return $this->sendResponse([], 'User logged out successfully');
        } catch (TokenExpiredException $exception) {
            return $this->sendError('Token expired', [], 401);
        } catch (TokenInvalidException $exception) {
            return $this->sendError('Token invalid', [], 401);
        } catch (JWTException $exception) {
            return $this->sendError('Token missing', [], 500);
        }
    }
    
    /*
     * get client IP address
     */
    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }    

    /*
     * get logged in user details
     */
    public function getAuthenticatedUser()
    {
         try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return $this->sendError('User not found', [], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->sendError('Token expired', [], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->sendError('Token invalid', [], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->sendError('Token missing', [], $e->getStatusCode());
        }
        //$user = JWTAuth::parseToken()->authenticate();
        //$result['user'] = $user; 
        
        if($user != '')
        {
            //get cedant company details
            $get_cedant = ReinsuranceCedant::find($user->cedants_id);
            $reinsurances_id = '';
            $types_cedants_id = '';
            if($get_cedant != '')
            {
                $reinsurances_id = (string)$get_cedant->reinsurances_id;
                $types_cedants_id = (string)$get_cedant->types_cedants_id;
            }            
            
            $user['reinsurances_id'] = $reinsurances_id; 
            $user['cedants_type_id'] = $types_cedants_id;                       
        }
        
        return $this->sendResponse($user, 'User exists', 200);
    }
    
    /*
     * forgot password
     */
    public function ForgotPassword ()
    {

    }

}

