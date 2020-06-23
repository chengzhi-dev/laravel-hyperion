/*
* update claim slip for insurance company by reinsurance user
*/
public function update_claim_slip(Request $request)
{
$validator = Validator::make($request->all() , [
'claim_slip_id' => 'required',
'cedants_type_id' => 'required',
'insurance_type' => 'required',
'cases_array' => 'required'

]);

if($validator->fails()){
return $this->sendError('Validation Error', $validator->errors(), 400);
}

$cases_array = $request->get('cases_array');
$claim_slip_id = $request->get('claim_slip_id');
$get_cedant_type = $request->insurance_type;
$return_array = [];

if(!empty($cases_array))
{
$i=0;
$decode_cases = json_decode($cases_array);
           foreach($decode_cases as $each_case)
           {
               $each_case = (array)$each_case;
               $case_id = $each_case['case_id']; //$request->get('case_id');

               if($get_cedant_type == 'not life')
               {
                   $claim_case = CedantClaimNotLifeCases::where('_id','=',$case_id)->first();
                   $claim_case->active_status = 0;
                   $claim_case->updated_at = date('Y-m-d H:i:s');
                   $claim_case->save();

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
