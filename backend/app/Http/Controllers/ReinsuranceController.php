<?php

namespace App\Http\Controllers;

use App\Reinsurance;
use App\ReinsuranceCedant;
use App\ReinsuranceInsuranceType;
use App\UserReinsuranceCedant;
use App\UserReinsuranceProfile;
use App\UserReinsuranceRole;
use App\UserCedantRole;
use App\GroupInsurance;
use App\CedantType;
use App\Currency;
use App\Country;
use App\Region;
use App\Representation;
use App\Branch;
use App\BranchCapital;
use App\BranchCommission;
use App\Comment;
use App\CedantPremiums;
use App\CedantPremiumCases;
use App\CedantPremiumNotLifeCases;
use App\CedantClaims;
use App\CedantClaimCases;
use App\CedantClaimNotLifeCases;
use App\UserReinsurance;
use App\Files;
use App\Notes;
use App\SettingApp;
use App\PaymentMethod;
use App\Gender;
use App\Civility;
use Carbon\Carbon;

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

require_once base_path().'/modules/phpdocx/classes/CreateDocx.inc';
use CreateDocxFromTemplate;

class ReinsuranceController extends BaseController
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
     * create country for reinsurance company
     */
    public function create_country(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255',
            'code' =>'required',
            'regions_id' => 'required',
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $country = Country::create([
            'name' => $request->name,
            'code' => $request->code,
            'regions_id' => $request->regions_id,
        ]);

        $country_id = '';
        if(isset($country->_id) && $country->_id != '')
        {
            $country_id = $country->_id;
        }

        $result['country_id'] = $country_id;
        return $this->sendResponse($result, 'Country created successfully', 200);
    }

    /*
     * update country for reinsurance company
     */
    public function update_country(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255',
            'code' =>'required',
            'regions_id' => 'required',
            'country_id' => 'required',

        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $country = Country::find($request->country_id);
        if($country != null || $country != '')
        {
            $country->name = $request->name;
            $country->code = $request->code;
            $country->regions_id = $request->regions_id;
            $country->updated_at = date('Y-m-d H:i:s');
            $country->save();
        }

        $result['country_id'] = $request->country_id;
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'Country updated successfully', 200);
    }

    /*
     * create region/zone for reinsurance company
     */
    public function create_region(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255',
            'code' =>'required',
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $region = Region::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        $region_id = '';
        if(isset($region->_id) && $region->_id != '')
        {
            $region_id = $region->_id;
        }

        $result['region_id'] = $region_id;
        return $this->sendResponse($result, 'Region created successfully', 200);
    }

    /*
     * update region/zone for reinsurance company
     */
    public function update_region(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255',
            'code' =>'required',
            'region_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $region = Region::find($request->region_id);
        if($region != null || $region != '')
        {
            $region->name = $request->name;
            $region->code = $request->code;
            $region->updated_at = date('Y-m-d H:i:s');
            $region->save();
        }

        $result['region_id'] = $request->region_id;
        return $this->sendResponse($result, 'Region updated successfully', 200);
    }

    /*
     * create insurance type for reinsurance company
     */
    public function create_insurance_type(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255|unique:types_cedants',
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $ins_type = ReinsuranceInsuranceType::create([
            'name' => $request->get('name'),
        ]);

        $ins_type_id = '';
        if(isset($ins_type->_id) && $ins_type->_id != '')
        {
            $ins_type_id = $ins_type->_id;
        }

        $result['ins_type_id'] = $ins_type_id;
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'Insurance type created successfully', 200);
    }

    /*
     * update insurance type for reinsurance company
     */
    public function update_insurance_type(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255|unique:types_cedants,name,'. $request->ins_type_id. ',_id'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $ins_type = ReinsuranceInsuranceType::find($request->ins_type_id);
        if($ins_type != null || $ins_type != '')
        {
            $ins_type->name = $request->get('name');
            $ins_type->updated_at = date('Y-m-d H:i:s');
            $ins_type->save();
        }

        $result['ins_type_id'] = $request->ins_type_id;
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'Insurance type updated successfully', 200);
    }

    /*
     * create insurance company for reinsurance company
     */
    public function create_cedant(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:cedants',
            'groups_cedants_id' => 'required',
            'reinsurances_id' => 'required',
            'contact' => 'required',
            //'logo' => 'required',
            'color1' => 'required',
            'color2' => 'required',
            'countries_id' => 'required',
            'region_id' => 'required',
            'types_cedants_id' => 'required',
            'currencies_id' => 'required',
            'benefit_percentage' => 'required'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $logo_path = '';
        if(isset($_FILES["logo"]["name"]))
        {
            foreach($_FILES["logo"]["error"] as $key=>$error)
            {
               if($error == 0)
               {
                    $tmp_name = $_FILES["logo"]["tmp_name"][$key];
                    $name = str_replace(' ', '_', $_FILES["logo"]["name"][$key]);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
                    {
                        $name = 'logo_'.time().'.'.$ext;
                        $path = public_path().'/images/cedants';
                        $path2 = 'images/cedants';
                        $final_file_path = $path."/".$name;
                        $final_file_path2 = $path2."/".$name;
                        if(!file_exists($path))
                        {
                            mkdir($path, 0777, true);
                        }

                        if(move_uploaded_file($tmp_name, $final_file_path))
                        {
                            $logo_path = $final_file_path2;
                        }
                    }
               }
            }
        }

        $ins = ReinsuranceCedant::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'groups_cedants_id' => $this->convertObjectId($request->get('groups_cedants_id')),
            'reinsurances_id' => $this->convertObjectId($request->get('reinsurances_id')),
            'contact' => $request->get('contact'),
            'logo' => $logo_path,
            'color1' => $request->get('color1'),
            'color2' => $request->get('color2'),
            'countries_id' => $this->convertObjectId($request->get('countries_id')),
            'region_id' => $this->convertObjectId($request->get('region_id')),
            'types_cedants_id' => $this->convertObjectId($request->get('types_cedants_id')),
            'currencies_id' => $this->convertObjectId($request->get('currencies_id')),
            'benefit_percentage' => $request->get('benefit_percentage'),
            'code' => $request->get('code')
        ]);

        $ins_id = '';
        if(isset($ins->_id) && $ins->_id != '')
        {
            $ins_id = $ins->_id;
        }

        $result['ins_id'] = $ins_id;
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'Insurance company created successfully', 200);
    }

    /*
     * update insurance company for reinsurance company
     */
    public function update_cedant(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:cedants,email,'. $request->ins_id. ',_id',
            'groups_cedants_id' => 'required',
            'reinsurances_id' => 'required',
            'contact' => 'required',
            //'logo' => 'required',
            'color1' => 'required',
            'color2' => 'required',
            'countries_id' => 'required',
            'region_id' => 'required',
            'types_cedants_id' => 'required',
            'currencies_id' => 'required',
            'benefit_percentage' => 'required'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $logo_path = '';
        if(isset($_FILES["logo"]["name"]))
        {
            foreach($_FILES["logo"]["error"] as $key=>$error)
            {
               if($error == 0)
               {
                    $tmp_name = $_FILES["logo"]["tmp_name"][$key];
                    $name = str_replace(' ', '_', $_FILES["logo"]["name"][$key]);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
                    {
                        $name = 'logo_'.time().'.'.$ext;
                        $path = public_path().'/images/cedants';
                        $path2 = 'images/cedants';
                        $final_file_path = $path."/".$name;
                        $final_file_path2 = $path2."/".$name;
                        if(!file_exists($path))
                        {
                            mkdir($path, 0777, true);
                        }

                        if(move_uploaded_file($tmp_name, $final_file_path))
                        {
                            $logo_path = $final_file_path2;
                        }
                    }
               }
            }
        }

        $ins = ReinsuranceCedant::find($request->ins_id);
        if($ins != null || $ins != '')
        {
            $ins->name = $request->get('name');
            $ins->email = $request->get('email');
            $ins->groups_cedants_id = $this->convertObjectId($request->get('groups_cedants_id'));
            $ins->reinsurances_id = $this->convertObjectId($request->get('reinsurances_id'));
            $ins->contact = $request->get('contact');
            if($logo_path != '')
            {
                $ins->logo = $logo_path;
            }
            $ins->color1 = $request->get('color1');
            $ins->color2 = $request->get('color2');
            $ins->countries_id = $this->convertObjectId($request->get('countries_id'));
            $ins->region_id = $this->convertObjectId($request->get('region_id'));
            $ins->types_cedants_id = $this->convertObjectId($request->get('types_cedants_id'));
            $ins->currencies_id = $this->convertObjectId($request->get('currencies_id'));
            $ins->benefit_percentage = $request->get('benefit_percentage');
            $ins->code = $request->get('code');
            $ins->updated_at = date('Y-m-d H:i:s');
            $ins->save();
        }

        $result['ins_id'] = $request->ins_id;
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'Insurance company updated successfully', 200);
    }

    /*
     * create user for reinsurance cedants - insurance company
     */
    public function create_cedant_user(Request $request)
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
     * update user for reinsurance cedants - insurance company
     */
    public function update_cedant_user(Request $request)
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
            if($request->get('password') != '')
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
    public function list_cedant_users(Request $request)
    {
        if($request->cedants_id != '')
        {
            $list_users = UserReinsuranceCedant::where('cedants_id','=',$this->convertObjectId($request->cedants_id))->orderBy('created_at', 'desc')->get();

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
                    $return_array[$i]['_id'] = $list_user->_id;
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
        else
        {
            return $this->sendResponse([], 'List of insurance users', 200);
        }
    }

    /*
     * List of all insurance users
     */
    public function list_all_cedants_users(Request $request)
    {
        $list_users = UserReinsuranceCedant::orderBy('created_at', 'desc')->get();
        $return_array = array();
        if(!empty($list_users))
        {
            $i=0;
            foreach($list_users as $list_user)
            {
                $role_id = (string)$list_user->users_cedants_role_id;
                $role_data = UserCedantRole::find($role_id);
                $cedants_id = (string)$list_user->cedants_id;
                $cedants_data = ReinsuranceCedant::find($cedants_id);
                $role_name = '';
                if($role_data != '')
                {
                    $role_name = $role_data->name;
                }

                $cedant_name = '';
                if($cedants_data != '')
                {
                    $cedant_name = $cedants_data->name;
                }

                //echo '<pre>'; print_r($cedant_name); exit;
                $return_array[$i]['_id'] = $list_user->_id;
                $return_array[$i]['username'] = $list_user->username;
                $return_array[$i]['email'] = $list_user->email;
                $return_array[$i]['status'] = $list_user->status;
                $return_array[$i]['users_cedants_role_id'] = $role_id;
                $return_array[$i]['users_cedants_role_name'] = $role_name;
                $return_array[$i]['cedants_id'] = $cedants_id;
                $return_array[$i]['cedant_name'] = $cedant_name;
                $return_array[$i]['signature'] = $list_user->signature;
                $return_array[$i]['created_at'] = $list_user->created_at;
                $i++;
            }
        }
        return $this->sendResponse($return_array, 'List of insurance users', 200);
    }

    /*
    * update premium slip for insurance company by reinsurance user
    */
    public function update_premium_slip(Request $request)
    {
       $validator = Validator::make($request->all() , [
           //'reference' => 'required|max:255',
           //'edited_period' => 'required',
           'premium_slip_id' => 'required',
           'cedants_type_id' => 'required',
           'insurance_type' => 'required',
           'cases_array' => 'required'

       ]);

       if($validator->fails()){
               return $this->sendError('Validation Error', $validator->errors(), 400);
       }

       $cases_array = $request->get('cases_array');
       $premium_slip_id = $request->get('premium_slip_id');
       $get_cedant_type = $request->insurance_type;
       $return_array = [];

       if(!empty($cases_array))
       {
           $i=0;
           $decode_cases = json_decode($cases_array);
           //echo '<pre>'; print_r($decode_cases); exit;
           foreach($decode_cases as $each_case)
           {
               $each_case = (array)$each_case;
               $case_id = $each_case['case_id']; //$request->get('case_id');

               if($get_cedant_type == 'not life')
               {
                   $premium_case = CedantPremiumNotLifeCases::where('_id','=',$case_id)->first();
                   $premium_case->active_status = 0;
                   $premium_case->updated_at = date('Y-m-d H:i:s');
                   $premium_case->save();

                   $case_validation_status = 'Pending';
                   $policy_number = $each_case['policy_number'];
                   $branch = $each_case['branch'];
                   $category = $each_case['category'];
                   $branches_id = $each_case['branches_id'];
                   $sub_branches_id = $each_case['sub_branches_id'];
                   $nature_risque_id = $each_case['nature_risque_id'];
                   $date_effective = $each_case['date_effective'];
                   $deadline = $each_case['deadline'];
                   $date_transaction = $each_case['date_transaction'];
                   $fullname_souscriber = $each_case['fullname_souscriber'];
                   $fullname_insured = $each_case['fullname_insured'];
                   $geographic_location = $each_case['geographic_location'];
                   $insured_capital = $each_case['insured_capital'];
                   $premium_ht = $each_case['premium_ht'];
                   $paid_commission = $each_case['paid_commission'];
                   $part_cedant_coass = $each_case['part_cedant_coass'];
                   $premium_ceded = $each_case['premium_ceded'];
                   $commission_cession = $each_case['commission_cession'];
                   $prime_net_ceded = $each_case['prime_net_ceded'];

                   if(isset($premium_slip_id))
                   {
                       $slipes_prime_id = $this->convertObjectId($premium_slip_id);
                   }

                   //save updated new case for a not life premium slip
                   $case_not_life_premium = CedantPremiumNotLifeCases::create([
                       'policy_number' => (isset($policy_number))?$policy_number:'',
                       'branch' => (isset($branch))?$branch:'',
                       'category' => (isset($category))?$category:'',
                       'branches_id' => (isset($branches_id))?$this->convertObjectId($branches_id):'',
                       'sub_branches_id' => (isset($sub_branches_id))?$this->convertObjectId($sub_branches_id):'',
                       'nature_risque_id' => (isset($nature_risque_id))?$nature_risque_id:'',
                       'date_effective' => (isset($date_effective))?$date_effective:'',
                       'deadline' => (isset($deadline))?$deadline:'',
                       'date_transaction' => (isset($date_transaction))?$date_transaction:'',
                       'fullname_souscriber' => (isset($fullname_souscriber))?$fullname_souscriber:'',
                       'fullname_insured' => (isset($fullname_insured))?$fullname_insured:'',
                       'geographic_location' => (isset($geographic_location))?$geographic_location:'',
                       'insured_capital' => (isset($insured_capital))?$insured_capital:'',
                       'premium_ht' => (isset($premium_ht))?$premium_ht:'',
                       'paid_commission' => (isset($paid_commission))?$paid_commission:'',
                       'part_cedant_coass' => (isset($part_cedant_coass))?$part_cedant_coass:'',
                       'premium_ceded' => (isset($premium_ceded))?$premium_ceded:'',
                       'commission_cession' => (isset($commission_cession))?$commission_cession:'',
                       'prime_net_ceded' => (isset($prime_net_ceded))?$prime_net_ceded:'',
                       'slipes_prime_id' => $slipes_prime_id,
                       'case_validation_status' => $case_validation_status,
                       'active_status' => 1
                   ]);
               }
               else if($get_cedant_type == 'life')
               {
                   $premium_case = CedantPremiumCases::where('_id','=',$case_id)->first();
                   $premium_case->active_status = 0;
                   $premium_case->updated_at = date('Y-m-d H:i:s');
                   $premium_case->save();

                   $case_validation_status = 'Pending';
                   $policy_number = $each_case['policy_number'];
                   $insured_number = $each_case['insured_number'];
                   $fullname_souscriber = $each_case['fullname_souscriber'];
                   $fullname_insured = $each_case['fullname_insured'];
                   $dateofbirth_insured = $each_case['dateofbirth_insured'];
                   $nature = $each_case['nature'];
                   $type = $each_case['type'];
                   $branches_id = $each_case['branches_id'];
                   $sub_branches_id = $each_case['sub_branches_id'];
                   $date_effective = $each_case['date_effective'];
                   $deadline = $each_case['deadline'];
                   $date_operation = $each_case['date_operation'];
                   $capital_insured_death_or_constitution = $each_case['capital_insured_death_or_constitution'];
                   $capital_insured_accidental_death = $each_case['capital_insured_accidental_death'];
                   $capital_insured_triply_accidentally = $each_case['capital_insured_triply_accidentally'];
                   $capital_insured_partial_permanent_disability = $each_case['capital_insured_partial_permanent_disability'];
                   $capital_insured_loss_jobs = $each_case['capital_insured_loss_jobs'];
                   $premium_periodicity = $each_case['premium_periodicity'];
                   $taux_supprime = $each_case['taux_supprime'];
                   $prime_deces = $each_case['prime_deces'];
                   $suprime_deces = $each_case['suprime_deces'];
                   $prime_guarantee_supplement = $each_case['prime_guarantee_supplement'];
                   $prime_nette_total = $each_case['prime_nette_total'];
                   $comission = $each_case['comission'];
                   $part_cedante = $each_case['part_cedante'];
                   $prime_nette_totale_cedante = $each_case['prime_nette_totale_cedante'];
                   $comission_cedante = $each_case['comission_cedante'];
                   $prime_cedee = $each_case['prime_cedee'];
                   $comission_cession = $each_case['comission_cession'];
                   $prime_nette_cedee = $each_case['prime_nette_cedee'];

                   if(isset($premium_slip_id))
                   {
                       $slipes_prime_id = $this->convertObjectId($premium_slip_id);
                   }

                   //save no of cases for a life premium slip
                   $case_life_premium = CedantPremiumCases::create([
                       'policy_number' => (isset($policy_number))?$policy_number:'',
                       'insured_number' => (isset($insured_number))?$insured_number:'',
                       'nature' => (isset($nature))?$nature:'',
                       'type' => (isset($type))?$type:'',
                       'branches_id' => (isset($branches_id))?$this->convertObjectId($branches_id):'',
                       'sub_branches_id' => (isset($sub_branches_id))?$this->convertObjectId($sub_branches_id):'',
                       'date_effective' => (isset($date_effective))?$date_effective:'',
                       'date_operation' => (isset($date_operation))?$date_operation:'',
                       'deadline' => (isset($deadline))?$deadline:'',
                       'fullname_souscriber' => (isset($fullname_souscriber))?$fullname_souscriber:'',
                       'fullname_insured' => (isset($fullname_insured))?$fullname_insured:'',
                       'dateofbirth_insured' => (isset($dateofbirth_insured))?$dateofbirth_insured:'',
                       'capital_insured_death_or_constitution' => (isset($capital_insured_death_or_constitution))?$capital_insured_death_or_constitution:'',
                       'capital_insured_accidental_death' => (isset($capital_insured_accidental_death))?$capital_insured_accidental_death:'',
                       'capital_insured_triply_accidentally' => (isset($capital_insured_triply_accidentally))?$capital_insured_triply_accidentally:'',
                       'capital_insured_partial_permanent_disability' => (isset($capital_insured_partial_permanent_disability))?$capital_insured_partial_permanent_disability:'',
                       'capital_insured_loss_jobs' => (isset($capital_insured_loss_jobs))?$capital_insured_loss_jobs:'',
                       'premium_periodicity' => (isset($premium_periodicity))?$premium_periodicity:'',
                       'taux_supprime' => (isset($taux_supprime))?$taux_supprime:'',
                       'prime_deces' => (isset($prime_deces))?$prime_deces:'',
                       'suprime_deces' => (isset($suprime_deces))?$suprime_deces:'',
                       'prime_guarantee_supplement' => (isset($prime_guarantee_supplement))?$prime_guarantee_supplement:'',
                       'prime_nette_total' => (isset($prime_nette_total))?$prime_nette_total:'',
                       'comission' => (isset($comission))?$comission:'',
                       'slipes_prime_id' => $slipes_prime_id,
                       'part_cedante' => (isset($part_cedante))?$part_cedante:'',
                       'prime_nette_totale_cedante' => (isset($prime_nette_totale_cedante))?$prime_nette_totale_cedante:'',
                       'comission_cedante' => (isset($comission_cedante))?$comission_cedante:'',
                       'prime_cedee' => (isset($prime_cedee))?$prime_cedee:'',
                       'comission_cession' => (isset($comission_cession))?$comission_cession:'',
                       'prime_nette_cedee' => (isset($prime_nette_cedee))?$prime_nette_cedee:'',
                       'case_validation_status' => $case_validation_status,
                       'active_status' => 1
                   ]);

               }
               $return_array[] = $policy_number;
               $i++;
           }
       }

       $result['premium_slip_id'] = $premium_slip_id;
       $result['cases_updated'] = $return_array;
       return $this->sendResponse($result, 'Premium slip updated successfully', 200);
    }

    /*
     * List of premium slips and cases related to it
     */
    public function list_premium_slips(Request $request)
    {
        $list_premiums = CedantPremiums::where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->where('approval_status','=','Verified')->orderBy('created_at', 'desc')->get();
        if(!empty($list_premiums))
        {
            foreach($list_premiums as $list_premium)
            {
                $cedant_type_id = $list_premium->cedants_type_id;

                $get_cedant_type = '';
                if(isset($cedant_type_id) && $cedant_type_id != '')
                {
                    $get_cedant_type_data = CedantType::find($cedant_type_id);
                    if($get_cedant_type_data != '')
                    {
                        $get_cedant_type = $get_cedant_type_data->name;
                    }
                }
                $list_premium['cedant_type'] = $get_cedant_type;

                if($get_cedant_type == 'NOT LIFE')
                {
                    $premium_cases = CedantPremiumNotLifeCases::where('slipes_prime_id','=',$this->convertObjectId($list_premium->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else
                {
                    $premium_cases = CedantPremiumCases::where('slipes_prime_id','=',$this->convertObjectId($list_premium->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                $list_premium['premium_cases'] = $premium_cases;
            }
        }
        //echo '<pre>'; print_r($list_premiums); exit;
        return $this->sendResponse($list_premiums, 'List of premium slips', 200);
    }

    /*
     * List of big risk premium slips and cases related to it
     */
    public function list_premium_big_risk_slips(Request $request)
    {
        $list_premiums = CedantPremiums::where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->where('slip_type','=','Big Risk')->where('approval_status','=','Verified')->orderBy('created_at', 'desc')->get();
        if(!empty($list_premiums))
        {
            foreach($list_premiums as $list_premium)
            {
                $cedant_type_id = $list_premium->cedants_type_id;
                $get_cedant_type = '';
                if(isset($cedant_type_id) && $cedant_type_id != '')
                {
                    $get_cedant_type_data = CedantType::find($cedant_type_id);
                    if($get_cedant_type_data != '')
                    {
                        $get_cedant_type = $get_cedant_type_data->name;
                    }
                }

                if($get_cedant_type == 'NOT LIFE')
                {
                    $premium_cases = CedantPremiumNotLifeCases::where('slipes_prime_id','=',$this->convertObjectId($list_premium->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else
                {
                    $premium_cases = CedantPremiumCases::where('slipes_prime_id','=',$this->convertObjectId($list_premium->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                $list_premium['premium_cases'] = $premium_cases;
            }
        }
        //echo '<pre>'; print_r($list_premiums); exit;
        return $this->sendResponse($list_premiums, 'List of big risk premium slips', 200);
    }

    /*
     * List of regularization premium slips and cases related to it
     */
    public function list_premium_regularization_slips(Request $request)
    {
        $list_premiums = CedantPremiums::where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->where('slip_type','=','Regularization')->where('approval_status','=','Verified')->orderBy('created_at', 'desc')->get();
        if(!empty($list_premiums))
        {
            foreach($list_premiums as $list_premium)
            {
                $cedant_type_id = $list_premium->cedants_type_id;
                $get_cedant_type = '';
                if(isset($cedant_type_id) && $cedant_type_id != '')
                {
                    $get_cedant_type_data = CedantType::find($cedant_type_id);
                    if($get_cedant_type_data != '')
                    {
                        $get_cedant_type = $get_cedant_type_data->name;
                    }
                }

                if($get_cedant_type == 'NOT LIFE')
                {
                    $premium_cases = CedantPremiumNotLifeCases::where('slipes_prime_id','=',$this->convertObjectId($list_premium->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else
                {
                    $premium_cases = CedantPremiumCases::where('slipes_prime_id','=',$this->convertObjectId($list_premium->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                $list_premium['premium_cases'] = $premium_cases;
            }
        }
        //echo '<pre>'; print_r($list_premiums); exit;
        return $this->sendResponse($list_premiums, 'List of regularized premium slips', 200);
    }

    /*
     * List of premium slips and cases related to a particular cedant
     */
    public function list_cedant_validated_premium_slips(Request $request)
    {
        $list_premiums = CedantPremiums::where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))
                ->where('cedants_id','=',$this->convertObjectId($request->cedants_id))
                ->where('approval_status','=','Verified')->orderBy('created_at', 'desc')->get();

        $list_slips_array = [];
        if(!empty($list_premiums))
        {
            foreach($list_premiums as $list_premium)
            {
                $cedant_type_id = $list_premium->cedants_type_id;
                $get_cedant_type = '';
                if(isset($cedant_type_id) && $cedant_type_id != '')
                {
                    $get_cedant_type_data = CedantType::find($cedant_type_id);
                    if($get_cedant_type_data != '')
                    {
                        $get_cedant_type = $get_cedant_type_data->name;
                    }
                }

                if($get_cedant_type == 'NOT LIFE')
                {
                    $premium_cases = CedantPremiumNotLifeCases::where('slipes_prime_id','=',$this->convertObjectId($list_premium->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else
                {
                    $premium_cases = CedantPremiumCases::where('slipes_prime_id','=',$this->convertObjectId($list_premium->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }

                $case_valid = [];
                if($premium_cases != null || $premium_cases != '')
                {
                    foreach($premium_cases as $premium_cas)
                    {
                        if($premium_cas->case_validation_status == 'Verified')
                        {
                           $case_valid[] = 'Verified';
                        }
                        else
                        {
                           $case_valid[] = 'Rejected';
                        }
                    }
                }

                if(in_array("Verified",$case_valid))
                {
                    $list_premium['premium_cases'] = $premium_cases;
                    $list_slips_array[] = $list_premium;
                }
            }
        }
        //echo '<pre>'; print_r($list_premiums); exit;
        return $this->sendResponse($list_slips_array, 'List of validated premium slips', 200);
    }

    /*
     * Detail about premium slip and cases related to it
     */
    public function view_premium_slip(Request $request)
    {
        if($request->premium_slip_id != '')
        {
            $view_premium_slip_detail = CedantPremiums::where('_id','=',$request->premium_slip_id)->first();
            $cedant_type_id = $view_premium_slip_detail->cedants_type_id;
            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::find($cedant_type_id);
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }
            $result['cedant_type'] = $get_cedant_type;
            $cedant_name = '';
            $cedant_country = '';
            $get_cedant_details = $this->get_cedant_details($view_premium_slip_detail->cedants_id);
            if(isset($get_cedant_details->original['data']) && !empty($get_cedant_details->original['data']) )
            {
                $cedant_name = $get_cedant_details->original['data']['name'];
                $cedant_country = $get_cedant_details->original['data']['country_name'];
            }
            $result['cedant_name'] = $cedant_name;
            $result['cedant_country'] = $cedant_country;

            if($get_cedant_type == 'NOT LIFE')
            {
                $premium_cases = CedantPremiumNotLifeCases::where('slipes_prime_id','=',$this->convertObjectId($request->premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                $check_premium_warnings = $this->warning_premium_check($premium_cases, 'not life', $request->premium_slip_id);
            }
            else
            {
                $premium_cases = CedantPremiumCases::where('slipes_prime_id','=',$this->convertObjectId($request->premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                $check_premium_warnings = $this->warning_premium_check($premium_cases, 'life', $request->premium_slip_id);
            }
            //echo '<pre>'; print_r($check_premium_warnings); exit;
            $result['premium_slip_detail'] = $view_premium_slip_detail;
            $result['premium_cases'] = $premium_cases;
            $result['check_premium_warnings'] = $check_premium_warnings;
            return $this->sendResponse($result, 'Premium slip detail', 200);
        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * automatic warning for premium slip first integrity check (Life and Not Life company)
     */
    public function warning_premium_check($premium_cases, $get_cedant_type, $premium_slip_id)
    {
        if($premium_slip_id != '')
        {
            $country_id = '';
            $view_premium_slip_detail = CedantPremiums::where('_id','=',$premium_slip_id)->first();
            $ins = ReinsuranceCedant::where('_id','=', $view_premium_slip_detail->cedants_id)->first();
            if($ins != null || $ins != '')
            {
                $country_id = $ins->countries_id;
            }

            $legal_assignment_percentage = SettingApp::first();
            $premium_slip_case_check = [];

            if($get_cedant_type == 'not life')
            {
                $premium_not_life_cases = $premium_cases;
                if(!empty($premium_not_life_cases))
                {
                    foreach ($premium_not_life_cases as $value)
                    {
                        $branch_id = '';
                        $sub_branch_id = '';
                        $messages = [];
                        //$case_errors = [];
                        if($value->branches_id != '')
                        {
                            $branch_id = $this->convertObjectId($value->branches_id);
                        }

                        if($value->sub_branches_id != '')
                        {
                            $sub_branch_id = $this->convertObjectId($value->sub_branches_id);
                        }

                        //rule 1
                        $branch_commission = '';
                        $branch_commission_data = BranchCommission::where('branch_id','=',$branch_id)
                                ->where('sub_branch_id','=',$sub_branch_id)
                                ->where('country_id','=',$country_id)
                                ->first();
                        if($branch_commission_data != '')
                        {
                            $branch_commission = $branch_commission_data->commission/100;
                        }

                        $nb = 0.02;
                        if($branch_commission != '')
                        {
                            $nb = $branch_commission;
                        }

                        $greater_than_comision = '';
                        $col16 = 0;
                        $col17 = 0;
                        $col18 = 0;
                        $check_comission = $this->replaceCurrencyToDigit($value->paid_commission);
                        $check_premium_ht = $this->replaceCurrencyToDigit($value->premium_ht);
                        if($check_comission != '' && $check_premium_ht != '')
                        {
                            if(($check_comission/$check_premium_ht) > $nb)
                            {
                                $greater_than_comision = 'greater';
                            }

                            $col16 = $check_premium_ht * ( $legal_assignment_percentage->legal_assignment_percentage / 100);
                            $col17 = (($check_comission/$check_premium_ht) + $nb) * $col16;
                            $col18 = $col16 - $col17;
                        }
                        else
                        {
                            $messages[] = 'paid_commission_values_not_matching';
                        }

                        if($col16 != $value->premium_ceded || $col17 != $value->commission_cession || $col18 != $value->prime_net_ceded)
                        {
                            $messages[] = 'premium_commission_values_not_matching';
                        }

                        if($greater_than_comision == 'greater')
                        {
                            $messages[] = 'premium_commission_exceeded_defined_by_country_branch';
                        }

                        //rule 2
                        if($value->part_cedant_coass < 100)
                        {
                            $messages[] = 'premium_coinsurance_case';
                        }
                        else if($value->part_cedant_coass > 100)
                        {
                            $messages[] = 'premium_exceeding_limit_case';
                        }

                        //rule 3
                        if($value->date_effective > $value->deadline)
                        {
                            $messages[] = 'effective_date_greater_than_deadline_date';
                        }

                        //rule 4
                        $premium_rule = CedantPremiumNotLifeCases::where('policy_number',$value->policy_number)
                        ->where('case_validation_status','=','Rejected')->orderBy('created_at', 'desc')->get();
                        if($premium_rule->count() > 1)
                        {
                            $messages[] = 'previous_rejected_case';
                        }

                        //rule 5
                        $trimester_months = $this->getTrimesterMonths();
                        if($value->date_effective >= $trimester_months['start_date'] && $value->date_effective <= $trimester_months['end_date'])
                        { }
                        else
                        {
                            $messages[] = 'this_is_to_be_regularisation_slip';
                        }

                        //rule 6
                        $branch_risk_capital = '';
                        $branch_risk_capital_data = BranchCapital::where('branch_id','=',$branch_id)
                                ->where('sub_branch_id','=',$sub_branch_id)
                                ->where('country_id','=',$country_id)
                                ->first();
                        if($branch_risk_capital_data != '')
                        {
                            $branch_risk_capital = $branch_risk_capital_data->max_risk_capital;
                        }

                        if($branch_risk_capital != '' && $value->insured_capital > $branch_risk_capital)
                        {
                            $messages[] = 'big_risk_premium_slip';
                        }

                        $premium_slip_case_check[$value->_id] = $messages;
                    }
                }

                $result['premium_slip_case_check'] = $premium_slip_case_check;
            }
            else if($get_cedant_type == 'life')
            {
                $premium_life_cases = $premium_cases;
                if(!empty($premium_life_cases))
                {

                    foreach ($premium_life_cases as $value)
                    {
                        $branch_id = '';
                        $sub_branch_id = '';
                        $messages = [];
                        //$case_errors = [];
                        if($value->branches_id != '')
                        {
                            $branch_id = $this->convertObjectId($value->branches_id);
                        }

                        if($value->sub_branches_id != '')
                        {
                            $sub_branch_id = $this->convertObjectId($value->sub_branches_id);
                        }

                        //rule 1
                        $branch_commission = '';
                        $branch_commission_data = BranchCommission::where('branch_id','=',$branch_id)
                                ->where('sub_branch_id','=',$sub_branch_id)
                                ->where('country_id','=',$country_id)
                                ->first();
                        if($branch_commission_data != '')
                        {
                            $branch_commission = $branch_commission_data->commission/100;
                        }

                        $nb = 0.02;
                        if($branch_commission != '')
                        {
                            $nb = $branch_commission;
                        }

                        $greater_than_comision = '';
                        $col25 = 0;
                        $col26 = 0;
                        $col27 = 0;
                        $col28 = 0;
                        $col29 = 0;
                        $check_prime_nette_total = $this->replaceCurrencyToDigit($value->prime_nette_total);
                        $check_part_cedante = $this->replaceCurrencyToDigit($value->part_cedante);
                        $check_comission = $this->replaceCurrencyToDigit($value->comission);
                        if($check_prime_nette_total != '' && $check_part_cedante != '' && $check_comission != '')
                        {
                            $col25 = $check_prime_nette_total*$check_part_cedante;
                            $col26 = $check_comission*$check_part_cedante;
                            $col27 = $col25 * ( $legal_assignment_percentage->legal_assignment_percentage / 100);
                            $col28 = (($col26 / $col25) + $nb) * $col27;
                            $col29 = $col27 - $col28;

                            if(($col26 / $col25) > $nb)
                            {
                                $greater_than_comision = 'greater';
                            }
                        }
                        else
                        {
                            $messages[] = 'paid_commission_values_not_matching';
                        }

                        if($col25 != $value->prime_nette_totale_cedante || $col26 != $value->comission_cedante || $col27 != $value->prime_cedee || $col28 != $value->comission_cession || $col29 != $value->prime_nette_cedee)
                        {
                            $messages[] = 'premium_commission_values_not_matching';
                        }


                        if($greater_than_comision == 'greater')
                        {
                            $messages[] = 'premium_commission_exceeded_defined_by_country_branch';
                        }

                        //rule 2
                        if($value->part_cedante < 100)
                        {
                            $messages[] = 'premium_coinsurance_case';
                        }
                        else if($value->part_cedante > 100)
                        {
                            $messages[] = 'premium_exceeding_limit_case';
                        }

                        //rule 3
                        if($value->date_effective > $value->deadline)
                        {
                            $messages[] = 'effective_date_greater_than_deadline_date';
                        }

                        //rule 4
                        if($value->prime_nette_total > 100)
                        {
                            $messages[] = 'bonus_total_exceeds_100';
                        }

                        //rule 5
                        if($value->comission > 100)
                        {
                            $messages[] = 'comission_exceeds_100';
                        }

                        //rule 6
                        $branch_risk_capital = '';
                        $branch_risk_capital_data = BranchCapital::where('branch_id','=',$branch_id)
                                ->where('sub_branch_id','=',$sub_branch_id)
                                ->where('country_id','=',$country_id)
                                ->first();
                        if($branch_risk_capital_data != '')
                        {
                            $branch_risk_capital = $branch_risk_capital_data->max_risk_capital;
                        }

                        if($branch_risk_capital != '' && $value->prime_nette_total > $branch_risk_capital)
                        {
                            $messages[] = 'big_risk_premium_slip';
                        }

                        //rule 7
                        $premium_rule = CedantPremiumCases::where('policy_number',$value->policy_number)
                        ->where('case_validation_status','=','Rejected')->orderBy('created_at', 'desc')->get();
                        if($premium_rule->count() > 1)
                        {
                            $messages[] = 'previous_rejected_case';
                        }

                        //rule 8
                        $trimester_months = $this->getTrimesterMonths();
                        if($value->date_effective >= $trimester_months['start_date'] && $value->date_effective <= $trimester_months['end_date'])
                        { }
                        else
                        {
                            $messages[] = 'this_is_to_be_regularisation_slip';
                        }

                        //$case_errors[$value->_id] = $messages;
                        $premium_slip_case_check[$value->_id] = $messages;
                        //array_push($premium_slip_case_check,$case_errors);
                    }
                }

                $result['premium_slip_case_check'] = $premium_slip_case_check;
            }
        }
        return $result;
    }

     /*
     * automatic warning for claim slip first integrity check (Life and Not Life company)
     */
    public function warning_claim_check(Request $request)
    {

        if($request->claim_slip_id != '')
        {

            $view_claim_slip_detail = CedantClaims::where('_id','=',$request->claim_slip_id)->first();
            $cedant_type_id = $view_claim_slip_detail->cedants_type_id;
            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::where('_id','=', $cedant_type_id )->first() ;
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }

            $legal_assignment_percentage = SettingApp::first();
            $claim_slip_case_check = [];


            if($get_cedant_type == 'NOT LIFE')
            {
                $claim_cases = CedantClaimNotLifeCases::where('slipes_claims_id','=',$this->convertObjectId($request->claim_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();

                //rule 1
                foreach ($claim_cases as $item) {

                    $claim_rule = CedantClaimNotLifeCases::where('slipes_claims_id','=',$this->convertObjectId($request->claim_slip_id))
                    ->where('claim_number',$item->claim_number)->orderBy('created_at', 'desc')->get();

                    if($claim_rule->count() > 1){
                        array_push($claim_slip_case_check,[
                            'case_id'=>$item->_id,
                            'message'=>'claim_number_double'
                            ]);
                    }
                }

                //rule 2
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantClaimNotLifeCases::where('slipes_claims_id','<>',$this->convertObjectId($request->claim_slip_id))
                    ->where('claim_number',$item->claim_number)
                    ->where('case_validation_status','Verified')
                    ->orderBy('created_at', 'desc')->get();

                    if($claim_rule->count() > 0){
                        array_push($claim_slip_case_check,[
                            'case_id'=>$item->_id,
                            'message'=>'claim_number_exists_paid_claims_slip_before'
                            ]);
                    }
                }

                //rule 3
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantClaimNotLifeCases::where('policy_number',$item->police_number)
                    ->where('case_validation_status','<>','Verified')
                    ->orderBy('created_at', 'desc')->get();
                    if($claim_rule->count() > 0){
                        array_push($claim_slip_case_check,[
                            'case_id'=>$item->_id,
                            'message'=>'police_number_no_validated_premium_slips'
                            ]);
                    }
                }

                //rule 4 //rule 5
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantClaimNotLifeCases::where('policy_number',$item->police_number)
                    ->orderBy('created_at', 'desc')->first();

                    if($claim_rule){
                        if($claim_rule->part_cedant_coass < 100){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'part_cedant_coass_percentage'=>$claim_rule->part_cedant_coass,
                                'message'=>'police_number_marked_coinsurance_premium_slips',
                                ]);
                        }
                    }
                }

                //rule 6
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantClaimNotLifeCases::where('policy_number',$item->police_number)
                    ->where('case_validation_status','<>','Verified')
                    ->orderBy('created_at', 'desc')->get();

                    if($claim_rule->count() > 0){
                        array_push($claim_slip_case_check,[
                            'case_id'=>$item->_id,
                            'message'=>'police_number_no_paid_premium_slips'
                            ]);
                    }
                }

                //rule 7
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantClaimNotLifeCases::where('policy_number',$item->police_number)
                    ->orderBy('created_at', 'desc')->first();

                    if($claim_rule){
                        if($claim_rule->branches_id != $item->branches_id){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'message'=>'branches_no_match_premium_slips',
                                ]);
                        }
                    }
                }

                //rule 8
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantClaimNotLifeCases::where('policy_number',$item->police_number)
                    ->orderBy('created_at', 'desc')->first();

                    if($claim_rule){

                        if($claim_rule->premium_slips->country_id != $view_claim_slip_detail->country_id){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'message'=>'country_no_match_premium_slips',
                                ]);
                        }
                    }
                }


                //rule 9
                foreach ($claim_cases as $item) {


                    if(($item->claim_date) && ($item->date_effective)){

                        $claim_date = Carbon::parse($item->claim_date)->addDay(7)->format('Y-m-d');
                        $date_effective = Carbon::parse($item->date_effective)->format('Y-m-d');

                        if($claim_date > $date_effective){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'message'=>'date_effective_no_more_than_claim_date_7days',
                                ]);
                        }

                    }
                }


                //rule 10  //rule 11
                foreach ($claim_cases as $item) {

                    $claim_rule = CedantClaimNotLifeCases::where('police_number',$item->police_number)
                                ->orderBy('created_at', 'desc')->get();


                    $last_years = Carbon::now()->format('Y') ;

                    if($claim_rule->count() > 1){
                        foreach ($claim_rule as $value){

                            if($value->claim_date){
                                $claim_date = Carbon::parse($value->claim_date)->format('Y');
                                if($last_years > $claim_date){
                                    $last_years = $claim_date ;
                                }

                            }

                        }

                        $years = Carbon::now()->format('Y') - $last_years ;

                        array_push($claim_slip_case_check,[
                            'case_id'=>$item->_id,
                            'number_appearances' => $claim_rule->count() ,
                            'years' => ($years) ? $years : 1,
                            'message'=>'police_number_appearances_by_years',
                        ]);
                    }
                }

                $result['claim_slip_case_no_life_check'] = $claim_slip_case_check;
            }
            else
            {
                $claim_cases = CedantClaimCases::where('slipes_claims_id','=',$this->convertObjectId($request->claim_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();

                //dd($claim_cases->count());

                //rule 1
                foreach ($claim_cases as $item) {

                    $claim_rule = CedantClaimCases::where('slipes_claims_id','=',$this->convertObjectId($request->claim_slip_id))
                    ->where('claim_number',$item->claim_number)->orderBy('created_at', 'desc')->get();

                    if($claim_rule->count() > 1){
                        array_push($claim_slip_case_check,[
                            'case_id'=>$item->_id,
                            'message'=>'claim_number_double'
                            ]);
                    }
                }

                //rule 2
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantClaimCases::where('slipes_claims_id','<>',$this->convertObjectId($request->claim_slip_id))
                    ->where('claim_number',$item->claim_number)
                    ->where('case_validation_status','Verified')
                    ->orderBy('created_at', 'desc')->get();

                    if($claim_rule->count() > 0){
                        array_push($claim_slip_case_check,[
                            'case_id'=>$item->_id,
                            'message'=>'claim_number_exists_paid_claims_slip_before'
                            ]);
                    }
                }

                //rule 3
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantPremiumCases::where('policy_number',$item->police_number)
                    ->where('case_validation_status','<>','Verified')
                    ->orderBy('created_at', 'desc')->get();
                    if($claim_rule->count() > 0){
                        array_push($claim_slip_case_check,[
                            'case_id'=>$item->_id,
                            'message'=>'police_number_no_validated_premium_slips'
                            ]);
                    }
                }

                //rule 4 //rule 5
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantPremiumCases::where('policy_number',$item->police_number)
                    ->orderBy('created_at', 'desc')->first();

                    if($claim_rule){

                        if($claim_rule->part_cedante < 100){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'part_cedant_coass_percentage'=>$claim_rule->part_cedante,
                                'message'=>'police_number_marked_coinsurance_premium_slips',
                                ]);
                        }
                    }
                }

                //rule 6
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantPremiumCases::where('policy_number',$item->police_number)
                    ->where('case_validation_status','<>','Verified')
                    ->orderBy('created_at', 'desc')->get();

                    if($claim_rule->count() > 0){
                        array_push($claim_slip_case_check,[
                            'case_id'=>$item->_id,
                            'message'=>'police_number_no_paid_premium_slips'
                            ]);
                    }
                }


                //rule 8
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantPremiumCases::where('policy_number',$item->police_number)
                    ->orderBy('created_at', 'desc')->first();

                    if($claim_rule){

                        if($claim_rule->premium_slips->country_id != $view_claim_slip_detail->country_id){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'message'=>'country_no_match_premium_slips',
                                ]);
                        }
                    }
                }

                //rule 9
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantPremiumCases::where('policy_number',$item->police_number)
                    ->orderBy('created_at', 'desc')->first();

                    if($claim_rule){

                        if($item->capital_loss_death > $claim_rule->capital_insured_death_or_constitution){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'message'=>'check_capital_loss_death_more_than_capital_insured_death_or_constitution',
                                ]);
                        }
                    }
                }

                //rule 10
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantPremiumCases::where('policy_number',$item->police_number)
                    ->orderBy('created_at', 'desc')->first();

                    if($claim_rule){

                        if($item->capital_loss_death_acc > $claim_rule->capital_insured_accidental_death){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'message'=>'check_capital_loss_death_acc_more_than_capital_insured_accidental_death',
                                ]);
                        }
                    }
                }

                //rule 11 //rule 12
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantPremiumCases::where('policy_number',$item->police_number)
                    ->orderBy('created_at', 'desc')->first();

                    if($claim_rule){

                        if($item->capital_loss_ta > $claim_rule->capital_insured_triply_accidentally){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'message'=>'check_capital_loss_ta_more_than_capital_insured_triply_accidentally',
                                ]);
                        }
                    }
                }

                //rule 13
                foreach ($claim_cases as $item) {
                    $claim_rule = CedantPremiumCases::where('policy_number',$item->police_number)
                    ->orderBy('created_at', 'desc')->first();

                    if($claim_rule){

                        if($item->capital_loss_ipp > $claim_rule->capital_insured_partial_permanent_disability){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'message'=>'check_capital_loss_ipp_more_than_capital_insured_partial_permanent_disability',
                                ]);
                        }
                    }
                }

                 //rule 14
                 foreach ($claim_cases as $item) {
                    $claim_rule = CedantPremiumCases::where('policy_number',$item->police_number)
                    ->orderBy('created_at', 'desc')->first();

                    if($claim_rule){

                        if($item->capital_loss_jobs > $claim_rule->capital_insured_loss_jobs){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'message'=>'check_capital_loss_jobs_more_than_capital_insured_loss_jobs',
                                ]);
                        }
                    }
                }

                //rule 15
                foreach ($claim_cases as $item) {


                    if(($item->claim_date) && ($item->date_effective)){

                        $claim_date = Carbon::parse($item->claim_date)->addDay(7)->format('Y-m-d');
                        $date_effective = Carbon::parse($item->date_effective)->format('Y-m-d');

                        if($claim_date > $date_effective){
                            array_push($claim_slip_case_check,[
                                'case_id'=>$item->_id,
                                'message'=>'date_effective_no_more_than_claim_date_7days',
                                ]);
                        }

                    }
                }

                //rule 16  //rule 17
                foreach ($claim_cases as $item) {

                    $claim_rule = CedantClaimCases::where('police_number',$item->police_number)
                                ->orderBy('created_at', 'desc')->get();


                    $last_years = Carbon::now()->format('Y') ;

                    if($claim_rule->count() > 1){
                        foreach ($claim_rule as $value){

                            if($value->claim_date){
                                $claim_date = Carbon::parse($value->claim_date)->format('Y');
                                if($last_years > $claim_date){
                                    $last_years = $claim_date ;
                                }

                            }

                        }

                        $years = Carbon::now()->format('Y') - $last_years ;

                        array_push($claim_slip_case_check,[
                            'case_id'=>$item->_id,
                            'number_appearances' => $claim_rule->count() ,
                            'years' => ($years) ? $years : 1,
                            'message'=>'police_number_appearances_by_years',
                        ]);
                    }
                }




                $result['claim_slip_case_life_check'] = $claim_slip_case_check;
            }

            $result['claim_slip_detail'] = $view_claim_slip_detail;
            return $this->sendResponse($result, 'Claim slips case check', 200);



        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

     /*
     * automatic warning for claim slip(Life company)-System calculation
     */
    public function warning_claim_life_slip_calculation(Request $request)
    {

        if($request->claim_slip_id != '')
        {

            $view_claim_slip_detail = CedantClaims::where('_id','=',$request->claim_slip_id)->first();
            $cedant_type_id = $view_claim_slip_detail->cedants_type_id;

            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::where('_id','=', $cedant_type_id )->first() ;
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }

            $legal_assignment_percentage = SettingApp::first();
            $claim_slip_case_error = [];

            if($get_cedant_type == 'LIFE')
            {
                $claim_cases = CedantClaimCases::where('slipes_claims_id','=',$this->convertObjectId($request->claim_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();

                foreach ($claim_cases as $item) {

                    $Col19 = $item->claim_assignor * ( $legal_assignment_percentage->legal_assignment_percentage / 100) * 24 ;

                    if($Col19 != $item->claim_cede ){
                        array_push($claim_slip_case_error,$item);

                    }
                }

                $result['claim_slip_detail'] = $view_claim_slip_detail;
                $result['claim_slip_case_error'] = $claim_slip_case_error;
                return $this->sendResponse($result, 'Claim slips case calculation error.', 200);
            }
            else
            {
                return $this->sendError('Something went wrong. Please try again.', [], 400);
            }




        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

     /*
     * automatic warning for premium slip(Life company)-System calculation
     */
    public function warning_premium_life_slip_calculation(Request $request)
    {

        if($request->premium_slip_id != '')
        {
            $view_premium_slip_detail = CedantPremiums::where('_id','=',$request->premium_slip_id)->first();
            $cedant_type_id = $view_premium_slip_detail->cedants_type_id;

            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::where('_id','=', $cedant_type_id )->first() ;
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }

            $legal_assignment_percentage = SettingApp::first();
            $premium_slip_case_error = [];

            if($get_cedant_type == 'LIFE')
            {
                $premium_cases = CedantPremiumCases::where('slipes_prime_id','=',$this->convertObjectId($request->premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();

                foreach ($premium_cases as $value) {
                    $col25 = $value->prime_nette_total * $value->part_cedante ;
                    $col26 = $value->comission * $value->part_cedante ;
                    $col27 = $col25 * ( $legal_assignment_percentage->legal_assignment_percentage / 100) ;
                    $col28 = (($col26 / $col25) + 0.02) * $col27 ;
                    $col29 = $col27 - $col28 ;

                    if($col25 != $value->prime_nette_totale_cedante || $col26 != $value->comission_cedante || $col27 != $value->prime_cedee || $col28 != $value->comission_cession || $col29 != $value->prime_nette_cedee){
                        array_push($premium_slip_case_error,$value);
                    }
                }

                $result['premium_slip_detail'] = $view_premium_slip_detail;
                $result['premium_slip_case_error'] = $premium_slip_case_error;
                return $this->sendResponse($result, 'Premium slips case calculation error.', 200);
            }
            else
            {
                return $this->sendError('Something went wrong. Please try again.', [], 400);
            }




        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

     /*
     * automatic warning for premium slip(Life company)-mark as co-insurance
     */
    public function warning_premium_life_slip_coinsurance(Request $request)
    {
        if($request->premium_slip_id != '')
        {
            $view_premium_slip_detail = CedantPremiums::where('_id','=',$request->premium_slip_id)->first();
            $cedant_type_id = $view_premium_slip_detail->cedants_type_id;
            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::find($cedant_type_id);
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }

            $premium_slip_case_coinsurance = [];

            if($get_cedant_type == 'LIFE')
            {
                $premium_cases = CedantPremiumCases::where('slipes_prime_id','=',$this->convertObjectId($request->premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();

                foreach ($premium_cases as $value) {

                    if($value->part_cedante < 100){
                        array_push($premium_slip_case_coinsurance,$value);
                    }
                }

                $result['premium_slip_detail'] = $view_premium_slip_detail;
                $result['premium_slip_case_coinsurance'] = $premium_slip_case_coinsurance;
                return $this->sendResponse($result, 'Premium slips case mark as co-insurance.', 200);
            }
            else
            {
                return $this->sendError('Something went wrong. Please try again.', [], 400);
            }




        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * automatic warning for premium slip(Not Life company)-System calculation
     */
    public function warning_premium_iard_slip_calculation(Request $request)
    {
        if($request->premium_slip_id != '')
        {
            $view_premium_slip_detail = CedantPremiums::where('_id','=',$request->premium_slip_id)->first();
            $cedant_type_id = $view_premium_slip_detail->cedants_type_id;
            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::find($cedant_type_id);
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }

            $legal_assignment_percentage = SettingApp::first();
            $premium_slip_case_error = [];

            if($get_cedant_type == 'NOT LIFE')
            {
                $premium_cases = CedantPremiumNotLifeCases::where('slipes_prime_id','=',$this->convertObjectId($request->premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();

                foreach ($premium_cases as $value) {
                    $col16 = $value->premium_ht * ( $legal_assignment_percentage->legal_assignment_percentage / 100) ;
                    $col17 = (($value->paid_commission / $value->premium_ht) + 0.02) * $col16 ;
                    $col18 = $col16 - $col17 ;

                    if($col16 != $value->premium_ceded || $col17 != $value->commission_cession || $col18 != $value->prime_net_ceded){
                        array_push($premium_slip_case_error,$value);
                    }
                }

                $result['premium_slip_detail'] = $view_premium_slip_detail;
                $result['premium_slip_case_error'] = $premium_slip_case_error;
                return $this->sendResponse($result, 'Premium slips case calculation error.', 200);
            }
            else
            {
                return $this->sendError('Something went wrong. Please try again.', [], 400);
            }




        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * automatic warning for premium slip(Not Life company)-mark as co-insurance
     */
    public function warning_premium_iard_slip_coinsurance(Request $request)
    {
        if($request->premium_slip_id != '')
        {
            $view_premium_slip_detail = CedantPremiums::where('_id','=',$request->premium_slip_id)->first();
            $cedant_type_id = $view_premium_slip_detail->cedants_type_id;
            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::find($cedant_type_id);
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }

            $premium_slip_case_coinsurance = [];

            if($get_cedant_type == 'NOT LIFE')
            {
                $premium_cases = CedantPremiumNotLifeCases::where('slipes_prime_id','=',$this->convertObjectId($request->premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();

                foreach ($premium_cases as $value) {

                    if($value->part_cedant_coass < 100){
                        array_push($premium_slip_case_coinsurance,$value);
                    }
                }

                $result['premium_slip_detail'] = $view_premium_slip_detail;
                $result['premium_slip_case_coinsurance'] = $premium_slip_case_coinsurance;
                return $this->sendResponse($result, 'Premium slips case mark as co-insurance.', 200);
            }
            else
            {
                return $this->sendError('Something went wrong. Please try again.', [], 400);
            }




        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * decision about slip from admin of reinsurance company
     */
    public function check_premium_slip(Request $request)
    {
        if($request->validation_status != '' && $request->premium_slip_id != '')
        {
            if($request->validation_status == 1)
            {
                $validation_status = 'Verified';
            }
            else
            {
                $validation_status = 'Rejected';
            }

            $slipe_prime = CedantPremiums::find($request->premium_slip_id);
            if($slipe_prime != null || $slipe_prime != '')
            {
                $slipe_prime->validation_status = $validation_status;
                $slipe_prime->updated_at = date('Y-m-d H:i:s');
                $slipe_prime->save();

                $result['premium_slip_id'] = $request->premium_slip_id;
                return $this->sendResponse($result, 'Premium slip status updated successfully', 200);
            }
        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * decision about slip premium cases from admin of reinsurance company
     */
    public function check_cases_premium_slip(Request $request)
    {
        //echo '<pre>'; print_r($request->all()); exit;
        if($request->validation_status != '' && !empty($request->cases_array) && $request->insurance_type != '')
        {
            if($request->validation_status == 1)
            {
                $validation_status = 'Verified';
            }
            else
            {
                $validation_status = 'Rejected';
            }

            $get_cedant_type = $request->insurance_type;
            $slipe_prime_case = '';
            $return_array = [];
            $decode_cases = json_decode($request->cases_array);

            foreach($decode_cases as $each_case)
            {
                $each_case = (array)$each_case;
                $each_case_id = $each_case['case_id'];
                if($get_cedant_type == 'not life')
                {
                    $slipe_prime_case = CedantPremiumNotLifeCases::find($each_case_id);
                }
                else if($get_cedant_type == 'life')
                {
                    $slipe_prime_case = CedantPremiumCases::find($each_case_id);
                }

                if($slipe_prime_case != null || $slipe_prime_case != '')
                {
                    $slipe_prime_case->case_validation_status = $validation_status;
                    $slipe_prime_case->updated_at = date('Y-m-d H:i:s');
                    $slipe_prime_case->save();

                    $return_array[] = $each_case_id;
                }
            }

            if(!empty($return_array))
            {
                $result['cases_id'] = $return_array;
                return $this->sendResponse($result, 'Case status updated successfully', 200);
            }

        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * final decision about slip premium from admin of reinsurance company
     */
    public function check_final_premium_slip(Request $request)
    {
        if($request->premium_slip_id != '')
        {
            $premium_slip_id = $request->premium_slip_id;
            $view_premium_slip_detail = CedantPremiums::where('_id','=',$premium_slip_id)->first();
            $cedant_type_id = $view_premium_slip_detail->cedants_type_id;
            $validation_status_verified = 'Verified';
            $validation_status_partial_verified = 'Partial Verified';
            $validation_status_rejected = 'Rejected';

            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::find($cedant_type_id);
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }

            if($get_cedant_type == 'NOT LIFE')
            {
                $slipe_premium_cases = CedantPremiumNotLifeCases::where('slipes_prime_id','=',$this->convertObjectId($premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
            }
            else
            {
                $slipe_premium_cases = CedantPremiumCases::where('slipes_prime_id','=',$this->convertObjectId($premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
            }

            if($slipe_premium_cases != null || $slipe_premium_cases != '')
            {
                $case_valid = [];
                $case_msg = [];
                foreach($slipe_premium_cases as $slipe_premium_cs)
                {
                    $policy_no = $slipe_premium_cs->policy_number;
                    if($slipe_premium_cs->case_validation_status == 'Verified')
                    {
                       $case_valid[] = 'Verified';
                       $case_msg[] = "Case with policy number $policy_no is verified.";
                    }
                    else if($slipe_premium_cs->case_validation_status == 'Rejected')
                    {
                       $case_valid[] = 'Rejected';
                       $case_msg[] = "Case with policy number $policy_no is rejected.";
                    }
                    else
                    {
                       $case_valid[] = 'Pending';
                       $case_msg[] = "Case with policy number $policy_no is pending. Please review this case.";
                    }
                }
                //echo '<pre>'; print_r($case_msg); exit;

                if(!in_array("Rejected",$case_valid) && !in_array("Pending",$case_valid))
                {
                    $view_premium_slip_detail->validation_status = $validation_status_verified;
                    $view_premium_slip_detail->updated_at = date('Y-m-d H:i:s');
                    $view_premium_slip_detail->save();

                    $result['slipes_prime_id'] = $premium_slip_id;
                    return $this->sendResponse($result, 'Premium Slip is fully verified.', 200);
                }
                else if(!in_array("Verified",$case_valid) && !in_array("Pending",$case_valid))
                {
                    $view_premium_slip_detail->validation_status = $validation_status_rejected;
                    $view_premium_slip_detail->updated_at = date('Y-m-d H:i:s');
                    $view_premium_slip_detail->save();

                    $result['slipes_prime_id'] = $premium_slip_id;
                    return $this->sendResponse($result, 'Premium Slip is fully rejected.', 200);
                }
                else if(in_array("Pending",$case_valid))
                {
                    $result['slipes_prime_id'] = $premium_slip_id;
                    $result['case_msg'] = $case_msg;
                    return $this->sendResponse($result, 'Premium Slip cannot be validated.', 200);
                }
                else
                {
                    $view_premium_slip_detail->validation_status = $validation_status_partial_verified;
                    $view_premium_slip_detail->updated_at = date('Y-m-d H:i:s');
                    $view_premium_slip_detail->save();

                    $result['slipes_prime_id'] = $premium_slip_id;
                    return $this->sendResponse($result, 'Premium Slip is partially verified.', 200);
                    //return $this->sendError('Some cases are still pending for review. Please try again after validating the cases.', $case_msg, 400);
                }

            }
        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

     /*
     * Edit credit notes
     */
    public function edit_credit_note(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'credit_note_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $credit_note = Notes::where('_id','=',$this->convertObjectId($request->credit_note_id))->where('type','=','credit')->first();
        if($credit_note){
            if($request->location) $credit_note->location = $request->location;
            if($request->date) $credit_note->date = $request->date;
            if($request->periodicity) $credit_note->periodicity = $request->periodicity;
            if($request->year) $credit_note->year = $request->year ;
            if($request->type) $credit_note->type = $request->type ;
            if($request->slip_ids) $credit_note->slip_ids = $request->slip_ids;
            if($request->note_url) $credit_note->note_url = $request->note_url;
            if($request->payment_status) $credit_note->payment_status = $request->payment_status;
            if($request->validation_status) $credit_note->validation_status = $request->validation_status;
            if($request->approval_status) $credit_note->approval_status = $request->approval_status;

            $credit_note->save();



            return $this->sendResponse($credit_note, 'Credit note edited successfully', 200);
        }else{
            return $this->sendError('Something went wrong. Please try again.', [], 400);
        }



    }

    /*
     * final decision about all slips premium from admin of reinsurance company
     */
    public function check_final_validation_premium_slips(Request $request)
    {
        if($request->reinsurances_id != '')
        {
            $get_trimester_dates = $this->getTrimesterMonths();
            $start = $this->convertDateToMongoDate($get_trimester_dates['start_date']);
            $end = $this->convertDateToMongoDate($get_trimester_dates['end_date']);
            $get_premium_slips = CedantPremiums::whereBetween('created_at', array($start, $end))->where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->get();

            $slip_data = [];
            $result = [];
            foreach($get_premium_slips as $eachslip)
            {
                $premium_slip_id = $eachslip->_id;
                $cedant_type_id = $eachslip->cedants_type_id;
                $get_cedant_type = '';
                if(isset($cedant_type_id) && $cedant_type_id != '')
                {
                    $get_cedant_type_data = CedantType::find($cedant_type_id);
                    if($get_cedant_type_data != '')
                    {
                        $get_cedant_type = $get_cedant_type_data->name;
                    }
                }

                if($get_cedant_type == 'NOT LIFE')
                {
                    $slipe_premium_cases = CedantPremiumNotLifeCases::where('slipes_prime_id','=',$this->convertObjectId($premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else
                {
                    $slipe_premium_cases = CedantPremiumCases::where('slipes_prime_id','=',$this->convertObjectId($premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }

                if($slipe_premium_cases != null || $slipe_premium_cases != '')
                {
                    $case_valid = [];
                    $error_msg = [];
                    foreach($slipe_premium_cases as $slipe_premium_cs)
                    {
                        if($slipe_premium_cs->case_validation_status == 'Verified')
                        {
                           $case_valid[] = 'Verified';
                        }
                        else
                        {
                           $case_valid[] = 'Rejected';
                           $error_msg[] = 'Premium Case id '.$slipe_premium_cs->_id.' is not verified. Please recheck this case.';
                        }
                    }

                    if(!in_array("Rejected",$case_valid))
                    {
                        $eachslip->validation_status = 'Verified';
                        $eachslip->updated_at = date('Y-m-d H:i:s');
                        $eachslip->save();

                        $result[] = array('slip_id' => $premium_slip_id, 'status' => 'Fully Verified', 'error' => $error_msg);
                        //return $this->sendResponse($result, 'Premium Slip validation status updated successfully', 200);
                    }
                    else
                    {
                        $result[] = array('slip_id' => $premium_slip_id, 'status' => 'Partially Verified', 'error' => $error_msg);
                        //return $this->sendError('All cases are not verified. Please try again.', $error_msg, 400);
                    }

                }

            }

            //send response
            return $this->sendResponse($result, 'Validation result', 200);

        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * create/update debit note from selected slips premium from admin of reinsurance company
     */
    public function save_debit_note(Request $request)
    {
        if($request->reinsurances_id != '' && $request->selected_slips != '')
        {
            $user = JWTAuth::user();
            $get_trimester_dates = $this->getTrimesterMonths();
            $start = $this->convertDateToMongoDate($get_trimester_dates['start_date']);
            $end = $this->convertDateToMongoDate($get_trimester_dates['end_date']);
            //$get_premium_slips_array = CedantPremiums::whereBetween('created_at', array($start, $end))->where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->get();
            $get_premium_slips_array = $request->selected_slips;

            $slip_data = [];
            $result = [];

            foreach($get_premium_slips_array as $get_premium_slip_id)
            {
                $eachslip = CedantPremiums::find($get_premium_slip_id);
                $notes_count = Notes::count();
                $premium_slip_id = $eachslip->_id;
                $cedant_type_id = (string)$eachslip->cedants_type_id;
                $cedants_id = (string)$eachslip->cedants_id;
                $get_cedant_type = '';
                if(isset($cedant_type_id) && $cedant_type_id != '')
                {
                    $get_cedant_type_data = CedantType::find($cedant_type_id);
                    if($get_cedant_type_data != '')
                    {
                        $get_cedant_type = $get_cedant_type_data->name;
                    }
                }

                if($get_cedant_type == 'NOT LIFE')
                {
                    $slipe_premium_cases = CedantPremiumNotLifeCases::where('slipes_prime_id','=',$this->convertObjectId($premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else
                {
                    $slipe_premium_cases = CedantPremiumCases::where('slipes_prime_id','=',$this->convertObjectId($premium_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }

                if($slipe_premium_cases != null || $slipe_premium_cases != '')
                {
                    $case_valid = [];
                    $error_msg = [];
                    $slip_cases_total_sum = 0;
                    foreach($slipe_premium_cases as $slipe_premium_cs)
                    {
                        if($slipe_premium_cs->case_validation_status == 'Verified')
                        {
                           $case_valid[] = 'Verified';
                           $slip_cases_total_sum = $slip_cases_total_sum + $slipe_premium_cs->prime_nette_cedee;
                        }
                        else
                        {
                           $case_valid[] = 'Rejected';
                           $error_msg[] = 'Premium Case id '.$slipe_premium_cs->_id.' is not verified. Please recheck this case.';
                        }
                    }

                    if($slip_cases_total_sum > 0)
                    {
                        $slip_data[] = array('slip_id' => $premium_slip_id, 'slip_total' => $slip_cases_total_sum);


                        //make a entry for debit note in the database if not exists else update it
                        $cedant = ReinsuranceCedant::find($cedants_id);
                        $reinsurance = Reinsurance::find($request->reinsurances_id);
                        $cedant_code = '';
                        $cedant_code_concat = '';
                        $reinsurance_name = '';
                        if($cedant != '')
                        {
                            $cedant_code = $cedant->code;
                            $cedant_code_concat = '-'.$cedant_code;
                        }

                        if($reinsurance != '')
                        {
                            $reinsurance_name = $reinsurance->name;
                        }
                        $initial_name = $this->getInitalNames($user->username);
                        $periodicity = $get_trimester_dates['trimester_no'].' trimester';
                        $year = date('Y');
                        $date = date('dMY');
                        $get_trimester_note = Notes::where('periodicity','=',$periodicity)->where('year','=',$year)
                                ->where('type','=','debit')
                                ->where('cedants_id','=',$this->convertObjectId($eachslip->cedants_id))
                                ->where('reinsurances_id','=',$this->convertObjectId($eachslip->reinsurances_id))
                                ->first();

                        if($get_trimester_note == '')
                        {
                            $autonum = $notes_count+1;
                            /* $countlen = strlen($autonum);
                            if($countlen == 1)
                            {
                                $ref_chronic_no = '000'.$autonum;
                            }
                            else if($countlen == 2)
                            {
                                $ref_chronic_no = '00'.$autonum;
                            }
                            else if($countlen == 3)
                            {
                                $ref_chronic_no = '0'.$autonum;
                            }
                            else
                            {
                                $ref_chronic_no = $autonum;
                            }*/
                            $chronic_no = $autonum.$cedant_code_concat;
                            $reference = "ND-$chronic_no/$initial_name/$year/$reinsurance_name";
                            $location = '';
                            $type= 'debit';
                            $note_url = '';
                            $cedants_id = $eachslip->cedants_id;
                            $reinsurances_id = $eachslip->reinsurances_id;
                            $payment_status = 'Pending';
                            $validation_status = 'Pending';
                            $approval_status = 'Pending';

                            $new_debit_note = Notes::create([
                                'reference' => $reference,
                                'location' => $location,
                                'date' => $date,
                                'periodicity' => $periodicity,
                                'year' => $year,
                                'type' => $type,
                                'slip_ids' => array($premium_slip_id),
                                'slip_total' => array($slip_cases_total_sum),
                                'ins_type' => $get_cedant_type,
                                'note_url' => $note_url,
                                'cedants_id' => $this->convertObjectId($cedants_id),
                                'reinsurances_id' => $this->convertObjectId($reinsurances_id),
                                'payment_status' => $payment_status,
                                'validation_status' => $validation_status,
                                'approval_status' => $approval_status
                            ]);

                        }
                        else
                        {
                            $existing_slips = $get_trimester_note->slip_ids;
                            array_push($existing_slips,$premium_slip_id);

                            $existing_slip_total = $get_trimester_note->slip_total;
                            array_push($existing_slip_total,$slip_cases_total_sum);

                            $get_trimester_note->slip_ids = $existing_slips;
                            $get_trimester_note->slip_total = $existing_slip_total;
                            $get_trimester_note->updated_at = date('Y-m-d H:i:s');
                            $get_trimester_note->save();
                        }

                    }

                    if(!in_array("Rejected",$case_valid))
                    {
                        $result[] = array('slip_id' => $premium_slip_id, 'status' => 'Fully Verified', 'error' => $error_msg);
                    }
                    else
                    {
                        $result[] = array('slip_id' => $premium_slip_id, 'status' => 'Partially Verified', 'error' => $error_msg);
                    }

                }

            }

            //send response
            return $this->sendResponse($result, 'Debit note generated successfully', 200);

        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * final decision about note from admin of reinsurance company
     */
    public function check_final_note(Request $request)
    {
        if($request->validation_status != '' && $request->note_id != '')
        {
            $note_id = $request->note_id;
            $note = Notes::where('_id','=',$note_id)->first();
            if($request->validation_status == 1)
            {
                $validation_status = 'Verified';
            }
            else
            {
                $validation_status = 'Rejected';
            }

            if($note != null || $note != '')
            {
                $note->validation_status = $validation_status;
                $note->updated_at = date('Y-m-d H:i:s');
                $note->save();

                $result['note_id'] = $note_id;
                return $this->sendResponse($result, 'Note validation status updated successfully', 200);
            }
        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * final decision about note payment from admin of reinsurance company
     */
    public function check_final_payment_note(Request $request)
    {
        if($request->payment_status != '' && $request->note_id != '')
        {
            $note_id = $request->note_id;
            $note = Notes::where('_id','=',$note_id)->first();

            if($note != null || $note != '')
            {
                $note->payment_status = $request->payment_status;
                $note->updated_at = date('Y-m-d H:i:s');
                $note->save();

                $result['note_id'] = $note_id;
                return $this->sendResponse($result, 'Note payment status updated successfully', 200);
            }
        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * final validate about note from admin of reinsurance company
     */
    public function final_validate_note(Request $request)
    {
        if($request->note_id != '')
        {
            $note_id = $request->note_id;
            $note = Notes::where('_id','=',$note_id)->first();

            if($note != null || $note != '')
            {
                if($note->validation_status == 'Verified')
                {
                    $get_slip_ids = $note->slip_ids;
                    $get_slip_total = $note->slip_total;
                    $get_ins_type = $note->ins_type;
                    $get_note_type = $note->type;
                    $refno = $note->reference;
                    $fulldate = date('dMY');
                    $current_date = date('F j, Y');
                    $year = date('Y');
                    $month = date('n');
                    $getTrimesterDetails = $this->getTrimesterMonthNames();
                    $get_cedant_details = $this->get_cedant_details($note->cedants_id);
                    //echo '<pre>'; print_r($getTrimesterDetails['trimester_no']); exit;

                    $cedant_name = '';
                    $cedant_address = '';
                    $cedant_city = '';
                    $cedant_country = '';
                    if(isset($get_cedant_details->original['data']) && !empty($get_cedant_details->original['data']) )
                    {
                        $cedant_name = $get_cedant_details->original['data']['name'];
                        $cedant_address = $get_cedant_details->original['data']['contact'];
                        $cedant_city = $get_cedant_details->original['data']['region_name'];
                        $cedant_country = $get_cedant_details->original['data']['country_name'];
                    }

                    $count=0;
                    $slip1_favor_reins_total = 0;
                    $slip2_favor_reins_total = 0;
                    $slip3_favor_reins_total = 0;
                    $slip1_favor_ins_total = 0;
                    $slip2_favor_ins_total = 0;
                    $slip3_favor_ins_total = 0;
                    $slip1_month_year = '';
                    $slip2_month_year = '';
                    $slip3_month_year = '';
                    $slip1_month = '--';
                    $slip2_month = '--';
                    $slip3_month = '--';
                    $slip1_table_array = array();
                    $slip2_table_array = array();
                    $slip3_table_array = array();
                    $view_slip_detail = '';
                    foreach($get_slip_ids as $each_slip_id)
                    {
                        if($get_note_type == 'debit')
                        {
                            $view_slip_detail = CedantPremiums::where('_id','=',$each_slip_id)->first();
                        }
                        else if($get_note_type == 'credit')
                        {
                            $view_slip_detail = CedantClaims::where('_id','=',$each_slip_id)->first();
                        }

                        if(isset($get_slip_total[$count]) && $get_slip_total[$count] > 0)
                        {
                            if($count == 0)
                            {
                                $slip1_month_year = $view_slip_detail->edited_period;
                                if($get_note_type == 'debit')
                                {
                                    $slip1_favor_reins_total = $get_slip_total[$count];
                                }
                                else if($get_note_type == 'credit')
                                {
                                    $slip1_favor_ins_total = $get_slip_total[$count];
                                }
                            }
                            else if($count == 1)
                            {
                                $slip2_month_year = $view_slip_detail->edited_period;
                                if($get_note_type == 'debit')
                                {
                                    $slip2_favor_reins_total = $get_slip_total[$count];
                                }
                                else if($get_note_type == 'credit')
                                {
                                    $slip2_favor_ins_total = $get_slip_total[$count];
                                }
                            }
                            else if($count == 2)
                            {
                                $slip3_month_year = $view_slip_detail->edited_period;
                                if($get_note_type == 'debit')
                                {
                                    $slip3_favor_reins_total = $get_slip_total[$count];
                                }
                                else if($get_note_type == 'credit')
                                {
                                    $slip3_favor_ins_total = $get_slip_total[$count];
                                }
                            }

                        }

                        $count++;
                    }

                    if($get_note_type == 'debit')
                    {
                        $FAVOR_REINS_TOTAL = $slip1_favor_reins_total + $slip2_favor_reins_total + $slip3_favor_reins_total;
                        $FAVOR_INS_BALANCE = $FAVOR_REINS_TOTAL;
                        $FAVOR_INS_TOTAL = $FAVOR_INS_BALANCE;
                        $premium_deduct_percentage = 10;

                        $fcfa_deduct = round((($FAVOR_REINS_TOTAL * $premium_deduct_percentage)/100),2);
                        $total_fcfa_pay = $FAVOR_REINS_TOTAL - $fcfa_deduct;
                        $template_path = public_path().'/templates/DebitnoteTemplate.docx';
                        $docx = new CreateDocxFromTemplate($template_path);

                        $variables = array(
                            'RefNo' => $refno, 'GenerationDate' => $current_date, 'Assignor' => $cedant_name, 'CedantAddress' => $cedant_address,
                            'CedantCity' => $cedant_city, 'CedantCountry' => $cedant_country, 'total_pay' => $total_fcfa_pay,
                            'trimester_no' => $getTrimesterDetails['trimester_no'], 'year' => $year, 'FAVOR_INS_BALANCE' => $FAVOR_INS_BALANCE,
                            'FAVOR_INS_TOTAL' => $FAVOR_INS_TOTAL, 'FAVOR_REINS_TOTAL' => $FAVOR_REINS_TOTAL, 'TRIMESTER_BALANCE' => $total_fcfa_pay
                        );
                        $options = array('parseLineBreaks' =>true);
                        $docx->replaceVariableByText($variables, $options);

                        if($slip1_month_year != '')
                        {
                            $slip1_table_array = array(
                                            'LABEL' => "Premium Slip $slip1_month_year ($slip1_month)",
                                            'FAVOR_INS' => '',
                                            'FAVOR_REINS' => $slip1_favor_reins_total,
                                        );
                        }

                        if($slip2_month_year != '')
                        {
                            $slip2_table_array = array(
                                            'LABEL' => "Premium Slip $slip2_month_year ($slip2_month)",
                                            'FAVOR_INS' => '',
                                            'FAVOR_REINS' => $slip2_favor_reins_total,
                                        );
                        }

                        if($slip3_month_year != '')
                        {
                            $slip3_table_array = array(
                                            'LABEL' => "Premium Slip $slip3_month_year ($slip3_month)",
                                            'FAVOR_INS' => '',
                                            'FAVOR_REINS' => $slip3_favor_reins_total,
                                        );
                        }
                        $table_data = array(
                                        $slip1_table_array,
                                        $slip2_table_array,
                                        $slip3_table_array
                                );

                        $docx->replaceTableVariable($table_data, array('parseLineBreaks' => true));

                        $name = 'debit_note_'.$fulldate;
                        $path = public_path().'/documents/notes';
                        $path2 = 'documents/notes';
                        $final_file_path = $path."/".$name;
                        $final_file_path2 = $path2."/".$name;
                        if(!file_exists($path))
                        {
                            mkdir($path, 0777, true);
                        }
                        $create_new = $docx->createDocx($final_file_path);

                        $note->note_url = $final_file_path2;
                        $note->save();

                        $result['debit_note_file_path'] = $final_file_path2;
                        return $this->sendResponse($result, 'Debit note generated successfully', 200);
                    }
                    else if($get_note_type == 'credit')
                    {
                        $FAVOR_INS_TOTAL = $slip1_favor_ins_total + $slip2_favor_ins_total + $slip3_favor_ins_total;
                        $FAVOR_REINS_CASH_CALL_TOTAL = 0;
                        $claim_deduct_percentage = 0;

                        $fcfa_deduct = round((($FAVOR_INS_TOTAL * $claim_deduct_percentage)/100),2);
                        $total_fcfa_pay = $FAVOR_INS_TOTAL - $FAVOR_REINS_CASH_CALL_TOTAL - $fcfa_deduct;
                        $template_path = public_path().'/templates/CreditnoteTemplate.docx';
                        $docx = new CreateDocxFromTemplate($template_path);

                        $variables = array(
                            'RefNo' => $refno, 'GenerationDate' => $current_date, 'Assignor' => $cedant_name, 'CedantAddress' => $cedant_address,
                            'CedantCity' => $cedant_city, 'CedantCountry' => $cedant_country, 'total_pay' => $total_fcfa_pay,
                            'trimester_no' => $getTrimesterDetails['trimester_no'], 'year' => $year, 'FAVOR_REINS_CASH_CALL_TOTAL' => $FAVOR_REINS_CASH_CALL_TOTAL,
                            'TRIMESTER_BALANCE' => $total_fcfa_pay
                        );
                        $options = array('parseLineBreaks' =>true);
                        $docx->replaceVariableByText($variables, $options);

                        if($slip1_month_year != '')
                        {
                            $slip1_table_array = array(
                                            'LABEL' => "Claim Slip $slip1_month_year ($slip1_month)",
                                            'FAVOR_INS' => $slip1_favor_ins_total,
                                            'FAVOR_REINS' => '',
                                        );
                        }

                        if($slip2_month_year != '')
                        {
                            $slip2_table_array = array(
                                            'LABEL' => "Claim Slip $slip2_month_year ($slip2_month)",
                                            'FAVOR_INS' => $slip2_favor_ins_total,
                                            'FAVOR_REINS' => '',
                                        );
                        }

                        if($slip3_month_year != '')
                        {
                            $slip3_table_array = array(
                                            'LABEL' => "Claim Slip $slip3_month_year ($slip3_month)",
                                            'FAVOR_INS' => $slip3_favor_ins_total,
                                            'FAVOR_REINS' => '',
                                        );
                        }
                        $table_data = array(
                                        $slip1_table_array,
                                        $slip2_table_array,
                                        $slip3_table_array
                                );

                        $docx->replaceTableVariable($table_data, array('parseLineBreaks' => true));

                        $name = 'credit_note_'.$fulldate;
                        $path = public_path().'/documents/notes';
                        $path2 = 'documents/notes';
                        $final_file_path = $path."/".$name;
                        $final_file_path2 = $path2."/".$name;
                        if(!file_exists($path))
                        {
                            mkdir($path, 0777, true);
                        }
                        $create_new = $docx->createDocx($final_file_path);

                        $note->note_url = $final_file_path2;
                        $note->save();

                        $result['credit_note_file_path'] = $final_file_path2;
                        return $this->sendResponse($result, 'Credit note generated successfully', 200);

                    }
                    else
                    {
                        return $this->sendError('Something went wrong. Please try again.', [], 400);
                    }

                }
                else
                {
                    return $this->sendError('Note is not validated', [], 400);
                }
            }
        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * List of debit notes
     */
    public function list_debit_notes(Request $request)
    {
        $list_debit_notes = Notes::where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->where('type','=','debit')->orderBy('created_at', 'desc')->get();
        return $this->sendResponse($list_debit_notes, 'List of debit notes', 200);
    }

    /*
     * List of credit notes
     */
    public function list_credit_notes(Request $request)
    {
        $list_credit_notes = Notes::where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->where('type','=','credit')->orderBy('created_at', 'desc')->get();
        return $this->sendResponse($list_credit_notes, 'List of credit notes', 200);
    }

    /*
     * List of claim slips and cases related to it
     */
    public function list_claim_slips(Request $request)
    {
        $list_claims = CedantClaims::where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->where('approval_status','=','Verified')->orderBy('created_at', 'desc')->get();
        if(!empty($list_claims))
        {
            foreach($list_claims as $list_claim)
            {
                $cedant_type_id = $list_claim->cedants_type_id;
                $get_cedant_type = '';
                if(isset($cedant_type_id) && $cedant_type_id != '')
                {
                    $get_cedant_type_data = CedantType::find($cedant_type_id);
                    if($get_cedant_type_data != '')
                    {
                        $get_cedant_type = $get_cedant_type_data->name;
                    }
                }

                if($get_cedant_type == 'NOT LIFE')
                {
                    $claim_cases = CedantClaimNotLifeCases::where('slipes_claims_id','=',$this->convertObjectId($list_claim->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else
                {
                    $claim_cases = CedantClaimCases::where('slipes_claims_id','=',$this->convertObjectId($list_claim->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                $list_claim['claim_cases'] = $claim_cases;
            }
        }
        //echo '<pre>'; print_r($list_premiums); exit;
        return $this->sendResponse($list_claims, 'List of claim slips', 200);
    }

    /*
     * List of cash call claim slips and cases related to it
     */
    public function list_claim_cash_call_slips(Request $request)
    {
        $list_claims = CedantClaims::where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->where('slip_type','=','Cash Call')->where('approval_status','=','Verified')->orderBy('created_at', 'desc')->get();
        if(!empty($list_claims))
        {
            foreach($list_claims as $list_claim)
            {
                $cedant_type_id = $list_claim->cedants_type_id;
                $get_cedant_type = '';
                if(isset($cedant_type_id) && $cedant_type_id != '')
                {
                    $get_cedant_type_data = CedantType::find($cedant_type_id);
                    if($get_cedant_type_data != '')
                    {
                        $get_cedant_type = $get_cedant_type_data->name;
                    }
                }

                if($get_cedant_type == 'NOT LIFE')
                {
                    $claim_cases = CedantClaimNotLifeCases::where('slipes_claims_id','=',$this->convertObjectId($list_claim->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else
                {
                    $claim_cases = CedantClaimCases::where('slipes_claims_id','=',$this->convertObjectId($list_claim->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                $list_claim['claim_cases'] = $claim_cases;
            }
        }
        //echo '<pre>'; print_r($list_premiums); exit;
        return $this->sendResponse($list_claims, 'List of cash call claim slips', 200);
    }

    /*
     * List of claim slips and cases related to a particular cedant
     */
    public function list_cedant_validated_claim_slips(Request $request)
    {
        $list_claims = CedantClaims::where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))
                ->where('cedants_id','=',$this->convertObjectId($request->cedants_id))
                ->orderBy('created_at', 'desc')->get();

        $list_slips_array = [];
        if(!empty($list_claims))
        {
            foreach($list_claims as $list_claim)
            {
                $cedant_type_id = $list_claim->cedants_type_id;
                $get_cedant_type = '';
                if(isset($cedant_type_id) && $cedant_type_id != '')
                {
                    $get_cedant_type_data = CedantType::find($cedant_type_id);
                    if($get_cedant_type_data != '')
                    {
                        $get_cedant_type = $get_cedant_type_data->name;
                    }
                }

                if($get_cedant_type == 'NOT LIFE')
                {
                    $claim_cases = CedantClaimNotLifeCases::where('slipes_claims_id','=',$this->convertObjectId($list_claim->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else
                {
                    $claim_cases = CedantClaimCases::where('slipes_claims_id','=',$this->convertObjectId($list_claim->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }

                $case_valid = [];
                if($claim_cases != null || $claim_cases != '')
                {
                    foreach($claim_cases as $claim_cas)
                    {
                        if($claim_cas->case_validation_status == 'Verified')
                        {
                           $case_valid[] = 'Verified';
                        }
                        else
                        {
                           $case_valid[] = 'Rejected';
                        }
                    }
                }

                if(in_array("Verified",$case_valid))
                {
                    $list_claim['claim_cases'] = $claim_cases;
                    $list_slips_array[] = $list_claim;
                }

            }
        }
        //echo '<pre>'; print_r($list_premiums); exit;
        return $this->sendResponse($list_slips_array, 'List of validated claim slips', 200);
    }

    /*
     * Detail about claim slip and cases related to it
     */
    public function view_claim_slip(Request $request)
    {
        if($request->claim_slip_id != '')
        {
            $view_claim_slip_detail = CedantClaims::where('_id','=',$request->claim_slip_id)->first();
            $cedant_type_id = $view_claim_slip_detail->cedants_type_id;
            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::find($cedant_type_id);
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }
            $result['cedant_type'] = $get_cedant_type;
            $cedant_name = '';
            $cedant_country = '';
            $get_cedant_details = $this->get_cedant_details($view_claim_slip_detail->cedants_id);
            if(isset($get_cedant_details->original['data']) && !empty($get_cedant_details->original['data']) )
            {
                $cedant_name = $get_cedant_details->original['data']['name'];
                $cedant_country = $get_cedant_details->original['data']['country_name'];
            }
            $result['cedant_name'] = $cedant_name;
            $result['cedant_country'] = $cedant_country;

            if($get_cedant_type == 'NOT LIFE')
            {
                $claim_cases = CedantClaimNotLifeCases::where('slipes_claims_id','=',$this->convertObjectId($request->claim_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
            }
            else
            {
                $claim_cases = CedantClaimCases::where('slipes_claims_id','=',$this->convertObjectId($request->claim_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
            }
            $result['claim_slip_detail'] = $view_claim_slip_detail;
            $result['claim_cases'] = $claim_cases;
            return $this->sendResponse($result, 'Claim slip detail', 200);
        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * decision about slip claim cases from admin of reinsurance company
     */
    public function check_cases_claim_slip(Request $request)
    {
        //echo '<pre>'; print_r($request->all()); exit;
        if($request->validation_status != '' && !empty($request->cases_array) && $request->insurance_type != '')
        {
            if($request->validation_status == 1)
            {
                $validation_status = 'Verified';
            }
            else
            {
                $validation_status = 'Rejected';
            }

            $get_cedant_type = $request->insurance_type;
            $slipe_claim_case = '';
            $return_array = [];
            $decode_cases = json_decode($request->cases_array);

            foreach($decode_cases as $each_case)
            {
                $each_case = (array)$each_case;
                $each_case_id = $each_case['case_id'];
                if($get_cedant_type == 'not life')
                {
                    $slipe_claim_case = CedantClaimNotLifeCases::find($each_case_id);
                }
                else if($get_cedant_type == 'life')
                {
                    $slipe_claim_case = CedantClaimCases::find($each_case_id);
                }

                if($slipe_claim_case != null || $slipe_claim_case != '')
                {
                    $slipe_claim_case->case_validation_status = $validation_status;
                    $slipe_claim_case->updated_at = date('Y-m-d H:i:s');
                    $slipe_claim_case->save();

                    $return_array[] = $each_case_id;
                }
            }

            if(!empty($return_array))
            {
                $result['cases_id'] = $return_array;
                return $this->sendResponse($result, 'Case status updated successfully', 200);
            }

        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * final decision about slip claim from admin of reinsurance company
     */
    public function check_final_claim_slip(Request $request)
    {
        if($request->claim_slip_id != '')
        {
            $claim_slip_id = $request->claim_slip_id;
            $view_claim_slip_detail = CedantClaims::where('_id','=',$claim_slip_id)->first();
            $cedant_type_id = $view_claim_slip_detail->cedants_type_id;
            $validation_status_verified = 'Verified';
            $validation_status_partial_verified = 'Partial Verified';
            $validation_status_rejected = 'Rejected';

            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::find($cedant_type_id);
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }

            if($get_cedant_type == 'NOT LIFE')
            {
                $slipe_claim_cases = CedantClaimNotLifeCases::where('slipes_claims_id','=',$this->convertObjectId($claim_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
            }
            else
            {
                $slipe_claim_cases = CedantClaimCases::where('slipes_claims_id','=',$this->convertObjectId($claim_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
            }

            if($slipe_claim_cases != null || $slipe_claim_cases != '')
            {
                $case_valid = [];
                $case_msg = [];
                foreach($slipe_claim_cases as $slipe_claim_cs)
                {
                    $policy_no = $slipe_claim_cs->policy_number;
                    if($slipe_claim_cs->case_validation_status == 'Verified')
                    {
                       $case_valid[] = 'Verified';
                       $case_msg[] = "Case with policy number $policy_no is verified.";
                    }
                    else if($slipe_claim_cs->case_validation_status == 'Rejected')
                    {
                       $case_valid[] = 'Rejected';
                       $case_msg[] = "Case with policy number $policy_no is rejected.";
                    }
                    else
                    {
                       $case_valid[] = 'Pending';
                       $case_msg[] = "Case with policy number $policy_no is pending. Please review this case.";
                    }
                }

                if(!in_array("Rejected",$case_valid) && !in_array("Pending",$case_valid))
                {
                    $view_claim_slip_detail->validation_status = $validation_status_verified;
                    $view_claim_slip_detail->updated_at = date('Y-m-d H:i:s');
                    $view_claim_slip_detail->save();

                    $result['slipes_claims_id'] = $claim_slip_id;
                    return $this->sendResponse($result, 'Claim Slip is fully verified.', 200);
                }
                else if(!in_array("Verified",$case_valid) && !in_array("Pending",$case_valid))
                {
                    $view_claim_slip_detail->validation_status = $validation_status_rejected;
                    $view_claim_slip_detail->updated_at = date('Y-m-d H:i:s');
                    $view_claim_slip_detail->save();

                    $result['slipes_claims_id'] = $claim_slip_id;
                    return $this->sendResponse($result, 'Claim Slip is fully rejected.', 200);
                }
                else if(in_array("Pending",$case_valid))
                {
                    $result['slipes_claims_id'] = $claim_slip_id;
                    $result['case_msg'] = $case_msg;
                    return $this->sendResponse($result, 'Claim Slip cannot be validated.', 200);
                }
                else
                {
                    $view_claim_slip_detail->validation_status = $validation_status_partial_verified;
                    $view_claim_slip_detail->updated_at = date('Y-m-d H:i:s');
                    $view_claim_slip_detail->save();

                    $result['slipes_claims_id'] = $claim_slip_id;
                    return $this->sendResponse($result, 'Claim Slip is partially verified.', 200);
                }

            }
        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * final decision about all slips claim from admin of reinsurance company
     */
    public function check_final_validation_claim_slips(Request $request)
    {
        if($request->reinsurances_id != '')
        {
            $get_trimester_dates = $this->getTrimesterMonths();
            $start = $this->convertDateToMongoDate($get_trimester_dates['start_date']);
            $end = $this->convertDateToMongoDate($get_trimester_dates['end_date']);
            $get_claim_slips = CedantClaims::whereBetween('created_at', array($start, $end))->where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->get();

            $slip_data = [];
            $result = [];
            foreach($get_claim_slips as $eachslip)
            {
                $claim_slip_id = $eachslip->_id;
                $cedant_type_id = $eachslip->cedants_type_id;
                $get_cedant_type = '';
                if(isset($cedant_type_id) && $cedant_type_id != '')
                {
                    $get_cedant_type_data = CedantType::find($cedant_type_id);
                    if($get_cedant_type_data != '')
                    {
                        $get_cedant_type = $get_cedant_type_data->name;
                    }
                }

                if($get_cedant_type == 'NOT LIFE')
                {
                    $slipe_claim_cases = CedantClaimNotLifeCases::where('slipes_claims_id','=',$this->convertObjectId($claim_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else
                {
                    $slipe_claim_cases = CedantClaimCases::where('slipes_claims_id','=',$this->convertObjectId($claim_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }

                if($slipe_claim_cases != null || $slipe_claim_cases != '')
                {
                    $case_valid = [];
                    $error_msg = [];
                    foreach($slipe_claim_cases as $slipe_claim_cs)
                    {
                        if($slipe_claim_cs->case_validation_status == 'Verified')
                        {
                           $case_valid[] = 'Verified';
                        }
                        else
                        {
                           $case_valid[] = 'Rejected';
                           $error_msg[] = 'Claim Case id '.$slipe_claim_cs->_id.' is not verified. Please recheck this case.';
                        }
                    }

                    if(!in_array("Rejected", $case_valid))
                    {
                        $eachslip->validation_status = 'Verified';
                        $eachslip->updated_at = date('Y-m-d H:i:s');
                        $eachslip->save();

                        $result[] = array('slip_id' => $claim_slip_id, 'status' => 'Fully Verified', 'error' => $error_msg);
                    }
                    else
                    {
                        $result[] = array('slip_id' => $claim_slip_id, 'status' => 'Partially Verified', 'error' => $error_msg);
                    }

                }

            }

            //send response
            return $this->sendResponse($result, 'Validation result', 200);

        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * create/update credit note from selected slips claim from admin of reinsurance company
     */
    public function save_credit_note(Request $request)
    {
        if($request->reinsurances_id != '' && $request->selected_slips != '')
        {
            $user = JWTAuth::user();
            $get_trimester_dates = $this->getTrimesterMonths();
            $start = $this->convertDateToMongoDate($get_trimester_dates['start_date']);
            $end = $this->convertDateToMongoDate($get_trimester_dates['end_date']);
            //$get_claim_slips = CedantClaims::whereBetween('created_at', array($start, $end))->where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->get();
            $get_claim_slips = $request->selected_slips;

            $slip_data = [];
            $result = [];
            foreach($get_claim_slips as $get_claim_slip_id)
            {
                $eachslip = CedantClaims::find($get_claim_slip_id);
                $notes_count = Notes::count();
                $claim_slip_id = $eachslip->_id;
                $cedant_type_id = $eachslip->cedants_type_id;
                $cedants_id = (string)$eachslip->cedants_id;
                $get_cedant_type = '';
                if(isset($cedant_type_id) && $cedant_type_id != '')
                {
                    $get_cedant_type_data = CedantType::find($cedant_type_id);
                    if($get_cedant_type_data != '')
                    {
                        $get_cedant_type = $get_cedant_type_data->name;
                    }
                }

                if($get_cedant_type == 'NOT LIFE')
                {
                    $slipe_claim_cases = CedantClaimNotLifeCases::where('slipes_claims_id','=',$this->convertObjectId($claim_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else
                {
                    $slipe_claim_cases = CedantClaimCases::where('slipes_claims_id','=',$this->convertObjectId($claim_slip_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
                }

                if($slipe_claim_cases != null || $slipe_claim_cases != '')
                {
                    $case_valid = [];
                    $error_msg = [];
                    $slip_cases_total_sum = 0;
                    foreach($slipe_claim_cases as $slipe_claim_cs)
                    {
                        if($slipe_claim_cs->case_validation_status == 'Verified')
                        {
                           $case_valid[] = 'Verified';
                           if($get_cedant_type == 'NOT LIFE')
                           {
                               $slip_cases_total_sum = $slip_cases_total_sum + $slipe_claim_cs->use_cash; //or $slipe_claim_cs->recoveries_received
                           }
                           else
                           {
                               $slip_cases_total_sum = $slip_cases_total_sum + $slipe_claim_cs->claim_cede;
                           }
                        }
                        else
                        {
                           $case_valid[] = 'Rejected';
                           $error_msg[] = 'Claim Case id '.$slipe_claim_cs->_id.' is not verified. Please recheck this case.';
                        }
                    }

                    if($slip_cases_total_sum > 0)
                    {
                        $slip_data[] = array('slip_id' => $claim_slip_id, 'slip_total' => $slip_cases_total_sum);

                        //make a entry for credit note in the database if not exists else update it
                        $cedant = ReinsuranceCedant::find($cedants_id);
                        $reinsurance = Reinsurance::find($request->reinsurances_id);
                        $cedant_code = '';
                        $cedant_code_concat = '';
                        $reinsurance_name = '';
                        if($cedant != '')
                        {
                            $cedant_code = $cedant->code;
                            $cedant_code_concat = '-'.$cedant_code;
                        }

                        if($reinsurance != '')
                        {
                            $reinsurance_name = $reinsurance->name;
                        }
                        $initial_name = $this->getInitalNames($user->username);
                        $periodicity = $get_trimester_dates['trimester_no'].' trimester';
                        $year = date('Y');
                        $date = date('dMY');
                        $get_trimester_note = Notes::where('periodicity','=',$periodicity)->where('year','=',$year)
                                ->where('type','=','credit')
                                ->where('cedants_id','=',$this->convertObjectId($eachslip->cedants_id))
                                ->where('reinsurances_id','=',$this->convertObjectId($eachslip->reinsurances_id))
                                ->first();

                        if($get_trimester_note == '')
                        {
                            $autonum = $notes_count+1;
                            /* $countlen = strlen($autonum);
                            if($countlen == 1)
                            {
                                $ref_chronic_no = '000'.$autonum;
                            }
                            else if($countlen == 2)
                            {
                                $ref_chronic_no = '00'.$autonum;
                            }
                            else if($countlen == 3)
                            {
                                $ref_chronic_no = '0'.$autonum;
                            }
                            else
                            {
                                $ref_chronic_no = $autonum;
                            } */
                            $chronic_no = $autonum.$cedant_code_concat;
                            $reference = "NC-$chronic_no/$initial_name/$year/$reinsurance_name";
                            $location = '';
                            $type= 'credit';
                            $note_url = '';
                            $cedants_id = $eachslip->cedants_id;
                            $reinsurances_id = $eachslip->reinsurances_id;
                            $payment_status = 'Pending';
                            $validation_status = 'Pending';
                            $approval_status = 'Pending';

                            $new_credit_note = Notes::create([
                                'reference' => $reference,
                                'location' => $location,
                                'date' => $date,
                                'periodicity' => $periodicity,
                                'year' => $year,
                                'type' => $type,
                                'slip_ids' => array($claim_slip_id),
                                'slip_total' => array($slip_cases_total_sum),
                                'ins_type' => $get_cedant_type,
                                'note_url' => $note_url,
                                'cedants_id' => $this->convertObjectId($cedants_id),
                                'reinsurances_id' => $this->convertObjectId($reinsurances_id),
                                'payment_status' => $payment_status,
                                'validation_status' => $validation_status,
                                'approval_status' => $approval_status
                            ]);

                        }
                        else
                        {
                            $existing_slips = $get_trimester_note->slip_ids;
                            array_push($existing_slips,$claim_slip_id);

                            $existing_slip_total = $get_trimester_note->slip_total;
                            array_push($existing_slip_total,$slip_cases_total_sum);

                            $get_trimester_note->slip_ids = $existing_slips;
                            $get_trimester_note->slip_total = $existing_slip_total;
                            $get_trimester_note->updated_at = date('Y-m-d H:i:s');
                            $get_trimester_note->save();
                        }

                    }

                    if(!in_array("Rejected",$case_valid))
                    {
                        $result[] = array('slip_id' => $claim_slip_id, 'status' => 'Fully Verified', 'error' => $error_msg);
                    }
                    else
                    {
                        $result[] = array('slip_id' => $claim_slip_id, 'status' => 'Partially Verified', 'error' => $error_msg);
                    }

                }

            }

            //send response
            return $this->sendResponse($result, 'Credit note generated successfully', 200);

        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
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
     * List of cedants related to it
     */
    public function list_cedants(Request $request)
    {
        if(isset($request->reinsurances_id) && $request->reinsurances_id != '')
        {
            $list_cedants = ReinsuranceCedant::where('reinsurances_id','=',$this->convertObjectId($request->reinsurances_id))->orderBy('created_at', 'desc')->get();
            //$result['list_cedants'] = $list_cedants;
            $return_array = array();
            if(!empty($list_cedants))
            {
                $i=0;
                foreach($list_cedants as $list_cedant)
                {
                    $reinsurances_id = (string)$list_cedant->reinsurances_id;
                    $countries_id = (string)$list_cedant->countries_id;
                    $region_id = (string)$list_cedant->region_id;
                    $types_cedants_id = (string)$list_cedant->types_cedants_id;
                    $currencies_id = (string)$list_cedant->currencies_id;
                    $groups_cedants_id = (string)$list_cedant->groups_cedants_id;

                    $country = Country::find($countries_id);
                    $region = Region::find($region_id);
                    $group = GroupInsurance::find($groups_cedants_id);
                    $country_name = '';
                    $region_name = '';
                    $group_name = '';
                    if($country != '')
                    {
                        $country_name = $country->name;
                    }

                    if($region != '')
                    {
                        $region_name = $region->name;
                    }

                    if($group != '')
                    {
                        $group_name = $group->name;
                    }

                    //echo '<pre>'; print_r($list_cedant); exit;
                    $return_array[$i]['id'] = $list_cedant->_id;
                    $return_array[$i]['name'] = $list_cedant->name;
                    $return_array[$i]['email'] = $list_cedant->email;
                    $return_array[$i]['contact'] = $list_cedant->contact;
                    $return_array[$i]['reinsurances_id'] = $reinsurances_id;
                    $return_array[$i]['groups_cedants_id'] = $groups_cedants_id;
                    $return_array[$i]['group_name'] = $group_name;
                    $return_array[$i]['logo'] = $list_cedant->logo;
                    $return_array[$i]['color1'] = $list_cedant->color1;
                    $return_array[$i]['color2'] = $list_cedant->color2;
                    $return_array[$i]['countries_id'] = $countries_id;
                    $return_array[$i]['region_id'] = $region_id;
                    $return_array[$i]['country_name'] = $country_name;
                    $return_array[$i]['region_name'] = $region_name;
                    $return_array[$i]['types_cedants_id'] = $types_cedants_id;
                    $return_array[$i]['currencies_id'] = $currencies_id;
                    $return_array[$i]['benefit_percentage'] = $list_cedant->benefit_percentage;
                    $return_array[$i]['created_at'] = $list_cedant->created_at;
                    $i++;
                }
            }
            return $this->sendResponse($return_array, 'List of cedants', 200);
        }
        else
        {
            $result = array();
            return $this->sendResponse($result, 'List of cedants', 200);
        }
    }

    /*
     * List of profiles
     */
    public function get_profiles(Request $request)
    {
        $profiles = UserReinsuranceProfile::get();
        return $this->sendResponse($profiles, 'List of profiles', 200);
    }

    /*
     * List of roles
     */
    public function get_roles(Request $request)
    {
        $roles = UserReinsuranceRole::get();
        return $this->sendResponse($roles, 'List of roles', 200);
    }

    /*
     * List of groups
     */
    public function get_groups(Request $request)
    {
        $groups = GroupInsurance::get();
        return $this->sendResponse($groups, 'List of groups', 200);
    }

    /*
     * List of countries
     */
    public function get_countries(Request $request)
    {
        $countries = Country::orderBy('created_at', 'desc')->get();
        $return_array = array();
        if(!empty($countries))
        {
            $i=0;
            foreach($countries as $list_user)
            {
                $region_id = (string)$list_user->regions_id;
                $region_data = Region::find($region_id);
                $region_name = '';
                if($region_data != '')
                {
                    $region_name = $region_data->name;
                }

                //echo '<pre>'; print_r($list_user); exit;
                $return_array[$i]['_id'] = $list_user->_id;
                $return_array[$i]['name'] = $list_user->name;
                $return_array[$i]['code'] = $list_user->code;
                $return_array[$i]['regions_id'] = $region_id;
                $return_array[$i]['region_name'] = $region_name;
                $return_array[$i]['created_at'] = $list_user->created_at;
                $i++;
            }
        }
        return $this->sendResponse($return_array, 'List of countries', 200);
    }

    /*
     * List of regions
     */
    public function get_regions(Request $request)
    {
        $regions = Region::orderBy('created_at', 'desc')->get();
        return $this->sendResponse($regions, 'List of regions', 200);
    }

    /*
     * List of cedant types
     */
    public function get_cedant_types(Request $request)
    {
        $cedant_types = CedantType::get();
        return $this->sendResponse($cedant_types, 'List of cedant types', 200);
    }

    /*
     * List of currencies
     */
    public function get_currencies(Request $request)
    {
        $currencies = Currency::get();
        return $this->sendResponse($currencies, 'List of currencies', 200);
    }

    /*
     * List of branch categories
     */
//    public function get_branch_categories(Request $request)
//    {
//        $branch_categories = BranchCategory::get();
//        return $this->sendResponse($branch_categories, 'List of branch categories', 200);
//    }

    /*
     * add comment for reinsurance company cases
     */
    public function add_comment(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'message' => 'required|max:255',
            'cases_id' => 'required',
            'cases_type' => 'required',
            'user_reinsurance_id' => 'required'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $comment = Comment::create([
            'message' => $request->get('message'),
            'cases_id' => $this->convertObjectId($request->get('cases_id')),
            'cases_type' => $request->get('cases_type'),
            'user_reinsurance_id' => $this->convertObjectId($request->get('user_reinsurance_id')),
            'status' => 1
        ]);

        $comment_id = '';
        if(isset($comment->_id) && $comment->_id != '')
        {
            $comment_id = $comment->_id;
        }

        $result['comment_id'] = $comment_id;
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'Comment created successfully', 200);
    }

    /*
     * update comment for reinsurance company cases
     */
    public function update_comment(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'message' => 'required|max:255',
            'comment_id' => 'required',
            'user_reinsurance_id' => 'required'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $comment = Comment::find($request->comment_id);
        if($comment != null || $comment != '')
        {
            $comment->message = $request->get('message');
            $comment->updated_at = date('Y-m-d H:i:s');
            $comment->save();
        }

        $comment_id = '';
        if(isset($comment->_id) && $comment->_id != '')
        {
            $comment_id = $comment->_id;
        }

        $result['comment_id'] = $request->comment_id;
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'Comment updated successfully', 200);
    }

    /*
     * add note comment for reinsurance company notes
     */
    public function add_note_comment(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'message' => 'required|max:255',
            'note_id' => 'required',
            'note_type' => 'required',
            'user_reinsurance_id' => 'required'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $comment = Comment::create([
            'message' => $request->get('message'),
            'note_id' => $this->convertObjectId($request->get('note_id')),
            'note_type' => $request->get('note_type'),
            'user_reinsurance_id' => $this->convertObjectId($request->get('user_reinsurance_id')),
            'status' => 1
        ]);

        $comment_id = '';
        if(isset($comment->_id) && $comment->_id != '')
        {
            $comment_id = $comment->_id;
        }

        $result['comment_id'] = $comment_id;
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'Comment created successfully', 200);
    }

    /*
     * update note comment for reinsurance company notes
     */
    public function update_note_comment(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'message' => 'required|max:255',
            'comment_id' => 'required',
            'user_reinsurance_id' => 'required'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $comment = Comment::find($request->comment_id);
        if($comment != null || $comment != '')
        {
            $comment->message = $request->get('message');
            $comment->updated_at = date('Y-m-d H:i:s');
            $comment->save();
        }

        $comment_id = '';
        if(isset($comment->_id) && $comment->_id != '')
        {
            $comment_id = $comment->_id;
        }

        $result['comment_id'] = $request->comment_id;
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'Comment updated successfully', 200);
    }

    /*
     * Detail about claim slip justification files and cases related to it
     */
    public function view_justification_files(Request $request)
    {
        if($request->claim_slip_id != '' && $request->case_id != '')
        {
            $view_claim_slip_detail = CedantClaims::where('_id','=',$request->claim_slip_id)->first();
            $cedant_type_id = $view_claim_slip_detail->cedants_type_id;
            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::find($cedant_type_id);
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }

            if($get_cedant_type == 'NOT LIFE')
            {
                $claim_case_files = Files::where('cases_id','=',$this->convertObjectId($request->case_id))->where('cases_type','=','claim_not_life')->orderBy('created_at', 'desc')->get();
            }
            else
            {
                $claim_case_files = Files::where('cases_id','=',$this->convertObjectId($request->case_id))->where('cases_type','=','claim_life')->orderBy('created_at', 'desc')->get();
            }
            $result['claim_slip_detail'] = $view_claim_slip_detail;
            $result['claim_case_files'] = $claim_case_files;
            return $this->sendResponse($result, 'Claim slip justification files', 200);
        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * Detail about premium slip comments and cases related to it
     */
    public function view_premium_comments(Request $request)
    {
        if($request->premium_slip_id != '' && $request->case_id != '')
        {
            $view_premium_slip_detail = CedantPremiums::where('_id','=',$request->premium_slip_id)->first();
            $cedant_type_id = $view_premium_slip_detail->cedants_type_id;
            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::find($cedant_type_id);
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }

            if($get_cedant_type == 'NOT LIFE')
            {
                $premium_case_comments = Comment::where('cases_id','=',$this->convertObjectId($request->case_id))->where('cases_type','=','premium_not_life')->orderBy('created_at', 'desc')->get();
            }
            else
            {
                $premium_case_comments = Comment::where('cases_id','=',$this->convertObjectId($request->case_id))->where('cases_type','=','premium_life')->orderBy('created_at', 'desc')->get();
            }
            $result['premium_slip_detail'] = $view_premium_slip_detail;
            $result['premium_case_comments'] = $premium_case_comments;
            return $this->sendResponse($result, 'Premium slip comments', 200);
        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * Detail about claim slip comments and cases related to it
     */
    public function view_claim_comments(Request $request)
    {
        if($request->claim_slip_id != '' && $request->case_id != '')
        {
            $view_claim_slip_detail = CedantClaims::where('_id','=',$request->claim_slip_id)->first();
            $cedant_type_id = $view_claim_slip_detail->cedants_type_id;
            $get_cedant_type = '';
            if(isset($cedant_type_id) && $cedant_type_id != '')
            {
                $get_cedant_type_data = CedantType::find($cedant_type_id);
                if($get_cedant_type_data != '')
                {
                    $get_cedant_type = $get_cedant_type_data->name;
                }
            }

            if($get_cedant_type == 'NOT LIFE')
            {
                $claim_case_comments = Comment::where('cases_id','=',$this->convertObjectId($request->case_id))->where('cases_type','=','claim_not_life')->orderBy('created_at', 'desc')->get();
            }
            else
            {
                $claim_case_comments = Comment::where('cases_id','=',$this->convertObjectId($request->case_id))->where('cases_type','=','claim_life')->orderBy('created_at', 'desc')->get();
            }
            $result['claim_slip_detail'] = $view_claim_slip_detail;
            $result['claim_case_comments'] = $claim_case_comments;
            return $this->sendResponse($result, 'Claim slip comments', 200);
        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * Detail about note comments
     */
    public function view_note_comments(Request $request)
    {
        if($request->note_id != '')
        {
            $note_comments = Comment::where('note_id','=',$this->convertObjectId($request->note_id))->orderBy('created_at', 'desc')->get();
            return $this->sendResponse($note_comments, 'Note comments', 200);
        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * Detail about note
     */
    public function view_note(Request $request)
    {
        if($request->note_id != '')
        {
            $note = Notes::find($request->note_id);
            return $this->sendResponse($note, 'Note details', 200);
        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
     * add invoice files for reinsurance company notes
     */
    public function add_invoice_note_files(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'note_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $invoice_files = '';
        $file_path = array();
        if(isset($_FILES["invoice_image"]["name"]))
        {
            foreach($_FILES["invoice_image"]["error"] as $key=>$error)
            {
               if($error == 0)
               {
                    $tmp_name = $_FILES["invoice_image"]["tmp_name"][$key];
                    $name = str_replace(' ', '_', $_FILES["invoice_image"]["name"][$key]);
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
                    {
                        $name = 'note_'.time().'.'.$ext;
                        $path = public_path().'/documents/note_invoice_files';
                        $path2 = 'documents/note_invoice_files';
                        $final_file_path = $path."/".$name;
                        $final_file_path2 = $path2."/".$name;
                        if(!file_exists($path))
                        {
                            mkdir($path, 0777, true);
                        }

                        if(move_uploaded_file($tmp_name, $final_file_path))
                        {
                            $file_path[] = $final_file_path2;
                        }
                    }
               }
            }
        }
        else
        {
            return $this->sendError('Validation Error', 'File not found', 400);
        }

        if(!empty($file_path))
        {
            $invoice_files = implode(',',$file_path);
        }

        $note = Notes::find($request->note_id);
        if($note != '' && $note != null)
        {
            $note->invoice_url = $invoice_files;
            $note->updated_at = date('Y-m-d H:i:s');
            $note->save();
        }

        $result['note_id'] = $request->note_id;
        return $this->sendResponse($result, 'Invoice file saved successfully', 200);
    }

    /*
     * get details for insurance company
     */
    public function get_cedant_details($cedant_id)
    {
        $ins = ReinsuranceCedant::find($cedant_id);
        if($ins != null || $ins != '')
        {
            $name = $ins->name;
            $email = $ins->email;
            $contact = $ins->contact;
            $logo = $ins->logo;
            $color1 = $ins->color1;
            $color2 = $ins->color2;
            $country_id = (string)$ins->countries_id;
            $region_id = (string)$ins->region_id;
            $type_cedant_id = (string)$ins->types_cedants_id;
            $currency_id = (string)$ins->currencies_id;
            $benefit_percentage = $ins->benefit_percentage;

            $country_name = '';
            $region_name = '';
            $insurance_type = '';
            $currency_name = '';
            $country = Country::find($country_id);
            if($country != '')
            {
                $country_name = $country->name;
            }

            $region = Region::find($region_id);
            if($region != '')
            {
                $region_name = $region->name;
            }

            $cedant_type = CedantType::find($type_cedant_id);
            if($cedant_type != '')
            {
                $insurance_type = $cedant_type->name;
            }

            $currency = Currency::find($currency_id);
            if($currency != '')
            {
                $currency_name = $currency->name;
            }

            $result = array('name' => $name, 'email' => $email, 'contact' => $contact, 'logo' => $logo,
                'color1' => $color1, 'color2' => $color2, 'country_name' => $country_name,
                'region_name' => $region_name, 'insurance_type' => $insurance_type, 'currency_name' => $currency_name,
                'benefit_percentage' => $benefit_percentage);

            return $this->sendResponse($result, 'Cedant details', 200);

        }

        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }

    /*
    * create payment method
    */
    public function create_payment_method(Request $request){
       $validator = Validator::make($request->all() , [
           'name' => 'required|max:255|unique:payment_methods'
       ]);

       if($validator->fails()){
               return $this->sendError('Validation Error', $validator->errors(), 400);
       }

       $payment_method = PaymentMethod::create([
           'name' => $request->get('name')
       ]);

       $payment_method_id = '';
       if(isset($payment_method->_id) && $payment_method->_id != '')
       {
           $payment_method_id = $payment_method->_id;
       }

       $result['payment_method_id'] = $payment_method_id;
       return $this->sendResponse($result, 'Payment Method created successfully', 200);
    }

    /*
    * Update payment method
    */
    public function update_payment_method(Request $request){
       $validator = Validator::make($request->all() , [
           'name' => 'required|max:255|unique:payment_methods,name,'. $request->payment_method_id. ',_id',
           'payment_method_id' => 'required'
       ]);

       if($validator->fails()){
               return $this->sendError('Validation Error', $validator->errors(), 400);
       }

       $payment_method = PaymentMethod::find($request->payment_method_id);
       if($payment_method != null || $payment_method != '')
       {
           $payment_method->name = $request->get('name');
           $payment_method->updated_at = date('Y-m-d H:i:s');
           $payment_method->save();
       }

       $result['payment_method_id'] = $request->payment_method_id;
       return $this->sendResponse($result, 'Payment method updated successfully', 200);
    }

    /*
    * List of payment methods
    */
    public function list_payment_methods(Request $request)
    {
       $payment_methods = PaymentMethod::orderBy('created_at', 'desc')->get();
       return $this->sendResponse($payment_methods, 'List of payment methods', 200);
    }

    /*
    * create representation
    */
    public function create_representation(Request $request){
       $validator = Validator::make($request->all() , [
           'name' => 'required|max:255|unique:representation',
           'agent' => 'required',
           'city' => 'required',
           'header' => 'required',
           'footer' => 'required'
       ]);

       if($validator->fails()){
               return $this->sendError('Validation Error', $validator->errors(), 400);
       }

       $representation = Representation::create([
           'name' => $request->get('name'),
           'agent' => $request->get('agent'),
           'city' => $request->get('city'),
           'header' => $request->get('header'),
           'footer' => $request->get('footer')
       ]);

       $representation_id = '';
       if(isset($representation->_id) && $representation->_id != '')
       {
           $representation_id = $representation->_id;
       }

       $result['representation_id'] = $representation_id;
       return $this->sendResponse($result, 'Representation created successfully', 200);
    }

    /*
    * Update representation
    */
    public function update_representation(Request $request){
       $validator = Validator::make($request->all() , [
           'name' => 'required|max:255|unique:representation,name,'. $request->representation_id. ',_id',
           'agent' => 'required',
           'city' => 'required',
           'header' => 'required',
           'footer' => 'required',
           'representation_id' => 'required'
       ]);

       if($validator->fails()){
               return $this->sendError('Validation Error', $validator->errors(), 400);
       }

       $representation = Representation::find($request->representation_id);
       if($representation != null || $representation != '')
       {
           $representation->name = $request->get('name');
           $representation->agent = $request->get('agent');
           $representation->city = $request->get('city');
           $representation->header = $request->get('header');
           $representation->footer = $request->get('footer');
           $representation->updated_at = date('Y-m-d H:i:s');
           $representation->save();
       }

       $result['representation_id'] = $request->representation_id;
       return $this->sendResponse($result, 'Representation updated successfully', 200);
    }

    /*
    * List of representations
    */
    public function list_representations(Request $request)
    {
       $representations = Representation::orderBy('created_at', 'desc')->get();
       return $this->sendResponse($representations, 'List of representations', 200);
    }

    /*
    * create gender
    */
    public function create_gender(Request $request){
       $validator = Validator::make($request->all() , [
           'name' => 'required|max:255|unique:gender'
       ]);

       if($validator->fails()){
               return $this->sendError('Validation Error', $validator->errors(), 400);
       }

       $gender = Gender::create([
           'name' => $request->get('name')
       ]);

       $gender_id = '';
       if(isset($gender->_id) && $gender->_id != '')
       {
           $gender_id = $gender->_id;
       }

       $result['gender_id'] = $gender_id;
       return $this->sendResponse($result, 'Gender created successfully', 200);
    }

    /*
    * Update gender
    */
    public function update_gender(Request $request){
       $validator = Validator::make($request->all() , [
           'name' => 'required|max:255|unique:gender,name,'. $request->gender_id. ',_id',
           'gender_id' => 'required'
       ]);

       if($validator->fails()){
               return $this->sendError('Validation Error', $validator->errors(), 400);
       }

       $gender = Gender::find($request->gender_id);
       if($gender != null || $gender != '')
       {
           $gender->name = $request->get('name');
           $gender->updated_at = date('Y-m-d H:i:s');
           $gender->save();
       }

       $result['gender_id'] = $request->gender_id;
       return $this->sendResponse($result, 'Gender updated successfully', 200);
    }

    /*
    * List of genders
    */
    public function list_gender(Request $request)
    {
       $gender = Gender::orderBy('created_at', 'desc')->get();
       return $this->sendResponse($gender, 'List of gender', 200);
    }

    /*
    * create civility
    */
    public function create_civility(Request $request){
       $validator = Validator::make($request->all() , [
           'name' => 'required|max:255|unique:civility',
           'abbreviation' => 'required'
       ]);

       if($validator->fails()){
               return $this->sendError('Validation Error', $validator->errors(), 400);
       }

       $civility = Civility::create([
           'name' => $request->get('name'),
           'abbreviation' => $request->get('abbreviation'),
       ]);

       $civility_id = '';
       if(isset($civility->_id) && $civility->_id != '')
       {
           $civility_id = $civility->_id;
       }

       $result['civility_id'] = $civility_id;
       return $this->sendResponse($result, 'Civility created successfully', 200);
    }

    /*
    * Update civility
    */
    public function update_civility(Request $request){
       $validator = Validator::make($request->all() , [
           'name' => 'required|max:255|unique:civility,name,'. $request->civility_id. ',_id',
           'abbreviation' => 'required',
           'civility_id' => 'required'
       ]);

       if($validator->fails()){
               return $this->sendError('Validation Error', $validator->errors(), 400);
       }

       $civility = Civility::find($request->civility_id);
       if($civility != null || $civility != '')
       {
           $civility->name = $request->get('name');
           $civility->abbreviation = $request->get('abbreviation');
           $civility->updated_at = date('Y-m-d H:i:s');
           $civility->save();
       }

       $result['civility_id'] = $request->civility_id;
       return $this->sendResponse($result, 'Civility updated successfully', 200);
    }

    /*
    * List of civility
    */
    public function list_civility(Request $request)
    {
       $civility = Civility::orderBy('created_at', 'desc')->get();
       return $this->sendResponse($civility, 'List of civility', 200);
    }

    /*
     * create branch for life/no life
     */
    public function create_branch(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255|unique:branches',
            'type' => 'required',
            'code' => 'required'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch = Branch::create([
            'name' => $request->get('name'),
            'is_parent' => 1,
            'parent_branch_id' => '',
            'status' => 1,
            'type' => $request->get('type'),
            'alias' => $request->get('alias'),
            'code' => $request->get('code')
        ]);

        $branch_id = '';
        if(isset($branch->_id) && $branch->_id != '')
        {
            $branch_id = $branch->_id;
        }

        $result['branch_id'] = $branch_id;
        return $this->sendResponse($result, 'Branch created successfully', 200);
    }

    /*
     * update branch for life/no life
     */
    public function update_branch(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255|unique:branches,name,'. $request->branch_id. ',_id',
            'type' => 'required',
            'code' => 'required'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch = Branch::find($request->branch_id);
        if($branch != null || $branch != '')
        {
            $branch->name = $request->get('name');
            $branch->type = $request->get('type');
            $branch->alias = $request->get('alias');
            $branch->code = $request->get('code');
            $branch->updated_at = date('Y-m-d H:i:s');
            $branch->save();
        }

        $branch_id = '';
        if(isset($branch->_id) && $branch->_id != '')
        {
            $branch_id = $branch->_id;
        }

        $result['branch_id'] = $request->branch_id;
        return $this->sendResponse($result, 'Branch updated successfully', 200);
    }

    /*
     * List of all branches
     */
    public function list_branches(Request $request)
    {
        $list_branches = Branch::where('is_parent','=',1)->orderBy('created_at', 'desc')->get();
        if(!empty($list_branches))
        {
            foreach($list_branches as $branch)
            {
                $branch_id = $branch->_id;
                $list_sub_branches = Branch::where('parent_branch_id','=',$this->convertObjectId($branch_id))->orderBy('created_at', 'desc')->get();
                //echo '<pre>'; print_r($list_sub_branches); exit;
                $branch['sub_branches'] = $list_sub_branches;
            }
        }
        return $this->sendResponse($list_branches, 'List of branches', 200);
    }

    /*
     * List of life branches
     */
    public function list_life_branches(Request $request)
    {
        $list_branches = Branch::where('is_parent','=',1)->where('type','=','life')->orderBy('created_at', 'desc')->get();
        if(!empty($list_branches))
        {
            foreach($list_branches as $branch)
            {
                $branch_id = $branch->_id;
                $list_sub_branches = Branch::where('parent_branch_id','=',$this->convertObjectId($branch_id))->orderBy('created_at', 'desc')->get();
                //echo '<pre>'; print_r($list_sub_branches); exit;
                $branch['sub_branches'] = $list_sub_branches;
            }
        }
        return $this->sendResponse($list_branches, 'List of branches', 200);
    }

    /*
     * List of not life branches
     */
    public function list_not_life_branches(Request $request)
    {
        $list_branches = Branch::where('is_parent','=',1)->where('type','=','not life')->orderBy('created_at', 'desc')->get();
        if(!empty($list_branches))
        {
            foreach($list_branches as $branch)
            {
                $branch_id = $branch->_id;
                $list_sub_branches = Branch::where('parent_branch_id','=',$this->convertObjectId($branch_id))->orderBy('created_at', 'desc')->get();
                //echo '<pre>'; print_r($list_sub_branches); exit;
                $branch['sub_branches'] = $list_sub_branches;
            }
        }
        return $this->sendResponse($list_branches, 'List of branches', 200);
    }

    /*
     * create branch capital
     */
    public function create_branch_capital(Request $request){
        $validator = Validator::make($request->all() , [
            'country_id' => 'required',
            'branch_id' => 'required',
            'max_risk_capital' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch_capital = BranchCapital::create([
            'country_id' => $this->convertObjectId($request->get('country_id')),
            'branch_id' => $this->convertObjectId($request->get('branch_id')),
            'sub_branch_id' => '',
            'max_risk_capital' => $request->get('max_risk_capital')
        ]);

        $branch_capital_id = '';
        if(isset($branch_capital->_id) && $branch_capital->_id != '')
        {
            $branch_capital_id = $branch_capital->_id;
        }

        $result['branch_capital_id'] = $branch_capital_id;
        return $this->sendResponse($result, 'Branch Capital created successfully', 200);
    }

    /*
     * Update branch capital
     */
    public function update_branch_capital(Request $request){
        $validator = Validator::make($request->all() , [
            'country_id' => 'required',
            'branch_id' => 'required',
            'max_risk_capital' => 'required',
            'branch_capital_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch_capital = BranchCapital::find($request->branch_capital_id);
        if($branch_capital != null || $branch_capital != '')
        {
            $branch_capital->country_id = $this->convertObjectId($request->get('country_id'));
            $branch_capital->branch_id = $this->convertObjectId($request->get('branch_id'));
            $branch_capital->max_risk_capital = $request->get('max_risk_capital');
            $branch_capital->updated_at = date('Y-m-d H:i:s');
            $branch_capital->save();
        }

        $result['branch_capital_id'] = $request->branch_capital_id;
        return $this->sendResponse($result, 'Branch Capital updated successfully', 200);
    }

    /*
     * List of branch capitals
     */
    public function list_branch_capital(Request $request)
    {
        $branch_capitals = BranchCapital::where('sub_branch_id','=','')->orderBy('created_at', 'desc')->get();
        $return_array = [];
        if(!empty($branch_capitals))
        {
            $i=0;
            foreach($branch_capitals as $list_user)
            {
                $country_id = (string)$list_user->country_id;
                $country_data = Country::find($country_id);
                $branch_id = (string)$list_user->branch_id;
                $branch_data = Branch::find($branch_id);
                $country_name = '';
                $branch_name = '';
                if($country_data != '')
                {
                    $country_name = $country_data->name;
                }

                if($branch_data != '')
                {
                    $branch_name = $branch_data->name;
                }

                //echo '<pre>'; print_r($list_user); exit;
                $return_array[$i]['_id'] = $list_user->_id;
                $return_array[$i]['country_id'] = $country_id;
                $return_array[$i]['branch_id'] = $branch_id;
                $return_array[$i]['country_name'] = $country_name;
                $return_array[$i]['branch_name'] = $branch_name;
                $return_array[$i]['max_risk_capital'] = $list_user->max_risk_capital;
                $return_array[$i]['created_at'] = $list_user->created_at;
                $i++;
            }
        }
        return $this->sendResponse($return_array, 'List of branch capitals', 200);
    }

    /*
     * create branch commission
     */
    public function create_branch_commission(Request $request){
        $validator = Validator::make($request->all() , [
            'country_id' => 'required',
            'branch_id' => 'required',
            'commission' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch_commission = BranchCommission::create([
            'country_id' => $this->convertObjectId($request->get('country_id')),
            'branch_id' => $this->convertObjectId($request->get('branch_id')),
            'sub_branch_id' => '',
            'commission' => $request->get('commission')
        ]);

        $branch_commission_id = '';
        if(isset($branch_commission->_id) && $branch_commission->_id != '')
        {
            $branch_commission_id = $branch_commission->_id;
        }

        $result['branch_commission_id'] = $branch_commission_id;
        return $this->sendResponse($result, 'Branch Commission created successfully', 200);
    }

    /*
     * Update branch commission
     */
    public function update_branch_commission(Request $request){
        $validator = Validator::make($request->all() , [
            'country_id' => 'required',
            'branch_id' => 'required',
            'commission' => 'required',
            'branch_commission_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch_commission = BranchCommission::find($request->branch_commission_id);
        if($branch_commission != null || $branch_commission != '')
        {
            $branch_commission->country_id = $this->convertObjectId($request->get('country_id'));
            $branch_commission->branch_id = $this->convertObjectId($request->get('branch_id'));
            $branch_commission->commission = $request->get('commission');
            $branch_commission->updated_at = date('Y-m-d H:i:s');
            $branch_commission->save();
        }

        $result['branch_commission_id'] = $request->branch_commission_id;
        return $this->sendResponse($result, 'Branch Commission updated successfully', 200);
    }

    /*
     * List of branch commissions
     */
    public function list_branch_commission(Request $request)
    {
        $branch_commissions = BranchCommission::where('sub_branch_id','=','')->orderBy('created_at', 'desc')->get();
        $return_array = [];
        if(!empty($branch_commissions))
        {
            $i=0;
            foreach($branch_commissions as $list_user)
            {
                $country_id = (string)$list_user->country_id;
                $country_data = Country::find($country_id);
                $branch_id = (string)$list_user->branch_id;
                $branch_data = Branch::find($branch_id);
                $country_name = '';
                $branch_name = '';
                if($country_data != '')
                {
                    $country_name = $country_data->name;
                }

                if($branch_data != '')
                {
                    $branch_name = $branch_data->name;
                }

                //echo '<pre>'; print_r($list_user); exit;
                $return_array[$i]['_id'] = $list_user->_id;
                $return_array[$i]['country_id'] = $country_id;
                $return_array[$i]['branch_id'] = $branch_id;
                $return_array[$i]['country_name'] = $country_name;
                $return_array[$i]['branch_name'] = $branch_name;
                $return_array[$i]['commission'] = $list_user->commission;
                $return_array[$i]['created_at'] = $list_user->created_at;
                $i++;
            }
        }
        return $this->sendResponse($return_array, 'List of branch commissions', 200);
    }

    /*
     * create sub branch for life/no life
     */
    public function create_sub_branch(Request $request){
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255|unique:branches',
            'parent_branch_id' => 'required',
            'type' => 'required',
            'code' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch = Branch::create([
            'name' => $request->get('name'),
            'is_parent' => 0,
            'parent_branch_id' => $this->convertObjectId($request->get('parent_branch_id')),
            'status' => 1,
            'type' => $request->get('type'),
            'alias' => $request->get('alias'),
            'code' => $request->get('code')
        ]);

        $branch_id = '';
        if(isset($branch->_id) && $branch->_id != '')
        {
            $branch_id = $branch->_id;
        }

        $result['branch_id'] = $branch_id;
        return $this->sendResponse($result, 'Sub Branch created successfully', 200);
    }

    /*
     * Update sub branch for life/no life
     */
    public function update_sub_branch(Request $request){
        $validator = Validator::make($request->all() , [
            'name' => 'required|max:255|unique:branches,name,'. $request->branch_id. ',_id',
            'parent_branch_id' => 'required',
            'type' => 'required',
            'code' => 'required',
            'branch_id' => 'required'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch = Branch::find($request->branch_id);
        if($branch != null || $branch != '')
        {
            $branch->name = $request->get('name');
            $branch->parent_branch_id = $this->convertObjectId($request->get('parent_branch_id'));
            $branch->type = $request->get('type');
            $branch->alias = $request->get('alias');
            $branch->code = $request->get('code');
            $branch->updated_at = date('Y-m-d H:i:s');
            $branch->save();
        }

        $branch_id = '';
        if(isset($branch->_id) && $branch->_id != '')
        {
            $branch_id = $branch->_id;
        }

        $result['branch_id'] = $request->branch_id;
        return $this->sendResponse($result, 'Sub Branch updated successfully', 200);
    }

    /*
     * List of sub branches
     */
    public function list_sub_branches(Request $request)
    {
        $list_branches = Branch::where('is_parent','=',0)->orderBy('created_at', 'desc')->get();
        return $this->sendResponse($list_branches, 'List of sub branches', 200);
    }

    /*
     * create sub branch capital
     */
    public function create_sub_branch_capital(Request $request){
        $validator = Validator::make($request->all() , [
            'country_id' => 'required',
            'branch_id' => 'required',
            'sub_branch_id' => 'required',
            'max_risk_capital' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch_capital = BranchCapital::create([
            'country_id' => $this->convertObjectId($request->get('country_id')),
            'branch_id' => $this->convertObjectId($request->get('branch_id')),
            'sub_branch_id' => $this->convertObjectId($request->get('sub_branch_id')),
            'max_risk_capital' => $request->get('max_risk_capital')
        ]);

        $branch_capital_id = '';
        if(isset($branch_capital->_id) && $branch_capital->_id != '')
        {
            $branch_capital_id = $branch_capital->_id;
        }

        $result['branch_capital_id'] = $branch_capital_id;
        return $this->sendResponse($result, 'Sub Branch Capital created successfully', 200);
    }

    /*
     * Update sub branch capital
     */
    public function update_sub_branch_capital(Request $request){
        $validator = Validator::make($request->all() , [
            'country_id' => 'required',
            'branch_id' => 'required',
            'sub_branch_id' => 'required',
            'max_risk_capital' => 'required',
            'branch_capital_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch_capital = BranchCapital::find($request->branch_capital_id);
        if($branch_capital != null || $branch_capital != '')
        {
            $branch_capital->country_id = $this->convertObjectId($request->get('country_id'));
            $branch_capital->branch_id = $this->convertObjectId($request->get('branch_id'));
            $branch_capital->sub_branch_id = $this->convertObjectId($request->get('sub_branch_id'));
            $branch_capital->max_risk_capital = $request->get('max_risk_capital');
            $branch_capital->updated_at = date('Y-m-d H:i:s');
            $branch_capital->save();
        }

        $result['branch_capital_id'] = $request->branch_capital_id;
        return $this->sendResponse($result, 'Sub Branch Capital updated successfully', 200);
    }

    /*
     * List of sub branch capitals
     */
    public function list_sub_branch_capital(Request $request)
    {
        $branch_capitals = BranchCapital::where('sub_branch_id','!=','')->orderBy('created_at', 'desc')->get();
        $return_array = [];
        if(!empty($branch_capitals))
        {
            $i=0;
            foreach($branch_capitals as $list_user)
            {
                $country_id = (string)$list_user->country_id;
                $country_data = Country::find($country_id);
                $branch_id = (string)$list_user->branch_id;
                $branch_data = Branch::find($branch_id);
                $sub_branch_id = (string)$list_user->sub_branch_id;
                $sub_branch_data = Branch::find($sub_branch_id);
                $country_name = '';
                $branch_name = '';
                $sub_branch_name = '';
                if($country_data != '')
                {
                    $country_name = $country_data->name;
                }

                if($branch_data != '')
                {
                    $branch_name = $branch_data->name;
                }

                if($sub_branch_data != '')
                {
                    $sub_branch_name = $sub_branch_data->name;
                }

                //echo '<pre>'; print_r($list_user); exit;
                $return_array[$i]['_id'] = $list_user->_id;
                $return_array[$i]['country_id'] = $country_id;
                $return_array[$i]['branch_id'] = $branch_id;
                $return_array[$i]['sub_branch_id'] = $sub_branch_id;
                $return_array[$i]['country_name'] = $country_name;
                $return_array[$i]['branch_name'] = $branch_name;
                $return_array[$i]['sub_branch_name'] = $sub_branch_name;
                $return_array[$i]['max_risk_capital'] = $list_user->max_risk_capital;
                $return_array[$i]['created_at'] = $list_user->created_at;
                $i++;
            }
        }
        return $this->sendResponse($return_array, 'List of sub branch capitals', 200);
    }

    /*
     * create sub branch commission
     */
    public function create_sub_branch_commission(Request $request){
        $validator = Validator::make($request->all() , [
            'country_id' => 'required',
            'branch_id' => 'required',
            'sub_branch_id' => 'required',
            'commission' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch_commission = BranchCommission::create([
            'country_id' => $this->convertObjectId($request->get('country_id')),
            'branch_id' => $this->convertObjectId($request->get('branch_id')),
            'sub_branch_id' => $this->convertObjectId($request->get('sub_branch_id')),
            'commission' => $request->get('commission')
        ]);

        $branch_commission_id = '';
        if(isset($branch_commission->_id) && $branch_commission->_id != '')
        {
            $branch_commission_id = $branch_commission->_id;
        }

        $result['branch_commission_id'] = $branch_commission_id;
        return $this->sendResponse($result, 'Sub Branch Commission created successfully', 200);
    }

    /*
     * Update sub branch commission
     */
    public function update_sub_branch_commission(Request $request){
        $validator = Validator::make($request->all() , [
            'country_id' => 'required',
            'branch_id' => 'required',
            'sub_branch_id' => 'required',
            'commission' => 'required',
            'branch_commission_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400);
        }

        $branch_commission = BranchCommission::find($request->branch_commission_id);
        if($branch_commission != null || $branch_commission != '')
        {
            $branch_commission->country_id = $this->convertObjectId($request->get('country_id'));
            $branch_commission->branch_id = $this->convertObjectId($request->get('branch_id'));
            $branch_commission->sub_branch_id = $this->convertObjectId($request->get('sub_branch_id'));
            $branch_commission->commission = $request->get('commission');
            $branch_commission->updated_at = date('Y-m-d H:i:s');
            $branch_commission->save();
        }

        $result['branch_commission_id'] = $request->branch_commission_id;
        return $this->sendResponse($result, 'Sub Branch Commission updated successfully', 200);
    }

    /*
     * List of sub branch commissions
     */
    public function list_sub_branch_commission(Request $request)
    {
        $branch_commissions = BranchCommission::where('sub_branch_id','!=','')->orderBy('created_at', 'desc')->get();
        $return_array = [];
        if(!empty($branch_commissions))
        {
            $i=0;
            foreach($branch_commissions as $list_user)
            {
                $country_id = (string)$list_user->country_id;
                $country_data = Country::find($country_id);
                $branch_id = (string)$list_user->branch_id;
                $branch_data = Branch::find($branch_id);
                $sub_branch_id = (string)$list_user->sub_branch_id;
                $sub_branch_data = Branch::find($sub_branch_id);
                $country_name = '';
                $branch_name = '';
                $sub_branch_name = '';
                if($country_data != '')
                {
                    $country_name = $country_data->name;
                }

                if($branch_data != '')
                {
                    $branch_name = $branch_data->name;
                }

                if($sub_branch_data != '')
                {
                    $sub_branch_name = $sub_branch_data->name;
                }

                //echo '<pre>'; print_r($list_user); exit;
                $return_array[$i]['_id'] = $list_user->_id;
                $return_array[$i]['country_id'] = $country_id;
                $return_array[$i]['branch_id'] = $branch_id;
                $return_array[$i]['sub_branch_id'] = $sub_branch_id;
                $return_array[$i]['country_name'] = $country_name;
                $return_array[$i]['branch_name'] = $branch_name;
                $return_array[$i]['sub_branch_name'] = $sub_branch_name;
                $return_array[$i]['commission'] = $list_user->commission;
                $return_array[$i]['created_at'] = $list_user->created_at;
                $i++;
            }
        }
        return $this->sendResponse($return_array, 'List of sub branch commissions', 200);
    }


}
