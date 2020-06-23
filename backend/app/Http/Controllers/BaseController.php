<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200)->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', '*')
            ->header('Access-Control-Allow-Headers', '*');
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code)->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', '*')
            ->header('Access-Control-Allow-Headers', '*');
    }
    
    /**
     * return string to object id.
     *
     * @return \Illuminate\Http\Response
     */
    public function convertObjectId($param)
    {
        if($param != '')
        {
            return new \MongoDB\BSON\ObjectId($param);
        }
        else
        {
            return '';
        }
       
    }
    
    /**
     * return normal date format to mongodb supported date format.
     *
     * @return \Illuminate\Http\Response
     */
    public function convertDateToMongoDate($param)
    {        
        if($param != '')
        {
            return new \MongoDB\BSON\UTCDateTime($param);
        }
        else
        {
            return '';
        }
    }
    
    /**
     * return current trimester months
     *
     * @return \Illuminate\Http\Response
     */
    public function getTrimesterMonths()
    {        
        $month = date('n');
        $year = date('Y');
        $trimester_no = '';
        $start_date = '';
        $end_date = '';
        if($month >= 1 && $month <= 3)
        {
            $trimester_no = 'first';
            $start_date = new \DateTime("$year-01-01");
            $end_date = new \DateTime("$year-03-31");
        }
        else if($month >= 4 && $month <= 6)
        {
            $trimester_no = 'second';
            $start_date = new \DateTime("$year-04-01");
            $end_date = new \DateTime("$year-06-30");
        }
        else if($month >= 7 && $month <= 9)
        {
            $trimester_no = 'third';
            $start_date = new \DateTime("$year-07-01");
            $end_date = new \DateTime("$year-09-30");
        }
        else if($month >= 10 && $month <= 12)
        {
            $trimester_no = 'fourth';
            $start_date = new \DateTime("$year-10-01");
            $end_date = new \DateTime("$year-12-31");
        }
        
        return array('trimester_no'=>$trimester_no, 'start_date'=>$start_date, 'end_date'=>$end_date);
        
    }
    
    /**
     * return current trimester month names
     *
     * @return \Illuminate\Http\Response
     */
    public function getTrimesterMonthNames()
    {        
        $year = date('Y');
        $month = date('n');
        $trimester_no = '';
        $slip1_month = '';
        $slip2_month = '';
        $slip3_month = '';
        $slip1_month_year = '';
        $slip2_month_year = '';
        $slip3_month_year = '';
        if($month >= 1 && $month <= 3)
        {
            $trimester_no = 'first';
            $slip1_month = 'January';
            $slip2_month = 'February';
            $slip3_month = 'March';
            $slip1_month_year = '01/'.$year;
            $slip2_month_year = '02/'.$year;
            $slip3_month_year = '03/'.$year;
        }
        else if($month >= 4 && $month <= 6)
        {
            $trimester_no = 'second';
            $slip1_month = 'April';
            $slip2_month = 'May';
            $slip3_month = 'June';
            $slip1_month_year = '04/'.$year;
            $slip2_month_year = '05/'.$year;
            $slip3_month_year = '06/'.$year;
        }
        else if($month >= 7 && $month <= 9)
        {
            $trimester_no = 'third';
            $slip1_month = 'July';
            $slip2_month = 'August';
            $slip3_month = 'September';
            $slip1_month_year = '07/'.$year;
            $slip2_month_year = '08/'.$year;
            $slip3_month_year = '09/'.$year;
        }
        else if($month >= 10 && $month <= 12)
        {
            $trimester_no = 'fourth';
            $slip1_month = 'October';
            $slip2_month = 'November';
            $slip3_month = 'December';
            $slip1_month_year = '10/'.$year;
            $slip2_month_year = '11/'.$year;
            $slip3_month_year = '12/'.$year;
        }
        
        return array('trimester_no'=>$trimester_no, 'slip1_month'=>$slip1_month, 'slip2_month'=>$slip2_month,
           'slip3_month'=>$slip3_month, 'slip1_month_year'=>$slip1_month_year, 'slip2_month_year'=>$slip2_month_year,
           'slip3_month_year'=>$slip3_month_year );
        
    }
    
    /**
     * return initials from the words
     *
     * @return \Illuminate\Http\Response
     */
    public function getInitalNames($string)
    {
        $inital = '';
        $initial_array = [];
        $explode_arr = explode(' ', $string);
        if(!empty($explode_arr))
        {
            foreach($explode_arr as $expl_ar)
            {
               $initial_array[] = substr($expl_ar, 0, 1); 
            }
            $inital = implode('', $initial_array);
        }
        return $inital;
    }
    
    /**
     * return digits only from european currency style
     *
     * @return \Illuminate\Http\Response
     */
    public function replaceCurrencyToDigit($string)
    {
        $inital = '';
        if($string != '')
        {
            $digit = str_replace(['.', ',', ' ', '%'], '', $string);       
            if(ctype_digit($digit) == 1)
            {
                $inital = $digit;
            }
        }
        return $inital;
    }
    
}