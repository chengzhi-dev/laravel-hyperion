<?php

namespace App\Http\Controllers;

use App\UserReinsurance;
use App\UserReinsuranceProfile;
use App\UserReinsuranceRole;
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

class UserReinsuranceController extends BaseController
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
     * create user for reinsurance company
     */
    public function create_user(Request $request)
    {
        $client_ip = $this->getIp();
        $validator = Validator::make($request->all() , [
            'fullname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users_reinsurances',
            'password' => 'required|min:8',
            'reinsurances_id' => 'required',
            'profiles_users_reinsurance_id' => 'required',
            'users_reinsurances_role' => 'required',
            'position' => 'required',
            'gender' => 'required',
            'civility' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        //$encoded_ret = json_encode($_FILES);
        //return $this->sendResponse($_FILES, 'File array', 200);
        //echo '<pre>'; print_r($_FILES); exit;
        $signature_path = '';
        if(isset($_FILES["signature"]["name"]))
        {            
               if($_FILES["signature"]["error"] == 0)   
               {
                    $tmp_name = $_FILES["signature"]["tmp_name"];
                    $name = str_replace(' ', '_', $_FILES["signature"]["name"]);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
                    {
                        $name = 'signature_'.time().'.'.$ext;
                        $path = public_path().'/images/cicare_user';
                        $path2 = 'images/cicare_user';
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
        
        $photo_path = '';
        if(isset($_FILES["photo"]["name"]))
        {            
               if($_FILES["photo"]["error"] == 0)   
               {
                    $tmp_name = $_FILES["photo"]["tmp_name"];
                    $name = str_replace(' ', '_', $_FILES["photo"]["name"]);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
                    {
                        $name = 'photo_'.time().'.'.$ext;
                        $path = public_path().'/images/cicare_user';
                        $path2 = 'images/cicare_user';
                        $final_file_path = $path."/".$name;
                        $final_file_path2 = $path2."/".$name;
                        if(!file_exists($path))
                        {
                            mkdir($path, 0777, true);
                        }

                        if(move_uploaded_file($tmp_name, $final_file_path))
                        {
                            $photo_path = $final_file_path2;
                        }
                    }
               }
        }
        
        $stamp_path = '';
        if(isset($_FILES["stamp"]["name"]))
        {            
               if($_FILES["stamp"]["error"] == 0)   
               {
                    $tmp_name = $_FILES["stamp"]["tmp_name"];
                    $name = str_replace(' ', '_', $_FILES["stamp"]["name"]);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
                    {
                        $name = 'stamp_'.time().'.'.$ext;
                        $path = public_path().'/images/cicare_user';
                        $path2 = 'images/cicare_user';
                        $final_file_path = $path."/".$name;
                        $final_file_path2 = $path2."/".$name;
                        if(!file_exists($path))
                        {
                            mkdir($path, 0777, true);
                        }

                        if(move_uploaded_file($tmp_name, $final_file_path))
                        {
                            $stamp_path = $final_file_path2;
                        }
                    }
               }
        }

        $initial_name = $this->getInitalNames($request->get('fullname'));        
        $user = UserReinsurance::create([
            'fullname' => $request->get('fullname'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'status' => $request->get('status'),
            'reinsurances_id' => $this->convertObjectId($request->get('reinsurances_id')),
            'users_reinsurances_role' => $this->convertObjectId($request->get('users_reinsurances_role')),
            'profiles_users_reinsurance_id' => $this->convertObjectId($request->get('profiles_users_reinsurance_id')),
            'acronym' => $initial_name,
            'position' => $request->get('position'),
            'gender' => $request->get('gender'),
            'civility' => $request->get('civility'),
            'signature' => $signature_path,
            'photo' => $photo_path,
            'stamp' => $stamp_path,
            'ip_address' => $client_ip,
            'status' => $request->get('status')
        ]);

        $token = JWTAuth::fromUser($user);
        $user_id = '';
        if(isset($user->_id) && $user->_id != '')
        {
            $user_id = $user->_id;
        }

        $result['user_id'] = $user_id;
        return $this->sendResponse($result, 'User created successfully', 200);
    }

    /*
     * update user for reinsurance company
     */
    public function update_user(Request $request)
    {
        $client_ip = $this->getIp();
        $validator = Validator::make($request->all() , [
            'fullname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users_reinsurances,email,'. $request->user_id. ',_id',
            'password' => 'nullable|min:8',
            'reinsurances_id' => 'required',
            //'profiles_users_reinsurance_id' => 'required',
            'users_reinsurances_role' => 'required',
            'position' => 'required',
            'gender' => 'required',
            'civility' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $signature_path = '';
        if(isset($_FILES["signature"]["name"]))
        {            
               if($_FILES["signature"]["error"] == 0)   
               {
                    $tmp_name = $_FILES["signature"]["tmp_name"];
                    $name = str_replace(' ', '_', $_FILES["signature"]["name"]);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
                    {
                        $name = 'signature_'.time().'.'.$ext;
                        $path = public_path().'/images/cicare_user';
                        $path2 = 'images/cicare_user';
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
        
        $photo_path = '';
        if(isset($_FILES["photo"]["name"]))
        {            
               if($_FILES["photo"]["error"] == 0)   
               {
                    $tmp_name = $_FILES["photo"]["tmp_name"];
                    $name = str_replace(' ', '_', $_FILES["photo"]["name"]);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
                    {
                        $name = 'photo_'.time().'.'.$ext;
                        $path = public_path().'/images/cicare_user';
                        $path2 = 'images/cicare_user';
                        $final_file_path = $path."/".$name;
                        $final_file_path2 = $path2."/".$name;
                        if(!file_exists($path))
                        {
                            mkdir($path, 0777, true);
                        }

                        if(move_uploaded_file($tmp_name, $final_file_path))
                        {
                            $photo_path = $final_file_path2;
                        }
                    }
               }
        }
        
        $stamp_path = '';
        if(isset($_FILES["stamp"]["name"]))
        {            
               if($_FILES["stamp"]["error"] == 0)   
               {
                    $tmp_name = $_FILES["stamp"]["tmp_name"];
                    $name = str_replace(' ', '_', $_FILES["stamp"]["name"]);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
                    {
                        $name = 'stamp_'.time().'.'.$ext;
                        $path = public_path().'/images/cicare_user';
                        $path2 = 'images/cicare_user';
                        $final_file_path = $path."/".$name;
                        $final_file_path2 = $path2."/".$name;
                        if(!file_exists($path))
                        {
                            mkdir($path, 0777, true);
                        }

                        if(move_uploaded_file($tmp_name, $final_file_path))
                        {
                            $stamp_path = $final_file_path2;
                        }
                    }
               }
        }

        $user = UserReinsurance::find($request->user_id);
        if($user != null || $user != '')
        {
            $user->fullname = $request->get('fullname');
            $user->email = $request->get('email');
            if($request->get('password') != '' && $request->get('password') != null)
            {
                $user->password = Hash::make($request->get('password'));
            }
            $user->status = $request->get('status');
            $user->reinsurances_id = $this->convertObjectId($request->get('reinsurances_id'));
            $user->users_reinsurances_role = $this->convertObjectId($request->get('users_reinsurances_role'));
            $user->profiles_users_reinsurance_id = $this->convertObjectId($request->get('profiles_users_reinsurance_id'));
            
            if($signature_path != '')
            {
                $user->signature = $signature_path;
            }
            
            if($photo_path != '')
            {
                $user->photo = $photo_path;
            }
            
            if($stamp_path != '')
            {
                $user->stamp = $stamp_path;
            }
            
            $initial_name = $this->getInitalNames($request->get('fullname'));  
            $user->acronym = $initial_name;
            $user->gender = $request->get('gender');
            $user->civility = $request->get('civility');
            $user->position = $request->get('position');
            $user->ip_address = $client_ip;
            $user->updated_at = date('Y-m-d H:i:s');
            $user->save();
        }

        $result['user_id'] = $request->user_id;
        return $this->sendResponse($result, 'User updated successfully', 200);
    }
    
    /*
     * List of reinsurance users 
     */
    public function view_user(Request $request)
    {
        $return_array = array();
        if($request->user_id != '')
        {
            $user_id = $request->user_id;
            $view_user = UserReinsurance::find($user_id);
            
            if($view_user != '')
            {
                $role_id = (string)$view_user->users_reinsurances_role;
                $profile_id = (string)$view_user->profiles_users_reinsurance_id;
                $role_data = UserReinsuranceRole::find($role_id);
                $profile_data = UserReinsuranceProfile::find($profile_id);
                $role_name = '';
                $profile_name = '';
                if($role_data != '')
                {
                    $role_name = $role_data->name;
                }

                if($profile_data != '')
                {
                    $profile_name = $profile_data->name;
                }
                    
                $return_array['id'] = $view_user->_id;
                $return_array['fullname'] = $view_user->fullname;
                $return_array['email'] = $view_user->email;
                $return_array['status'] = $view_user->status;
                $return_array['users_reinsurances_role'] = $role_id;
                $return_array['profiles_users_reinsurance_id'] = $profile_id;
                $return_array['users_reinsurances_role_name'] = $role_name;
                $return_array['profiles_users_reinsurance_name'] = $profile_name;
                $return_array['gender'] = $view_user->gender;
                $return_array['civility'] = $view_user->civility;
                $return_array['position'] = $view_user->position;
                $return_array['acronym'] = $view_user->acronym;
                $return_array['signature'] = $view_user->signature;
                $return_array['photo'] = $view_user->photo;
                $return_array['stamp'] = $view_user->stamp;
                $return_array['created_at'] = $view_user->created_at;
            }
                        
        }
        return $this->sendResponse($return_array, 'View user details', 200); 
    }
    
    /*
     * List of reinsurance users 
     */
    public function list_users(Request $request)
    {
        $user = JWTAuth::user();
        $loggedin_email = $user->email;
        $list_users = UserReinsurance::where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->where('email','!=',$loggedin_email)->orderBy('created_at', 'desc')->get();
        
        $return_array = array();
        if(!empty($list_users))
        {
            $i=0;
            foreach($list_users as $list_user)
            {
                $role_id = (string)$list_user->users_reinsurances_role;
                $profile_id = (string)$list_user->profiles_users_reinsurance_id;
                $role_data = UserReinsuranceRole::find($role_id);
                $profile_data = UserReinsuranceProfile::find($profile_id);
                $role_name = '';
                $profile_name = '';
                if($role_data != '')
                {
                    $role_name = $role_data->name;
                }
                
                if($profile_data != '')
                {
                    $profile_name = $profile_data->name;
                }
                
                //echo '<pre>'; print_r($role_data); exit;
                $return_array[$i]['id'] = $list_user->_id;
                $return_array[$i]['fullname'] = $list_user->fullname;
                $return_array[$i]['email'] = $list_user->email;
                $return_array[$i]['status'] = $list_user->status;
                $return_array[$i]['users_reinsurances_role'] = $role_id;
                $return_array[$i]['profiles_users_reinsurance_id'] = $profile_id;
                $return_array[$i]['users_reinsurances_role_name'] = $role_name;
                $return_array[$i]['profiles_users_reinsurance_name'] = $profile_name;
                $return_array[$i]['gender'] = $list_user->gender;
                $return_array[$i]['civility'] = $list_user->civility;
                $return_array[$i]['position'] = $list_user->position;
                $return_array[$i]['acronym'] = $list_user->acronym;
                $return_array[$i]['signature'] = $list_user->signature;
                $return_array[$i]['photo'] = $list_user->photo;
                $return_array[$i]['stamp'] = $list_user->stamp;
                $return_array[$i]['created_at'] = $list_user->created_at;
                $i++;
            }
        }
        return $this->sendResponse($return_array, 'List of reinsurance users', 200); 
    }

    /*
     * login user for reinsurance company
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
            $userDetail['fullname'] = $user->fullname;
            $userDetail['email'] = $user->email;
            $reinsurances_id = (string)$user->reinsurances_id;
            $userDetail['reinsurances_id'] = $reinsurances_id;
            $users_reinsurances_role = (string)$user->users_reinsurances_role;
            $userDetail['users_reinsurances_role'] = $users_reinsurances_role;    
            $userDetail['signature'] = $user->signature;
            $userDetail['photo'] = $user->photo;
            $userDetail['stamp'] = $user->stamp;
            $userDetail['gender'] = $user->gender;
            $userDetail['civility'] = $user->civility;
            $userDetail['position'] = $user->position;
            $userDetail['acronym'] = $user->acronym;  
        }
        else if($user != '' && isset($user->status) && $user->status == 0)
        {
            return $this->sendError('User is inactive.', [], 400);
        }
        else
        {
            return $this->sendError('User doesnot exist.', [], 400);
        }
        
        $result['userDetail'] = $userDetail;
        $result['token'] = $token;
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
     * create profile for reinsurance company
     */
    public function create_profile(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|string|max:255',
            'modules_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $user = UserReinsuranceProfile::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'modules_id' => $request->get('modules_id')
        ]);

        $user_profile_id = '';
        if(isset($user->_id) && $user->_id != '')
        {
            $user_profile_id = $user->_id;
        }

        $result['user_profile_id'] = $user_profile_id;
        return $this->sendResponse($result, 'User profile created successfully', 200);
    }

    /*
     * update profile for reinsurance company
     */
    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|string|max:255',
            'modules_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $user = UserReinsuranceProfile::find($request->user_profile_id);
        if($user != null || $user != '')
        {
            $user->name = $request->get('name');
            $user->description = $request->get('description');
            $user->modules_id = $request->get('modules_id');
            $user->updated_at = date('Y-m-d H:i:s');
            $user->save();
        }

        $result['user_profile_id'] = $request->user_profile_id;
        return $this->sendResponse($result, 'User profile updated successfully', 200);
    }

    /*
     * create user role for reinsurance company
     */

    public function create_role(Request $request){
        $validator = Validator::make($request->all() , [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $role = UserReinsuranceRole::create([
            'name' => $request->get('name')
        ]);

        $user_role_id = '';
        if(isset($role->_id) && $role->_id != '')
        {
            $user_role_id = $role->_id;
        }

        $result['user_role_id'] = $user_role_id;
        return $this->sendResponse($result, 'User role created successfully', 200);
    }


    /*
     * Update user role for reinsurance company
     */

    public function update_role(Request $request){
        $validator = Validator::make($request->all() , [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $role = UserReinsuranceRole::find($request->user_role_id);
        if($role != null || $role != '')
        {
            $role->name = $request->get('name');
            $role->updated_at = date('Y-m-d H:i:s');
            $role->save();
        }

        $result['user_role_id'] = $request->user_role_id;
        return $this->sendResponse($result, 'User role updated successfully', 200);
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
        return $this->sendResponse($user, 'User exists', 200);
    }

}
