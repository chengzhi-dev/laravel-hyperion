<?php

namespace App\Http\Controllers;

use App\CedantPremiums;
use App\CedantPremiumCases;
use App\CedantPremiumNotLifeCases;
use App\CedantClaims;
use App\CedantClaimCases;
use App\CedantClaimNotLifeCases;
use App\Comment;
use App\Files;
use App\UserCedantRole;
use App\UserReinsuranceCedant;
use App\CedantType;
use App\ReinsuranceCedant;
use App\Reinsurance;
use App\Country;
use App\Region;
use App\Currency;
use App\Branch;
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

require_once base_path().'/modules/xlsx/src/SimpleXLSX.php';
use SimpleXLSX;

class CedantController extends BaseController
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
     * create premium slip for insurance company
     */
    public function create_premium_slip(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'cedants_id' => 'required',
            'cedants_type_id' => 'required',
            'reinsurances_id' => 'required',            
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400); 
        }
        
        //read excel file to save case and premium slip data
        $country = '';
        $company = '';  
        $edited_period = '';
        $publishing_date = '';
        $reference = '';
        $policy_issue = array();
        $insured_number = array();
        $fullname_souscriber = array();
        $fullname_insured = array();
        $date_of_birth = array();
        $nature = array();
        $type = array();
        $effective_date = array();
        $deadline_date = array();
        $operation_date = array();
        $capital_insured_death_or_constitution = array();
        $capital_insured_accidental_death = array();
        $capital_insured_triply_accidentally = array();
        $capital_insured_partial_permanent_disability = array();
        $capital_insured_loss_jobs = array();
        $premium_periodicity = array();       
        $taux_supprime = array();
        $prime_deces = array();
        $suprime_deces = array();
        $prime_guarantee_supplement = array();
        $prime_nette_total = array();
        $comission = array();
        $part_cedante = array();
        $prime_nette_totale_cedante = array();
        $comission_cedante = array();
        $prime_cedee = array();
        $comission_cession = array();
        $prime_nette_cedee = array();
        
        $policy_number = array();
        $branch = array();
        $category = array();
        $branches_id = array();
        $sub_branches_id = array();        
        $nature_risque_id = array();
        $date_effective = array();
        $deadline = array();
        $date_transaction = array();
        $geographic_location = array();
        $insured_capital = array();
        $premium_ht = array();
        $paid_commission = array();
        $part_cedant_coass = array();
        $premium_ceded = array();
        $commission_cession = array();
        $prime_net_ceded = array();
        $insurance_type = '';
        $slip_type = '';
        $slip_detail = '';
        
        if($request->xlsData != '' && $request->xlsData != null)
        {
            $insurance_type = $request->insurance_type;
            $slip_type = $request->slip_type;
            $slip_data = json_decode($request->xlsData);
            //echo '<pre>'; print_r($slip_data); exit;
            $slip_data_cols = $slip_data->cols;
            $slip_data_rows = $slip_data->rows;
            $slip_data_rows_count = count($slip_data_rows);
            $user = JWTAuth::user();
            
            if($request->slip_data != '')
            {
                $slip_detail = json_decode($request->slip_data);                
                /* if(isset($slip_detail[1]->published_date))
                {
                    $publishing_date = $slip_detail[1]->published_date;
                } */
                
                if(isset($slip_detail[2]->period_edited))
                {
                    $edited_period = $slip_detail[2]->period_edited;
                }
                
                //calculate reference number
                $slips_db_count = CedantPremiums::count();
                $cedant = ReinsuranceCedant::find($request->cedants_id);
                $reinsurance = Reinsurance::find($request->reinsurances_id);
                $cedant_code = '';
                $cedant_code_concat = '';
                $reinsurance_name = '';
                $year = date('Y');
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
                /* if(isset($slip_detail[3]->reference))
                {
                    $reference = $slip_detail[3]->reference; 
                } */
                $autonum = $slips_db_count+1;
                $chronic_no = $autonum.$cedant_code_concat;
                $reference = "BCP-$chronic_no/$initial_name/$year/$reinsurance_name";
            }               
                
            if($slip_data_rows_count > 0)
            {
                foreach($slip_data_rows as $r)
                {
                    //echo '<pre>'; print_r($r); exit;
                    if($insurance_type == 'life')
                    {
                        //col 1 to 28 - 1=>police issue and 28=>bonus net assigned
                         if(isset($r[1]) && $r[1] != '')
                         {
                             $policy_issue[] = $r[1];
                         }

                         if(isset($r[2]) && $r[2] != '')
                         {
                             $insured_number[] = $r[2];
                         }

                         if(isset($r[3]) && $r[3] != '')
                         {
                             $fullname_souscriber[] = $r[3];
                         }

                         if(isset($r[4]) && $r[4] != '')
                         {
                             $fullname_insured[] = $r[4];
                         }

                         if(isset($r[5]) && $r[5] != '')
                         {
                             $date_of_birth[] = $r[5];
                         }

                         if(isset($r[6]) && $r[6] != '')
                         {
                             $nature[] = $r[6];
                             $br_query = Branch::where('is_parent','=',1)->where('alias','=',$r[6])->orderBy('created_at', 'desc')->first();
                             $sub_br_query = Branch::where('is_parent','=',0)->where('alias','=',$r[6])->orderBy('created_at', 'desc')->first();
                             if($br_query != '')
                             {
                                 $branches_id[] = $this->convertObjectId($br_query->_id);
                             }
                             
                             if($sub_br_query != '')
                             {
                                 $sub_branches_id[] = $this->convertObjectId($sub_br_query->_id);
                             } 
                             
                         }
                         
                         if(isset($r[7]) && $r[7] != '')
                         {
                             $type[] = $r[7];
                         }

                         if(isset($r[8]) && $r[8] != '')
                         {
                             $effective_date[] = $r[8];
                         }

                         if(isset($r[9]) && $r[9] != '')
                         {
                             $deadline_date[] = $r[9];
                         }

                         if(isset($r[10]) && $r[10] != '')
                         {
                             $operation_date[] = $r[10];
                         }

                         if(isset($r[11]) && $r[11] != '')
                         {
                             $capital_insured_death_or_constitution[] = $r[11];
                         }

                         if(isset($r[12]) && $r[12] != '')
                         {
                             $capital_insured_accidental_death[] = $r[12];
                         }

                         if(isset($r[13]) && $r[13] != '')
                         {
                             $capital_insured_triply_accidentally[] = $r[13];
                         }

                         if(isset($r[14]) && $r[14] != '')
                         {
                             $capital_insured_partial_permanent_disability[] = $r[14];
                         }

                         if(isset($r[15]) && $r[15] != '')
                         {
                             $capital_insured_loss_jobs[] = $r[15];
                         }

                         if(isset($r[16]) && $r[16] != '')
                         {
                             $premium_periodicity[] = $r[16];
                         }

                         if(isset($r[17]) && $r[17] != '')
                         {
                             $taux_supprime[] = $r[17];
                         }

                         if(isset($r[18]) && $r[18] != '')
                         {
                             $prime_deces[] = $r[18];
                         }

                         if(isset($r[19]) && $r[19] != '')
                         {
                             $suprime_deces[] = $r[19];
                         }
                         
                         if(isset($r[20]) && $r[20] != '')
                         {
                             $prime_guarantee_supplement[] = $r[20];
                         }

                         if(isset($r[21]) && $r[21] != '')
                         {
                             $prime_nette_total[] = $r[21];
                         }

                         if(isset($r[22]) && $r[22] != '')
                         {
                             $comission[] = $r[22];
                         }

                         if(isset($r[23]) && $r[23] != '')
                         {
                             $part_cedante[] = $r[23];
                         }

                         $col26 = '';
                         $col27 = '';
                         $col28 = '';
                         if(isset($r[24]) && $r[24] != '')
                         {
                             $prime_nette_totale_cedante[] = $r[24];
                             $col26 = ($r[24] * 5)/100;
                         }

                         if(isset($r[25]) && $r[25] != '')
                         {
                             $comission_cedante[] = $r[25];
                             if($col26 != '')
                             {
                                 $col27 = (($r[25]/$r[24])+0.02)*$col26;
                             }
                         }
                         
                         if($col26 != '' && $col27 != '' && ( $col26 > $col27 ))
                         {
                             $col28 = $col26 - $col27;
                         }
                         
                         $prime_cedee[] = $col26;
                         $comission_cession[] = $col27;
                         $prime_nette_cedee[] = $col28;
                         /* if(isset($r[26]) && $r[26] != '')
                         {
                             $prime_cedee[] = $r[26];
                         }

                         if(isset($r[27]) && $r[27] != '')
                         {
                             $comission_cession[] = $r[27];
                         }

                         if(isset($r[28]) && $r[28] != '')
                         {
                             $prime_nette_cedee[] = $r[28];
                         } */
                         
                    }
                    else if($insurance_type == 'not life')
                    {
                        //col 1 to 17 - 1=>police number and 17=>prime net assigned
                         if(isset($r[1]) && $r[1] != '')
                         {
                             $policy_number[] = $r[1];
                         }

                         if(isset($r[2]) && $r[2] != '')
                         {
                             $branch[] = $r[2];
                             $br_query = Branch::where('is_parent','=',1)->where('alias','=',$r[2])->orderBy('created_at', 'desc')->first();
                             if($br_query != '')
                             {
                                 $branches_id[] = $this->convertObjectId($br_query->_id);
                             }                             
                         }

                         if(isset($r[3]) && $r[3] != '')
                         {
                             $category = $r[3];
                             $sub_br_query = Branch::where('is_parent','=',0)->where('alias','=',$r[3])->orderBy('created_at', 'desc')->first();
                             if($sub_br_query != '')
                             {
                                 $sub_branches_id[] = $this->convertObjectId($sub_br_query->_id);
                             }                             
                         }

                         if(isset($r[4]) && $r[4] != '')
                         {
                             $nature_risque_id[] = $r[4];
                         }

                         if(isset($r[5]) && $r[5] != '')
                         {
                             $date_effective[] = $r[5];
                         }

                         if(isset($r[6]) && $r[6] != '')
                         {
                             $deadline[] = $r[6];
                         }

                         if(isset($r[7]) && $r[7] != '')
                         {
                             $date_transaction[] = $r[7];
                         }

                         if(isset($r[8]) && $r[8] != '')
                         {
                             $fullname_souscriber[] = $r[8];
                         }

                         if(isset($r[9]) && $r[9] != '')
                         {
                             $fullname_insured[] = $r[9];
                         }

                         if(isset($r[10]) && $r[10] != '')
                         {
                             $geographic_location[] = $r[10];
                         }

                         if(isset($r[11]) && $r[11] != '')
                         {
                             $insured_capital[] = $r[11];
                         }

                         $col15 = '';
                         $col16 = '';
                         $col17 = '';
                         if(isset($r[12]) && $r[12] != '')
                         {
                             $premium_ht[] = $r[12];
                             $r12_digit = $this->replaceCurrencyToDigit($r[12]);
                             if($r12_digit == '')
                             {
                                 $col15 = '';
                             }
                             else
                             {
                                 $col15 = ($r12_digit * 5)/100;
                             }
                             
                         }

                         if(isset($r[13]) && $r[13] != '')
                         {
                             $paid_commission[] = $r[13];
                             $r13_digit = $this->replaceCurrencyToDigit($r[13]);
                             if($col15 != '' && $r13_digit != '')
                             {
                                 $col16 = (($r13_digit/$r12_digit)+0.02)*$col15;
                             }
                         }

                         if(isset($r[14]) && $r[14] != '')
                         {
                             $part_cedant_coass[] = $r[14];
                         }
                         
                         if($col15 != '' && $col16 != '' && ( $col15 > $col16 ))
                         {
                             $col17 = $col15 - $col16;
                         }

                         /* if(isset($r[15]) && $r[15] != '')
                         {
                             $premium_ceded[] = $r[15];
                         }

                         if(isset($r[16]) && $r[16] != '')
                         {
                             $commission_cession[] = $r[16];
                         }

                         if(isset($r[17]) && $r[17] != '')
                         {
                             $prime_net_ceded[] = $r[17];
                         } */
                         
                         $premium_ceded[] = $col15;
                         $commission_cession[] = $col16;
                         $prime_net_ceded[] = $col17;
                         
                    }
                }                
                
            }
        }
                
        $slip_path = '';
        if(!empty($_FILES) && isset($_FILES['file']['tmp_name']))
        {            
            if(isset($_FILES["file"]["name"]))
            { 
                   if($_FILES["file"]["error"] == 0)
                   {
                        $tmp_name = $_FILES["file"]["tmp_name"];
                        $name = str_replace(' ', '_', $_FILES["file"]["name"]);                
                        $ext = pathinfo($name, PATHINFO_EXTENSION);
                        //echo $ext; exit;

                        if($ext == 'xlsx')   
                        { 
                            $name = 'slip_'.time().'.'.$ext;
                            $path = public_path().'/documents/premium_slips';
                            $path2 = 'documents/premium_slips';
                            $final_file_path = $path."/".$name;
                            $final_file_path2 = $path2."/".$name;
                            if(!file_exists($path))
                            {
                                mkdir($path, 0777, true);                            
                            }                                           

                            if(move_uploaded_file($tmp_name, $final_file_path))
                            {
                                $slip_path = $final_file_path2;
                            }
                            else
                            {
                                echo 'Problem in moving the file to desired location';
                            }
                        } 
                        else
                        {
                            echo 'This file type is not allowed';
                        }
                   }
            }
        }
        //echo 'slsls-'.$slip_path; exit;
        $cedants_id = $this->convertObjectId($request->get('cedants_id'));
        $cedants_type_id = $this->convertObjectId($request->get('cedants_type_id'));
        $reinsurances_id = $this->convertObjectId($request->get('reinsurances_id'));
        $validation_status = 'Pending';
        $approval_status = 'Pending';
        $case_validation_status = 'Pending';
             
        $slipe_prime = CedantPremiums::create([
            'reference' => $reference,
            'cedants_id' => $cedants_id,
            'cedants_type_id' => $cedants_type_id,
            'reinsurances_id' => $reinsurances_id,
            'edited_period' => $edited_period,
            'published_date' => $publishing_date,
            'file_url' => $slip_path,
            'slip_type' => $slip_type,
            'validation_status' => $validation_status,
            'approval_status' => $approval_status            
        ]);
        
        $premium_slip_id = '';
        if(isset($slipe_prime->_id) && $slipe_prime->_id != '')
        {
            $premium_slip_id = $slipe_prime->_id;
        }
        
        if(count($fullname_souscriber) > 0 )
        {
            $count_cases = 0;
            foreach($fullname_souscriber as $ino)
            {
                if($insurance_type == 'life')
                {
                    //save no of cases for a life premium slip
                    $case_life_prime = CedantPremiumCases::create([
                        'policy_number' => (isset($policy_issue[$count_cases]))?$policy_issue[$count_cases]:'',
                        'insured_number' => (isset($insured_number[$count_cases]))?$insured_number[$count_cases]:'',                        
                        'nature' => (isset($nature[$count_cases]))?$nature[$count_cases]:'',
                        'type' => (isset($type[$count_cases]))?$type[$count_cases]:'',
                        'branches_id' => (isset($branches_id[$count_cases]))?$branches_id[$count_cases]:'',
                        'sub_branches_id' => (isset($sub_branches_id[$count_cases]))?$sub_branches_id[$count_cases]:'',
                        'date_effective' => (isset($effective_date[$count_cases]))?$effective_date[$count_cases]:'',
                        'date_operation' => (isset($operation_date[$count_cases]))?$operation_date[$count_cases]:'',
                        'deadline' => (isset($deadline_date[$count_cases]))?$deadline_date[$count_cases]:'',
                        'fullname_souscriber' => (isset($fullname_souscriber[$count_cases]))?$fullname_souscriber[$count_cases]:'',
                        'fullname_insured' => (isset($fullname_insured[$count_cases]))?$fullname_insured[$count_cases]:'',
                        'dateofbirth_insured' => (isset($date_of_birth[$count_cases]))?$date_of_birth[$count_cases]:'',
                        'capital_insured_death_or_constitution' => (isset($capital_insured_death_or_constitution[$count_cases]))?$capital_insured_death_or_constitution[$count_cases]:'',
                        'capital_insured_accidental_death' => (isset($capital_insured_accidental_death[$count_cases]))?$capital_insured_accidental_death[$count_cases]:'',
                        'capital_insured_triply_accidentally' => (isset($capital_insured_triply_accidentally[$count_cases]))?$capital_insured_triply_accidentally[$count_cases]:'',
                        'capital_insured_partial_permanent_disability' => (isset($capital_insured_partial_permanent_disability[$count_cases]))?$capital_insured_partial_permanent_disability[$count_cases]:'',
                        'capital_insured_loss_jobs' => (isset($capital_insured_loss_jobs[$count_cases]))?$capital_insured_loss_jobs[$count_cases]:'',
                        'premium_periodicity' => (isset($premium_periodicity[$count_cases]))?$premium_periodicity[$count_cases]:'',
                        'taux_supprime' => (isset($taux_supprime[$count_cases]))?$taux_supprime[$count_cases]:'',
                        'prime_deces' => (isset($prime_deces[$count_cases]))?$prime_deces[$count_cases]:'',
                        'suprime_deces' => (isset($suprime_deces[$count_cases]))?$suprime_deces[$count_cases]:'',
                        'prime_guarantee_supplement' => (isset($prime_guarantee_supplement[$count_cases]))?$prime_guarantee_supplement[$count_cases]:'',
                        'prime_nette_total' => (isset($prime_nette_total[$count_cases]))?$prime_nette_total[$count_cases]:'',
                        'comission' => (isset($comission[$count_cases]))?$comission[$count_cases]:'',
                        'slipes_prime_id' => $this->convertObjectId($premium_slip_id),
                        'part_cedante' => (isset($part_cedante[$count_cases]))?$part_cedante[$count_cases]:'',
                        'prime_nette_totale_cedante' => (isset($prime_nette_totale_cedante[$count_cases]))?$prime_nette_totale_cedante[$count_cases]:'',
                        'comission_cedante' => (isset($comission_cedante[$count_cases]))?$comission_cedante[$count_cases]:'',
                        'prime_cedee' => (isset($prime_cedee[$count_cases]))?$prime_cedee[$count_cases]:'',
                        'comission_cession' => (isset($comission_cession[$count_cases]))?$comission_cession[$count_cases]:'',
                        'prime_nette_cedee' => (isset($prime_nette_cedee[$count_cases]))?$prime_nette_cedee[$count_cases]:'',
                        'case_validation_status' => $case_validation_status,
                        'active_status' => 1
                    ]);
                }
                else if($insurance_type == 'not life')
                {
                    //save no of cases for a not life premium slip
                    $case_life_prime = CedantPremiumNotLifeCases::create([
                        'policy_number' => (isset($policy_number[$count_cases]))?$policy_number[$count_cases]:'',
                        'branch' => (isset($branch[$count_cases]))?$branch[$count_cases]:'',
                        'category' => (isset($category[$count_cases]))?$category[$count_cases]:'',
                        'branches_id' => (isset($branches_id[$count_cases]))?$branches_id[$count_cases]:'',
                        'sub_branches_id' => (isset($sub_branches_id[$count_cases]))?$sub_branches_id[$count_cases]:'',
                        'nature_risque_id' => (isset($nature_risque_id[$count_cases]))?$nature_risque_id[$count_cases]:'',
                        'date_effective' => (isset($date_effective[$count_cases]))?$date_effective[$count_cases]:'',
                        'deadline' => (isset($deadline[$count_cases]))?$deadline[$count_cases]:'',
                        'date_transaction' => (isset($date_transaction[$count_cases]))?$date_transaction[$count_cases]:'',
                        'fullname_souscriber' => (isset($fullname_souscriber[$count_cases]))?$fullname_souscriber[$count_cases]:'',
                        'fullname_insured' => (isset($fullname_insured[$count_cases]))?$fullname_insured[$count_cases]:'',
                        'geographic_location' => (isset($geographic_location[$count_cases]))?$geographic_location[$count_cases]:'',
                        'insured_capital' => (isset($insured_capital[$count_cases]))?$insured_capital[$count_cases]:'',
                        'premium_ht' => (isset($premium_ht[$count_cases]))?$premium_ht[$count_cases]:'',
                        'paid_commission' => (isset($paid_commission[$count_cases]))?$paid_commission[$count_cases]:'',
                        'part_cedant_coass' => (isset($part_cedant_coass[$count_cases]))?$part_cedant_coass[$count_cases]:'',
                        'premium_ceded' => (isset($premium_ceded[$count_cases]))?$premium_ceded[$count_cases]:'',
                        'commission_cession' => (isset($commission_cession[$count_cases]))?$commission_cession[$count_cases]:'',
                        'prime_net_ceded' => (isset($prime_net_ceded[$count_cases]))?$prime_net_ceded[$count_cases]:'',
                        'case_validation_status' => $case_validation_status,
                        'active_status' => 1,
                        'slipes_prime_id' => $this->convertObjectId($premium_slip_id)
                    ]);
                }                
                
                $count_cases++;
            }
        }
               
        $result['premium_slip_id'] = $premium_slip_id;  
        return $this->sendResponse($result, 'Premium slip submitted successfully', 200); 
    }
    
    /*
     * update premium slip for insurance company
     */
    public function update_premium_slip(Request $request)
    {
        $validator = Validator::make($request->all() , [
            //'reference' => 'required|max:255',
            //'edited_period' => 'required',
            'premium_slip_id' => 'required',
            'cedants_type_id' => 'required',
            'insurance_type' => 'required',
            'case_id' => 'required'
           
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400); 
        }

        $premium_slip_id = $request->get('premium_slip_id');
        $case_id = $request->get('case_id');
        $get_cedant_type = $request->insurance_type;
                
        //$reference = $request->get('reference');
        //$edited_period = $request->get('edited_period');
                
        /* $slipe_prime = CedantPremiums::where('_id','=',$premium_slip_id)->first();
        if($slipe_prime != null || $slipe_prime != '')
        {
            //$slipe_prime->reference = $reference;
            $slipe_prime->edited_period = $edited_period;
            $slipe_prime->updated_at = date('Y-m-d H:i:s');
            $slipe_prime->save();
        } */
        
        if($get_cedant_type == 'not life')
        {
            $premium_case = CedantPremiumNotLifeCases::where('_id','=',$case_id)->first();
            $premium_case->active_status = 0;
            $premium_case->updated_at = date('Y-m-d H:i:s');
            $premium_case->save();
            
            $case_validation_status = 'Pending';
            if($request->get('policy_number') != '')
            {
                $policy_number = $request->get('policy_number');
            }
            
            if($request->get('branch') != '')
            {
                $branch = $this->convertObjectId($request->get('branch'));
            }
            
            if($request->get('category') != '')
            {
                $category = $request->get('category');
            }
            
            if($request->get('branches_id') != '')
            {
                $branches_id = $this->convertObjectId($request->get('branches_id'));
            }
            
            if($request->get('sub_branches_id') != '')
            {
                $sub_branches_id = $this->convertObjectId($request->get('sub_branches_id'));
            }
            
            if($request->get('nature_risque_id') != '')
            {
                $nature_risque_id = $request->get('nature_risque_id');
            }
            
            if($request->get('date_effective') != '')
            {
                $date_effective = $request->get('date_effective');
            }
            
            if($request->get('deadline') != '')
            {
                $deadline = $request->get('deadline');
            }
            
            if($request->get('date_transaction') != '')
            {
                $date_transaction = $request->get('date_transaction');
            }
            
            if($request->get('fullname_souscriber') != '')
            {
                $fullname_souscriber = $request->get('fullname_souscriber');
            }
            
            if($request->get('fullname_insured') != '')
            {
                $fullname_insured = $request->get('fullname_insured');
            }
            
            if($request->get('geographic_location') != '')
            {
                $geographic_location = $request->get('geographic_location');
            }
            
            if($request->get('insured_capital') != '')
            {
                $insured_capital = $request->get('insured_capital');
            }
            
            if($request->get('premium_ht') != '')
            {
                $premium_ht = $request->get('premium_ht');
            }
            
            if($request->get('paid_commission') != '')
            {
                $paid_commission = $request->get('paid_commission');
            }
            
            if($request->get('part_cedant_coass') != '')
            {
                $part_cedant_coass = $request->get('part_cedant_coass');
            }
            
            if($request->get('premium_ceded') != '')
            {
                $premium_ceded = $request->get('premium_ceded');
            }
                       
            if($request->get('commission_cession') != '')
            {
                $commission_cession = $request->get('commission_cession');
            }
            
            if($request->get('prime_net_ceded') != '')
            {
                $prime_net_ceded = $request->get('prime_net_ceded');
            }
            
            if(isset($premium_slip_id))
            {
                $slipes_prime_id = $this->convertObjectId($premium_slip_id);
            }
            
            //save updated new case for a not life premium slip
            $case_not_life_premium = CedantPremiumNotLifeCases::create([
                'policy_number' => (isset($policy_number))?$policy_number:'',
                'branch' => (isset($branch))?$branch:'',
                'category' => (isset($category))?$category:'',
                'branches_id' => (isset($branches_id))?$branches_id:'',
                'sub_branches_id' => (isset($sub_branches_id))?$sub_branches_id:'',
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
                //'prime_deces' => (isset($prime_deces))?$prime_deces:'',
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
            if($request->get('policy_number') != '')
            {
                $policy_number = $request->get('policy_number');
            }
            
            if($request->get('insured_number') != '')
            {
                $insured_number = $request->get('insured_number');
            }
            
            if($request->get('nature') != '')
            {
                $nature = $request->get('nature');
            }
            
            if($request->get('type') != '')
            {
                $type = $request->get('type');
            }
            
            if($request->get('branches_id') != '')
            {
                $branches_id = $this->convertObjectId($request->get('branches_id'));
            }
            
            if($request->get('sub_branches_id') != '')
            {
                $sub_branches_id = $this->convertObjectId($request->get('sub_branches_id'));
            }
            
            if($request->get('date_effective') != '')
            {
                $date_effective = $request->get('date_effective');
            }
            
            if($request->get('date_operation') != '')
            {
                $date_operation = $request->get('date_operation');
            }
            
            if($request->get('deadline') != '')
            {
                $deadline = $request->get('deadline');
            }
            
            if($request->get('fullname_souscriber') != '')
            {
                $fullname_souscriber = $request->get('fullname_souscriber');
            }
            
            if($request->get('fullname_insured') != '')
            {
                $fullname_insured = $request->get('fullname_insured');
            }
            
            if($request->get('dateofbirth_insured') != '')
            {
                $dateofbirth_insured = $request->get('dateofbirth_insured');
            }
            
            if($request->get('capital_insured_death_or_constitution') != '')
            {
                $capital_insured_death_or_constitution = $request->get('capital_insured_death_or_constitution');
            }
            
            if($request->get('capital_insured_accidental_death') != '')
            {
                $capital_insured_accidental_death = $request->get('capital_insured_accidental_death');
            }
            
            if($request->get('capital_insured_triply_accidentally') != '')
            {
                $capital_insured_triply_accidentally = $request->get('capital_insured_triply_accidentally');
            }
            
            if($request->get('capital_insured_partial_permanent_disability') != '')
            {
                $capital_insured_partial_permanent_disability = $request->get('capital_insured_partial_permanent_disability');
            }
            
            if($request->get('capital_insured_loss_jobs') != '')
            {
                $capital_insured_loss_jobs = $request->get('capital_insured_loss_jobs');
            }
            
            if($request->get('premium_periodicity') != '')
            {
                $premium_periodicity = $request->get('premium_periodicity');
            }
            
            if($request->get('taux_supprime') != '')
            {
                $taux_supprime = $request->get('taux_supprime');
            }
            
            if($request->get('prime_deces') != '')
            {
                $prime_deces = $request->get('prime_deces');
            }
            
            if($request->get('suprime_deces') != '')
            {
                $suprime_deces = $request->get('suprime_deces');
            }
            
            if($request->get('prime_guarantee_supplement') != '')
            {
                $prime_guarantee_supplement = $request->get('prime_guarantee_supplement');
            }
            
            if($request->get('prime_nette_total') != '')
            {
                $prime_nette_total = $request->get('prime_nette_total');
            }
            
            if($request->get('comission') != '')
            {
                $comission = $request->get('comission');
            }
            
            if($request->get('part_cedante') != '')
            {
                $part_cedante = $request->get('part_cedante');
            }
            
            if($request->get('prime_nette_totale_cedante') != '')
            {
                $prime_nette_totale_cedante = $request->get('prime_nette_totale_cedante');
            }
            
            if($request->get('comission_cedante') != '')
            {
                $comission_cedante = $request->get('comission_cedante');
            }
            
            if($request->get('prime_cedee') != '')
            {
                $prime_cedee = $request->get('prime_cedee');
            }
            
            if($request->get('comission_cession') != '')
            {
                $comission_cession = $request->get('comission_cession');
            }
            
            if($request->get('prime_nette_cedee') != '')
            {
                $prime_nette_cedee = $request->get('prime_nette_cedee');
            }
            
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
                'branches_id' => (isset($branches_id))?$branches_id:'',
                'sub_branches_id' => (isset($sub_branches_id))?$sub_branches_id:'',
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
        
        $result['premium_slip_id'] = $premium_slip_id;  
        $result['case_id'] = $case_id;
        return $this->sendResponse($result, 'Premium slip updated successfully', 200);         
    }
    
    /*
     * List of premium slips and cases related to it 
     */
    public function list_premium_slips(Request $request)
    {
        $list_premiums = CedantPremiums::where('cedants_id','=',$this->convertObjectId($request->cedants_id))->orderBy('created_at', 'desc')->get();
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
        return $this->sendResponse($list_premiums, 'List of premium slips', 200); 
    }
    
    /*
     * List of big risk premium slips and cases related to it 
     */
    public function list_premium_big_risk_slips(Request $request)
    {
        $list_premiums = CedantPremiums::where('cedants_id','=',$this->convertObjectId($request->cedants_id))->where('slip_type','=','Big Risk')->orderBy('created_at', 'desc')->get();
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
        $list_premiums = CedantPremiums::where('cedants_id','=',$this->convertObjectId($request->cedants_id))->where('slip_type','=','Regularization')->orderBy('created_at', 'desc')->get();
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
            
            if($get_cedant_type == 'NOT LIFE')
            {
                $premium_cases = CedantPremiumNotLifeCases::where('slipes_prime_id','=',$this->convertObjectId($view_premium_slip_detail->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
            }
            else
            {
                $premium_cases = CedantPremiumCases::where('slipes_prime_id','=',$this->convertObjectId($view_premium_slip_detail->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
            }
            $result['premium_slip_detail'] = $view_premium_slip_detail;
            $result['premium_cases'] = $premium_cases;
            return $this->sendResponse($result, 'Premium slip detail', 200); 
        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }
        
    /*
     * decision about slip from admin of insurance company
     */
    public function check_premium_slip(Request $request)
    {
        if($request->approval_status != '' && $request->premium_slip_id != '')
        {
            if($request->approval_status == 1)
            {
                $approval_status = 'Verified';
            }
            else
            {
                $approval_status = 'Rejected';
            }
            
            $slipe_prime = CedantPremiums::find($request->premium_slip_id);
            if($slipe_prime != null || $slipe_prime != '')
            {
                $slipe_prime->approval_status = $approval_status;
                $slipe_prime->published_date = date('Y-m-d H:i:s');
                $slipe_prime->updated_at = date('Y-m-d H:i:s');
                $slipe_prime->save();
                
                $result['premium_slip_id'] = $request->premium_slip_id;  
                return $this->sendResponse($result, 'Premium slip status updated successfully', 200);
            }
        }
        
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }
    
    /*
     * create claim slip for insurance company
     */
    public function create_claim_slip(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'cedants_id' => 'required',
            'cedants_type_id' => 'required',
            'reinsurances_id' => 'required',            
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400); 
        }
        //echo '<pre>'; print_r($_FILES); exit;
        //read excel file to save case and premium slip data
        $country = '';
        $company = '';
        $edited_period = '';
        $publishing_date = '';
        $reference = '';
        $claim_number = array();
        $police_number = array();
        $date_effective = array();
        $deadline = array();
        $branches_id = array();
        $fullname_insured = array();
        $claim_date = array();
        $claim_nature = array();
        $declaration_date = array();
        $capital_loss_death = array();
        $capital_loss_death_acc = array();
        $capital_loss_ta = array();
        $capital_loss_ipp = array();
        $capital_loss_jobs = array();
        $claim_a_100 = array();
        $part_assignor = array();       
        $claim_assignor = array();
        $payment_date = array();
        $claim_cede = array();
        $disaster_warranty = array();
        $opening_estimate = array();
        $revised_estimate = array();
        $payment_period = array();
        $cumulative_period = array();
        $left_to_pay = array();
        $use_cash = array();
        $recoveries_received = array();
        $use_remaining_cash = array();
        $adverse_ccie = array();
        $insurance_type = '';
        $slip_type = '';
        $slip_detail = '';
        
        if($request->xlsData != '' && $request->xlsData != null)
        {
            $insurance_type = $request->insurance_type;
            $slip_type = $request->slip_type;
            $slip_data = json_decode($request->xlsData);
            $slip_data_cols = $slip_data->cols;
            $slip_data_rows = $slip_data->rows;
            $slip_data_rows_count = count($slip_data_rows);
            $user = JWTAuth::user();
            
            if($request->slip_data != '')
            {
                $slip_detail = json_decode($request->slip_data);                
//                if(isset($slip_detail[1]->published_date))
//                {
//                    $publishing_date = $slip_detail[1]->published_date;
//                }
                
                if(isset($slip_detail[2]->period_edited))
                {
                    $edited_period = $slip_detail[2]->period_edited;
                }
                
                //calculate reference number
                $slips_db_count = CedantClaims::count();
                $cedant = ReinsuranceCedant::find($request->cedants_id);
                $reinsurance = Reinsurance::find($request->reinsurances_id);
                $cedant_code = '';
                $cedant_code_concat = '';
                $reinsurance_name = '';
                $year = date('Y');
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
                /* if(isset($slip_detail[3]->reference))
                {
                    $reference = $slip_detail[3]->reference; 
                } */
                $autonum = $slips_db_count+1;
                $chronic_no = $autonum.$cedant_code_concat;
                $reference = "BCS-$chronic_no/$initial_name/$year/$reinsurance_name";
                
            }
            
            if($slip_data_rows_count > 0)
            {
                foreach($slip_data_rows as $r)
                {
                    //echo '<pre>'; print_r($r); exit;
                    if($insurance_type == 'life')
                    {
                        //col 1 to 18 - 1=>claim number and 18=>claim ceded
                        if(isset($r[1]) && $r[1] != '')
                        {
                            $claim_number[] = $r[1];
                        }

                        if(isset($r[2]) && $r[2] != '')
                        {
                            $police_number[] = $r[2];
                        }

                        if(isset($r[3]) && $r[3] != '')
                        {
                            $date_effective[] = $r[3];
                        }

                        if(isset($r[4]) && $r[4] != '')
                        {
                            $deadline[] = $r[4];
                        }

                        if(isset($r[5]) && $r[5] != '')
                        {
                            $fullname_insured[] = $r[5];
                        }

                        if(isset($r[6]) && $r[6] != '')
                        {
                            $claim_date[] = $r[6];
                        }

                        if(isset($r[7]) && $r[7] != '')
                        {
                            $declaration_date[] = $r[7];
                        }

                        if(isset($r[8]) && $r[8] != '')
                        {
                            $claim_nature[] = $r[8];
                        }

                        if(isset($r[9]) && $r[9] != '')
                        {
                            $capital_loss_death[] = $r[9];
                        }

                        if(isset($r[10]) && $r[10] != '')
                        {
                            $capital_loss_death_acc[] = $r[10];
                        }

                        if(isset($r[11]) && $r[11] != '')
                        {
                            $capital_loss_ta[] = $r[11];
                        }

                        if(isset($r[12]) && $r[12] != '')
                        {
                            $capital_loss_ipp[] = $r[12];
                        }

                        if(isset($r[13]) && $r[13] != '')
                        {
                            $capital_loss_jobs[] = $r[13];
                        }

                        if(isset($r[14]) && $r[14] != '')
                        {
                            $claim_a_100[] = $r[14];
                        }

                        if(isset($r[15]) && $r[15] != '')
                        {
                            $part_assignor[] = $r[15];
                        }

                        if(isset($r[16]) && $r[16] != '')
                        {
                            $claim_assignor[] = $r[16];
                        }

                        if(isset($r[17]) && $r[17] != '')
                        {
                            $payment_date[] = $r[17];
                        }

                        if(isset($r[18]) && $r[18] != '')
                        {
                            $claim_cede[] = $r[18];
                        }
                        
                    }
                    else if($insurance_type == 'not life')
                    {
                        //col 1 to 18 - 1=>claim date and 18=>adverse ccie
                        if(isset($r[1]) && $r[1] != '')
                        {
                            $claim_date[] = $r[1];
                        }

                        if(isset($r[2]) && $r[2] != '')
                        {
                            $claim_number[] = $r[2];
                        }

                        if(isset($r[3]) && $r[3] != '')
                        {
                            $payment_date[] = $r[3];
                        }

                        if(isset($r[4]) && $r[4] != '')
                        {
                            $fullname_insured[] = $r[4];
                        }

                        if(isset($r[5]) && $r[5] != '')
                        {
                            $disaster_warranty[] = $r[5];
                        }

                        if(isset($r[6]) && $r[6] != '')
                        {
                            $branches_id[] = $r[6];
                        }

                        if(isset($r[7]) && $r[7] != '')
                        {
                            $police_number[] = $r[7];
                        }

                        if(isset($r[8]) && $r[8] != '')
                        {
                            $date_effective[] = $r[8];
                        }

                        if(isset($r[9]) && $r[9] != '')
                        {
                            $deadline[] = $r[9];
                        }

                        if(isset($r[10]) && $r[10] != '')
                        {
                            $opening_estimate[] = $r[10];
                        }

                        if(isset($r[11]) && $r[11] != '')
                        {
                            $revised_estimate[] = $r[11];
                        }

                        if(isset($r[12]) && $r[12] != '')
                        {
                            $payment_period[] = $r[12];
                        }

                        if(isset($r[13]) && $r[13] != '')
                        {
                            $cumulative_period[] = $r[13];
                        }

                        if(isset($r[14]) && $r[14] != '')
                        {
                            $left_to_pay[] = $r[14];
                        }

                        if(isset($r[15]) && $r[15] != '')
                        {
                            $use_cash[] = $r[15];
                        }

                        if(isset($r[16]) && $r[16] != '')
                        {
                            $recoveries_received[] = $r[16];
                        }

                        if(isset($r[17]) && $r[17] != '')
                        {
                            $use_remaining_cash[] = $r[17];
                        }

                        if(isset($r[18]) && $r[18] != '')
                        {
                            $adverse_ccie[] = $r[18];
                        }
                        
                    }
                }
            }
        }
        
        $slip_path = '';
        //echo '<pre>'; print_r($_FILES); exit;
        if(!empty($_FILES) && isset($_FILES['file']['tmp_name']))
        {            
            if(isset($_FILES["file"]["name"]))
            { 
                   if($_FILES["file"]["error"] == 0)
                   {
                        $tmp_name = $_FILES["file"]["tmp_name"];
                        $name = str_replace(' ', '_', $_FILES["file"]["name"]);                
                        $ext = pathinfo($name, PATHINFO_EXTENSION);
                        //echo $ext; exit;

                        if($ext == 'xlsx')   
                        { 
                            $name = 'slip_'.time().'.'.$ext;
                            $path = public_path().'/documents/claim_slips';
                            $path2 = 'documents/claim_slips';
                            $final_file_path = $path."/".$name;
                            $final_file_path2 = $path2."/".$name;
                            if(!file_exists($path))
                            {
                                mkdir($path, 0777, true);                            
                            }                                           

                            if(move_uploaded_file($tmp_name, $final_file_path))
                            {
                                $slip_path = $final_file_path2;
                            }
                            else
                            {
                                echo 'Problem in moving the file to desired location';
                            }
                        } 
                        else
                        {
                            echo 'This file type is not allowed';
                        }
                   }
            }
        }        
        
        $cedants_id = $this->convertObjectId($request->get('cedants_id'));
        $cedants_type_id = $this->convertObjectId($request->get('cedants_type_id'));
        $reinsurances_id = $this->convertObjectId($request->get('reinsurances_id'));
        $validation_status = 'Pending';
        $approval_status = 'Pending';
        $case_validation_status = 'Pending';
             
        $slipe_claims = CedantClaims::create([
            'reference' => $reference,
            'cedants_id' => $cedants_id,
            'cedants_type_id' => $cedants_type_id,
            'reinsurances_id' => $reinsurances_id,
            'edited_period' => $edited_period,
            'published_date' => $publishing_date,
            'file_url' => $slip_path,
            'slip_type' => $slip_type,
            'validation_status' => $validation_status,
            'approval_status' => $approval_status            
        ]);
        
        $claim_slip_id = '';
        if(isset($slipe_claims->_id) && $slipe_claims->_id != '')
        {
            $claim_slip_id = $slipe_claims->_id;
        }
        
        if(count($police_number) > 0 )
        {
            $count_cases = 0;
            foreach($police_number as $ino)
            {
                if($insurance_type == 'life')
                {
                    //save no of cases for a life claim slip
                    $case_life_claim = CedantClaimCases::create([
                        'claim_number' => (isset($claim_number[$count_cases]))?$claim_number[$count_cases]:'',
                        //'branches_id' => $branches_id,
                        'police_number' => (isset($police_number[$count_cases]))?$police_number[$count_cases]:'',
                        'date_effective' => (isset($date_effective[$count_cases]))?$date_effective[$count_cases]:'',
                        'deadline' => (isset($deadline[$count_cases]))?$deadline[$count_cases]:'',
                        'fullname_insured' => (isset($fullname_insured[$count_cases]))?$fullname_insured[$count_cases]:'',
                        'claim_date' => (isset($claim_date[$count_cases]))?$claim_date[$count_cases]:'',
                        'declaration_date' => (isset($declaration_date[$count_cases]))?$declaration_date[$count_cases]:'',
                        'claim_nature' => (isset($claim_nature[$count_cases]))?$claim_nature[$count_cases]:'',
                        'capital_loss_death' => (isset($capital_loss_death[$count_cases]))?$capital_loss_death[$count_cases]:'',
                        'capital_loss_death_acc' => (isset($capital_loss_death_acc[$count_cases]))?$capital_loss_death_acc[$count_cases]:'',
                        'capital_loss_ta' => (isset($capital_loss_ta[$count_cases]))?$capital_loss_ta[$count_cases]:'',
                        'capital_loss_ipp' => (isset($capital_loss_ipp[$count_cases]))?$capital_loss_ipp[$count_cases]:'',
                        'capital_loss_jobs' => (isset($capital_loss_jobs[$count_cases]))?$capital_loss_jobs[$count_cases]:'',
                        'claim_a_100' => (isset($claim_a_100[$count_cases]))?$claim_a_100[$count_cases]:'',
                        'part_assignor' => (isset($part_assignor[$count_cases]))?$part_assignor[$count_cases]:'',
                        'claim_assignor' => (isset($claim_assignor[$count_cases]))?$claim_assignor[$count_cases]:'',
                        'payment_date' => (isset($payment_date[$count_cases]))?$payment_date[$count_cases]:'',
                        'claim_cede' => (isset($claim_cede[$count_cases]))?$claim_cede[$count_cases]:'',
                        'slipes_claims_id' => $this->convertObjectId($claim_slip_id),
                        'case_validation_status' => $case_validation_status,
                        'active_status' => 1
                    ]);
                }
                else if($insurance_type == 'not life')
                {
                    //save no of cases for a not life claim slip
                    $case_not_life_claim = CedantClaimNotLifeCases::create([
                        'claim_date' => (isset($claim_date[$count_cases]))?$claim_date[$count_cases]:'',
                        'claim_number' => (isset($claim_number[$count_cases]))?$claim_number[$count_cases]:'',
                        'payment_date' => (isset($payment_date[$count_cases]))?$payment_date[$count_cases]:'',
                        'fullname_insured' => (isset($fullname_insured[$count_cases]))?$fullname_insured[$count_cases]:'',
                        'disaster_warranty' => (isset($disaster_warranty[$count_cases]))?$disaster_warranty[$count_cases]:'',
                        'branches_id' => (isset($branches_id[$count_cases]))?$branches_id[$count_cases]:'',
                        'police_number' => (isset($police_number[$count_cases]))?$police_number[$count_cases]:'',
                        'date_effective' => (isset($date_effective[$count_cases]))?$date_effective[$count_cases]:'',
                        'deadline' => (isset($deadline[$count_cases]))?$deadline[$count_cases]:'',
                        'opening_estimate' => (isset($opening_estimate[$count_cases]))?$opening_estimate[$count_cases]:'',
                        'revised_estimate' => (isset($revised_estimate[$count_cases]))?$revised_estimate[$count_cases]:'',
                        'payment_period' => (isset($payment_period[$count_cases]))?$payment_period[$count_cases]:'',
                        'cumulative_period' => (isset($cumulative_period[$count_cases]))?$cumulative_period[$count_cases]:'',
                        'left_to_pay' => (isset($left_to_pay[$count_cases]))?$left_to_pay[$count_cases]:'',
                        'use_cash' => (isset($use_cash[$count_cases]))?$use_cash[$count_cases]:'',
                        'recoveries_received' => (isset($recoveries_received[$count_cases]))?$recoveries_received[$count_cases]:'',
                        'use_remaining_cash' => (isset($use_remaining_cash[$count_cases]))?$use_remaining_cash[$count_cases]:'',
                        'adverse_ccie' => (isset($adverse_ccie[$count_cases]))?$adverse_ccie[$count_cases]:'',
                        'slipes_claims_id' => $this->convertObjectId($claim_slip_id),
                        'case_validation_status' => $case_validation_status,
                        'active_status' => 1
                    ]);
                }
                
                $count_cases++;
            }
        }
              
        $result['claim_slip_id'] = $claim_slip_id;  
        return $this->sendResponse($result, 'Claim slip submitted successfully', 200); 
    }
    
    /*
     * update claim slip for insurance company
     */
    public function update_claim_slip(Request $request)
    {
        $validator = Validator::make($request->all() , [
            //'reference' => 'required|max:255',
            //'edited_period' => 'required',
            'claim_slip_id' => 'required',
            'cedants_type_id' => 'required',
            'insurance_type' => 'required',
            'case_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400); 
        }

        $claim_slip_id = $request->get('claim_slip_id');
        $case_id = $request->get('case_id');
        $get_cedant_type = $request->insurance_type;
        
        //$reference = $request->get('reference');
        //$edited_period = $request->get('edited_period');
        
        /* $slipe_claim = CedantClaims::where('_id','=',$claim_slip_id)->first();
        if($slipe_claim != null || $slipe_claim != '')
        {
            //$slipe_claim->reference = $reference;
            $slipe_claim->edited_period = $edited_period;
            $slipe_claim->updated_at = date('Y-m-d H:i:s');
            $slipe_claim->save();
        } */
        //echo '<pre>'; print_r($request->all());
        //echo '<pre>'; print_r($request->get('claim_date')); exit;
        
        if($get_cedant_type == 'not life')
        {
            $claim_case = CedantClaimNotLifeCases::where('_id','=',$case_id)->first();
            $claim_case->active_status = 0;
            $claim_case->updated_at = date('Y-m-d H:i:s');
            $claim_case->save();
            
            $case_validation_status = 'Pending';
            if($request->get('claim_date') != '')
            {
                $claim_date = $request->get('claim_date');
            }
            
            if($request->get('claim_number') != '')
            {
                $claim_number = $request->get('claim_number');
            }
            
            if($request->get('payment_date') != '')
            {
                $payment_date = $request->get('payment_date');
            }
            
            if($request->get('fullname_insured') != '')
            {
                $fullname_insured = $request->get('fullname_insured');
            }
            
            if($request->get('disaster_warranty') != '')
            {
                $disaster_warranty = $request->get('disaster_warranty');
            }
            
            if($request->get('branches_id') != '')
            {
                $branches_id = $request->get('branches_id');
            }
            
            if($request->get('police_number') != '')
            {
                $police_number = $request->get('police_number');
            }
            
            if($request->get('date_effective') != '')
            {
                $date_effective = $request->get('date_effective');
            }
            
            if($request->get('deadline') != '')
            {
                $deadline = $request->get('deadline');
            }
            
            if($request->get('opening_estimate') != '')
            {
                $opening_estimate = $request->get('opening_estimate');
            }
            
            if($request->get('revised_estimate') != '')
            {
                $revised_estimate = $request->get('revised_estimate');
            }
            
            if($request->get('payment_period') != '')
            {
                $payment_period = $request->get('payment_period');
            }
            
            if($request->get('cumulative_period') != '')
            {
                $cumulative_period = $request->get('cumulative_period');
            }
            
            if($request->get('left_to_pay') != '')
            {
                $left_to_pay = $request->get('left_to_pay');
            }
            
            if($request->get('use_cash') != '')
            {
                $use_cash = $request->get('use_cash');
            }
            
            if($request->get('recoveries_received') != '')
            {
                $recoveries_received = $request->get('recoveries_received');
            }
            
            if($request->get('use_remaining_cash') != '')
            {
                $use_remaining_cash = $request->get('use_remaining_cash');
            }
            
            if($request->get('adverse_ccie') != '')
            {
                $adverse_ccie = $request->get('adverse_ccie');
            }
            
            if(isset($claim_slip_id))
            {
                $slipes_claims_id = $this->convertObjectId($claim_slip_id);
            }
            
            //save updated new case for a not life claim slip
            $case_not_life_claim = CedantClaimNotLifeCases::create([
                'claim_date' => (isset($claim_date))?$claim_date:'',
                'claim_number' => (isset($claim_number))?$claim_number:'',
                'payment_date' => (isset($payment_date))?$payment_date:'',
                'fullname_insured' => (isset($fullname_insured))?$fullname_insured:'',
                'disaster_warranty' => (isset($disaster_warranty))?$disaster_warranty:'',
                'branches_id' => (isset($branches_id))?$branches_id:'',
                'police_number' => (isset($police_number))?$police_number:'',
                'date_effective' => (isset($date_effective))?$date_effective:'',
                'deadline' => (isset($deadline))?$deadline:'',
                'opening_estimate' => (isset($opening_estimate))?$opening_estimate:'',
                'revised_estimate' => (isset($revised_estimate))?$revised_estimate:'',
                'payment_period' => (isset($payment_period))?$payment_period:'',
                'cumulative_period' => (isset($cumulative_period))?$cumulative_period:'',
                'left_to_pay' => (isset($left_to_pay))?$left_to_pay:'',
                'use_cash' => (isset($use_cash))?$use_cash:'',
                'recoveries_received' => (isset($recoveries_received))?$recoveries_received:'',
                'use_remaining_cash' => (isset($use_remaining_cash))?$use_remaining_cash:'',
                'adverse_ccie' => (isset($adverse_ccie))?$adverse_ccie:'',
                'slipes_claims_id' => $slipes_claims_id,
                'case_validation_status' => $case_validation_status,
                'active_status' => 1
            ]);
        }
        else if($get_cedant_type == 'life')
        {
            $claim_case = CedantClaimCases::where('_id','=',$case_id)->first();
            $claim_case->active_status = 0;
            $claim_case->updated_at = date('Y-m-d H:i:s');
            $claim_case->save();
            
            $case_validation_status = 'Pending';
            if($request->get('claim_number') != '')
            {
                $claim_number = $request->get('claim_number');
            }
            
            if($request->get('police_number') != '')
            {
                $police_number = $request->get('police_number');
            }
            
            if($request->get('date_effective') != '')
            {
                $date_effective = $request->get('date_effective');
            }
            
            if($request->get('deadline') != '')
            {
                $deadline = $request->get('deadline');
            }
            
            if($request->get('fullname_insured') != '')
            {
                $fullname_insured = $request->get('fullname_insured');
            }
            
            if($request->get('claim_date') != '')
            {
                $claim_date = $request->get('claim_date');
            }
            
            if($request->get('declaration_date') != '')
            {
                $declaration_date = $request->get('declaration_date');
            }
            
            if($request->get('claim_nature') != '')
            {
                $claim_nature = $request->get('claim_nature');
            }
            
            if($request->get('capital_loss_death') != '')
            {
                $capital_loss_death = $request->get('capital_loss_death');
            }
            
            if($request->get('capital_loss_death_acc') != '')
            {
                $capital_loss_death_acc = $request->get('capital_loss_death_acc');
            }
            
            if($request->get('capital_loss_ta') != '')
            {
                $capital_loss_ta = $request->get('capital_loss_ta');
            }
            
            if($request->get('capital_loss_ipp') != '')
            {
                $capital_loss_ipp = $request->get('capital_loss_ipp');
            }
            
            if($request->get('capital_loss_jobs') != '')
            {
                $capital_loss_jobs = $request->get('capital_loss_jobs');
            }
            
            if($request->get('claim_a_100') != '')
            {
                $claim_a_100 = $request->get('claim_a_100');
            }
            
            if($request->get('part_assignor') != '')
            {
                $part_assignor = $request->get('part_assignor');
            }
            
            if($request->get('claim_assignor') != '')
            {
                $claim_assignor = $request->get('claim_assignor');
            }
            
            if($request->get('payment_date') != '')
            {
                $payment_date = $request->get('payment_date');
            }
            
            if($request->get('claim_cede') != '')
            {
                $claim_cede = $request->get('claim_cede');
            }
            
            if(isset($claim_slip_id))
            {
                $slipes_claims_id = $this->convertObjectId($claim_slip_id);
            }
            
            //save no of cases for a life claim slip
            $case_life_claim = CedantClaimCases::create([
                'claim_number' => (isset($claim_number))?$claim_number:'',
                'police_number' => (isset($police_number))?$police_number:'',
                'date_effective' => (isset($date_effective))?$date_effective:'',
                'deadline' => (isset($deadline))?$deadline:'',
                'fullname_insured' => (isset($fullname_insured))?$fullname_insured:'',
                'claim_date' => (isset($claim_date))?$claim_date:'',
                'declaration_date' => (isset($declaration_date))?$declaration_date:'',
                'claim_nature' => (isset($claim_nature))?$claim_nature:'',
                'capital_loss_death' => (isset($capital_loss_death))?$capital_loss_death:'',
                'capital_loss_death_acc' => (isset($capital_loss_death_acc))?$capital_loss_death_acc:'',
                'capital_loss_ta' => (isset($capital_loss_ta))?$capital_loss_ta:'',
                'capital_loss_ipp' => (isset($capital_loss_ipp))?$capital_loss_ipp:'',
                'capital_loss_jobs' => (isset($capital_loss_jobs))?$capital_loss_jobs:'',
                'claim_a_100' => (isset($claim_a_100))?$claim_a_100:'',
                'part_assignor' => (isset($part_assignor))?$part_assignor:'',
                'claim_assignor' => (isset($claim_assignor))?$claim_assignor:'',
                'payment_date' => (isset($payment_date))?$payment_date:'',
                'claim_cede' => (isset($claim_cede))?$claim_cede:'',
                'slipes_claims_id' => $slipes_claims_id,
                'case_validation_status' => $case_validation_status,
                'active_status' => 1
            ]);
        }
                
        $result['claim_slip_id'] = $claim_slip_id;  
        return $this->sendResponse($result, 'Claim slip updated successfully', 200);         
    }
    
    /*
     * final decision about note from admin of insurance company
     */
    public function check_final_note(Request $request)
    {
        if($request->approval_status != '' && $request->note_id != '')
        {
            $note_id = $request->note_id;
            $note = Notes::where('_id','=',$note_id)->first();
            if($request->approval_status == 1)
            {
                $approval_status = 'Verified';
            }
            else
            {
                $approval_status = 'Rejected';
            }
            
            if($note != null || $note != '')
            {
                $note->approval_status = $approval_status;
                $note->updated_at = date('Y-m-d H:i:s');
                $note->save();

                $result['note_id'] = $note_id;  
                return $this->sendResponse($result, 'Note approval status updated successfully', 200);
            }
        }
        
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }
    
    /*
     * List of debit notes
     */
    public function list_debit_notes(Request $request)
    {
        $list_debit_notes = Notes::where('cedants_id','=',$this->convertObjectId($request->cedants_id))->where('type','=','debit')->orderBy('created_at', 'desc')->get();
        return $this->sendResponse($list_debit_notes, 'List of debit notes', 200);
    }
    
    /*
     * List of credit notes
     */
    public function list_credit_notes(Request $request)
    {
        $list_credit_notes = Notes::where('cedants_id','=',$this->convertObjectId($request->cedants_id))->where('type','=','credit')->orderBy('created_at', 'desc')->get();
        return $this->sendResponse($list_credit_notes, 'List of credit notes', 200);
    }
    
    /*
     * List of claim slips and cases related to it 
     */
    public function list_claim_slips(Request $request)
    {
        $list_claims = CedantClaims::where('cedants_id','=',$this->convertObjectId($request->cedants_id))->orderBy('created_at', 'desc')->get();
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
        $list_claims = CedantClaims::where('cedants_id','=',$this->convertObjectId($request->cedants_id))->where('slip_type','=','Cash Call')->orderBy('created_at', 'desc')->get();
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
            
            if($get_cedant_type == 'NOT LIFE')
            {
                $claim_cases = CedantClaimNotLifeCases::where('slipes_claims_id','=',$this->convertObjectId($view_claim_slip_detail->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
            }
            else
            {
                $claim_cases = CedantClaimCases::where('slipes_claims_id','=',$this->convertObjectId($view_claim_slip_detail->_id))->where('active_status','=',1)->orderBy('created_at', 'desc')->get();
            }            
            $result['claim_slip_detail'] = $view_claim_slip_detail;
            $result['claim_cases'] = $claim_cases;
            return $this->sendResponse($result, 'Claim slip detail', 200); 
        }
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }
    
    /*
     * decision about claim slip from admin of insurance company
     */
    public function check_claim_slip(Request $request)
    {
        if($request->approval_status != '' && $request->claim_slip_id != '')
        {
            if($request->approval_status == 1)
            {
                $approval_status = 'Verified';
            }
            else
            {
                $approval_status = 'Rejected';
            }
            
            $slipe_claim = CedantClaims::find($request->claim_slip_id);
            if($slipe_claim != null || $slipe_claim != '')
            {
                $slipe_claim->approval_status = $approval_status;
                $slipe_claim->published_date = date('Y-m-d H:i:s');
                $slipe_claim->updated_at = date('Y-m-d H:i:s');
                $slipe_claim->save();
                
                $result['claim_slip_id'] = $request->claim_slip_id;  
                return $this->sendResponse($result, 'Claim slip status updated successfully', 200);
            }
        }
        
        return $this->sendError('Something went wrong. Please try again.', [], 400);
    }
    
    /*
     * List of cedant roles 
     */
    public function get_roles(Request $request)
    {
        $roles = UserCedantRole::get();
        return $this->sendResponse($roles, 'List of roles', 200); 
    }
    
    /*
     * add comment for insurance company cases
     */
    public function add_comment(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'message' => 'required|max:255',  
            'cases_id' => 'required',
            'cases_type' => 'required', //value - premium_life, premium_not_life, claim_life, claim_not_life
            'user_cedant_id' => 'required'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400); 
        }

        $comment = Comment::create([
            'message' => $request->get('message'),  
            'cases_id' => $this->convertObjectId($request->get('cases_id')),  
            'cases_type' => $request->get('cases_type'),
            'user_cedant_id' => $this->convertObjectId($request->get('user_cedant_id')),  
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
            'user_cedant_id' => 'required'
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
     * add note comment for insurance company notes
     */
    public function add_note_comment(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'message' => 'required|max:255',  
            'note_id' => 'required',
            'note_type' => 'required', //value - credit, debit
            'user_cedant_id' => 'required'
        ]);

        if($validator->fails()){
                //return response()->json($validator->errors()->toJson(), 400);
                return $this->sendError('Validation Error', $validator->errors(), 400); 
        }

        $comment = Comment::create([
            'message' => $request->get('message'),  
            'note_id' => $this->convertObjectId($request->get('note_id')),
            'note_type' => $request->get('note_type'),
            'user_cedant_id' => $this->convertObjectId($request->get('user_cedant_id')),  
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
            'user_cedant_id' => 'required'
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
     * add justification files for insurance company cases
     */
    public function add_justification_files(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'cases_id' => 'required',
            'cases_type' => 'required',
            'user_cedant_id' => 'required'
        ]);

        if($validator->fails()){
                return $this->sendError('Validation Error', $validator->errors(), 400); 
        }
        
        $justification_files = '';
        $file_path = array();
        if(isset($_FILES["justication_image"]["name"]))
        { 
            foreach($_FILES["justication_image"]["error"] as $key=>$error) 
            { 
               if($error == 0)
               {
                    $tmp_name = $_FILES["justication_image"]["tmp_name"][$key];
                    $name = str_replace(' ', '_', $_FILES["justication_image"]["name"][$key]);                
                    $ext = pathinfo($name, PATHINFO_EXTENSION);

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')   
                    { 
                        $name = 'case_'.time().'.'.$ext;
                        $path = public_path().'/documents/case_files';
                        $path2 = 'documents/case_files';
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
            $justification_files = implode(',',$file_path);
        }

        $files = Files::create([
            'file_urls' => $justification_files,  
            'cases_id' => $this->convertObjectId($request->get('cases_id')),  
            'cases_type' => $request->get('cases_type'),
            'user_cedant_id' => $this->convertObjectId($request->get('user_cedant_id')),  
        ]);
        
        $file_id = '';
        if(isset($files->_id) && $files->_id != '')
        {
            $file_id = $files->_id;
        }
        
        $result['file_id'] = $file_id; 
        //return response()->json(compact('user','token'),201);
        return $this->sendResponse($result, 'File submitted successfully', 200);
    }
    
    /*
     * get details for insurance company
     */
    public function get_cedant_details(Request $request)
    {
        $ins = ReinsuranceCedant::find($request->cedants_id);
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

}
