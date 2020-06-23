<?php
session_start();
include_once("../db/databasereport.php");
date_default_timezone_set('Asia/Kolkata');
require_once '../excellib/Classes/PHPExcel/IOFactory.php';
$resolution_text_box = true;
function burnExcel($report_id) {
    $db = new ReportBurning();
    $generic = $db->getGraphData($report_id);
    $share_holding_patterns = $generic['share_holding_patterns'];
    $variation_director_remuneration = $generic['variation_director_remuneration'];
    $remuneration_growth = $generic['remuneration_growth'];
    $board_independence = $generic['board_independence'];
    $dividend_and_earnings = $generic['dividend_and_earnings'];
    $dividend_payout_ratio = $generic['dividend_payout_ratio'];
    $appointment_auditors_table_1 = $generic['appointment_auditors_table_1'];
    $executive_compensation = $generic['executive_compensation'];
    $average_commission = $generic['average_commission'];
    $director_commision = $generic['director_commision'];
    $stock_performance = $generic['stock_performance'];
    $borrowing_limits = $generic['borrowing_limits'];


    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
    $objPHPExcel = $objReader->load("burning.xlsx");

    $fin1= $share_holding_patterns[0]['financial_year'];
    $fin2= $share_holding_patterns[1]['financial_year'];
    $fin3= $share_holding_patterns[2]['financial_year'];
    $fin4= $share_holding_patterns[3]['financial_year'];

    $objPHPExcel->getActiveSheet()->SetCellValue('C4', $fin1);
    $objPHPExcel->getActiveSheet()->SetCellValue('C5', $share_holding_patterns[0]['promoter']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C6', $share_holding_patterns[0]['fii']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C7', $share_holding_patterns[0]['dii']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C8', $share_holding_patterns[0]['others']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D4', $fin2);
    $objPHPExcel->getActiveSheet()->SetCellValue('D5', $share_holding_patterns[1]['promoter']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D6', $share_holding_patterns[1]['fii']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D7', $share_holding_patterns[1]['dii']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D8', $share_holding_patterns[1]['others']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E4', $fin3);
    $objPHPExcel->getActiveSheet()->SetCellValue('E5', $share_holding_patterns[2]['promoter']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E6', $share_holding_patterns[2]['fii']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E7', $share_holding_patterns[2]['dii']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E8', $share_holding_patterns[2]['others']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F4', $fin4);
    $objPHPExcel->getActiveSheet()->SetCellValue('F5', $share_holding_patterns[3]['promoter']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F6', $share_holding_patterns[3]['fii']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F7', $share_holding_patterns[3]['dii']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F8', $share_holding_patterns[3]['others']);

    // Remuneration Growth

    for($i=38,$j=0;$i<=42;$i++,$j++) {
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $remuneration_growth[$j]['financial_year']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $remuneration_growth[$j]['md']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $remuneration_growth[$j]['indexed_tsr']);
    }

    // Retiring

    $objPHPExcel->getActiveSheet()->SetCellValue('C16', $board_independence['retiring']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C17', $board_independence['non_retiring']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C18', $board_independence['not_applicable']);

    // Board Independence

    $objPHPExcel->getActiveSheet()->SetCellValue('C28', $board_independence['id_as_per_ses']/100);
    $objPHPExcel->getActiveSheet()->SetCellValue('C29', $board_independence['nid_as_per_ses']/100);
    $objPHPExcel->getActiveSheet()->SetCellValue('C30', $board_independence['nid_as_per_company']/100);
    $objPHPExcel->getActiveSheet()->SetCellValue('C31', $board_independence['id_as_per_company']/100);

    // Variation

    $objPHPExcel->getActiveSheet()->SetCellValue('C50', $variation_director_remuneration['ex_promoter']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C51', $variation_director_remuneration['ex_non_promoter']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D50', $variation_director_remuneration['non_ex_promoter']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D51', $variation_director_remuneration['non_ex_non_promoter']);

    // Dividend and Earnings
    for($i=60,$j=0;$i<=62;$i++,$j++) {
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $dividend_and_earnings[$j]['financial_year']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $dividend_and_earnings[$j]['dividend']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $dividend_and_earnings[$j]['eps']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $dividend_and_earnings[$j]['dividend_payout']);
    }

    // Dividend payout ratio
    for($i=72,$j=0;$i<=74;$i++,$j++) {
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $dividend_payout_ratio[$j]['dividend']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $dividend_payout_ratio[$j]['eps']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $dividend_payout_ratio[$j]['dividend_payout']);
    }

    // appointment_auditors_table_1

//    $appointment_auditors_table_1

    $objPHPExcel->getActiveSheet()->SetCellValue('C82', $appointment_auditors_table_1[0]['financial_year']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D82', $appointment_auditors_table_1[1]['financial_year']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C83', $appointment_auditors_table_1[1]['audit_fee']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D83', $appointment_auditors_table_1[1]['audit_fee']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C84', $appointment_auditors_table_1[1]['audit_related_fee']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D84', $appointment_auditors_table_1[1]['audit_related_fee']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C85', $appointment_auditors_table_1[1]['non_audit_fee']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D85', $appointment_auditors_table_1[1]['non_audit_fee']);


    $year_1 = intval(substr($appointment_auditors_table_1[2]['financial_year'],2,2));
    $year_1 = "FY ".($year_1-1)."/".$year_1;
    $year_2 = intval(substr($appointment_auditors_table_1[1]['financial_year'],2,2));
    $year_2 = "FY ".($year_2-1)."/".$year_2;
    $year_3 = intval(substr($appointment_auditors_table_1[0]['financial_year'],2,2));
    $year_3 = "FY ".($year_3-1)."/".$year_3;

    $objPHPExcel->getActiveSheet()->SetCellValue('C96', $year_1);
    $objPHPExcel->getActiveSheet()->SetCellValue('D96', $year_2);
    $objPHPExcel->getActiveSheet()->SetCellValue('E96', $year_3);

    $objPHPExcel->getActiveSheet()->SetCellValue('C97',$appointment_auditors_table_1[2]['audit_fee']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C98',$appointment_auditors_table_1[2]['audit_related_fee']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C99',$appointment_auditors_table_1[2]['non_audit_fee']);

    $objPHPExcel->getActiveSheet()->SetCellValue('D97',$appointment_auditors_table_1[1]['audit_fee']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D98',$appointment_auditors_table_1[1]['audit_related_fee']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D99',$appointment_auditors_table_1[1]['non_audit_fee']);

    $objPHPExcel->getActiveSheet()->SetCellValue('E97',$appointment_auditors_table_1[0]['audit_fee']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E98',$appointment_auditors_table_1[0]['audit_related_fee']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E99',$appointment_auditors_table_1[0]['non_audit_fee']);


    //    12th graph
    $row= 110;
    for($i=0;$i<=5;$i++) {
        $years = "FY ".(intval(substr($executive_compensation[$i]['ex_rem_years'],2,2))-1)."/".substr($executive_compensation[$i]['ex_rem_years'],2,2);
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,$years);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$executive_compensation[$i]['ed_remuneration']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,$executive_compensation[$i]['indexed_tsr']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$row,$executive_compensation[$i]['net_profit']);
        $row++;
    }

    // 11th grapah
    $objPHPExcel->getActiveSheet()->SetCellValue('D123',$average_commission[5]['text']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D124',$average_commission[6]['text']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D125',$average_commission[7]['text']);


    //    12th graph
    $row= 134;
    for($i=0;$i<=4;$i++) {
        $years = "FY ".(intval(substr($director_commision[$i]['year'],2,2))-1)."/".substr($director_commision[$i]['year'],2,2);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$years);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,$director_commision[$i]['value']);
        $row++;
    }


    //    13th graph
    $row= 153;
    for($i=0;$i<=4;$i++) {
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$stock_performance[$i]['company']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,$stock_performance[$i]['sp_cnx_nifty']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$row,$stock_performance[$i]['cnx_finance']);
        $row++;
    }

//    15th graph

    $month_1 = substr(ucfirst($borrowing_limits[0]['quater']),0,3);
    $month_2 = substr(ucfirst($borrowing_limits[1]['quater']),0,3);

    $objPHPExcel->getActiveSheet()->SetCellValue('B484',$month_1."'".substr($borrowing_limits[0]['year'],2,2));
    $objPHPExcel->getActiveSheet()->SetCellValue('C484',$borrowing_limits[0]['existing']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D484',$borrowing_limits[0]['unavailed']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E484',$borrowing_limits[0]['proposed']);

    $objPHPExcel->getActiveSheet()->SetCellValue('B485',$month_2."'".substr($borrowing_limits[1]['year'],2,2));
    $objPHPExcel->getActiveSheet()->SetCellValue('C485',$borrowing_limits[1]['existing']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D485',$borrowing_limits[1]['unavailed']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E485',$borrowing_limits[1]['proposed']);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save("graph_excel.xlsx");
}
function htmlParser($text,$recommendation_text=0) {
    if($recommendation_text==1) {
        $text = str_replace("&#39;","'",$text);
        $text = str_replace('<p style="margin-left: 40px;">',"<p style='margin-left:30px; margin-bottom: 0; margin-top: 0; padding-top: 8px; padding-bottom: 8px; font-size: 10;line-height:135%; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>",$text);
        $text = str_replace("<p>","<p style='padding-top: 8px; padding-bottom: 8px; margin: 0; font-size: 10;line-height:135%; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>",$text);
        $text = str_replace("<ul>","<ul style='font-size: 10;'>",$text);
    }
    else {
        $text = str_replace("&#39;","'",$text);
        $text = str_replace('<p style="margin-left: 40px;">',"<p style='font-size: 10; margin-left: 30px; margin-top: 0; margin-bottom: 0; margin-right: 0; line-height:135%; padding-top: 8px; padding-bottom: 8px; text-align: justify; '>",$text);
        $text = str_replace("<p>","<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>",$text);
        $text = str_replace("<ul>","<ul style='font-size: 10;'>",$text);
    }
    return "<div style='font-size: 10;'>$text</div>";
}
function htmlParserForTable($text) {
    $text = str_replace("&#39;","'",$text);
    $text = str_replace('<p style="margin-left: 40px;">',"<p style='font-size: 10; margin 0; line-height:135%; padding: 0; text-align: justify; '>",$text);
    $text = str_replace("<p>","<p style='font-size: 10; line-height:135%; padding:0px; margin: 0; text-align: justify; '>",$text);
    $text = str_replace("<ul>","<ul style='font-size: 10;'>",$text);
    return $text;
}
function getDocxFormatDate($date) {
    $db_date = $date;
    $formated_day = date_format(date_create_from_format('Y-m-d', $db_date), 'd');
    $formated_month = date_format(date_create_from_format('Y-m-d', $db_date), 'M');
    $formated_year = date_format(date_create_from_format('Y-m-d', $db_date), 'Y');
    $super = "";
    switch($formated_day) {
        case "01":
        case "21":
        case "31":
            $super = "st";
            break;
        case "02":
        case "22":
            $super = "nd";
            break;
        case "03":
        case "23":
            $super = "rd";
            break;
        case "04":
        case "05":
        case "06":
        case "07":
        case "08":
        case "09":
        case "10":
        case "11":
        case "12":
        case "13":
        case "14":
        case "15":
        case "16":
        case "17":
        case "18":
        case "19":
        case "20":
        case "24":
        case "25":
        case "26":
        case "27":
        case "28":
        case "29":
        case "30":
            $super = "th";
            break;
    }
    return "<span style='font-size: 10;'>".$formated_day."<sup>$super</sup>"." ".$formated_month.", ".$formated_year."</span>";
}
function getHeaderIndexFormatDate($date) {
    $db_date = $date;
    $formated_day = date_format(date_create_from_format('Y-m-d', $db_date), 'd');
    $formated_month = date_format(date_create_from_format('Y-m-d', $db_date), 'F');
    $formated_year = date_format(date_create_from_format('Y-m-d', $db_date), 'Y');
    $super = "";
    switch($formated_day) {
        case "01":
        case "21":
        case "31":
            $super = "st";
            break;
        case "02":
        case "22":
            $super = "nd";
            break;
        case "03":
        case "23":
            $super = "rd";
            break;
        case "04":
        case "05":
        case "06":
        case "07":
        case "08":
        case "09":
        case "10":
        case "11":
        case "12":
        case "13":
        case "14":
        case "15":
        case "16":
        case "17":
        case "18":
        case "19":
        case "20":
        case "24":
        case "25":
        case "26":
        case "27":
        case "28":
        case "29":
        case "30":
            $super = "th";
            break;
    }
    return "<span style='font-size: 10;'>".$formated_day."<sup>$super</sup>"." ".$formated_month.", ".$formated_year."</span>";
}
function addHeader($docx,$report_id) {
    $db = new ReportBurning();
    $company_report_details = $db->getCompanyAndMeetingDetails($report_id);
    $imageOptions = array(
        'src' => 'logo.png',
        'dpi' => 120
    );
    $headerImage = new WordFragment($docx, 'defaultHeader');
    $headerImage->addImage($imageOptions);
    $textOptions = array(
        'fontSize' => 20,
        'color' => '000000',
        'textAlign' => 'right',
        'font'=> 'Cambria',
    );
    $textOptions2 = array(
        'fontSize' => 10,
        'color' => '000000',
        'textAlign' => 'right'
    );
    $link = array(
        'fontSize' => 10,
        'url'=>$company_report_details['website'],
        'textAlign' => 'right',
        'spacingTop'=>140
    );
    $textOptions3 = array(
        'fontSize' => 10,
        'textAlign' => 'left'
    );

    $headerText = new WordFragment($docx, 'defaultHeader');
    $headerText->addText($company_report_details['name'], $textOptions);
    $headerText->addLink(substr($company_report_details['website'],7), $link);

    $headerDate = new WordFragment($docx, 'defaultHeader');
    $headerMetType = new WordFragment($docx, 'defaultHeader');

    $headerDate->embedHTML("<span style='display:block;font-size:10; text-align:right;'>Meeting Date: ".getHeaderIndexFormatDate($company_report_details['meeting_date'])."</span>");
    $headerMetType->addText('Meeting Type : '.$company_report_details['meeting_type'], $textOptions3);

    $valuesTable = array(
        array(
            array('value' =>$headerImage, 'vAlign' => 'center'),
            array('value' =>$headerText, 'vAlign' => 'center')
        ),
        array(
            array('value' =>$headerMetType, 'vAlign' => 'center', 'borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => '000000'),
            array('value' =>$headerDate, 'vAlign' => 'center','borderTop' => 'single', 'borderTopWidth'=>13,'borderTopColor' => '000000')
        ),
    );
    $widthTableCols = array(
        700,
        150000
    );
    $paramsTable = array(
        'border' => 'nil',
        'borderWidth' => 8,
        'borderColor' => 'cccccc',
        'columnWidths' => $widthTableCols,
    );
    $headerTable = new WordFragment($docx, 'defaultHeader');
    $headerTable->addTable($valuesTable, $paramsTable);
    $docx->addHeader(array('default' => $headerTable,'even' => $headerTable));
}
function addFooter($docx) {
    $imageOptions = array(
        'src' => 'footer_logo.png',
        'dpi' => 72,
        'height'=>40,
        'width'=>45
    );
    $footerImage = new WordFragment($docx, 'defaultFooter');
    $footerImage->addImage($imageOptions);
    $pageNumberOptions = array(
        'textAlign' => 'right',
        'fontSize' => 10,
    );
    $textOptions = array(
        'textAlign' => 'left',
        'fontSize' => 10,
    );
    $footerPageNumber = new WordFragment($docx);
    $footerPageNumber->addPageNumber('numerical', $pageNumberOptions);

    $footerText = new WordFragment($docx);
    $footerText->addText('© 2012 | Stakeholders Empowerment Services | All Rights Reserved', $textOptions);


    $valuesTable = array(
        array(
            array('value' =>$footerImage, 'vAlign' => 'center', 'borderTop' => 'single', 'borderTopColor' => '000000'),
            array('value' =>$footerText, 'vAlign' => 'center', 'borderTop' => 'single', 'borderTopColor' => '000000'),
            array('value' =>$footerPageNumber, 'vAlign' => 'center', 'borderTop' => 'single', 'borderTopColor' => '000000'),
            array('value' =>'| PAGE', 'vAlign' => 'center', 'borderTop' => 'single', 'borderTopColor' => '000000', 'cellMargin'=> 0),
        ),
    );
    $widthTableCols = array(
        700,
        11000,
        2500,
        2000,

    );
    $paramsTable = array(
        'borderTop' => 'nil',
        'borderWidth' => 4,
        'borderColor' => 'cccccc',
        'columnWidths' => $widthTableCols,
    );

    $footerTable = new WordFragment($docx, 'defaultfooter');
    $footerTable->addTable($valuesTable, $paramsTable);
    $docx->addFooter(array('default' => $footerTable,'even'=>$footerTable));
}
function resHeading($docx,$text,$level) {
    $docx->addText($text,array('headingLevel'=>$level,'color'=>'000000','borderTop' => 'single','borderTopWidth'=>2,'borderTopColor' => '000000','borderBottom' => 'single','borderBottomWidth'=>2,'borderBottomColor' => '000000','spacingTop'=>3,'spacingBottom'=>3,'borderBottomSpacing'=>3,'borderTopSpacing'=>3,'fontSize'=>10,'bold'=>true));
}
function resBlackStrip($docx,$text) {
//    $docx->addText($text,array('headingLevel'=>2,'backgroundColor'=>'464646','color'=>'FFFFFF','borderBottomSpacing'=>2,'borderTopSpacing'=>2,'fontSize'=>10,'bold'=>true));
    $docx->addText($text,array('headingLevel'=>2,'backgroundColor'=>'464646','color'=>'FFFFFF','borderTop' => 'single','borderTopWidth'=>2,'borderTopColor' => '464646','borderBottom' => 'single','borderBottomWidth'=>2,'borderBottomColor' => '464646','spacingTop'=>3,'spacingBottom'=>3,'borderBottomSpacing'=>3,'borderTopSpacing'=>3,'fontSize'=>10,'bold'=>true));
}
function addOrangeTextBox($docx,$text) {
    $orangebar = new WordFragment($docx);
    $orangebar->embedHtml($text);
    $textBoxOptions = array(
        'align' => 'right',
        'paddingLeft' => 2,
        'paddingTop' => 3,
        'border' => 0,
        'fillColor' => '#EB641B',
        'width' => 260,
        'contentVerticalAlign' => 'center',
        'height'=>40
    );
    $docx->addTextBox($orangebar, $textBoxOptions);
}
function createIndexPage($docx_index,$report_id) {
    $db = new ReportBurning();
    $company_and_meeting_details = $db->getIndexPageInfo($report_id);
    switch($company_and_meeting_details['meeting_type']) {
        case 'AGM':
            $company_and_meeting_details['meeting_type'] = "Annual General Meeting";
            break;
        case 'EGM':
            $company_and_meeting_details['meeting_type'] = "Extraordinary General Meeting";
            break;
        case 'PB':
            $company_and_meeting_details['meeting_type'] = "Postal Ballot";
            break;
        case 'CCM':
            $company_and_meeting_details['meeting_type'] = "Court Convened Meeting";
            break;
    }
    $variables = array(
        'company_name'=>$company_and_meeting_details['name'],
        'bse_code' => $company_and_meeting_details['bse_code'],
        'nse_code' => $company_and_meeting_details['nse_code'],
        'isin'=>$company_and_meeting_details['isin'],
        'sector'=>$company_and_meeting_details['sector'],
        'meeting_type'=>$company_and_meeting_details['meeting_type'],
        'meeting_venue'=>$company_and_meeting_details['meeting_venue'],
        'phone'=>$company_and_meeting_details['contact'],
        'fax'=>$company_and_meeting_details['fax'],
        'company_office'=>$company_and_meeting_details['address'],
        'meeting_time'=>$company_and_meeting_details['meeting_time']
    );
    $options = array('parseLineBreaks' =>true);
    $docx_index->replaceVariableByText($variables, $options);
    $docx_index->replaceVariableByHTML("e_voting_plateform","inline","<a style='font-size: 10;' href='$company_and_meeting_details[e_voting_platform_website]'>$company_and_meeting_details[e_voting_platform]</a>");
    $docx_index->replaceVariableByHTML("notice_link","inline","<a style='font-size: 10;' href='$company_and_meeting_details[notice_link]'>Click here</a>");
    $docx_index->replaceVariableByHTML("annual_report","inline","<a style='font-size: 10;' href='$company_and_meeting_details[annual_report]'>$company_and_meeting_details[annual_report_name]</a>");
    $docx_index->replaceVariableByHTML("company_email","inline","<a style='font-size: 10;' href='mailto:$company_and_meeting_details[email]'>$company_and_meeting_details[email]</a>");
    $date_in_format = getHeaderIndexFormatDate($company_and_meeting_details['e_voting_start_date']);
    $docx_index->replaceVariableByHTML("e_voting_start_date","inline",$date_in_format);
    $date_in_format = getHeaderIndexFormatDate($company_and_meeting_details['e_voting_end_date']);
    $docx_index->replaceVariableByHTML("e_voting_end_date","inline",$date_in_format);
    $date_in_format = getHeaderIndexFormatDate($company_and_meeting_details['meeting_date']);
    $docx_index->replaceVariableByHTML("meeting_date","inline",$date_in_format);
}
function agendaItemsAndRecommendations($docx,$report_id) {
    $db = new ReportBurning();
    $agenda_items = $db->getAgendaItemsAndRecommendations($report_id);
    $i=1;
    $odd_row_style_string = "font-size: 10; background-color: #F2F2F2; text-align: left; border-right: 1px solid #FFF;";
    $odd_row_style_string_center = "font-size: 10; background-color: #F2F2F2; text-align: left; border-right: 1px solid #FFF; text-align:center;";
    $even_row_style_string = "font-size: 10; background-color: #D9D9D9;  text-align: left; border-right: 1px solid #FFF;";
    $even_row_style_string_center = "font-size: 10; background-color: #D9D9D9;  text-align: left; border-right: 1px solid #FFF; text-align:center;";
    $odd_row_style_string_center_red_bold = "font-weight:bold; color:#F00; font-size: 10; background-color: #F2F2F2;  text-align: left; border-right: 1px solid #FFF; text-align:center;";
    $even_row_style_string_center_red_bold = "font-weight:bold; color:#F00; font-size: 10; background-color: #D9D9D9;  text-align: left; border-right: 1px solid #FFF; text-align:center;";
    $board_governance_score= "<tr>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>S. No.</td>
                                    <td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Resolution</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Type</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Recommendation</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Focus</td>
                                </tr>";
    foreach($agenda_items as $item) {
        if($i%2!=0) {
            $board_governance_score .= "<tr><td style='$odd_row_style_string_center'>$i</td><td style='$odd_row_style_string'>$item[resolution]</td><td style='$odd_row_style_string_center'>$item[type]</td><td style='$odd_row_style_string_center'>$item[recommendation]</td><td style='$odd_row_style_string_center_red_bold'>$item[focus]</td></tr>";
        }
        else {
            $board_governance_score .= "<tr><td style='$even_row_style_string_center'>$i</td><td style='$even_row_style_string'>$item[resolution]</td><td style='$even_row_style_string_center'>$item[type]</td><td style='$even_row_style_string_center'>$item[recommendation]</td><td style='$even_row_style_string_center_red_bold'>$item[focus]</td></tr>";
        }
        $i++;
    }
    $html = "<p style=''></p>";
    $html .= "<table style='border-collapse: collapse; width:100%; margin-top: 5;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 12; font-weight: bold; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;'>T</span>ABLE <span style='font-size: 13;'>1</span> - <span style='font-size: 13;'>A</span>GENDA <span style='font-size: 13;'>I</span>TEMS <span style='font-size: 13;'>A</span>ND <span style='font-size: 13;'>R</span>ECOMMENDATIONS</td></tr>
                    <tr><td colspan='8' style='font-size: 5; padding-top: 2px; padding-bottom: 2px; border-top: 1px solid #000000;border-bottom: 2px solid #000000;'>&nbsp;</td></tr>
                    $board_governance_score
                    <tr><td colspan='5' style='font-size: 8.5; padding-top: 5px; padding-bottom: 5px; border-bottom: 2px solid #000000;'><i>O - Ordinary Resolution; S - Special Resolution</i></td></tr>
                    <tr><td colspan='5' style='font-size: 12; padding-top: 5px; padding-bottom: 5px; border-bottom: 2px solid #000000;'><span style='font-size: 13;'>R</span>ESEARCH <span style='font-size: 13;'>A</span>NALYST:</td></tr>
                </tbody>
              </table>";
    $docx->embedHTML($html);
    $html = "<p style='font-size:9;margin-top:5px;margin-bottom: 0; text-align:justify; '><i><span style='font-weight: bold;'>C - Compliance: </span>The Company has not met statutory compliance requirements</i></p>";
    $html .= "<p style='font-size:9; margin: 0; text-align:justify;'><i><span style='font-weight: bold;'>F - Fairness: </span>The Company has proposed steps which may lead to undue advantage of a particular class of shareholders and can have adverse impact on non-controlling shareholders including minority shareholders</i></p>";
    $html .= "<p style='font-size:9;margin: 0; text-align:justify;'><i><span style='font-weight: bold;'>G - Governance: </span>SES questions the governance practices of the Company. The Company may have complied with the statutory requirements in letter. However, SES finds governance issues as per its standards.</i></p>";
    $html .= "<p style='font-size:9; margin: 0; text-align:justify;'><i><span style='font-weight: bold;'>T - Disclosures &amp; Transparency: </span>The Company has not made adequate disclosures necessary for shareholders to make an informed decision. The Company has intentionally or unintentionally kept the shareholders in dark.</i></p>";
    $docx->embedHTML($html);
}
function companyBackground($docx,$report_id) {
    $db = new ReportBurning();
    $generic_array = $db->companyBackgroundDate($report_id);
    $market_data = $generic_array['market_data'];
    $financial_indicators = $generic_array['financial_indicators'];
    $peer_comparision = $generic_array['peer_comparision'];
    $public_share_holders = $generic_array['public_share_holders'];
    $major_promoters=$generic_array['major_promoters'];
    $table_financial_indicators= "<tr>
                                    <td style='width: 25%;border-bottom: 2px solid #000000; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>(In <span style='font-family: Rupee Foradian;'>`</span> Crores)</td>
                                    <td style='text-align:center; width:10%; border-bottom: 2px solid #000000;color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>".$financial_indicators[0]['financial_year']."</td>
                                    <td style='text-align:center; width:10%;border-bottom: 2px solid #000000;color: #FFFFFF;font-weight: bold; font-size: 10; background-color: #464646;'>".$financial_indicators[1]['financial_year']."</td>
                                    <td style='text-align:center;width:10%; color: #FFFFFF;border-bottom: 2px solid #000000; font-weight: bold; font-size: 10; background-color: #464646;'>".$financial_indicators[2]['financial_year']."</td>
                                    <td style='width:0.5%;'>&nbsp;&nbsp;</td>
                                    <td style='width:22%; color: #FFFFFF;border-bottom: 2px solid #000000;font-weight: bold; font-size: 10; background-color: #464646; text-align:center;'>".$generic_array['peer_1_company_name']."</td>
                                    <td style='width:22%; color: #FFFFFF;font-weight: bold; font-size: 10;border-bottom: 2px solid #000000; background-color: #464646;text-align:center;'>".$generic_array['peer_2_company_name']."</td>
                                </tr>";
    $table_financial_indicators.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>Revenue</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[0]['revenue']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[1]['revenue']."</td>
                                    <td style='font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[2]['revenue']."</td>
                                    <td style='width:3%;'>&nbsp;&nbsp;</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;text-align:right;'>".$peer_comparision[0]['revenue']."</td>
                                    <td style='font-size: 10; background-color: #F2F2F2;text-align:right;'>".$peer_comparision[1]['revenue']."</td>
                                   </tr>";
    $table_financial_indicators.="<tr>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>Other Income</td>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[0]['other_income']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[1]['other_income']."</td>
                                        <td style='font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[2]['other_income']."</td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;text-align:right;'>".$peer_comparision[0]['other_income']."</td>
                                        <td style='font-size: 10; background-color: #D9D9D9;text-align:right;'>".$peer_comparision[1]['other_income']."</td>
                                   </tr>";
    $table_financial_indicators.="<tr>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>Total Income</td>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[0]['total_income']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[1]['total_income']."</td>
                                        <td style='font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[2]['total_income']."</td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;text-align:right;'>".$peer_comparision[0]['other_income']."</td>
                                        <td style='font-size: 10; background-color: #F2F2F2;text-align:right;'>".$peer_comparision[1]['other_income']."</td>
                                   </tr>";
    $table_financial_indicators.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>PBDT</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[0]['pbdt']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[1]['pbdt']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[2]['pbdt']."</td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;text-align:right;'>".$peer_comparision[0]['pbdt']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;text-align:right;'>".$peer_comparision[1]['pbdt']."</td>
                                           </tr>";
    $table_financial_indicators.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>Net Profit</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[0]['net_profit']."</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[1]['net_profit']."</td>
                                            <td style='font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[2]['net_profit']."</td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #F2F2F2;text-align:right;'>".$peer_comparision[0]['net_profit']."</td>
                                            <td style='font-size: 10; background-color: #F2F2F2;text-align:right;'>".$peer_comparision[1]['net_profit']."</td>
                                           </tr>";
    $table_financial_indicators.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;'>EPS (<span style='font-family: Rupee Foradian;'>`</span>)</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[0]['eps']."</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[1]['eps']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[2]['eps']."</td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;text-align:right;'>".$peer_comparision[0]['eps']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;text-align:right;'>".$peer_comparision[1]['eps']."</td>
                                           </tr>";
    $table_financial_indicators.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #F2F2F2;'>Dividend per share (<span style='font-family: Rupee Foradian;'>`</span>)</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[0]['dividend_per_share']."</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[1]['dividend_per_share']."</td>
                                            <td style='font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[2]['dividend_per_share']."</td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #F2F2F2;text-align:right;'>".$peer_comparision[0]['dividend_per_share']."</td>
                                            <td style='font-size: 10; background-color: #F2F2F2;text-align:right;'>".$peer_comparision[1]['dividend_per_share']."</td>
                                           </tr>";
    $table_financial_indicators.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;'>Dividend Pay-Out (%)</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[0]['dividend_pay_out']."</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[1]['dividend_pay_out']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[2]['dividend_pay_out']."</td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;text-align:right;'>".$peer_comparision[0]['dividend_pay_out']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;text-align:right;'>".$peer_comparision[1]['dividend_pay_out']."</td>
                                           </tr>";
    $table_financial_indicators.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #F2F2F2;'>OPM (%)</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[0]['opm']."</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[1]['opm']."</td>
                                            <td style='font-size: 10; background-color: #F2F2F2;text-align:right;'>".$financial_indicators[2]['opm']."</td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #F2F2F2;text-align:right;'>".$peer_comparision[0]['opm']."</td>
                                            <td style='font-size: 10; background-color: #F2F2F2;text-align:right;'>".$peer_comparision[1]['opm']."</td>
                                           </tr>";
    $table_financial_indicators.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;'>NPM (%)</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[0]['npm']."</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[0]['npm']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;text-align:right;'>".$financial_indicators[0]['npm']."</td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style='border-right: 1px solid #FFFFFF;font-size: 10; background-color: #D9D9D9;text-align:right;'>".$peer_comparision[0]['npm']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;text-align:right;'>".$peer_comparision[1]['npm']."</td>
                                           </tr>";
    $table_public_share_holders_major_promoters="";
    for($i=0;$i<=6;$i++) {
        if($i%2==0) {
            $table_public_share_holders_major_promoters .= "<tr>
                                                                <td style=' width: 45%; font-size: 10; background-color: #F2F2F2; border-right: 1px solid #FFFFFF;'>".substr($public_share_holders[$i]['share_holder_name'],0,35)."</td>
                                                                <td style='width:10%; font-size: 10; background-color: #F2F2F2;'>".$public_share_holders[$i]['share_holding']."</td>
                                                                <td style='width:0.5%;'>&nbsp;&nbsp;</td>
                                                                <td style='font-size: 10; background-color: #F2F2F2;border-right: 1px solid #FFFFFF;'>".substr($major_promoters[$i]['major_promoter_name'],0,35)."</td>
                                                                <td style='font-size: 10; background-color: #F2F2F2; text-align: right;'>".$major_promoters[$i]['share_holding']."</td>
                                                           </tr>";
        }
        else {
            $table_public_share_holders_major_promoters .= "<tr>
                                                                <td style='font-size: 10; background-color: #D9D9D9;border-right: 1px solid #FFFFFF;'>".substr($public_share_holders[$i]['share_holder_name'],0,35)."</td>
                                                                <td style='font-size: 10; background-color: #D9D9D9;'>".$public_share_holders[$i]['share_holding']."</td>
                                                                <td style='width:3%;'>&nbsp;&nbsp;</td>
                                                                <td style='font-size: 10; background-color: #D9D9D9;border-right: 1px solid #FFFFFF;'>".substr($major_promoters[$i]['major_promoter_name'],0,35)."</td>
                                                                <td style='font-size: 10; background-color: #D9D9D9; text-align: right;'>".$major_promoters[$i]['share_holding']."</td>
                                                           </tr>";
        }
    }
    $html = "<p style=''></p>";
    $html .="<table style='width:100%; border-collapse: collapse; margin:0; display: block;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 2px; padding-bottom: 2px; border-top: 2px solid #000000; border-bottom: 2px solid #000000; '>TABLE 2 - MARKET DATA (<span style='font-size: 9;'><i>As on []</i></span>)</td></tr>
                    <tr><td style='text-align: right; font-size: 10; background-color: #D9D9D9; border-bottom: 2px solid #000000; border-right: 1px solid #FFFFFF; border-right: 1px solid #FFFFFF;'>Price (<span style='font-family:Rupee Foradian; '>`</span>)</td><td style='text-align: left; font-size: 10; background-color: #D9D9D9; border-bottom: 2px solid #000000; border-right: 1px solid #FFFFFF;'>$market_data[price]</td><td style='text-align:right; font-size: 10; background-color: #D9D9D9; border-bottom: 2px solid #000000; border-right: 1px solid #FFFFFF;'>M Cap (<span style='font-family:Rupee Foradian; '>`</span> Cr.)</td><td style='text-align:left; font-size: 10; background-color: #D9D9D9; border-bottom: 2px solid #000000; border-right: 1px solid #FFFFFF;'>$market_data[market_capitalization]</td><td style='text-align:right;font-size: 10; background-color: #D9D9D9; border-bottom: 2px solid #000000; border-right: 1px solid #FFFFFF;'>Shares*</td><td style='text-align: left; font-size: 10; background-color: #D9D9D9; border-bottom: 2px solid #000000; border-right: 1px solid #FFFFFF;'>$market_data[shares]</td><td style='text-align: right; font-size: 10; background-color: #D9D9D9; border-bottom: 2px solid #000000; border-right: 1px solid #FFFFFF;'>PE Ratio\"</td><td style='text-align: left; font-size: 10;background-color: #D9D9D9; border-bottom: 2px solid #000000; border-right: 1px solid #FFFFFF;'>$market_data[pe_ratio]</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);

    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    $html = "<table style='border-collapse: collapse; width:100%; margin-bottom: 0; display: block;'>
                <tbody>
                    <tr><td colspan='4' style='font-size: 8; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'><i>Standalone Data ; Source: Capitaline</i></td><td>&nbsp;&nbsp;</td><td style='font-size: 8; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>* As on [date]</td><td colspan='2' style='font-size: 8; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>\"Based on EPS for FY []</td></tr>
                    <tr><td colspan='4' style='font-size: 10; padding-bottom: 2px; border-bottom: 2px solid #000000;'>TABLE 3: FINANCIAL INDICATORS (STANDALONE)</td><td>&nbsp;&nbsp;</td><td colspan='2' style='font-size: 10; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>TABLE 4: PEER COMPARISON (".$peer_comparision[0]['financial_year'].")</td></tr>
                    $table_financial_indicators
                    <tr><td colspan='4' style='font-size: 8; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'><i>Dividend pay-out includes Dividend Distribution Tax. Source: Capitaline</i></td><td>&nbsp;&nbsp;</td><td colspan='2' style='font-size: 8; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>&nbsp;</td></tr>";
    $html.="</table>";
    $docx->embedHTML($html);

    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    $html ="<table style='border-collapse: collapse; width:100%; margin: 0;'>
                <tr><td colspan='2' style='font-size: 10; padding-bottom: 2px; border-bottom: 2px solid #000000;'>TABLE 5: MAJOR PUBLIC SHAREOLDERS (MAR'15)</td><td>&nbsp;&nbsp;</td><td colspan='2' style='font-size: 10; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>TABLE 6: MAJOR PROMOTERS (MAR'15)</td></tr>
                $table_public_share_holders_major_promoters
                <tr><td colspan='2' style='font-size: 2; padding-top: 0px; padding-bottom: 0px; border-bottom: 2px solid #000000;'>&nbsp;</td><td>&nbsp;</td><td colspan='2' style='font-size: 2; padding-top: 0px; padding-bottom: 0px; border-bottom: 2px solid #000000;'>&nbsp;</td></tr>
                <tr><td colspan='2' style='font-size: 10; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>SHAREHOLDING PATTERN (%) (MARCH)</td><td>&nbsp;&nbsp;</td><td colspan='2' style='font-size: 10; padding-top: 2px; padding-bottom: 2px; border-bottom:2px solid #000000;'>DISCUSSION</td></tr>
              </table>";
    $docx->embedHTML($html);

    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    $new_fragment = new WordFragment($docx,"aslk");
    $new_fragment->addExternalFile(array('src'=>'ShareholdingPattern.docx'));

    $blank_fragment =  new WordFragment($docx,"aslk");
    $blank_fragment->addText("");

    $discussion_fragment =  new WordFragment($docx,"aslk");
    $discussion_fragment->embedHTML("<p style='padding-top: 8px; padding-bottom: 8px; margin: 0; font-size: 10;line-height:135%; text-align: justify; '>Discussion</p>");

    $valuesTable = array(
        array(
            array('value' =>$new_fragment, 'vAlign' => 'center'),
            array('value' =>$blank_fragment,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center'),
            array('value' =>$discussion_fragment, 'vAlign' => 'top','textAlign'=>'left'),
        )
    );
    $widthTableCols = array(
        5555,323,4240
    );
    $paramsTable = array(
        'border' => 'nil',
        'columnWidths' => $widthTableCols,
        'indent'=>108
    );
    $docx->addTable($valuesTable, $paramsTable);
}
function boardOfDirectorInfo($docx,$report_id) {
    $table_financial_indicators= "<tr>
                                        <td rowspan='2' style='width: 30%; border-right: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Director</td>
                                        <td rowspan='2' style='text-align:center; border-right: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>&nbsp;</td>
                                        <td colspan='2' style='text-align: center; border-right: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Classification</td>
                                        <td rowspan='2' style='text-align:center; vertical-align: middle; border-right: 1px solid #FFFFFF;color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Expertise/Specialization</td>
                                        <td rowspan='2' style='text-align:center; border-right: 1px solid #FFFFFF;color: #FFFFFF;font-weight: bold; font-size: 9; background-color: #464646;'>Tenure (Year)</td>
                                        <td rowspan='2' style='text-align:center; border-right: 1px solid #FFFFFF;color: #FFFFFF;font-weight: bold; font-size: 9; background-color: #464646;'><b><sup style='font-size: 9;'>[1]</sup></b>Directorship</td>
                                        <td rowspan='2' style='text-align:center; border-right: 1px solid #FFFFFF; color: #FFFFFF;font-weight: bold; font-size: 9; background-color: #464646;'><b><sup style='font-size: 9;'>[2]</sup></b>Committee Membership</td>
                                        <td rowspan='2' style='text-align:center; color: #FFFFFF;font-weight: bold; font-size: 9; background-color: #464646;'>Pay(<span style='font-family: Rupee Foradian;'>`</span> Lakh)</td>
                                    </tr>";
    $table_financial_indicators .="<tr>
                                        <td style='text-align: center; border-right: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Company</td>
                                        <td style='text-align:center; border-right: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>SES</td>
                                    </tr>";
    $db = new ReportBurning();
    $company_id = $_SESSION['company_id'];
    $financial_year = $_SESSION['report_year'];
    $generic = $db->companyBoardOfDirectors($report_id,$company_id,$financial_year);
    $board_directors = $generic['board_directors'];
    $standard_text = $generic['standard_text']['standard_text'];
    $liable_text = $generic['standard_text']['liable_analysis_text'];
    $board_text = $generic['standard_text']['board_analysis_text'];
    $analysis_text = $generic['analysis_text']['analysis_text'];
    $company_name = $generic['company_name'];
    $i=1;
    foreach($board_directors as $director) {
        if($i%2==1) {
            $table_financial_indicators.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 9; background-color: #F2F2F2;'>$director[dir_name]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #F2F2F2;'>$director[appointment]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #F2F2F2;'>$director[company_classfification]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF;font-size: 9; background-color: #F2F2F2;'>$director[ses_classification]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #F2F2F2;'>$director[expertise]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #F2F2F2;'>$director[tenure]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF;font-size: 9; background-color: #F2F2F2;'>$director[directorship]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #F2F2F2;'>$director[comm_membership]</td>
                                            <td style='text-align:center; font-size: 9; background-color: #F2F2F2;'>$director[pay]</td>
                                           </tr>";
        }
        else {
            $table_financial_indicators.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 9; background-color: #D9D9D9;'>$director[dir_name]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #D9D9D9;'>$director[appointment]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #D9D9D9;'>$director[company_classfification]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF;font-size: 9; background-color: #D9D9D9;'>$director[ses_classification]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #D9D9D9;'>$director[expertise]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #D9D9D9;'>$director[tenure]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF;font-size: 9; background-color: #D9D9D9;'>$director[directorship]</td>
                                            <td style='text-align:center; border-right: 1px solid #FFFFFF;font-size: 9; background-color: #D9D9D9;'>$director[comm_membership]</td>
                                            <td style='text-align:center; font-size: 9; background-color: #D9D9D9;'>$director[pay]</td>
                                           </tr>";
        }
        $i++;
    }
    $table_financial_indicators.="<tr><td colspan='9' style='font-size: 8; padding-top: 5px; padding-bottom: 5px; '><i>Reference: ED - Executive Director, NED- Non-Executive Director, ID - Independent Director, NID- Non-Independent Director, P- Promoter, W - Woman Director, R- Liable to retire by Rotation, U- Up for Re-appointment, N- New Appointment, MD- Managing Director, C- Chairman, CMD- Chairman and Managing Director <br/><b>[1]</b> Directorships show Directorships in Public Companies (Total Directorships which include Directorships in both Public and Private Companies) <br/><b>[2]</b> Committee memberships include committee chairmanships</i>";
    $table_financial_indicators.="<br/><i>Note: Directorships, committee membership and committee chairmanship includes such positions in $company_name</i></td></tr>";
    $table_financial_indicators.="<tr><td colspan='9' style='font-size: 9;'>".htmlParserForTable($standard_text,9)."</td></tr>";
    $html = "<p style=''></p>";
    $html .= "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    <tr><td colspan='9' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000; border-bottom: 2px solid #000000; '>TABLE 7 - BOARD PROFILE </td></tr>
                    $table_financial_indicators
                    <tr><td colspan='9' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-bottom: 2px solid #000000; border-top: 2px solid #000000; '>GRAPH 2 - BOARD PROFILE</td></tr>
                </tbody>
              </table>";
    $docx->embedHTML($html);

    // Graph
    $retire_fragment = new WordFragment($docx,"aslk");
    $retire_fragment->addExternalFile(array('src'=>'RetireByRotation.docx'));
    $board_compositions_fragment = new WordFragment($docx,"aslk");
    $board_compositions_fragment->addExternalFile(array('src'=>'BoardComposition.docx'));
    $retire_fragment_text = new WordFragment($docx,"standardtext");

    $retire_fragment_text->embedHTML("<p style='font-size: 9; margin 0; line-height:135%; padding: 0; text-align: justify; '>As per provisions of Section 149 and 152 of the Companies Act, 2013 Independent Directors shall not be liable to retire by rotation and unless provided by the Articles of the Company at least 2/3rd of the Non-Independent Directors should be liable to retire by rotation.</p>");
    $retire_fragment_text->embedHTML(htmlParserForTable($liable_text,9));

    $board_compositions_fragment_text = new WordFragment($docx,"standardtext");
    $board_compositions_fragment_text->embedHTML("<p style='font-size: 9; margin 0; line-height:135%; padding: 0; text-align: justify; '>As per Clause 49(ii)(A) of the Listing Agreement, the Company should have at least 33% Independent Directors if the Chairman of the Board is a Non-Executive Director and should have at least 50% independent directors if the Board Chairman is a promoter or an executive director.</p>");
    $board_compositions_fragment_text->embedHTML(htmlParserForTable($board_text,9));

    $valuesTable = array(
        array(
            array('value' =>$retire_fragment, 'vAlign' => 'center','textAlign'=>'center','borderRight' => 'single','borderRightWidth'=>3,'borderRightColor' => '999999'),
            array('value' =>$board_compositions_fragment, 'vAlign' => 'center','textAlign'=>'center'),
        ),
        array(
            array('value' =>$retire_fragment_text,'borderRight' => 'single','borderRightWidth'=>3,'borderRightColor' => '999999'),
            array('value' =>$board_compositions_fragment_text)
        )
    );
    $widthTableCols = array(
        7000,7000
    );
    $paramsTable = array(
        'border' => 'nil',
        'indent'=>108,
        'columnWidths' => $widthTableCols
    );
    $docx->addTable($valuesTable, $paramsTable);

    // Graph End


    $docx->addBreak(array('type' => 'column'));
    $board_committee_performance= "<tr>
                                        <td rowspan='2' style='width: 25%; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Committees</td>
                                        <td rowspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>#</td>
                                        <td colspan='2' style='text-align: center; border-bottom: 2px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Chairman's Classification</td>
                                        <td colspan='2' style='text-align: center;  border-bottom: 2px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Overall Independence</td>
                                        <td rowspan='2' style='text-align: center;color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Number of Meetings</td>
                                        <td rowspan='2' style='width: 25%;text-align: center; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Attendance < 75%</td>
                                    </tr>";
    $board_committee_performance .= "<tr>
                                        <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Company </td>
                                        <td style='text-align:center; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>SES</td>
                                        <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Company </td>
                                        <td style='text-align:center; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>SES</td>
                                    </tr>";

    $committee_performance = $generic['committee_performance'];
    if($generic['is_rem_nom_same']=='yes') {
        $array_committees = array("Audit","Investors' Grievance","Nomination &amp; Remuneration","CSR","Risk Committee");
    }
    else {
        $array_committees = array("Audit","Investors' Grievance","Remuneration","Nomination","CSR","Risk Committee");
    }
    for($i=0;$i<count($array_committees);$i++) {
        if($i%2==0) {
            $board_committee_performance.="<tr>
                                               <td style=' font-size: 9; background-color: #F2F2F2; text-align: left; border-right: 1px solid #FFF;'>$array_committees[$i]</td>
                                               <td style='font-size: 9; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['total']."</td>
                                               <td style='font-size: 9; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['chairman_com_classification']."</td>
                                               <td style='font-size: 9; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['chairman_ses_classification']."</td>
                                               <td style='font-size: 9; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['overall_com_independence']."%</td>
                                               <td style='font-size: 9; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['overall_ses_independence']."%</td>
                                               <td style='font-size: 9; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['no_meetings']."</td>
                                               <td style='font-size: 9; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['attendance_less_75']."</td>
                                           </tr>";
        }
        else {
            $board_committee_performance.="<tr>
                                            <td style=' font-size: 9; background-color: #D9D9D9;  text-align: left; border-right: 1px solid #FFF;'>$array_committees[$i]</td>
                                            <td style='font-size: 9; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['total']."</td>
                                            <td style='font-size: 9; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['chairman_com_classification']."</td>
                                            <td style='font-size: 9; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['chairman_ses_classification']."</td>
                                            <td style='font-size: 9; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['overall_com_independence']."%</td>
                                            <td style='font-size: 9; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['overall_ses_independence']."%</td>
                                            <td style='font-size: 9; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['no_meetings']."</td>
                                            <td style='font-size: 9; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$committee_performance[$i]['attendance_less_75']."</td>
                                          </tr>";
        }
    }
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000;border-bottom: 2px solid #000000; '>TABLE 8 - BOARD COMMITTEE PERFORMANCE</td></tr>
                    $board_committee_performance
                    <tr><td colspan='8' style='font-size: 8; padding-top: 5px; padding-bottom: 5px;'><i>Reference: ED - Executive Director, NED- Non-Executive Director, ID - Independent Director, NID- Non-Independent Director, P- Promoter, C- Chairman, #- Number of Members</i></td></tr>
                    <tr><td colspan='9' style='font-size: 9;'>".htmlParserForTable($analysis_text,9)."</td></tr>
                </tbody>
              </table>";
    $docx->embedHTML($html);
    $board_governance_score= "<tr>
                                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Criteria</td>
                                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Response</td>
                                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Score</td>
                                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Maximum</td>
                            </tr>";

    $array_gov_score_questions = array(
        "What is the percentage of Independent Directors on the Board?",
        "How many Independent Directors have tenure greater than 10 years?",
        "How many Independent Directors have Shareholdings &gt; <span style='font-family: Rupee Foradian;'>`</span> 1 Cr?",
        "Is the Chairman Independent?",
        "Is there a Lead Independent Director?",
        "How many Independent Directors are ex-executive of the Company?",
        "Have all directors been elected by the Company's shareholders?",
        "Are any directors on the Board related to each other?",
        "How many promoter directors are on the Board?",
        "Did Independent Directors meet atleast once without management?"
    );
    $array_max_values = array(10,10,5,10,10,10,10,10,15,10);
    $score_value = 0;
    $governance_score = $generic['board_governance_score'];
    for($i=0;$i<count($governance_score);$i++) {
        $percentage = "";
        if($i==0) {
            $percentage = "%";
        }
        if($i%2==0) {
            $board_governance_score.="<tr>
                                        <td style=' font-size: 9; background-color: #F2F2F2; text-align: left; border-right: 1px solid #FFF;'>$array_gov_score_questions[$i]</td>
                                        <td style='font-size: 9; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".ucfirst($governance_score[$i]['response']).$percentage."</td>
                                        <td style='font-size: 9; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$governance_score[$i]['score']."</td>
                                        <td style='font-size: 9; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>$array_max_values[$i]</td>
                                    </tr>";
        }
        else {
            $board_governance_score.="<tr>
                                        <td style=' font-size: 9; background-color: #D9D9D9; text-align: left; border-right: 1px solid #FFF;'>$array_gov_score_questions[$i]</td>
                                        <td style='font-size: 9; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".ucfirst($governance_score[$i]['response']).$percentage."</td>
                                        <td style='font-size: 9; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$governance_score[$i]['score']."</td>
                                        <td style='font-size: 9; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>$array_max_values[$i]</td>
                                    </tr>";
        }
        $score_value+=intval($governance_score[$i]['score']);
    }
    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    //$docx->addSection('continuous','A4', array('marginRight' => '1000','marginLeft' => '1000','marginTop'=>0,'marginBottom'=>0,'marginHeader'=>'200','marginFooter'=>'0'));
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000;border-bottom: 1px solid #000000; '>TABLE 9 - BOARD GOVERNANCE SCORE</td></tr>
                    $board_governance_score
                    <tr><td colspan='2' style='font-size: 9; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000; border-bottom: 1px solid #000000; font-weight: bold;'>Score</td><td style='font-size: 9; padding-top: 5px; text-align: center; padding-bottom: 5px; border-top: 2px solid #000000; border-bottom: 1px solid #000000; font-weight: bold;'>$score_value</td><td style='font-size: 9; text-align: center; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000; border-bottom: 1px solid #000000; font-weight: bold;'>100</td></tr>
                </tbody>
              </table>";
    $docx->embedHTML($html);
}
function remunerationAnalysis($docx,$report_id) {
    $db = new ReportBurning();
    $generic = $db->remunerationAnalysis($report_id);
    $remuneration_analysis_data = $generic['remuneration_analysis'];
    $analysis_text = $generic['analysis_text_1'];
    $analysis_text_2 = $generic['analysis_text_2'];
    $remuneration_analysis= "<tr>
                                <td colspan='2' style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>In <span style='font-family: Rupee Foradian;'>`</span> Crore</td>
                                <td colspan='2' style='border-bottom: 2px solid #FFF; border-left: 1px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>".$remuneration_analysis_data[0]['rem_first_year']."</td>
                                <td colspan='2' style='border-bottom: 2px solid #FFF; border-left: 1px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>".$remuneration_analysis_data[0]['rem_second_year']."</td>
                                <td colspan='2' style='border-bottom: 2px solid #FFF; border-left: 1px solid #FFF; border-right: 1px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>".$remuneration_analysis_data[0]['rem_third_year']."</td>
                                <td style='vertical-align: middle; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Ratio</td>
                            </tr>";
    $remuneration_analysis .= "<tr>
                                    <td colspan='2' style='border-right: 1px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>&nbsp;</td>
                                    <td style='border-right: 1px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Fixed Pay</td>
                                    <td style='border-right: 1px solid #FFF; text-align:center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Total Pay</td>
                                    <td style='border-right: 1px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Fixed Pay</td>
                                    <td style='border-right: 1px solid #FFF; text-align:center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Total Pay</td>
                                    <td style='border-right: 1px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Fixed Pay</td>
                                    <td style='border-right: 1px solid #FFF; text-align:center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Total Pay</td>
                                    <td style='border-bottom: 2px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>&nbsp;</td>
                                </tr>";

    for($i=0;$i<count($remuneration_analysis_data);$i++) {
        if($i%2==0) {
            $remuneration_analysis.="<tr>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$remuneration_analysis_data[$i]['director_name']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #F2F2F2;'>".$remuneration_analysis_data[$i]['promoter_non_promoter']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #F2F2F2;'>".$remuneration_analysis_data[$i]['fixed_pay_first_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #F2F2F2;'>".$remuneration_analysis_data[$i]['total_pay_first_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #F2F2F2;'>".$remuneration_analysis_data[$i]['fixed_pay_second_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #F2F2F2;'>".$remuneration_analysis_data[$i]['total_pay_second_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #F2F2F2;'>".$remuneration_analysis_data[$i]['fixed_pay_third_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #F2F2F2;'>".$remuneration_analysis_data[$i]['total_pay_third_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #F2F2F2;'>".$remuneration_analysis_data[$i]['ratio']."</td>
                                       </tr>";
        }
        else {
            $remuneration_analysis.="<tr>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$remuneration_analysis_data[$i]['director_name']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #D9D9D9;'>".$remuneration_analysis_data[$i]['promoter_non_promoter']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #D9D9D9;'>".$remuneration_analysis_data[$i]['fixed_pay_first_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #D9D9D9;'>".$remuneration_analysis_data[$i]['total_pay_first_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #D9D9D9;'>".$remuneration_analysis_data[$i]['fixed_pay_second_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #D9D9D9;'>".$remuneration_analysis_data[$i]['total_pay_second_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #D9D9D9;'>".$remuneration_analysis_data[$i]['fixed_pay_third_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #D9D9D9;'>".$remuneration_analysis_data[$i]['total_pay_third_year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; text-align:center; font-size: 10; background-color: #D9D9D9;'>".$remuneration_analysis_data[$i]['ratio']."</td>
                                       </tr>";
        }
    }
    $html = "<p style=''></p>";
    $html .= "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    <tr><td colspan='9' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000;border-bottom: 2px solid #000000; '>TABLE 10 - EXECUTIVE DIRECTORS' REMUNERATION</td></tr>
                    $remuneration_analysis
                    <tr><td colspan='9' style='border-top: 2px solid #000; font-size: 8; padding-top: 5px; padding-bottom: 5px; '><i>Note: Fixed pay includes basic pay, perquisites &amp; allowances. P- Promoter, NP- Non- Promoter, Ratio- Ratio of ED's remuneration to Median Remuneration of Employees, ND- Not Disclosed</i></td></tr>
                    <tr><td colspan='9' style='font-size: 9;'>".htmlParserForTable($analysis_text['analysis_text'],9)."</td></tr>
                    <tr><td colspan='9' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000; border-bottom: 2px solid #000000; '>DISCUSSION - INDEXED TSR vs. EXECUTIVE REMUNERATION</td></tr>
                </tbody>
              </table>";
    $docx->embedHTML($html);

    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    // Graph start

    $retire_fragment = new WordFragment($docx,"aslk");
    $retire_fragment->addExternalFile(array('src'=>'ExecutiveCompensation.docx'));
    $board_compositions_fragment = new WordFragment($docx,"aslk");
    $board_compositions_fragment->addExternalFile(array('src'=>'VariationInDirectorsRemuneration.docx'));
    $valuesTable = array(
        array(
            array('value' =>$retire_fragment, 'vAlign' => 'center'),
            array('value' =>$board_compositions_fragment, 'vAlign' => 'center'),
        )
    );
    $widthTableCols = array(
        7000,7000
    );
    $paramsTable = array(
        'border' => 'nil',
        'borderWidth' => 8,
        'borderColor' => 'cccccc',
        'columnWidths' => $widthTableCols
    );
    $docx->addTable($valuesTable, $paramsTable);

    $docx->embedHTML("<p style='margin: 0; text-align: justify; padding: 0; font-size: 8;'><i>Note: Indexed TSR (Total Shareholders Return) represents the value of <span style='font-family: Rupee Foradian;'>`</span> 100 invested in the Company at beginning of a 5-year period starting 1st April, 2011. One period return is calculated as (Final Price - Initial Price + Dividend) / Initial Price.</i></p>");

    // Graph end


    $executive_remuneration_data = $generic['executive_remuneration'];
    $executive_remuneration= "<tr>
                                <td style='border-bottom: 2px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>&nbsp;</td>
                                <td style='border-bottom: 2px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646; border-right: 1px solid #FFF;'>".$executive_remuneration_data[0]['company_name']."</td>
                                <td style='border-bottom: 2px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646; border-right: 1px solid #FFF;'>".$executive_remuneration_data[1]['company_name']."</td>
                                <td style='border-bottom: 2px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>".$executive_remuneration_data[2]['company_name']."</td>
                            </tr>";

    $array_executive_rows_heading = array(
        "Director Name",
        "Promoter Group",
        "Remuneration (<span style='font-family:Rupee Foradian;'>`</span> Crore) (A)",
        "Net Profits (<span style='font-family:Rupee Foradian;'>`</span> Crore) (B)",
        "Rem. Percentage (A/B * 100)"
    );
    $executive_remuneration.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$array_executive_rows_heading[0]."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$executive_remuneration_data[0]['director_name']."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$executive_remuneration_data[1]['director_name']."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$executive_remuneration_data[2]['director_name']."</td>
                               </tr>";

    $executive_remuneration.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$array_executive_rows_heading[1]."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".ucfirst($executive_remuneration_data[0]['promoter_group'])."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".ucfirst($executive_remuneration_data[1]['promoter_group'])."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".ucfirst($executive_remuneration_data[2]['promoter_group'])."</td>
                               </tr>";
    $executive_remuneration.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$array_executive_rows_heading[2]."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$executive_remuneration_data[0]['remuneration']."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$executive_remuneration_data[1]['remuneration']."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$executive_remuneration_data[2]['remuneration']."</td>
                               </tr>";

    $executive_remuneration.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$array_executive_rows_heading[3]."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$executive_remuneration_data[0]['net_profits']."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$executive_remuneration_data[1]['net_profits']."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$executive_remuneration_data[2]['net_profits']."</td>
                               </tr>";
    $executive_remuneration.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; border-bottom: 2px solid #000; font-size: 10; background-color: #F2F2F2;'>".$array_executive_rows_heading[4]."</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; border-bottom: 2px solid #000; font-size: 10; background-color: #F2F2F2;'>".$executive_remuneration_data[0]['rem_percentage']."%</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; border-bottom: 2px solid #000; font-size: 10; background-color: #F2F2F2;'>".$executive_remuneration_data[1]['rem_percentage']."%</td>
                                <td style='text-align:center; border-right: 1px solid #FFFFFF; border-bottom: 2px solid #000; font-size: 10; background-color: #F2F2F2;'>".$executive_remuneration_data[2]['rem_percentage']."%</td>
                               </tr>";

    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000;border-bottom: 2px solid #000000; '>TABLE 11- EXECUTIVE REMUNERATION - PEER COMPARISON</td></tr>
                    $executive_remuneration
                </tbody>
              </table>";
    $docx->embedHTML($html);
    if($analysis_text_2['analysis_text']!="" && $analysis_text_2['analysis_text']!="&nbsp;") {
        $docx->embedHTML(htmlParser($analysis_text_2['analysis_text']));
    }
}
function disclosures($docx,$report_id){
    $db = new ReportBurning();
    $generic = $db->disclosures($report_id);
    $disclosures_data = $generic['disclosures'];
    $analysis_text = $generic['analysis_text'];
    $questions = array(
        "Content of Corporate Social Responsibility Policy in prescribed format (if applicable)",
        "Statement on performance evaluation of Board, Committees and Directors",
        "Extract of the Annual Return as per Form No. MGT 9",
        "Related Party Transactions as per Form No. AOC.2",
        "Company's policy on appointment of directors and criteria for determining qualifications, positive attributes, director’s independence",
        "Ratio of the remuneration of executive director to the median employees remuneration",
        "Policy on remuneration of Directors, KMP and other employees",
        "Secretarial Audit Report",
        "Statement on declaration by Independent Directors",
        "Directors’ Responsibility Statement",
        "Particulars of loans, guarantees or investments",
        "Details of establishment of Vigil Mechanism",
        "Statement indicating development and implementation of a risk management policy",
        "Comments on qualifications made by Statutory Auditors/ CS"
    );
    $html = "<p style='font-size: 10'></p>";
    $html .="<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    <tr><td colspan='5' style='font-weight: bold; font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000; '>DISCLOSURE REQUIRED IN DIRECTOR'S REPORT</td></tr>
                    <tr><td colspan='5' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000; text-align: justify;'>The Companies Act, 2013 requires the listed companies to make certain disclosures in Board's Report. The table below shows the status of compliance of such some important requirements, by the Company</td></tr>
                </tbody>
              </table>";
    $docx->embedHTML($html);
    $docx->embedHtml("<p style='font-size: 2;'>&nbsp;</p>");
    for($i=0;$i<14;$i=$i+2) {

        if($disclosures_data[$i]['status']=='disclosed') {
            $temp_fragment1 = new WordFragment($docx,"aslk");
            $temp_fragment1->addImage(array('src'=>'checked.png'));
        }
        elseif($disclosures_data[$i]['status']=='not disclosed') {
            $temp_fragment1 = new WordFragment($docx,"aslk");
            $temp_fragment1->addImage(array('src'=>'unchecked.png'));
        }
        else {
            $temp_fragment1 = new WordFragment($docx,"aslk");
            $temp_fragment1->addImage(array('src'=>'na.png'));
        }

        if($disclosures_data[$i+1]['status']=='disclosed') {
            $temp_fragment3 = new WordFragment($docx,"aslk");
            $temp_fragment3->addImage(array('src'=>'checked.png'));
        }
        elseif($disclosures_data[$i+1]['status']=='not disclosed') {
            $temp_fragment3 = new WordFragment($docx,"aslk");
            $temp_fragment3->addImage(array('src'=>'unchecked.png'));
        }
        else {
            $temp_fragment3 = new WordFragment($docx,"aslk");
            $temp_fragment3->addImage(array('src'=>'na.png'));
        }

        $temp_fragment2 = new WordFragment($docx,"aslk");
        $temp_fragment2->addText($questions[$i],array('fontSize'=>10));
        $temp_fragment4 = new WordFragment($docx,"aslk");
        $temp_fragment4->addText($questions[$i+1],array('fontSize'=>10));
        $blank_fragment =  new WordFragment($docx,"aslk");
        $blank_fragment->addText(" ");
        if($i==0) {
            $valuesTable[] =
                array(
                    array('value' =>$temp_fragment1,'fontSize' => 10 ,'vAlign' => 'center','textAlign'=>'center','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => '000000'),
                    array('value' =>$temp_fragment2, 'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => '000000'),
                    array('value' =>$blank_fragment,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => '000000'),
                    array('value' =>$temp_fragment3, 'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => '000000'),
                    array('value' =>$temp_fragment4,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => '000000')
                );
        }
        else if($i!=12) {
            $valuesTable[] =
                array(
                    array('value' =>$temp_fragment1,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => 'D9D9D9'),
                    array('value' =>$temp_fragment2,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => 'D9D9D9'),
                    array('value' =>$blank_fragment,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center'),
                    array('value' =>$temp_fragment3,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => 'D9D9D9'),
                    array('value' =>$temp_fragment4,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => 'D9D9D9')
                );
        }
        if($i==12) {
            $valuesTable[] =
                array(
                    array('value' =>$temp_fragment1,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderBottom' => 'single','borderBottomWidth'=>13,'borderBottomColor' => '000000','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => 'D9D9D9'),
                    array('value' =>$temp_fragment2,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderBottom' => 'single','borderBottomWidth'=>13,'borderBottomColor' => '000000','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => 'D9D9D9'),
                    array('value' =>$blank_fragment,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderBottom' => 'single','borderBottomWidth'=>13,'borderBottomColor' => '000000'),
                    array('value' =>$temp_fragment3,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderBottom' => 'single','borderBottomWidth'=>13,'borderBottomColor' => '000000','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => 'D9D9D9'),
                    array('value' =>$temp_fragment4,'fontSize' => 10, 'vAlign' => 'center','textAlign'=>'center','borderBottom' => 'single','borderBottomWidth'=>13,'borderBottomColor' => '000000','borderTop' => 'single','borderTopWidth'=>13,'borderTopColor' => 'D9D9D9')
                );
        }
        $row_array[] = array('minHeight'=>800);
    }

    $widthTableCols = array(
        200,7000,50,200,10000
    );
    $paramsTable = array(
        'border' => 'nil',
        'indent'=>108,
        'fontSize' => 10,
        'borderColor' => 'cccccc',
        'columnWidths' => $widthTableCols
    );
    $docx->addTable($valuesTable, $paramsTable,$row_array);
    $docx->embedHTML("<p style='margin: 0; padding: 0; text-align: justify; font-size: 9;'><i>* Not applicable</i></p>");
    $docx->embedHTML("<p style='margin: 0; padding-top: 8px; padding-bottom: 8px; text-align: justify; line-height: 135%; font-size: 10;'>".$analysis_text['analysis_text']."</p>");
}
function adoptionOfAccounts($docx,$report_id) {

    $db = new ReportBurning();
    $generic_array = $db->adoptionOfAccount($report_id);
    if($generic_array['adoption_of_account_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $triggers = $generic_array['triggers'];
        $analysis_text = $generic_array['analysis_text'];
        $unaudited_statements_table = $generic_array['unaudited_statements_table'];
        $financial_indicators = $generic_array['financial_indicators'];
        $contingent_liabilities = $generic_array['contingent_liabilities'];
        $adoption_of_accounts_rpt = $generic_array['adoption_of_accounts_rpt'];
        $standalone_consolidated_acc = $generic_array['standalone_consolidated_acc'];

        $docx->addBreak(array('type' => 'page'));
        global $resolution_text_box;
        if($resolution_text_box) {
            $text_box_5 = "<p style='font-size: 18; padding: 0; margin: 0; color: #FFF; text-align: center; font-family: Cambria;'><span style='font-size: 20;'>R</span>ESOLUTION <span style='font-size: 20;'>A</span>NALYSIS</p>";
            addOrangeTextBox($docx,$text_box_5);
            $resolution_text_box = false;
        }

        $p_text = "<p style='font-size: 10;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: ADOPTION OF ACCOUNTS",1);
        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",1);
        $docx->embedHtml(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",2);
        $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 9;'><p style='line-height: 135%; margin:0; padding-top: 8px; padding-bottom: 8px;'><i>Note: Detailed analysis of the accounts is not within the scope of SES' activities. SES accepts the Report of the Directors and the Auditors to be true and fair representation of the company's financial position. The analysis below is aimed at enabling shareholders engage in discussions with the Board/ Management during the AGM.</i></p></td></tr>
                </tbody>
            </table>";
        $docx->embedHTML($html);
        resBlackStrip($docx,"AUDIT QUALIFICATIONS");
        if($triggers[0]['triggers']=='yes') {
            $audit_text = "";
            for($i=0;$i<3;$i++) {
                if($analysis_text[$i]['analysis_text']!="")
                    $audit_text .= $analysis_text[$i]['analysis_text'];
            }
            $docx->embedHTML(htmlParser($audit_text));
        }
        else {
            $audit_text = "";
            for($i=3;$i<=3;$i++) {
                if($analysis_text[$i]['analysis_text']!="")
                    $audit_text .= $analysis_text[$i]['analysis_text'];
            }
            $docx->embedHTML(htmlParser($audit_text));
        }

        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"AUDITORS' COMMENTS ON STANDALONE ACCOUNTS");

        if($triggers[1]['triggers']=='yes') {
            $docx->embedHTML(htmlParser($analysis_text[4]['analysis_text']));
        }
        else {
            $docx->embedHTML(htmlParser($analysis_text[5]['analysis_text']));
        }

        if($triggers[2]['triggers']=='yes' && $triggers[3]['triggers']=='yes') {
            resBlackStrip($docx,"AUDITORS' COMMENTS ON CONSOLIDATED ACCOUNTS");
            $docx->embedHTML(htmlParser($analysis_text[6]['analysis_text']));
        }
        if($triggers[4]['triggers']=='yes') {
            $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
            $text= "<tr>
                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Consolidated Entity (all figures in <span style='font-family: Rupee Foradian;'>`</span> Cr.)</td>
                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>Total Assets</td>
                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>Total Revenue</td>
                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>Net Profit</td>
                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Net Cash Flow</td>
                </tr>";
            for($i=0;$i<count($unaudited_statements_table);$i++) {
                if($i%2==0) {
                    $text.="<tr>
                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$unaudited_statements_table[$i]['field_name']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$unaudited_statements_table[$i]['total_assets']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$unaudited_statements_table[$i]['total_revenue']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$unaudited_statements_table[$i]['net_profit']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$unaudited_statements_table[$i]['net_cash_flow']."</td>
                           </tr>";
                }
                else {
                    $text.="<tr>
                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$unaudited_statements_table[$i]['field_name']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$unaudited_statements_table[$i]['total_assets']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$unaudited_statements_table[$i]['total_revenue']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$unaudited_statements_table[$i]['net_profit']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$unaudited_statements_table[$i]['net_cash_flow']."</td>
                           </tr>";
                }
            }
            $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                    <tbody>
                        $text
                    </tbody>
              </table>";
            $docx->embedHTML($html);
            $docx->embedHTML(htmlParser($other_text[1]['text']));
        }
        resBlackStrip($docx,"ACCOUNTING POLICIES");
        $docx->embedHTML(htmlParser($other_text[2]['text']));
        resBlackStrip($docx,"FINANCIAL INDICATORS");
        $docx->embedHTML("<p style='font-size:1;'>&nbsp;</p>");

        $text= "<tr>
                <td style='text-align: center;  width:25%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>&nbsp;</td>
                <td style='text-align: center;  width:10%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>".$generic_array['fiscal_month']."' ".substr($financial_indicators[0]['year1'],2,2)."</td>
                <td style='text-align: center;  width:10%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>".$generic_array['fiscal_month']."' ".substr($financial_indicators[0]['year2'],2,2)."</td>
                <td style='text-align: center;  width:10%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>Shift</td>
                <td style='text-align: center; width:45%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Company's Discussion</td>
            </tr>";
        for($i=0;$i<count($financial_indicators);$i++) {
            if($i%2==0) {
                $text.="<tr>
                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$financial_indicators[$i]['field_name']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$financial_indicators[$i]['fi_current']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$financial_indicators[$i]['fi_previous']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$financial_indicators[$i]['shift']."%</td>
                            <td style='text-align:justify; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #F2F2F2;'>".$financial_indicators[$i]['company_discussion']."</td>
                           </tr>";
            }
            else {
                $text.="<tr>
                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$financial_indicators[$i]['field_name']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$financial_indicators[$i]['fi_current']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$financial_indicators[$i]['fi_previous']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$financial_indicators[$i]['shift']."%</td>
                            <td style='text-align:justify; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #D9D9D9;'>".$financial_indicators[$i]['company_discussion']."</td>
                           </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $text
                    <tr><td colspan='5' style='text-align:left; font-size: 8;'><i>Source: Company's Annual Reports / Capitaline/ Moneycontrol</i></td></tr>
                </tbody>
              </table>";
        $docx->embedHTML($html);
        $text ="<p style='font-size: 9; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0; '>SES is of the opinion that board should take note of structural shift (positive and negative both) in various financial parameters which have a bearing on company's future performance and positioning in market place and disclose an analysis of the same to shareholders. SES believes that 25% change either way should be the threshold for triggering analysis and disclosure requirements.</p>";
        $docx->embedHTML($text);

        resBlackStrip($docx,"CONTINGENT LIABILITIES");
        $docx->embedHTML("<p style='font-size:1;'>&nbsp;</p>");
        $text= "<tr>
                <td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>(All figures in <span style='font-family: Rupee Foradian;'>`</span> Crore)</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>".$generic_array['fiscal_month']."' ".substr($contingent_liabilities[0]['year1'],2,2)."</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>".$generic_array['fiscal_month']."' ".substr($contingent_liabilities[0]['year2'],2,2)."</td>
            </tr>";
        $array_contingent_liabilities_cols = array(
            'Total contingent liabilities',
            'Net worth of the Company',
            'Contingent liabilities as a percentage of net worth'
        );
        for($i=0;$i<count($contingent_liabilities);$i++) {
            if($i%2==0) {
                $text.="<tr>
                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$array_contingent_liabilities_cols[$i]."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$contingent_liabilities[$i]['cl_current_year']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$contingent_liabilities[$i]['cl_previous_year']."</td>
                           </tr>";
            }
            else {
                $text.="<tr>
                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$array_contingent_liabilities_cols[$i]."</td>
                        <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$contingent_liabilities[$i]['cl_current_year']."</td>
                        <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$contingent_liabilities[$i]['cl_previous_year']."</td>
                       </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $text
                    <tr><td colspan='5' style='text-align:left; font-size: 8;'><i>Source: Company's Annual Reports/ Capitaline</i></td></tr>
                </tbody>
              </table>";
        $docx->embedHTML($html);
        $docx->embedHTML(htmlParser($other_text[4]['text']));

        resBlackStrip($docx,"RELATED PARTY TRANSACTIONS");
        $docx->embedHTML("<p style='font-size:1;'>&nbsp;</p>");

        $text= "<tr>
                <td style='text-align: center; width: 35%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Outstanding (<span style='font-family: Rupee Foradian;'>`</span> Crore)</td>
                <td style='text-align: center; width: 10%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>".$generic_array['fiscal_month']."' ".substr($adoption_of_accounts_rpt[0]['rpt_year1'],2,2)."</td>
                <td style='text-align: center; width: 10%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>".$generic_array['fiscal_month']."' ".substr($adoption_of_accounts_rpt[0]['rpt_year2'],2,2)."</td>
                <td style='text-align: center; border-right: 1px solid #FFF; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Shift</td>
                <td style='text-align: center; width: 45%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Comments</td>
            </tr>";
        for($i=0;$i<count($adoption_of_accounts_rpt);$i++) {
            if($i%2==0) {
                $text.="<tr>
                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$adoption_of_accounts_rpt[$i]['field_name']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$adoption_of_accounts_rpt[$i]['rpt_current_year']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$adoption_of_accounts_rpt[$i]['rpt_previous_year']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$adoption_of_accounts_rpt[$i]['shift']."</td>
                            <td style='text-align:justify; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #F2F2F2;'>".$adoption_of_accounts_rpt[$i]['rpt_comments']."</td>
                           </tr>";
            }
            else {
                $text.="<tr>
                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$adoption_of_accounts_rpt[$i]['field_name']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$adoption_of_accounts_rpt[$i]['rpt_current_year']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$adoption_of_accounts_rpt[$i]['rpt_previous_year']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #D9D9D9;'>".$adoption_of_accounts_rpt[$i]['shift']."</td>
                            <td style='text-align:justify; border-right: 1px solid #FFFFFF; font-size: 9; background-color: #D9D9D9;'>".$adoption_of_accounts_rpt[$i]['rpt_comments']."</td>
                           </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $text
                    <tr><td colspan='5' style='text-align:left; font-size: 8;'><i>Source: Company's Annual Reports</i></td></tr>
                </tbody>
              </table>";
        $docx->embedHTML($html);
        $docx->embedHTML(htmlParser($other_text[5]['text']));

        // standalone vs consolidated accounts

        $standalone_consolidated_acc_str= "<tr>
                                        <td rowspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>(In <span style='font-family: Rupee Foradian;'>`</span> Crore)</td>
                                        <td colspan='3' style='text-align: center; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFFFFF; font-size: 10; background-color: #808080;'>Standalone Accounts</td>
                                        <td colspan='3' style='text-align: center; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFFFFF; font-size: 10; background-color: #808080;'>Consolidated Accounts</td>
                                    </tr>";
        $standalone_consolidated_acc_str .= "<tr>
                                            <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>".$generic_array['fiscal_month']."' ".substr($standalone_consolidated_acc[0]['sa_year1'],2,2)."</td>
                                            <td style='text-align:center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>".$generic_array['fiscal_month']."' ".substr($standalone_consolidated_acc[0]['sa_year2'],2,2)."</td>
                                            <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>".$generic_array['fiscal_month']."' ".substr($standalone_consolidated_acc[0]['sa_year3'],2,2)."</td>
                                            <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>".$generic_array['fiscal_month']."' ".substr($standalone_consolidated_acc[0]['ca_year1'],2,2)."</td>
                                            <td style='text-align:center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>".$generic_array['fiscal_month']."' ".substr($standalone_consolidated_acc[0]['ca_year2'],2,2)."</td>
                                            <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>".$generic_array['fiscal_month']."' ".substr($standalone_consolidated_acc[0]['ca_year3'],2,2)."</td>
                                        </tr>";

        $array_col_vals = array(
            'Revenue',
            'Net Profit',
            'Total Assets',
            'Net Worth'
        );
        for($i=0;$i<count($standalone_consolidated_acc);$i++) {
            if($i%2==0) {
                $standalone_consolidated_acc_str.="<tr>
                                               <td style=' font-size: 10; background-color: #F2F2F2; text-align: left; border-right: 1px solid #FFF;'>$array_col_vals[$i]</td>
                                               <td style='font-size: 10; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['standalone_value1']."</td>
                                               <td style='font-size: 10; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['standalone_value2']."</td>
                                               <td style='font-size: 10; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['standalone_value3']."</td>
                                               <td style='font-size: 10; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['consolidated_value1']."</td>
                                               <td style='font-size: 10; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['consolidated_value2']."</td>
                                               <td style='font-size: 10; background-color: #F2F2F2;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['consolidated_value3']."</td>
                                           </tr>";
            }
            else {
                $standalone_consolidated_acc_str.="<tr>
                                            <td style=' font-size: 10; background-color: #D9D9D9;  text-align: left; border-right: 1px solid #FFF;'>$array_col_vals[$i]</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['standalone_value1']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['standalone_value2']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['standalone_value3']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['consolidated_value1']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['consolidated_value2']."</td>
                                            <td style='font-size: 10; background-color: #D9D9D9;  text-align: center; border-right: 1px solid #FFF;'>".$standalone_consolidated_acc[$i]['consolidated_value3']."</td>
                                          </tr>";
            }
        }

        resBlackStrip($docx,"STANDALONE VS CONSOLIDATED ACCOUNTS");
        $docx->embedHTML("<p style='font-size:1;'>&nbsp;</p>");
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $standalone_consolidated_acc_str
                </tbody>
              </table>";
        $docx->embedHTML($html);
        if($other_text[6]['text']!="" && $other_text[6]['text']!="&nbsp;") {
            $docx->embedHTML(htmlParser($other_text[6]['text']));
        }


        $analysis_txt = "";
        for($i=12;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $docx->embedHtml(htmlParser($analysis_text[$i]['analysis_text']));
            }
        }

        if($analysis_txt=="") {
            $docx->embedHtml(htmlParser($analysis_text[count($analysis_text)-1]['analysis_text']));
        }
    }

}
function declarationOfDividend($docx,$report_id) {

    $db = new ReportBurning();
    $generic_array = $db->declarationOfDevidend($report_id);

    if($generic_array['declaration_of_dividend_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];

        $docx->addBreak(array('type' => 'page'));
        global $resolution_text_box;
        if($resolution_text_box) {
            $text_box_5 = "<p style='font-size: 18; padding: 0; margin: 0; color: #FFF; text-align: center; font-family: Cambria;'><span style='font-size: 20;'>R</span>ESOLUTION <span style='font-size: 20;'>A</span>NALYSIS</p>";
            addOrangeTextBox($docx,$text_box_5);
            $resolution_text_box = false;
        }
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx, "RESOLUTION []: DECLARATION OF DIVIDEND", 1);
        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx, "SES RECOMMENDATION", 1);
        $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'], 1));
        resHeading($docx, "SES ANALYSIS", 1);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");

        // Graph Start

        $dividend_and_earning = new WordFragment($docx, "aslk");
        $dividend_and_earning->addExternalFile(array('src' => 'DividendAndEarning.docx'));
        $dividend_payout_ratio = new WordFragment($docx, "aslk");
        $dividend_payout_ratio->addExternalFile(array('src' => 'DividendPayoutRatio.docx'));
        $valuesTable = array(
            array(
                array('value' => $dividend_and_earning, 'vAlign' => 'center', 'textAlign' => 'center'),
                array('value' => $dividend_payout_ratio, 'vAlign' => 'center', 'textAlign' => 'center'),
            )
        );
        $widthTableCols = array(
            7000, 7000
        );
        $paramsTable = array(
            'border' => 'nil',
            'borderWidth' => 8,
            'borderColor' => 'cccccc',
            'columnWidths' => $widthTableCols
        );
        $docx->addTable($valuesTable, $paramsTable);

        // Graph Ends

        $analysis_txt = "";
        for ($i = 0; $i < count($analysis_text) - 1; $i++) {
            if ($analysis_text[$i]['analysis_text'] != "" && $analysis_text[$i]['analysis_text'] != "&nbsp;") {
                $docx->embedHtml(htmlParser($analysis_text[$i]['analysis_text']));
            }
        }
        if ($analysis_txt == "") {
            $docx->embedHtml(htmlParser($analysis_text[count($analysis_text) - 1]['analysis_text']));
        }
    }
}
function appointmentOfAuditors($docx,$report_id) {

    $db = new ReportBurning();

//    Burning Appointment Of Auditors At Banks

    $generic_array = $db->appointmentOfAuditorsAppointmentOfAuditorsAtBanks($report_id);
    if($generic_array['appointment_auditors_banks_exists']) {
        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: APPOINTMENT OF AUDITORS AT BANKS",1);
        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",1);
        $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",1);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $docx->embedHTML(htmlParser($other_text[1]['text']));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text'] != "&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        $docx->embedHtml(htmlParser($analysis_txt));
    }

    $generic_array = $db->appointmentOfAuditorsAppointmentOfAuditorsAtPSU($report_id);
    if($generic_array['appointment_auditors_psu_exists']) {
        echo "Coming in this as well";
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: APPOINTMENT OF AUDITORS AT PSU",1);
        $docx->embedHtml(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",1);
        $docx->embedHtml(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",1);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $docx->embedHtml(htmlParser($other_text[1]['text']));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text'] != "&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        $docx->embedHtml(htmlParser($analysis_txt));
    }

    $generic_array = $db->appointmentOfAuditorsAppointmentOfBranchAuditors($report_id);
    if($generic_array['appointment_branch_auditors_exists']) {
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx, "RESOLUTION []: APPOINTMENT OF BRANCH AUDITORS", 1);
        $docx->embedHtml(htmlParser($other_text[0]['text']));
        resHeading($docx, "SES RECOMMENDATION", 1);
        $docx->embedHtml(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx, "SES ANALYSIS", 1);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx, "COMPANY'S JUSTIFICATION");
        $docx->embedHtml(htmlParser($other_text[1]['text']));
        $analysis_txt = "";
        for ($i = 0; $i < count($analysis_text); $i++) {
            if ($analysis_text[$i]['analysis_text'] != "" && $analysis_text[$i]['analysis_text'] != "&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'] ;
            }
        }
        $docx->embedHtml(htmlParser($analysis_txt));
    }
// Burning Appointment of Branch Auditors ends

// Burning Appointment of Branch Auditors
    $generic_array = $db->appointmentOfAppointmentPaymentToCostAuditors($report_id);
    if($generic_array['payment_to_cost_auditors_exists']) {
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx, "RESOLUTION []: PAYMENT TO COST AUDITORS", 1);
        $docx->embedHtml(htmlParser($other_text[0]['text']));
        resHeading($docx, "SES RECOMMENDATION", 1);
        $docx->embedHtml(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx, "SES ANALYSIS", 1);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx, "COMPANY'S JUSTIFICATION");
        $docx->embedHtml(htmlParser($other_text[1]['text']));
        $analysis_txt = "";
        for ($i = 0; $i < count($analysis_text); $i++) {
            if ($analysis_text[$i]['analysis_text'] != "" && $analysis_text[$i]['analysis_text'] != "&nbsp;") {
                $analysis_txt .=  $analysis_text[$i]['analysis_text'] ;
            }
        }
        $docx->embedHtml(htmlParser($analysis_txt));
    }
// Burning Appointment of Branch Auditors ends

    $generic_array = $db->appointmentOfAppointmentRemovalOfAuditors($report_id);
    if($generic_array['removal_of_auditors_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: REMOVAL OF AUDITORS",1);
        $docx->embedHtml(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",1);
        $docx->embedHtml(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",1);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $docx->embedHtml(htmlParser($other_text[1]['text']));
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text'] != "&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        $docx->embedHtml(htmlParser($analysis_txt));
    }

    $generic_array = $db->appointmentOfAppointmentAppointmentOfAuditors($report_id);
    if($generic_array['appointment_of_auditors_exists']) {
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $triggers = $generic_array['triggers'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: APPOINTMENT OF AUDITORS",1);
        $docx->embedHtml(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",1);
        $docx->embedHtml(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",1);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"DISCLOSURES");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $no_auditors = $triggers[1]['triggers'];
        $inner="";
        for($i=0;$i<$no_auditors;$i++) {

            $inner .= "<tr>
                        <td style='text-align: left; width:40%; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>Name of the auditor up for appointment</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>".$triggers[$i+2]['triggers']."</td>
                      </tr>";
            $inner .= "<tr>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>Auditors' eligibility for appointment</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".ucwords($triggers[$i*2+5]['triggers'])."</td>
                      </tr>";
            $inner .= "<tr>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>Auditors' independence certificate</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>".ucwords($triggers[$i*2+6]['triggers'])."</td>
                      </tr>";

        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px; '>
                    <tbody>$inner</tbody>
                </table>";
        $docx->embedHTML($html);
        $docx->embedHTML("<p style='font-size: 3;'>&nbsp;</p>");
        resBlackStrip($docx,"AUDITORS' INDEPENDENCE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $inner = "<tr>
                        <td colspan='2' style='text-align: left; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #808080;'>Auditors</td>
                        <td colspan='2' style='text-align: left; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #808080;'>Audit Partners</td>
                    </tr>";
        for($i=0;$i<$no_auditors;$i++) {
            $inner .= "<tr>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$other_text[$i+1]['text']."</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$other_text[$i+7]['text']." years</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$other_text[$i*2+15]['text']."</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$other_text[$i*2+16]['text']." years</td>
                    </tr>";
        }
        $inner .= "<tr>
                        <td colspan='2' style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>Auditor's Network</td>
                        <td colspan='2' style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$other_text[$i+4]['text']."</td>
                      </tr>";
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px; '>
                        <tbody>$inner</tbody>
                    </table>";
        $docx->embedHTML($html);
        $docx->embedHtml(htmlParser($analysis_text[6]['analysis_text']));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"AUDITORS' REMUNERATION");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        // Graph Start 
        $dividend_and_earning = new WordFragment($docx,"aslk");
        $dividend_and_earning->addExternalFile(array('src'=>'RemunerationComponents.docx'));
        $dividend_payout_ratio = new WordFragment($docx,"aslk");
        $dividend_payout_ratio->addExternalFile(array('src'=>'AuditorsRemuneration.docx'));
        $valuesTable = array(
            array(
                array('value' =>$dividend_and_earning, 'vAlign' => 'top','textAlign'=>'center'),
                array('value' =>$dividend_payout_ratio, 'vAlign' => 'top','textAlign'=>'center'),
            )
        );
        $widthTableCols = array(5000,9000);
        $paramsTable = array(
            'border' => 'nil',
            'borderWidth' => 8,
            'borderColor' => 'cccccc',
            'columnWidths' => $widthTableCols
        );
        $docx->addTable($valuesTable, $paramsTable);
        // Graph Ends 
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"TERM OF APPOINTMENT");
        $docx->embedHtml(htmlParser($other_text[10]['text']));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        $docx->embedHtml(htmlParser($analysis_txt));
    }
}
function appointmentOfDirectors($docx,$report_id) {
    $db = new ReportBurning();
    $generic_array = $db->appointmentOfDirectorsED($report_id);
    if($generic_array['appointment_of_executive_directors_exists']) {
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $no_of_executive = $generic_array['no_of_executive'];
        $past_remuneration = $generic_array['past_remuneration'];
        $peer_comparison = $generic_array['peer_comparison'];
        $rem_package = $generic_array['rem_package'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: APPOINTMENT/REAPPOINTMENT OF EXECUTIVE DIRECTORS",1);
        $resolution_text = "";
        for($i=0;$i<$no_of_executive;$i++) {
            if($other_text[27*$i]['text']!="" && $other_text[27*$i]['text']!="&nbsp;")
                $resolution_text .= $other_text[29*$i]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = "";
        for($i=0;$i<$no_of_executive;$i++) {
            if($recommendation_text[$i]['recommendation_text']!="" && $recommendation_text[$i]['recommendation_text']!="&nbsp;")
                $resolution_text .= $recommendation_text[$i]['recommendation_text'];
        }
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"DIRECTOR'S PROFILE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $directors_profile = "<tr><td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>&nbsp;</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $director_name = $db->getDirectorName($other_text[29*$i+1]['text']);
            $directors_profile.="<td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; text-align: center; '>".$director_name."</td>";
        }
        $directors_profile.= "</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Current full time position</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[29*$i+2]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Functional Area</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[29*$i+3]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Education</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[29*$i+4]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Part of promoter group?</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".ucfirst($other_text[29*$i+5]['text'])."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Past Experience</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: justify; '>".$other_text[29*$i+6]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Committee positions in the Company</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[29*$i+7]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Retirement by rotation</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[29*$i+8]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-weight: bold; font-size: 10; background-color: #EB641B; color: #FFFFFF; text-align: left; '>SES Recommendation</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; color: #FFFFFF; font-size: 10; background-color: #EB641B; font-weight: bold; text-align: center;'>".strtoupper($other_text[29*$i+9]['text'])."</td>";
        }
        $directors_profile.="</tr>";
        $html = "<table style='border-collapse: collapse; width:98%; margin-left:8px;'>
                <tbody>
                    $directors_profile
                </tbody>
              </table>";
        $docx->embedHtml($html);
        $resolution_text = "<p style='margin:0; padding-top: 5px; padding-bottom: 8px; font-size: 9; font-style: italic; line-height:135%; padding-left: 0px;  text-align: justify; '>A - Audit Committee, SR - Stakeholders' Relationship Committee, NR - Nomination & Remuneration Committee, CSR - Corporate Social Responsibility Committee, M - Member, C - Chairman</p>";
        $docx->embedHTML($resolution_text);

        $resolution_text = "";
        for($i=0;$i<$no_of_executive;$i++) {
            if($other_text[29*$i+10]['text']!="" && $other_text[29*$i+10]['text']!="&nbsp;")
                $resolution_text .= $other_text[29*$i+10]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));

        resBlackStrip($docx,"PAST REMUNERATION OF THE DIRECTOR");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $year_1 = intval(substr($past_remuneration[0]['year1'],2,2));
        $year_1 = "FY ".($year_1-1)."/".$year_1;
        $year_2 = intval(substr($past_remuneration[0]['year2'],2,2));
        $year_2 = "FY ".($year_2-1)."/".$year_2;
        $year_3 = intval(substr($past_remuneration[0]['year3'],2,2));
        $year_3 = "FY ".($year_3-1)."/".$year_3;
        $past_remuneration_table= "<tr>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>In <span style='font-family: Rupee Foradian;'>`</span> Crore</td>
                                    <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>".$year_1."</td>
                                    <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>".$year_2."</td>
                                    <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>".$year_3."</td>
                                </tr>";
        $past_remuneration_table.= "<tr>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Executive Director</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Fixed Pay </td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Total Pay</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Fixed Pay</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Total Pay</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Fixed Pay</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Total Pay</td>
                                </tr>";
        for($i=0;$i<count($past_remuneration);$i++) {
            if($i%2==0) {
                $past_remuneration_table.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left;'>".$past_remuneration[$i]['dir_name']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: right; '>".$past_remuneration[$i]['fixed_pay_year1']."</td>
                                             <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: right; '>".$past_remuneration[$i]['total_pay_year1']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: right; '>".$past_remuneration[$i]['fixed_pay_year2']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: right; '>".$past_remuneration[$i]['total_pay_year2']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: right; '>".$past_remuneration[$i]['fixed_pay_year3']."</td>
                                             <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: right; '>".$past_remuneration[$i]['total_pay_year3']."</td>
                                           </tr>";
            }
            else {
                $past_remuneration_table.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>".$past_remuneration[$i]['dir_name']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: right; '>".$past_remuneration[$i]['fixed_pay_year1']."</td>
                                             <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: right; '>".$past_remuneration[$i]['total_pay_year1']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: right; '>".$past_remuneration[$i]['fixed_pay_year2']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: right; '>".$past_remuneration[$i]['total_pay_year2']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: right; '>".$past_remuneration[$i]['fixed_pay_year3']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: right; '>".$past_remuneration[$i]['total_pay_year3']."</td>
                                           </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $past_remuneration_table
                </tbody>
              </table>";
        $docx->embedHtml($html);

        $peer_comparison_table= "<tr><td colspan='3' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Executive Remuneration - Peer Comparison</td></tr>";
        $peer_comparison_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>Director</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$peer_comparison[0]['col_1']."</td>
                                     <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$peer_comparison[0]['col_2']."</td>

                                   </tr>";
        $peer_comparison_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>Company</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[1]['col_1']."</td>
                                     <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[1]['col_2']."</td>

                                   </tr>";
        $peer_comparison_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>Promoter</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$peer_comparison[2]['col_1']."</td>
                                     <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$peer_comparison[2]['col_2']."</td>

                                   </tr>";
        $peer_comparison_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>Remuneration (<span style='font-family: Rupee Foradian;'>`</span> Cr) (A)</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[3]['col_1']."</td>
                                     <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[3]['col_2']."</td>

                                   </tr>";
        $peer_comparison_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>Net Profits (<span style='font-family: Rupee Foradian;'>`</span> Cr) (B)</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$peer_comparison[4]['col_1']."</td>
                                     <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$peer_comparison[4]['col_2']."</td>

                                   </tr>";
        $peer_comparison_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>Ratio (A/B)</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[5]['col_1']."</td>
                                     <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[5]['col_2']."</td>

                                   </tr>";
        $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $peer_comparison_table
                </tbody>
              </table>";

        // Graph Start 
        $dividend_and_earning = new WordFragment($docx,"aslk");
        $dividend_and_earning->embedHTML($html);
        $dividend_payout_ratio = new WordFragment($docx,"aslk");
        $dividend_payout_ratio->addExternalFile(array('src'=>'ExecutiveRemuneration.docx'));
        $valuesTable = array(
            array(
                array('value' =>$dividend_and_earning, 'vAlign' => 'top','textAlign'=>'center'),
                array('value' =>$dividend_payout_ratio, 'vAlign' => 'top','textAlign'=>'center'),
            )
        );
        $widthTableCols = array(6000,5000);
        $paramsTable = array(
            'border' => 'nil',
            'borderWidth' => 8,
            'borderColor' => 'cccccc',
            'columnWidths' => $widthTableCols
        );
        $docx->addTable($valuesTable, $paramsTable);
        // Graph Ends 

        $p_text = "<p style='font-size: 1;'><br/></p>";
        $docx->embedHTML($p_text);
        resBlackStrip($docx,"DIRECTORS' TIME COMMITMENTS");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $time_commitment_table = "<tr><td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Criteria</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $director_name=$db->getDirectorName($other_text[29*$i+1]['text']);
            $time_commitment_table.="<td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>".$director_name."</td>";
        }
        $time_commitment_table.= "</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Total Directorships </td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[29*$i+11]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Total Committee memberships</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[29*$i+12]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Total Committee Chairmanship </td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[29*$i+13]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Full time role/ executive position</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[29*$i+14]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $time_commitment_table
                </tbody>
              </table>";
        $docx->embedHtml($html);
        $resolution_text = "<p style='margin:0; padding-top: 5px; padding-bottom: 8px; font-size: 9; line-height:135%; padding-left: 0px;  text-align: justify; '>Note: Committee memberships include Committee chairmanships, Total Directorships include Directorships in Public as well Private Companies</p>";
        $docx->embedHTML($resolution_text);

        $resolution_text = "";
        for($i=0;$i<$no_of_executive;$i++) {
            if($other_text[29*$i+15]['text']!="" && $other_text[29*$i+15]['text']!="&nbsp;")
                $resolution_text .= $other_text[29*$i+15]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));

        resBlackStrip($docx,"DIRECTORS’ PERFORMANCE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $directors_performance = "<tr><td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Attendance record</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $director_name = $db->getDirectorName($other_text[29*$i+1]['text']);
            $directors_performance.="<td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>".$director_name."</td>";
        }
        $directors_performance.= "</tr>";
        $directors_performance.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Last 3 AGMs </td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[29*$i+16]['text']."</td>";
        }
        $directors_performance.="</tr>";
        $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Board meetings held last year</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[29*$i+17]['text']."</td>";
        }
        $directors_performance.="</tr>";
        $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Board meetings in last 3 years (avg.) </td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[29*$i+18]['text']."</td>";
        }
        $directors_performance.="</tr>";
        $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Audit Committee meetings</td>";
        for($i=0;$i<$no_of_executive;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[29*$i+19]['text']."</td>";
        }
        $directors_performance.="</tr>";
        if($generic_array['are_committees_seperate']=='yes') {
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Nomination Committee meetings</td>";
            for($i=0;$i<$no_of_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[29*$i+21]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Remuneration Committee meetings</td>";
            for($i=0;$i<$no_of_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[29*$i+22]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>CSR Committee meetings</td>";
            for($i=0;$i<$no_of_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[29*$i+23]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Stakeholders' Relationship Committee meetings</td>";
            for($i=0;$i<$no_of_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[29*$i+24]['text']."</td>";
            }
            $directors_performance.="</tr>";
        }
        else {
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Nomination &amp; Remuneration Committee meetings</td>";
            for($i=0;$i<$no_of_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[29*$i+20]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>CSR Committee meetings</td>";
            for($i=0;$i<$no_of_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[29*$i+23]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Stakeholders' Relationship Committee meetings</td>";
            for($i=0;$i<$no_of_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[29*$i+24]['text']."</td>";
            }
            $directors_performance.="</tr>";
        }

        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $directors_performance
                </tbody>
              </table>";
        $docx->embedHtml($html);

        $resolution_text = "";
        for($i=0;$i<$no_of_executive;$i++) {
            if($other_text[29*$i+25]['text']!="" && $other_text[29*$i+25]['text']!="&nbsp;")
                $resolution_text .= $other_text[29*$i+25]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));


        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        for($i=0;$i<$no_of_executive;$i++) {

            $remuneration_package= "<tr>
                                    <td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Component</td>
                                    <td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Proposed Remuneration</td>
                                    <td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Comments</td>
                                </tr>";
            $remuneration_package.="<tr>
                                    <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Basic Pay</td>
                                    <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Proposed Salary: <span style='font-family: Rupee Foradian;'>`</span>".$rem_package[$i*15]['field_value']."</td>
                                    <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Increase in remuneration: ".$rem_package[$i*15+1]['field_value']."</td>
                                   </tr>";
            $remuneration_package.="<tr>
                                    <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Annual increment: ".$rem_package[$i*15+2]['field_value']."</td>
                                </tr>";

            $remuneration_package.="<tr>
                                        <td rowspan='2' style='font-size: 10; background-color: #D9D9D9; text-align: left; '>Perquisites/ Allowances</td>
                                        <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>All perquisites clearly defined: ".$rem_package[$i*15+3]['field_value']."</td>
                                        <td rowspan='2' style='font-size: 10; background-color: #D9D9D9; text-align: left; '>Cap placed on perquisites: ".$rem_package[$i*15+4]['field_value']."</td>
                                   </tr>";
            $remuneration_package.="<tr>
                                    <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>Total allowances: <span style='font-family: Rupee Foradian;'>`</span>".$rem_package[$i*15+5]['field_value']."</td>
                                   </tr>";

            $remuneration_package.="<tr>
                                    <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Variable Pay</td>
                                    <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>".ucfirst($rem_package[$i*15+6]['field_value'])."</td>
                                    <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Performance criteria disclosed: ".ucfirst($rem_package[$i*15+7]['field_value'])."</td>
                                   </tr>";
            $remuneration_package.="<tr>
                                    <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Cap placed on variable pay: ".ucfirst($rem_package[$i*15+8]['field_value'])."</td>
                                </tr>";

            $remuneration_package.="<tr>
                                    <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>Notice Period</td>
                                    <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>".$rem_package[$i*15+9]['field_value']." months</td>
                                    <td rowspan='2' style='font-size: 10; background-color: #D9D9D9; text-align: left; '>".$rem_package[$i*15+10]['field_value']."</td>
                                   </tr>";
            $remuneration_package.="<tr>
                                    <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>Severance Pay</td>
                                    <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>".$rem_package[$i*15+11]['field_value']." months</td>
                                   </tr>";
            $remuneration_package.="<tr>
                                    <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Minimum Remuneration</td>
                                   <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>".$rem_package[$i*15+12]['field_value']."</td>
                                    <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Within limits prescribed: ".$rem_package[$i*15+13]['field_value']."</td>

                                   </tr>";
            $remuneration_package.="<tr>
                                    <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Includes variable pay: ".$rem_package[$i*15+14]['field_value']."</td>
                                </tr>";
            resBlackStrip($docx,"REMUNERATION PACKAGE OF ".strtoupper($db->getDirectorName($other_text[29*$i+1]['text'])));
            $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
            $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $remuneration_package
                </tbody>
              </table>";
            $docx->embedHtml($html."<p style='font-size: 4;'>&nbsp;</p>");
        }

        $resolution_text = "";
        for($i=0;$i<$no_of_executive;$i++) {
            if($other_text[29*$i+26]['text']!="" && $other_text[29*$i+26]['text']!="&nbsp;")
                $resolution_text .= $other_text[29*$i+26]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));

        $resolution_text = "";
        for($i=0;$i<$no_of_executive;$i++) {
            if($other_text[29*$i+27]['text']!="" && $other_text[29*$i+27]['text']!="&nbsp;")
                $resolution_text .= $other_text[29*$i+27]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));

        $resolution_text = "";
        for($i=0;$i<$no_of_executive;$i++) {
            if($other_text[29*$i+28]['text']!="" && $other_text[29*$i+28]['text']!="&nbsp;")
                $resolution_text .= $other_text[29*$i+28]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));


        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="") {
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        }
        $docx->embedHTML(htmlParser($analysis_txt));
    }
    $generic_array = $db->appointmentOfDirectorsNED($report_id);
    if($generic_array['appointment_of_non_executive_directors_exists']) {
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $no_of_non_executive = $generic_array['no_of_non_executive'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: APPOINTMENT/REAPPOINTMENT OF NON-EXECUTIVE DIRECTORS",1);
        $resolution_text = "";
        for($i=0;$i<$no_of_non_executive;$i++) {
            if($other_text[28*$i]['text']!="" && $other_text[28*$i]['text']!="&nbsp;")
                $resolution_text .= $other_text[28*$i]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = "";
        for($i=0;$i<$no_of_non_executive;$i++) {
            if($recommendation_text[$i]['recommendation_text']!="" && $recommendation_text[$i]['recommendation_text']!="&nbsp;")
                $resolution_text .= $recommendation_text[$i]['recommendation_text'];
        }
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"DIRECTOR'S PROFILE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $directors_profile = "<tr><td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>&nbsp;</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $director_name = $db->getDirectorName($other_text[28*$i+1]['text']);
            $directors_profile.="<td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; text-align: center; '>".$director_name."</td>";
        }
        $directors_profile.= "</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Current full time position</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+2]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Functional Area</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[28*$i+3]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Education</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+4]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Impact on diversity</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[28*$i+5]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Past Experience</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+6]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Committee positions in the Company</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[28*$i+7]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Retirement by rotation</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+8]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Part of promoter group?</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".ucfirst($other_text[28*$i+9]['text'])."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-weight: bold; font-size: 10; background-color: #EB641B; color: #FFFFFF; text-align: left; '>SES Recommendation</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; color: #FFFFFF; font-size: 10; background-color: #EB641B; text-align: center; font-weight: bold;'>".strtoupper($other_text[28*$i+10]['text'])."</td>";
        }
        $directors_profile.="</tr>";
        $html = "<table style='border-collapse: collapse; width:98%; margin-left:8px;'>
                <tbody>
                    $directors_profile
                </tbody>
              </table>";
        $docx->embedHtml($html);
        $resolution_text = "<p style='margin:0; padding-top: 5px; padding-bottom: 8px; font-size: 9; font-style: italic; line-height:135%; padding-left: 0px;  text-align: justify; '>A - Audit Committee, SR - Stakeholders' Relationship Committee, NR - Nomination & Remuneration Committee, CSR - Corporate Social Responsibility Committee, M - Member, C - Chairman</p>";
        $docx->embedHTML($resolution_text);

        $resolution_text = "";
        for($i=0;$i<$no_of_non_executive;$i++) {
            if($other_text[28*$i+11]['text']!="" && $other_text[28*$i+11]['text']!="&nbsp;")
                $resolution_text .= $other_text[28*$i+11]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));

        resBlackStrip($docx,"DIRECTORS' TIME COMMITMENTS");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $time_commitment_table = "<tr><td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Criteria</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $director_name = $db->getDirectorName($other_text[28*$i+1]['text']);
            $time_commitment_table.="<td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>".$director_name."</td>";
        }
        $time_commitment_table.= "</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Total Directorships </td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+12]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Total Committee memberships</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[28*$i+13]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Total Committee Chairmanship </td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+14]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Full time role/ executive position</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[28*$i+15]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $html = "<table style='border-collapse: collapse; width:98%; margin-left:8px;'>
                <tbody>
                    $time_commitment_table
                </tbody>
              </table>";
        $docx->embedHtml($html);
        $resolution_text = "<p style='margin:0; padding-top: 5px; padding-bottom: 8px; font-size: 9; line-height:135%; padding-left: 0px;  text-align: justify; '>Note: Committee memberships include Committee chairmanships, Total Directorships include Directorships in Public as well Private Companies</p>";
        $docx->embedHTML($resolution_text);

        $resolution_text = "";
        for($i=0;$i<$no_of_non_executive;$i++) {
            if($other_text[28*$i+16]['text']!="" && $other_text[28*$i+16]['text']!="&nbsp;")
                $resolution_text .= $other_text[28*$i+16]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));

        resBlackStrip($docx,"DIRECTORS’ PERFORMANCE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $directors_performance = "<tr><td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Attendance record</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $director_name = $db->getDirectorName($other_text[28*$i+1]['text']);
            $directors_performance.="<td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>".$director_name."</td>";
        }
        $directors_performance.= "</tr>";
        $directors_performance.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Last 3 AGMs </td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+17]['text']."</td>";
        }
        $directors_performance.="</tr>";
        $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Board meetings held last year</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[28*$i+18]['text']."</td>";
        }
        $directors_performance.="</tr>";
        $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Board meetings in last 3 years (avg.) </td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+19]['text']."</td>";
        }
        $directors_performance.="</tr>";
        $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Audit Committee meetings</td>";
        for($i=0;$i<$no_of_non_executive;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[28*$i+20]['text']."</td>";
        }
        $directors_performance.="</tr>";
        if($generic_array['are_committees_seperate']=='yes') {
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Nomination Committee meetings</td>";
            for($i=0;$i<$no_of_non_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+22]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Remuneration Committee meetings</td>";
            for($i=0;$i<$no_of_non_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[28*$i+23]['text']."</td>";
            }
            $directors_performance.="</tr>";

            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>CSR Committee meetings</td>";
            for($i=0;$i<$no_of_non_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+24]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Stakeholders' Relationship Committee meetings</td>";
            for($i=0;$i<$no_of_non_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[28*$i+25]['text']."</td>";
            }
            $directors_performance.="</tr>";
        }
        else {
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Nomination &amp; Remuneration Committee meetings</td>";
            for($i=0;$i<$no_of_non_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+21]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>CSR Committee meetings</td>";
            for($i=0;$i<$no_of_non_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[28*$i+24]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Stakeholders' Relationship Committee meetings</td>";
            for($i=0;$i<$no_of_non_executive;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[28*$i+25]['text']."</td>";
            }
            $directors_performance.="</tr>";
        }

        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $directors_performance
                </tbody>
              </table>";
        $docx->embedHtml($html);

        $resolution_text = "";
        for($i=0;$i<$no_of_non_executive;$i++) {
            if($other_text[28*$i+26]['text']!="" && $other_text[28*$i+26]['text']!="&nbsp;")
                $resolution_text .= $other_text[28*$i+26]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));
        resBlackStrip($docx,"DIRECTOR'S REMUNERATION");
        $resolution_text = "";
        for($i=0;$i<$no_of_non_executive;$i++) {
            if($other_text[28*$i+27]['text']!="" && $other_text[28*$i+27]['text']!="&nbsp;")
                $resolution_text .= $other_text[28*$i+27]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));

        $total_analysis_rows = count($analysis_text);
        for($i=0;$i<$no_of_non_executive;$i++) {
            $resolution_text = "";
            for($j=0;$j<$total_analysis_rows-1;$j++) {
                if($analysis_text[51*$i+$j]['analysis_text']!="" && $analysis_text[51*$i+$j]['analysis_text']!="&nbsp;")
                    $resolution_text .= $analysis_text[51*$i+$j]['analysis_text'];
            }
            if($resolution_text=="") {
                $resolution_text .= $analysis_text[51*$i+$total_analysis_rows-1]['analysis_text'];
            }
            $docx->embedHTML(htmlParser($resolution_text));
        }
    }
    $generic_array = $db->appointmentOfDirectorsID($report_id);
    if($generic_array['appointment_of_independent_directors_exists']) {

        $other_text = $generic_array['other_text'];
        $analysis_text = $generic_array['analysis_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $no_of_independent = $generic_array['no_of_independent'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: APPOINTMENT/REAPPOINTMENT OF INDEPENDENT DIRECTORS",1);
        $resolution_text = "";
        for($i=0;$i<$no_of_independent;$i++) {
            if($other_text[65*$i]['text']!="" && $other_text[65*$i]['text']!="&nbsp;")
                $resolution_text .= $other_text[65*$i]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",1);
        $resolution_text = "";
        for($i=0;$i<$no_of_independent;$i++) {
            if($recommendation_text[$i]['recommendation_text']!="" && $recommendation_text[$i]['recommendation_text']!="&nbsp;")
                $resolution_text .= $recommendation_text[$i]['recommendation_text'];
        }
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPLIANCE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $Compliance_table = "<tr>
                                <td style='text-align: left; font-size: 10; background-color: #F2F2F2;'>Is Company complying with the retirement policy?</td>
                                <td style='text-align: left; font-size: 10; background-color: #F2F2F2;'>".ucfirst($other_text[2]['text'])."</td>
                                <td style='text-align: left; font-size: 10; background-color: #F2F2F2;'>".$other_text[3]['text']."</td>
                            </tr>";
        $Compliance_table .= "<tr>
                                <td style='text-align: left; font-size: 10; background-color: #D9D9D9;'>Has the Company disclosed the Independence Certificate provided by the Independent Directors?</td>
                                <td style='text-align: left; font-size: 10; background-color: #D9D9D9;'>".ucfirst($other_text[4]['text'])."</td>
                                <td style='text-align: left; font-size: 10; background-color: #D9D9D9;'>".$other_text[5]['text']."</td>
                            </tr>";
        $Compliance_table .= "<tr>
                                <td style='text-align: left; font-size: 10; background-color: #F2F2F2;'>Has the Company disclosed the terms of appointment of Independent Directors?</td>
                                <td style='text-align: left; font-size: 10; background-color: #F2F2F2;'>".ucfirst($other_text[6]['text'])."</td>
                                <td style='text-align: left; font-size: 10; background-color: #F2F2F2;'>".$other_text[7]['text']."</td>
                            </tr>";
        $Compliance_table .= "<tr>
                                <td style='text-align: left; font-size: 10; background-color: #D9D9D9;'>Has the Company disclosed Board evaluation and Directors' Evaluation Policy?</td>
                                <td style='text-align: left; font-size: 10; background-color: #D9D9D9;'>".ucfirst($other_text[8]['text'])."</td>
                                <td style='text-align: left; font-size: 10; background-color: #D9D9D9;'>".$other_text[9]['text']."</td>
                            </tr>";
        $Compliance_table .= "<tr>
                                <td style='text-align: left; font-size: 10; background-color: #F2F2F2;'>Did Independent Directors meet atleast once without the Management?</td>
                                <td style='text-align: left; font-size: 10; background-color: #F2F2F2;'>".ucfirst($other_text[10]['text'])."</td>
                                <td style='text-align: left; font-size: 10; background-color: #F2F2F2;'>".$other_text[11]['text']."</td>
                            </tr>";
        $Compliance_table .= "<tr>
                                <td style='text-align: left; font-size: 10; background-color: #D9D9D9;'>Does the Company has a Lead independent Director?</td>
                                <td style='text-align: left; font-size: 10; background-color: #D9D9D9;'>".ucfirst($other_text[12]['text'])."</td>
                                <td style='text-align: left; font-size: 10; background-color: #D9D9D9;'>".$other_text[13]['text']."</td>
                            </tr>";
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $Compliance_table
                </tbody>
              </table>";
        $docx->embedHtml($html);
        $docx->embedHTML("<p style='font-size: 1;padding-top:8px'>&nbsp;</p>");

        resBlackStrip($docx,"DIRECTOR'S PROFILE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $directors_profile = "<tr><td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>&nbsp;</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $director_name = $db->getDirectorName($other_text[65*$i+1]['text']);
            $directors_profile.="<td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; text-align: center; '>".$director_name."</td>";
        }
        $directors_profile.= "</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Current full time position</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+14]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Functional Area</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+15]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Education</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+16]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Impact on diversity</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+17]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Past Experience</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: justify; '>".$other_text[65*$i+18]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Committee positions in the Company</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+19]['text']."</td>";
        }
        $directors_profile.="</tr>";
        $directors_profile.="<tr><td style='border-right: 1px solid #FFFFFF; font-weight: bold; font-size: 10; background-color: #EB641B; color: #FFFFFF; text-align: left; '>SES Recommendation</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_profile.="<td style='border-right: 1px solid #FFFFFF; color: #FFFFFF; font-size: 10; background-color: #EB641B; text-align: center; font-weight: bold;'>".strtoupper($other_text[65*$i+20]['text'])."</td>";
        }
        $directors_profile.="</tr>";
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $directors_profile
                </tbody>
              </table>";
        $docx->embedHtml($html);
        $resolution_text = "<p style='margin:0; padding-top: 5px; padding-bottom: 8px; font-size: 9; font-style: italic; line-height:135%; padding-left: 0px;  text-align: justify; '>A - Audit Committee, SR - Stakeholders' Relationship Committee, NR - Nomination & Remuneration Committee, CSR - Corporate Social Responsibility Committee, M - Member, C - Chairman</p>";
        $docx->embedHTML($resolution_text);

        $resolution_text = "";
        for($i=0;$i<$no_of_independent;$i++) {
            if($other_text[65*$i+21]['text']!="" && $other_text[65*$i+21]['text']!="&nbsp;")
                $resolution_text .= $other_text[65*$i+21]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHTML("<p style='font-size: 1;padding-top:8px'>&nbsp;</p>");
        resBlackStrip($docx,"DIRECTORS' INDEPENDENCE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $directors_independence = "<tr><td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Criteria</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $director_name = $db->getDirectorName($other_text[65*$i+1]['text']);
            $directors_independence.="<td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>".$director_name."</td>";
        }
        $directors_independence.= "</tr>";
        $directors_independence.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Current tenure/association</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_independence.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+22]['text']."</td>";
        }
        $directors_independence.="</tr>";
        $directors_independence.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Directorships at group companies</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_independence.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+23]['text']."</td>";
        }
        $directors_independence.="</tr>";
        $directors_independence.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Relationships with the Company</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_independence.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+24]['text']."</td>";
        }
        $directors_independence.="</tr>";
        $directors_independence.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Nominee director</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_independence.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+25]['text']."</td>";
        }
        $directors_independence.="</tr>";
        $directors_independence.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Shareholding / ESOPs</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_independence.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+26]['text']."</td>";
        }
        $directors_independence.="</tr>";
        $directors_independence.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Remuneration ( <span style='font-family: Rupee Foradian;'>`</span> Lakhs)</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_independence.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+27]['text']."</td>";
        }
        $directors_independence.="</tr>";
        $directors_independence.="<tr><td style='border-right: 1px solid #FFFFFF; font-weight: bold; color: #FFFFFF; font-size: 10; background-color: #EB641B; text-align: left; '>SES Classification</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_independence.="<td style='border-right: 1px solid #FFFFFF; color: #FFFFFF; font-size: 10; background-color: #EB641B; text-align:center; font-weight: bold; '>".strtoupper($other_text[65*$i+28]['text'])."</td>";
        }
        $directors_independence.="</tr>";
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $directors_independence
                </tbody>
              </table>";
        $docx->embedHtml($html);
        $resolution_text = "";
        for($i=0;$i<$no_of_independent;$i++) {
            if($other_text[65*$i+29]['text']!="" && $other_text[65*$i+29]['text']!="&nbsp;")
                $resolution_text .= $other_text[65*$i+29]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));

        resBlackStrip($docx,"DIRECTORS' TIME COMMITMENTS");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $time_commitment_table = "<tr><td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Criteria</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $director_name = $db->getDirectorName($other_text[65*$i+1]['text']);
            $time_commitment_table.="<td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>".$director_name."</td>";
        }
        $time_commitment_table.= "</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Total Directorships </td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+30]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Total Committee memberships</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+31]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Total Committee Chairmanship </td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+32]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $time_commitment_table.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Full time role/ executive position</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $time_commitment_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+33]['text']."</td>";
        }
        $time_commitment_table.="</tr>";
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $time_commitment_table
                </tbody>
              </table>";
        $docx->embedHtml($html);
        $resolution_text = "<p style='margin:0; padding-top: 5px; padding-bottom: 8px; font-size: 9; line-height:135%; padding-left: 0px;  text-align: justify; '>Note: Committee memberships include Committee chairmanships, Total Directorships include Directorships in Public as well Private Companies.</p>";
        $docx->embedHTML($resolution_text);

        $resolution_text = "";
        for($i=0;$i<$no_of_independent;$i++) {
            if($other_text[65*$i+34]['text']!="" && $other_text[65*$i+34]['text']!="&nbsp;")
                $resolution_text .= $other_text[65*$i+34]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));

        resBlackStrip($docx,"DIRECTORS’ PERFORMANCE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $directors_performance = "<tr><td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Attendance record</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $director_name = $db->getDirectorName($other_text[65*$i+1]['text']);
            $directors_performance.="<td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>".$director_name."</td>";
        }
        $directors_performance.= "</tr>";
        $directors_performance.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Last 3 AGMs </td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+35]['text']."</td>";
        }
        $directors_performance.="</tr>";
        $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Board meetings held last year</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+36]['text']."</td>";
        }
        $directors_performance.="</tr>";
        $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Board meetings in last 3 years (avg.) </td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+37]['text']."</td>";
        }
        $directors_performance.="</tr>";
        $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Audit Committee meetings</td>";
        for($i=0;$i<$no_of_independent;$i++) {
            $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+38]['text']."</td>";
        }
        $directors_performance.="</tr>";
        if($generic_array['are_committees_seperate']=='yes') {
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Nomination Committee meetings</td>";
            for($i=0;$i<$no_of_independent;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+40]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Remuneration Committee meetings</td>";
            for($i=0;$i<$no_of_independent;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+41]['text']."</td>";
            }
            $directors_performance.="</tr>";

            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>CSR Committee meetings</td>";
            for($i=0;$i<$no_of_independent;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+42]['text']."</td>";
            }
            $directors_performance.="</tr>";

            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Stakeholders' Relationship Committee meetings</td>";
            for($i=0;$i<$no_of_independent;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+43]['text']."</td>";
            }
            $directors_performance.="</tr>";
        }
        else {
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Nomination &amp; Remuneration Committee meetings</td>";
            for($i=0;$i<$no_of_independent;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+39]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>CSR Committee meetings</td>";
            for($i=0;$i<$no_of_independent;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$other_text[65*$i+42]['text']."</td>";
            }
            $directors_performance.="</tr>";
            $directors_performance.="<tr><td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Stakeholders' Relationship Committee meetings</td>";
            for($i=0;$i<$no_of_independent;$i++) {
                $directors_performance.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$other_text[65*$i+43]['text']."</td>";
            }
            $directors_performance.="</tr>";
        }

        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $directors_performance
                </tbody>
              </table>";
        $docx->embedHtml($html);

        $resolution_text = "";
        for($i=0;$i<$no_of_independent;$i++) {
            if($other_text[65*$i+44]['text']!="" && $other_text[65*$i+44]['text']!="&nbsp;")
                $resolution_text .= $other_text[65*$i+44]['text'];
        }
        $docx->embedHTML(htmlParser($resolution_text));

        resHeading($docx,"DIRECTOR PERFORMANCE INDEX ADD DRAWS SKEWED REMUNERATION DISCUSS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        for($i=0;$i<$no_of_independent;$i++) {
            $total_score = 0;
            $directors_performance_index = "<tr>
                                            <td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Criteria</td>
                                            <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Response</td>
                                            <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Score</td>
                                            <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Maximum</td>
                                        </tr>";
            $directors_performance_index .= "<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Board Meetings Attendance held in the last year</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>" . $other_text[65 * $i + 45]['text'] . "</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>" . $other_text[65 * $i + 46]['text'] . "</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>5</td>
                                        </tr>";
            $total_score+=$other_text[65 * $i + 46]['text'];
            $directors_performance_index .= "<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Board Meetings Attendance held in the last 3 years</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>" . $other_text[65 * $i + 47]['text'] . " </td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>" . $other_text[65 * $i + 48]['text'] . " </td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>15</td>
                                        </tr>";
            $total_score+=$other_text[65 * $i + 48]['text'];
            $directors_performance_index .= "<tr>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Audit Committee Meetings Attendance</td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>" . $other_text[65 * $i + 49]['text'] . " </td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>" . $other_text[65 * $i + 50]['text'] . "</td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>10 </td>
                                            </tr>";
            $total_score+=$other_text[65 * $i + 50]['text'];
            $directors_performance_index .= "<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Nomination & Remuneration Committee Meetings Attendance</td>
                                     <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>" . $other_text[65 * $i + 51]['text'] . " </td>
                                      <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>" . $other_text[65 * $i + 52]['text'] . " </td>
                                       <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>10</td>
                                    </tr>";
            $total_score+=$other_text[65 * $i + 52]['text'];
            $directors_performance_index .= "<tr>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Total Directorships</td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>" . $other_text[65 * $i + 57]['text'] . " </td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>" . $other_text[65 * $i + 58]['text'] . "</td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>15 </td>
                                            </tr>";
            $total_score+=$other_text[65 * $i + 58]['text'];
            $directors_performance_index .= "<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Total Committee memberships</td>
                                     <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>" . $other_text[65 * $i + 59]['text'] . " </td>
                                      <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>" . $other_text[65 * $i + 60]['text'] . " </td>
                                       <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>15</td>
                                    </tr>";
            $total_score+=$other_text[65 * $i + 60]['text'];
            $directors_performance_index .= "<tr>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Total Committee Chairmanships</td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>" . $other_text[65 * $i + 61]['text'] . " </td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>" . $other_text[65 * $i + 62]['text'] . "</td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>15 </td>
                                             </tr>";
            $total_score+=$other_text[65 * $i + 62]['text'];
            $directors_performance_index .= "<tr>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Full Time Role/Executive Position</td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>" . $other_text[65 * $i + 63]['text'] . " </td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>" . $other_text[65 * $i + 64]['text'] . " </td>
                                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>15</td>
                                            </tr>";
            $total_score+=$other_text[65 * $i + 64]['text'];
            $directors_performance_index .= "<tr>
                                                <td colspan='2' style='padding-top: 2px; padding-bottom: 2px; border-right: 1px solid #FFFFFF; border-top: 2px solid #000000; font-size: 10; background-color: #FFFFFF; text-align: left; border-bottom: 2px solid #000000;'>Total</td>
                                                <td style='padding-top: 2px; padding-bottom: 2px; border-right: 1px solid #FFFFFF; border-top: 2px solid #000000; font-size: 10; background-color: #FFFFFF; text-align: center;border-bottom: 2px solid #000000; '>$total_score</td>
                                                <td style='padding-top: 2px; padding-bottom: 2px; border-right: 1px solid #FFFFFF; border-top: 2px solid #000000; font-size: 10; background-color: #FFFFFF; text-align: center;border-bottom: 2px solid #000000; '>100</td>
                                            </tr>";

            $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $directors_performance_index
                </tbody>
              </table>";
            $docx->embedHtml($html);
            $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        }

        $total_analysis_rows = count($analysis_text);
        for($i=0;$i<$no_of_non_executive;$i++) {
            $resolution_text = "";
            for($j=0;$j<$total_analysis_rows-1;$j++) {
                if($analysis_text[51*$i+$j]['analysis_text']!="" && $analysis_text[51*$i+$j]['analysis_text']!="&nbsp;")
                    $resolution_text .= $analysis_text[51*$i+$j]['analysis_text'];
            }
            if($resolution_text=="") {
                $resolution_text .= $analysis_text[51*$i+$total_analysis_rows-1]['analysis_text'];
            }
            $docx->embedHTML(htmlParser($resolution_text));
        }
    }
    $generic_array = $db->appointmentOfDirectorsCessationDirectorship($report_id);
    if($generic_array['cessation_directorship']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];

        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: CESSATION OF DIRECTORSHIP",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text[0]['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));

        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY JUSTIFICATION");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text'] != "&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="") {
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        }
        $docx->embedHtml(htmlParser($analysis_txt));

    }
    $generic_array = $db->appointmentOfDirectorsAlternateDirectors($report_id);
    if($generic_array['alternate_directors']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];

        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: ALTERNATE DIRECTORS",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text[0]['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));

        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY JUSTIFICATION");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text'] != "&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }
}
function directorsRemuneration($docx,$report_id){
    $db = new ReportBurning();

    $generic_array = $db->directorsRemunerationREDR($report_id);
    if($generic_array['non_executive_commision_exists']) {
        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $past_remuneration = $generic_array['past_remuneration'];
        $peer_comparison = $generic_array['peer_comparison'];
        $remuneration_package = $generic_array['remuneration_package'];
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: REVISION IN EXECUTIVE REMUNERATION",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"REASON FOR REVISION");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resBlackStrip($docx,"PAST REMUNERATION OF THE DIRECTOR");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $year_1 = intval(substr($past_remuneration[0]['current_year'],2,2));
        $year_1 = "FY ".($year_1-1)."/".$year_1;
        $year_2 = intval(substr($past_remuneration[0]['prev_year1'],2,2));
        $year_2 = "FY ".($year_2-1)."/".$year_2;
        $year_3 = intval(substr($past_remuneration[0]['prev_year2'],2,2));
        $year_3 = "FY ".($year_3-1)."/".$year_3;
        $past_remuneration_table= "<tr>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>In <span style='font-family: Rupee Foradian;'>`</span>Crore</td>
                                    <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>".$year_1."</td>
                                    <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>".$year_2."</td>
                                    <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>".$year_3."</td>
                                </tr>";
        $past_remuneration_table.= "<tr>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Executive Director</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Fixed Pay </td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Total Pay</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Fixed Pay</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Total Pay</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Fixed Pay</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Total Pay</td>
                                </tr>";
        for($i=0;$i<count($past_remuneration);$i++) {
            if($i%2==0) {
                $past_remuneration_table.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;'>".$past_remuneration[$i]['dir_name']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$past_remuneration[$i]['year1_fixed']."</td>
                                             <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$past_remuneration[$i]['year1_total']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$past_remuneration[$i]['year2_fixed']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$past_remuneration[$i]['year2_total']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$past_remuneration[$i]['year3_fixed']."</td>
                                             <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$past_remuneration[$i]['year3_total']."</td>
                                        </tr>";
            }
            else {
                $past_remuneration_table.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$past_remuneration[$i]['dir_name']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$past_remuneration[$i]['year1_fixed']."</td>
                                             <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$past_remuneration[$i]['year1_total']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$past_remuneration[$i]['year2_fixed']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$past_remuneration[$i]['year2_total']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$past_remuneration[$i]['year3_fixed']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$past_remuneration[$i]['year3_total']."</td>
                                        </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
            <tbody>
                $past_remuneration_table
            </tbody>
          </table>";
        $docx->embedHtml($html);
        $docx->embedHTML("<p style='font-size: 3;'>&nbsp;</p>");
        $peer_comparison_table= "<tr>
                                <td colspan='3' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Executive Remuneration - Peer Comparison</td>
                            </tr>";
        $peer_comparison_table.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>Director</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$generic_array['com_dir_name']."</td>
                                 <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$peer_comparison[0]['peer2']."</td>
                               </tr>";
        $peer_comparison_table.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>Company</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[1]['peer1']."</td>
                                 <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[1]['peer2']."</td>
                               </tr>";
        $peer_comparison_table.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>Promoter</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$peer_comparison[2]['peer1']."</td>
                                 <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$peer_comparison[2]['peer2']."</td>
                               </tr>";
        $peer_comparison_table.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>Remuneration (<span style='font-family: Rupee Foradian;'>`</span> Cr) (A)</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[3]['peer1']."</td>
                                 <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[3]['peer2']."</td>
                               </tr>";
        $peer_comparison_table.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>Net Profits (<span style='font-family: Rupee Foradian;'>`</span> Cr) (B)</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$peer_comparison[4]['peer1']."</td>
                                 <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$peer_comparison[4]['peer2']."</td>
                               </tr>";
        $peer_comparison_table.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>Ratio (A/B)</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[5]['peer1']."</td>
                                 <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$peer_comparison[5]['peer2']."</td>

                               </tr>";
        $html = "<table style='border-collapse: collapse; width:100%;'>
            <tbody>
                $peer_comparison_table
            </tbody>
          </table>";

        // Graph Start 
        $_peer_comparison = new WordFragment($docx,"Table");
        $_peer_comparison->embedHTML($html);
        $resolution_text = "Has the Company disclosed its Remuneration Policy: ".$other_text[2]['text'];
        $_peer_comparison->embedHTML(htmlParser($resolution_text));
        $executive_compensation = new WordFragment($docx,"aslk");
        $executive_compensation->addExternalFile(array('src'=>'ExecutiveRemuneration.docx'));
        $valuesTable = array(
            array(
                array('value' =>$_peer_comparison, 'vAlign' => 'top','textAlign'=>'center'),
                array('value' =>$executive_compensation, 'vAlign' => 'top','textAlign'=>'center'),
            )
        );
        $widthTableCols = array(6000,5000);
        $paramsTable = array(
            'border' => 'nil',
            'borderWidth' => 8,
            'borderColor' => 'cccccc',
            'columnWidths' => $widthTableCols
        );
        $docx->addTable($valuesTable, $paramsTable);
        // Graph Ends 

        resBlackStrip($docx,"REMUNERATION PACKAGE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $remuneration_package_table= "<tr>
                                <td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Component</td>
                                <td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Proposed Remuneration</td>
                                <td style='text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Comments</td>
                            </tr>";
        $remuneration_package_table.="<tr>
                                <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Basic Pay</td>
                                <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Proposed Salary: ".$remuneration_package[0]['proposed_salary']."</td>
                                <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Increase in remuneration: ".$remuneration_package[0]['increase_in_remuneration']."</td>
                               </tr>";
        $remuneration_package_table.="<tr>
                                        <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Annual increment: ".$remuneration_package[0]['annual_increment']."</td>
                                     </tr>";
        $remuneration_package_table.="<tr>
                                        <td rowspan='2' style='font-size: 10; background-color: #D9D9D9; text-align: left; '>Perquisites/ Allowances</td>
                                        <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>All perquisites clearly defined: ".$remuneration_package[0]['all_perquisites']."</td>
                                        <td rowspan='2' style='font-size: 10; background-color: #D9D9D9; text-align: left; '>Cap placed on perquisites: ".$remuneration_package[0]['can_placed_perquisites']."</td>
                                     </tr>";
        $remuneration_package_table.="<tr>
                                        <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>Total allowances: ".$remuneration_package[0]['total_allowances']."</td>
                                      </tr>";
        $remuneration_package_table.="<tr>
                                        <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Variable Pay</td>
                                        <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>".$remuneration_package[0]['variable_pay']."</td>
                                        <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Performance criteria disclosed: ".$remuneration_package[0]['performance_criteria']."</td>
                                     </tr>";
        $remuneration_package_table.="<tr>
                                        <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Cap placed on variable pay: ".$remuneration_package[0]['can_placed_on_variable']."</td>
                                      </tr>";
        $remuneration_package_table.="<tr>
                                        <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>Notice Period</td>
                                        <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>".$remuneration_package[0]['notice_period_month']." months</td>
                                        <td rowspan='2' style='font-size: 10; background-color: #D9D9D9; text-align: left; '>".$remuneration_package[0]['notice_period_comment']."</td>
                                      </tr>";
        $remuneration_package_table.="<tr>
                                        <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>Severance Pay</td>
                                        <td style='font-size: 10; background-color: #D9D9D9; text-align: left; '>".$remuneration_package[0]['severance_pay_months']." months</td>
                                      </tr>";
        $remuneration_package_table.="<tr>
                                        <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Minimum Remuneration</td>
                                        <td rowspan='2' style='font-size: 10; background-color: #F2F2F2; text-align: left; '>".$remuneration_package[0]['minimum_remuneration']."</td>
                                        <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Within limits prescribed: ".$remuneration_package[0]['within_limits']."</td>
                                     </tr>";
        $remuneration_package_table.="<tr>
                                <td style='font-size: 10; background-color: #F2F2F2; text-align: left; '>Includes variable pay: ".$remuneration_package[0]['includes_variable']."</td>
                            </tr>";

        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
            <tbody>
                $remuneration_package_table
            </tbody>
          </table>";
        $docx->embedHtml($html);

        $resolution_text="";
        for($i=3;$i<=5;$i++) {
            if($other_text[$i]['text']!="" && $other_text[$i]['text']!="&nbsp;") {
                $resolution_text .= $other_text[$i]['text'];
            }
        }
        $docx->embedHtml(htmlParser($resolution_text));
        $resolution_text="";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $resolution_text .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($resolution_text!="")
            $docx->embedHtml(htmlParser($resolution_text));

    }

    $generic_array = $db->directorsRemunerationNEDC($report_id);
    if($generic_array['non_executive_directors_commission_exists']) {
        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: PAYMENT OF COMMISSIONS TO NON-EXECUTIVE DIRECTORS",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMMISSION PAYABLE");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[2]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[3]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[4]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"DISTRIBUTION OF COMMISSION");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        // Graph Start 
        $average_commision = new WordFragment($docx,"aslk");
        $average_commision->addExternalFile(array('src'=>'AverageCommission.docx'));
        $total_commision = new WordFragment($docx,"aslk");
        $total_commision->addExternalFile(array('src'=>'TotalCommission.docx'));
        $valuesTable = array(
            array(
                array('value' =>$average_commision, 'vAlign' => 'top','textAlign'=>'center'),
                array('value' =>$total_commision, 'vAlign' => 'top','textAlign'=>'center'),
            )
        );
        $widthTableCols = array(6000,6000);
        $paramsTable = array(
            'border' => 'nil',
            'borderWidth' => 8,
            'borderColor' => 'cccccc',
            'columnWidths' => $widthTableCols
        );
        $docx->addTable($valuesTable, $paramsTable);
        // Graph Ends 

        $resolution_text = $other_text[8]['text'];
        $docx->embedHTML(htmlParser($resolution_text));

        $resolution_text="";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $resolution_text .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($resolution_text=="")
            $resolution_text = $analysis_text[count($analysis_text)-1]['analysis_text'];
        if($resolution_text!="")
            $docx->embedHTML(htmlParser($resolution_text));
    }

    $generic_array = $db->directorsRemunerationRNINED($report_id);
    if($generic_array['remuneration_non_independent_exists']) {
        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $analysis_text = $generic_array['analysis_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: REMUNERATION TO NON-INDEPENDENT NON-EXECUTIVE DIRECTORS",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        if($analysis_text[0]['analysis_text']!="" && $analysis_text[0]['analysis_text']!="&nbsp;") {
            $resolution_text = $analysis_text[0]['analysis_text'];
            $docx->embedHTML(htmlParser($resolution_text));
        }
    }

    $generic_array = $db->directorsRemunerationRID($report_id);
    if($generic_array['remuneration_independent_exists']) {

        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $analysis_text = $generic_array['analysis_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: REMUNERATION TO INDEPENDENT DIRECTORS",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->addText("SES RECOMMENDATION",array('headingLevel'=>2,'color'=>'000000','borderBottomSpacing'=>2,'borderTopSpacing'=>2,'fontSize'=>10,'bold'=>true));
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        $docx->addText("SES ANALYSIS",array('headingLevel'=>2,'color'=>'000000','borderBottomSpacing'=>2,'borderTopSpacing'=>2,'fontSize'=>10,'bold'=>true));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        if($analysis_text[0]['analysis_text']!="" && $analysis_text[0]['analysis_text']!="&nbsp;") {
            $resolution_text = $analysis_text[0]['analysis_text'];
            $docx->embedHTML(htmlParser($resolution_text));
        }
    }

    $generic_array = $db->directorsRemunerationWER($report_id);
    if($generic_array['waiver_excess_remuneration_exists']) {
        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $analysis_text = $generic_array['analysis_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: WAIVER OF EXCESS REMUNERATION",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->addText("SES RECOMMENDATION",array('headingLevel'=>2,'color'=>'000000','borderBottomSpacing'=>2,'borderTopSpacing'=>2,'fontSize'=>10,'bold'=>true));
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        $docx->addText("SES ANALYSIS",array('headingLevel'=>2,'color'=>'000000','borderBottomSpacing'=>2,'borderTopSpacing'=>2,'fontSize'=>10,'bold'=>true));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        if($analysis_text[0]['analysis_text']!="" && $analysis_text[0]['analysis_text']!="&nbsp;") {
            $resolution_text = $analysis_text[0]['analysis_text'];
            $docx->embedHTML(htmlParser($resolution_text));
        }
    }
}
function esops($docx,$report_id) {
    $db = new ReportBurning();
    $generic_array = $db->esopsApprovalOfESOPScheme($report_id);
    if($generic_array['esops_approval_ESOP_scheme_exists']) {
        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: APPROVAL OF ESOP SCHEME",1);
        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",1);
        $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",1);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"ESOP DISCLOSURES");
        $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
        $text= "<tr>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Disclosure requirement</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>Disclosure</td>
            </tr>";
        for($i=1;$i<=12;$i++) {
            if($other_text[$i]['text']=="")
                $other_text[$i]['text']="&nbsp;";
            if($i%2==1) {
                $text.="<tr>
                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>".$other_text[$i]['used_in']."</td>
                        <td style='text-align:left;; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".htmlParserForTable($other_text[$i]['text'])."</td>
                       </tr>";
            }
            else {
                $text.="<tr>
                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$other_text[$i]['used_in']."</td>
                        <td style='text-align:left; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".htmlParserForTable($other_text[$i]['text'])."</td>
                       </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $text
                </tbody>
              </table>";
        $docx->embedHTML($html);
        $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"SCHEME ADMINISTRATION");
        $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
        $text= "<tr>
                <td style='text-align: left; width: 40%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Criteria</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>Comments</td>
            </tr>";
        for($i=13;$i<=15;$i++) {
            if($other_text[$i]['text']=="")
                $other_text[$i]['text']="&nbsp;";
            if($i%2==1) {
                $text.="<tr>
                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>".$other_text[$i]['used_in']."</td>
                        <td style='text-align:left;; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".htmlParserForTable($other_text[$i]['text'])."</td>
                       </tr>";
            }
            else {
                $text.="<tr>
                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$other_text[$i]['used_in']."</td>
                        <td style='text-align:left; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".htmlParserForTable($other_text[$i]['text'])."</td>
                       </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $text
                </tbody>
              </table>";
        $docx->embedHTML($html);
        $para = $other_text[16]['text'];
        $docx->embedHtml(htmlParser($para));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="") {
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        }
        echo $analysis_txt;
        $docx->embedHtml(htmlParser($analysis_txt));
    }
    // ESOP RE-PRICING
    $generic_array = $db->esposRePricing($report_id);
    if($generic_array['espos_re_pricing_exists']) {
        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $optios_being_repriced = $generic_array['optios_being_repriced'];
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: ESOP RE-PRICING",1);
        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",1);
        $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",1);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"OPTIONS BEING RE-PRICED");
        $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
        $text= "<tr>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>ESOP Scheme</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>Options outstanding</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>Current Option Price</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>Current Market Price</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>Proposed Option Price</td>
            </tr>";
        for($i=0;$i<count($optios_being_repriced);$i++) {
            if($i%2==0) {
                $text.="<tr>
                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>".$optios_being_repriced[$i]['esop_scheme']."</td>
                        <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$optios_being_repriced[$i]['options_outstanding']."</td>
                        <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$optios_being_repriced[$i]['current_option_price']."</td>
                        <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$optios_being_repriced[$i]['current_market_price']."</td>
                        <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$optios_being_repriced[$i]['proposed_option_price']."</td>
                       </tr>";
            }
            else {
                $text.="<tr>
                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>".$optios_being_repriced[$i]['esop_scheme']."</td>
                        <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$optios_being_repriced[$i]['options_outstanding']."</td>
                        <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$optios_being_repriced[$i]['current_option_price']."</td>
                        <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$optios_being_repriced[$i]['current_market_price']."</td>
                        <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$optios_being_repriced[$i]['proposed_option_price']."</td>
                       </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $text
                </tbody>
              </table>";
        $docx->embedHTML($html);
        $docx->embedHtml("<p style='font-size:1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $docx->embedHtml(htmlParser($other_text[1]['text']));
        resBlackStrip($docx,"STOCK PERFORMANCE VERSUS BENCHMARKS");
        // Graph Start
        $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
        $stock_perrformance = new WordFragment($docx,"aslk");
        $stock_perrformance->addExternalFile(array('src'=>'StockPerformance.docx'));
        $stock_perrformance_comments = new WordFragment($docx,"aslk");
        $stock_perrformance_comments->addText("Comments",array('fontSize'=>10));
        $valuesTable = array(
            array(
                array('value' =>$stock_perrformance, 'vAlign' => 'center','textAlign'=>'center'),
                array('value' =>$stock_perrformance_comments, 'vAlign' => 'top','textAlign'=>'center'),
            )
        );
        $widthTableCols = array(
            7000,7000
        );
        $paramsTable = array(
            'border' => 'nil',
            'borderWidth' => 8,
            'borderColor' => 'cccccc',
            'columnWidths' => $widthTableCols
        );
        $docx->addTable($valuesTable, $paramsTable);
        // Graph Ends
        $docx->embedHtml(htmlParser($other_text[2]['text']));
        resBlackStrip($docx,"SES' OPINION ON RE-PRICING");

        $docx->embedHtml(htmlParser($other_text[3]['text']));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        $docx->embedHtml(htmlParser($analysis_txt));
    }
}
function relatedPartyTransaction($docx,$report_id) {

    $db = new ReportBurning();
//    Burning Appointment Of Auditors At Banks

    $generic_array = $db->relatedPartyTransaction($report_id);
    if($generic_array['related_party_transaction_exists']) {

        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $table_1 = $generic_array['table_1'];
        $table_2 = $generic_array['table_2'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];

        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: RELATED PARTY TRANSACTION",1);
        $docx->embedHtml(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",1);
        $docx->embedHtml(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",1);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"PROPOSED RELATED PARTY TRANSACTIONS");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $inner = "<tr>
                        <td style='text-align: left; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #464646;'>Disclosures</td>
                        <td style='text-align: center; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #464646;'>Details of disclosure</td>
                    </tr>";
        for($i=0;$i<7;$i++) {
            if($i%2==0) {
                $inner .= "<tr>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$table_1[$i]['disclosures']."</td>
                        <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$table_1[$i]['details_of_disclosure']."</td>
                    </tr>";
            }
            else {
                $inner .= "<tr>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>".$table_1[$i]['disclosures']."</td>
                        <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>".$table_1[$i]['details_of_disclosure']."</td>
                    </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width: 98%; margin-left: 8px; '>
                        <tbody>$inner</tbody>
                    </table>";
        $docx->embedHTML($html);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"DETAILS OF TRANSACTION WITH [RELATED PARTY] IN THE PAST");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $inner = "<tr>
                        <td style='text-align: left; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #464646;'>Disclosures (<span style='font-family: Rupee Foradian;'>`</span> in Crores)</td>
                        <td style='text-align: center; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #464646;'>FY ".$table_2[0]['value1']."</td>
                        <td style='text-align: center; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #464646;'>FY ".$table_2[0]['value2']."</td>
                        <td style='text-align: center; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #464646;'>FY ".$table_2[0]['value3']."</td>
                        <td style='text-align: center; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #464646;'>FY ".$table_2[0]['value4']."</td>
                        <td style='text-align: center; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #464646;'>FY ".$table_2[0]['value5']."</td>
                    </tr>";
        for($i=1;$i<=7;$i++) {
            if($i%2==0) {
                $inner .= "<tr>
                            <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$table_2[$i]['label_name']."</td>
                            <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$table_2[$i]['value1']."</td>
                            <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$table_2[$i]['value2']."</td>
                            <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$table_2[$i]['value3']."</td>
                            <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$table_2[$i]['value4']."</td>
                            <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$table_2[$i]['value5']."</td>
                         </tr>";
            }
            else {
                $inner .= "<tr>
                            <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>".$table_2[$i]['label_name']."</td>
                            <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>".$table_2[$i]['value1']."</td>
                            <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>".$table_2[$i]['value2']."</td>
                            <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>".$table_2[$i]['value3']."</td>
                            <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>".$table_2[$i]['value4']."</td>
                            <td style='text-align: center; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>".$table_2[$i]['value5']."</td>
                          </tr>";
            }

        }
        $html = "<table style='border-collapse: collapse; width: 98%; margin-left: 8px; '>
                        <tbody>$inner</tbody>
                    </table>";
        $docx->embedHTML($html);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"PURPOSE OF THE RESOLUTION (AS STATED BY THE COMPANY)");
        $docx->embedHtml(htmlParser($other_text[1]['text']));
        resBlackStrip($docx,"RELATED DIRECTORS/ KMPS");
        $docx->embedHtml(htmlParser($other_text[2]['text']));
        resBlackStrip($docx,"SES VIEWS");
        $docx->embedHtml(htmlParser($other_text[3]['text']));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        $docx->embedHtml(htmlParser($analysis_txt));
    }

}
function intercorporateLoans($docx,$report_id) {
    $db = new ReportBurning();
    $generic_array = $db->intercorporateLoans($report_id);
    $other_text = $generic_array['other_text'];
    $recommendation_text = $generic_array['recommendation_text'];
    $analysis_text = $generic_array['analysis_text'];
    $the_recipient = $generic_array['the_recipient'];
    $existing_transactions = $generic_array['existing_transactions'];

    print_r($recommendation_text);

    $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
    $docx->embedHTML($p_text);

    resHeading($docx,"RESOLUTION []: INTERCORPORATE LOANS/GUARANTEES/INVESTMENTS",1);
    $docx->embedHTML(htmlParser($other_text[0]['text']));

    resHeading($docx,"SES RECOMMENDATION",2);
    $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'],1));

    resHeading($docx,"SES ANALYSIS",2);

    resBlackStrip($docx,"THE RECIPIENT");
    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    $text= "<tr>
                <td rowspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>In <span style='font-family: Rupee Foradian;'>`</span> crore</td>
                <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Lender Company</td>
                <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; '>Recipient Copany</td>
            </tr>";
    $the_recipient[0]['s_date'] = date_format(date_create_from_format('Y-m-d',$the_recipient[0]['s_date']), 'd M Y');
    $the_recipient[1]['s_date'] = date_format(date_create_from_format('Y-m-d',$the_recipient[1]['s_date']), 'd M Y');
    $the_recipient[2]['s_date'] = date_format(date_create_from_format('Y-m-d',$the_recipient[2]['s_date']), 'd M Y');
    $the_recipient[3]['s_date'] = date_format(date_create_from_format('Y-m-d',$the_recipient[3]['s_date']), 'd M Y');
    $text.="<tr>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>".$the_recipient[0]['s_date']."</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>".$the_recipient[1]['s_date']."</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>".$the_recipient[2]['s_date']."</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; '>".$the_recipient[3]['s_date']."</td>
            </tr>";

    $text.="<tr>
                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Share Capital</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[0]['share']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[1]['share']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[2]['share']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[3]['share']."</td>
             </tr>";
    $text.="<tr>
                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Reserves and Surplus</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[0]['reserves_and_surplus']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[1]['reserves_and_surplus']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[2]['reserves_and_surplus']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[3]['reserves_and_surplus']."</td>
             </tr>";
    $text.="<tr>
                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Total Assets</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[0]['assets']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[1]['assets']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[2]['assets']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[3]['assets']."</td>
             </tr>";
    $text.="<tr>
                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Total Liabilities</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[0]['liabilities']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[1]['liabilities']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[2]['liabilities']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[3]['liabilities']."</td>
             </tr>";
    $text.="<tr>
                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Revenues</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[0]['revenues']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[1]['revenues']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[2]['revenues']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$the_recipient[3]['revenues']."</td>
             </tr>";
    $text.="<tr>
                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Profit After Tax</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[0]['profit_after_tax']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[1]['profit_after_tax']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[2]['profit_after_tax']."</td>
                <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$the_recipient[3]['profit_after_tax']."</td>
             </tr>";

    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $text
                </tbody>
              </table>";
    $docx->embedHTML($html);
    $other_txt = $other_text[1]['text'];
    $other_txt .= $other_text[2]['text'];
    $other_txt .= $other_text[3]['text'];
    $docx->embedHTML(htmlParser($other_txt));

    resBlackStrip($docx,"EXISTING TRANSACTIONS WITH THE RECIPIENT");
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    $text="<tr>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Type</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Transaction Details</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Date 1</td>
                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; '>Date 2</td>
            </tr>";
    $text.="<tr>
            <td rowspan='2' style='border-right: 1px solid #FFFFFF;border-bottom: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>".$existing_transactions[0]['type']."</td>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$existing_transactions[0]['transaction_details']."</td>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$existing_transactions[0]['details_values1']."</td>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$existing_transactions[0]['details_values2']."</td>
         </tr>";
    $text.="<tr>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$existing_transactions[1]['transaction_details']."</td>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$existing_transactions[1]['details_values1']."</td>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$existing_transactions[1]['details_values2']."</td>
         </tr>";
    $text.="<tr>
            <td rowspan='2' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>".$existing_transactions[2]['type']."</td>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$existing_transactions[2]['transaction_details']."</td>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$existing_transactions[2]['details_values1']."</td>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$existing_transactions[2]['details_values2']."</td>
         </tr>";
    $text.="<tr>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$existing_transactions[3]['transaction_details']."</td>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$existing_transactions[3]['details_values1']."</td>
            <td style='text-align:center; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".$existing_transactions[3]['details_values2']."</td>
         </tr>";
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $text
                </tbody>
              </table>";
    $docx->embedHTML($html);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    resBlackStrip($docx,"PURPOSE OF THE TRANSACTION");
    $other_txt = $other_text[4]['text'];
    $docx->embedHTML(htmlParser($other_txt));
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    resBlackStrip($docx,"TERMS AND CONDITIONS OF THE TRANSACTION");
    $other_txt = $other_text[5]['text'];
    $docx->embedHTML(htmlParser($other_txt));
    $other_txt = $other_text[6]['text'];
    $docx->embedHTML(htmlParser($other_txt));
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    resBlackStrip($docx,"FAIRNESS OF THE TRANSACTION");
    $other_txt = $other_text[7]['text'];
    $docx->embedHTML(htmlParser($other_txt));
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    resBlackStrip($docx,"DIRECTORS' INTERESTS");
    $other_txt = $other_text[8]['text'];
    $docx->embedHTML(htmlParser($other_txt));
    $other_txt = $other_text[9]['text'];
    $docx->embedHTML(htmlParser($other_txt));

    $analysis_txt = "";
    for($i=0;$i<count($analysis_text)-1;$i++) {
        if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
            $analysis_txt .= $analysis_text[$i]['analysis_text'];
        }
    }
    if($analysis_txt=="")
        $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
    if($analysis_txt!="")
        $docx->embedHtml(htmlParser($analysis_txt));

}
function corporateAction($docx,$report_id) {

    $db = new ReportBurning();
    $generic_array = $db->corporateActionStockSplit($report_id);
    if($generic_array['stock_split_exists']) {
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: STOCK SPLIT",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"TRENDS IN COMPANY'S STOCK PRICE");
        $docx->embedHTML($p_text);
        // Graph Start

        $trends_in_company_table= "<tr>
                                    <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>".$generic_array['company_name']."</td>
                                </tr>";
        $other_text[2]['text'] = date_format(date_create_from_format('d-M-Y', $other_text[2]['text']), 'Y-m-d');
        $trends_in_company_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Current Price (".getDocxFormatDate($other_text[2]['text']).")</td>
                                    <td style='text-align:left;; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '><span style='font-family: Rupee Foradian;'>`</span> ".$other_text[3]['text']."</td>
                                   </tr>";
        $trends_in_company_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>52 week high</td>
                                    <td style='text-align:left; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".htmlParserForTable($other_text[4]['text'])."</td>
                                   </tr>";
        $trends_in_company_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>52 week low</td>
                                    <td style='text-align:left;; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".htmlParserForTable($other_text[5]['text'])."</td>
                                   </tr>";
        $trends_in_company_table.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Price appreciation in last year</td>
                                <td style='text-align:left;; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; '>".htmlParserForTable($other_text[6]['text'])."%</td>
                               </tr>";
        $trends_in_company_table.="<tr>
                                    <td colspan='2' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #FFF; text-align: left; '>
                                    <ul style='padding: 0px; margin: 0;'>
                                        <li style='padding: 0; margin: 0;'>The subdivision will not have any dilutive impact on investor shareholdings.</li>
                                        <li>The stock price is in a region where a stock split may improve the stock's liquidity</li>
                                    </ul>
                                    </td>
                               </tr>";
        $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $trends_in_company_table
                </tbody>
              </table>";

        $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
        $stock_perrformance_comments = new WordFragment($docx,"aslk");
        $stock_perrformance_comments->embedHTML($html);
        $stock_price_graph = new WordFragment($docx,"aslk");
        $stock_price_graph->addExternalFile(array('src'=>'StockPrice.docx'));
        $valuesTable = array(
            array(
                array('value' =>$stock_perrformance_comments, 'vAlign' => 'top','textAlign'=>'center'),
                array('value' =>$stock_price_graph, 'vAlign' => 'top','textAlign'=>'center'),
            )
        );
        $widthTableCols = array(
            8000,6000
        );
        $paramsTable = array(
            'border' => 'nil',
            'borderWidth' => 8,
            'borderColor' => 'cccccc',
            'columnWidths' => $widthTableCols
        );
        $docx->addTable($valuesTable, $paramsTable);

        // Graph Ends

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        $docx->embedHtml(htmlParser($analysis_txt));
    }

    // Share Buy Back Page Burning

    $generic_array = $db->corporateActionShareBuyBack($report_id);
    if($generic_array['share_buy_back_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $shareholding = $generic_array['shareholding'];

        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: BUY-BACK OF EQUITY SHARES",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"RATIONALE FOR THE BUY-BACK");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resBlackStrip($docx,"ELIGIBILITY FOR BUY-BACK");
        $resolution_text = $other_text[2]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resBlackStrip($docx,"SIZE OF THE BUY-BACK");
        $resolution_text = $other_text[3]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resBlackStrip($docx,"BUY-BACK PRICE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $trends_in_company_table= "<table style='width:98%; margin-left: 8px; border-collapse: collapse; '>
                               <tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Maximum Buy-back price</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>".htmlParserForTable($other_text[4]['text'])."</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>Average Closing price in the last two weeks</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; '>".htmlParserForTable($other_text[6]['text'])."</td>
                               </tr>";
        $trends_in_company_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Closing Price as on []</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>".htmlParserForTable($other_text[5]['text'])."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>Average Closing price in the last six months</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; '>".htmlParserForTable($other_text[7]['text'])."</td>
                                   </tr>";
        $trends_in_company_table.="</table>";
        $docx->embedHTML($trends_in_company_table);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"PARTICIPATION OF THE PROMOTER GROUP");
        $resolution_text = $other_text[8]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"CHANGE IN SHAREHOLDING PATTERN");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $change_in_sharholding_table= "<table style='width:98%; margin-left: 8px; border-collapse: collapse; '>";
        $change_in_sharholding_table.="<tr >
                                        <th rowspan='3' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF; color: #FFFFFF;'>Item</th>
                                        <th colspan='2' rowspan='2' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right:1px solid #FFFFFF; border-bottom:2px solid #FFFFFF; color: #FFFFFF; '>Pre-Buyback</th>
                                        <th colspan='4' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-bottom:3px solid #FFFFFF; color: #FFFFFF;'>Post-Buyback of shares</th>
                                      </tr>
                                      <tr>
                                        <th colspan='2' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-bottom:2px solid #FFFFFF; color: #FFFFFF;'>Minimum buy-back</th>
                                        <th colspan='2' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-bottom:2px solid #FFFFFF; color: #FFFFFF; '>Maximum buy-back</th>
                                      </tr>
                               <tr>
                                    <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; color: #FFFFFF; '>Quantity</th>
                                    <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; color: #FFFFFF;'>Percentage</th>
                                    <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; color: #FFFFFF;'>Quantity</th>
                                    <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; color: #FFFFFF;'>Percentage</th>
                                    <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; color: #FFFFFF;'>Quantity</th>
                                    <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; color: #FFFFFF;'>Percentage</th>
                               </tr>";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Total Shares</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;'>".$shareholding[0]['qty']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$shareholding[0]['percent']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$shareholding[1]['qty']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$shareholding[1]['percent']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$shareholding[2]['qty']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$shareholding[2]['percent']."</td>

                                </tr>  ";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Promoter Group</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$shareholding[3]['qty']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$shareholding[3]['percent']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;'>".$shareholding[4]['qty']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$shareholding[4]['percent']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$shareholding[5]['qty']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;'>".$shareholding[5]['percent']."</td>
                                </tr>  ";

        $change_in_sharholding_table.="</table>";
        $docx->embedHTML($change_in_sharholding_table);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"IMPACT");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp; </p>");
        $resolution_text = $other_text[10]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[11]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resBlackStrip($docx,"DISCLOSURES");
        $resolution_text = $other_text[12]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[13]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[14]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[15]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[16]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[17]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[18]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[19]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[20]['text'];
        $docx->embedHTML(htmlParser($resolution_text));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="") {
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        }
        $docx->embedHtml(htmlParser($analysis_txt));
    }

    // Share Buy Back Page Burning Ends


    // Capital Reduction Page Burning

    $generic_array = $db->corporateActionCapitalReduction($report_id);
    if($generic_array['capital_reduction_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];

        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: CAPITAL REDUCTION",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"Company's Justification");
        $html = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($html));
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }

    // Capital Reduction Page Burning Ends


    // Debt Restructuring Page Burning

    $generic_array = $db->corporateActionDebtRestructuring($report_id);
    if($generic_array['debt_restructuring_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];

        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: DEBT RESTRUCTURING",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"Company's Justification");
        $html = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($html));
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }

    // Debt Restructuring Page Burning Ends


    // Variation in terms of use of IPO proceeds Page Burning

    $generic_array = $db->corporateActionVariationIPO($report_id);
    if($generic_array['variation_ipo_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];

        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: VARIATION IN TERMS OF USE OF IPO PROCEEDS",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"Company's Justification");
        $html = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($html));
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }

    // Variation in terms of use of IPO proceeds Page Burning Ends


    // Creation of charge Page Burning

    $generic_array = $db->corporateActionCreationOfCharge($report_id);
    if($generic_array['creation_of_charge_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];

        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: CREATION OF CHARGE",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"Company's Justification");
        $html = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($html));

        $html = $other_text[2]['text'];
        $docx->embedHTML(htmlParser($html));
        $html = $other_text[3]['text'];
        $docx->embedHTML(htmlParser($html));
        $html = $other_text[4]['text'];
        $docx->embedHTML(htmlParser($html));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="") {
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }

    // Creation of charge Page Burning Ends


    // Sale of Assets Page Burning

    $generic_array = $db->corporateActionSaleOfAssets($report_id);
    if($generic_array['sale_of_assets_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];

        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: SALE OF ASSETS/BUSINESS/UNDERTAKING",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text =$recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"DETAILS OF THE PROPOSED SALE");
        $html = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($html));
        $html = $other_text[2]['text'];
        $docx->embedHTML(htmlParser($html));
        $html = $other_text[3]['text'];
        $docx->embedHTML(htmlParser($html));
        $html = $other_text[4]['text'];
        $docx->embedHTML(htmlParser($html));
        $html = $other_text[5]['text'];
        $docx->embedHTML(htmlParser($html));
        resBlackStrip($docx,"RATIONALE FOR THE SALE");
        $html = $other_text[6]['text'];
        $docx->embedHTML(htmlParser($html));
        resBlackStrip($docx,"IMPACT OF THE SALE");
        $html = $other_text[7]['text'];
        $docx->embedHTML(htmlParser($html));
        $html = $other_text[8]['text'];
        $docx->embedHTML(htmlParser($html));
        $html = $other_text[9]['text'];
        $docx->embedHTML(htmlParser($html));
        resBlackStrip($docx,"USE OF FUNDS");
        $html = $other_text[10]['text'];
        $docx->embedHTML(htmlParser($html));
        resBlackStrip($docx,"FAIRNESS OF SALE");
        $html = $other_text[11]['text'];
        $docx->embedHTML(htmlParser($html));
        resBlackStrip($docx,"CONFLICT OF INTEREST ISSUES");
        $html = $other_text[12]['text'];
        $docx->embedHTML(htmlParser($html));
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="") {
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }

    // Sale of Assets Page Burning Ends

    // Increase in borrowing Limits
    $generic_array = $db->corporateActionIncreaseInBorrowingLimits($report_id);
    if($generic_array['increase_borrowing_limits_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];

        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: INCREASE IN BORROWING LIMITS",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"PURPOSE OF THE INCREASED BORROWING LIMITS");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"CHANGES IN REMAINING BORROWING CAPACITY");
        // Graph Start
        $docx->embedHtml("<p style='font-size: 2;'>&nbsp;</p>");
        $borrowing_limits_text = $other_text[2]['text'];
        $stock_perrformance_comments = new WordFragment($docx,"aslk");
        $stock_perrformance_comments->embedHTML(htmlParser($borrowing_limits_text));
        $borrowing_limit_graph = new WordFragment($docx,"aslk");
        $borrowing_limit_graph->addExternalFile(array('src'=>'UtilizationBorrowingLimits.docx'));
        $valuesTable = array(
            array(
                array('value' =>$borrowing_limit_graph, 'vAlign' => 'top','textAlign'=>'center'),
                array('value' =>$stock_perrformance_comments, 'vAlign' => 'top','textAlign'=>'left'),
            )
        );
        $widthTableCols = array(
            6000,8000
        );
        $paramsTable = array(
            'border' => 'nil',
            'borderWidth' => 8,
            'borderColor' => 'cccccc',
            'columnWidths' => $widthTableCols
        );
        $docx->addTable($valuesTable, $paramsTable);

        // Graph Ends

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }

}
function issuesOfShares($docx,$report_id) {

    $db = new ReportBurning();

    // Rights Issue/Public Issue Page Burning
    $generic_array = $db->issuesOfSharesRightsIssue($report_id);
    if($generic_array['rights_issue_public_issue_exists']) {
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: RIGHTS ISSUE/PUBLIC ISSUE",1);
        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",2);
        $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY JUSTIFICATION");
        $docx->embedHTML(htmlParser($other_text[1]['text']));
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        $docx->embedHTML(htmlParser($analysis_txt));
    }
    // Rights Issue/Public Issue Page Burning ENDS

    // PreferentialIssue Page Burning
    $generic_array = $db->issuesOfSharesPreferentialIssue($report_id);
    if($generic_array['preferential_issue_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $equity_row = $generic_array['equity_row'];
        $dilution_to_shareholding = $generic_array['dilution_to_shareholding'];

        $docx->addBreak(array('type' => 'page'));

        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: PREFERENTIAL ISSUE",1);
        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",2);
        $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"DETAILS OF THE PROPOSED ISSUE");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[2]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[3]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[4]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resBlackStrip($docx,"OBJECTIVE OF THE PROPOSED ISSUE");
        $docx->embedHTML(htmlParser($other_text[5]['text']));
        $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>SES is of the opinion that existing shareholders should have first right to participate in any capital issue. Preferential issues have a negative dilution effect on the minority shareholders' equity. Therefore, SES is against preferential allotment of shares to a particular shareholder or class of shareholders. SES believes that to raise equity capital, the Company should first go for a rights issue failing which it should look for an alternate source of equity funding. Only in circumstances where there is urgent need for funds or a strategic investor is investing in the Company should the Company go for a preferential issue instead of a rights issue.</p>";
        $docx->embedHTML($resolution_text);
        resBlackStrip($docx,"PAST EQUITY ISSUES");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $past_equity_issues= "<tr>
                                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Year</td>
                                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Capital Raised (<span style='font-family: Rupee Foradian;'>`</span> Crore)</td>
                                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Subscriber</td>
                                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>No of shares</td>
                                <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Issue price/share (<span style='font-family: Rupee Foradian;'>`</span>)</td>
                            </tr>";
        for($i=0;$i<count($equity_row);$i++) {
            if($i%2==0) {
                $past_equity_issues.="<tr>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$equity_row[$i]['year']."</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$equity_row[$i]['capital_raised']."</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$equity_row[$i]['subscriber']."</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$equity_row[$i]['no_of_shares']."</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$equity_row[$i]['issues_price']."</td>
                               </tr>";
            }
            else {
                $past_equity_issues.="<tr>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$equity_row[$i]['year']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$equity_row[$i]['capital_raised']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$equity_row[$i]['subscriber']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$equity_row[$i]['no_of_shares']."</td>
                                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$equity_row[$i]['issues_price']."</td>
                                       </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $past_equity_issues
                </tbody>
              </table>";
        $docx->embedHtml($html);
        $docx->embedHTML(htmlParser($other_text[6]['text']));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"DILUTION TO SHAREHOLDING");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $dilution_shareholding= "<tr>
                                    <td rowspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Sr. No.</td>
                                    <td rowspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Class of Shareholder</td>
                                    <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>Pre-allotment of shares</td>
                                    <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>Post-allotment of shares</td>
                                </tr>";
        $dilution_shareholding.= "<tr>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>No of shares</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>% of paid up capital</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>No of shares</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>% of paid up capital</td>
                                </tr>";
        for($i=0;$i<count($dilution_to_shareholding);$i++) {
            if($i%2==0) {
                $dilution_shareholding.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['sno']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['class_of_shareholder']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['pre_allotment_no_of_shares']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['pre_allotment_paid_up_capital']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['post_allotment_no_of_shares']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['post_allotment_paid_up_capital']."</td>
                                           </tr>";
            }
            else {
                $dilution_shareholding.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['sno']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['class_of_shareholder']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['pre_allotment_no_of_shares']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['pre_allotment_paid_up_capital']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['post_allotment_no_of_shares']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['post_allotment_paid_up_capital']."</td>
                                           </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $dilution_shareholding
                </tbody>
              </table>";
        $docx->embedHtml($html);
        $docx->embedHTML(htmlParser($other_text[7]['text']));
        resBlackStrip($docx,"OTHER DISCLOSURES");
        $resolution_text = $other_text[8]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[9]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[10]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[11]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[12]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[13]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[14]['text'];
        $docx->embedHTML(htmlParser($resolution_text));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="") {
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        }
        if($analysis_txt!="")
            $docx->embedHTML(htmlParser($analysis_txt));
    }
    // PreferentialIssue Burning ENDS

    // Bonus Issue Page Burning
    $generic_array = $db->issuesOfSharesBonusIssue($report_id);
    if($generic_array['bonus_issue_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];

        $docx->addBreak(array('type' => 'page'));

        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: ISSUE OF BONUS SHARES",1);

        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",2);

        $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");

        resBlackStrip($docx,"DETAILS OF THE PROPOSED ISSUE");
        $docx->embedHTML(htmlParser($other_text[1]['text']));

        $resolution_text = $other_text[2]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[3]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[4]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[5]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resBlackStrip($docx,"OBJECTIVE OF THE PROPOSED ISSUE");
        $docx->embedHTML(htmlParser($other_text[6]['text']));
        resBlackStrip($docx,"FINANCIAL POSITION OF THE COMPANY");
        $docx->embedHTML(htmlParser($other_text[7]['text']));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }

        if($analysis_txt=="") {
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }
    // Bonus Issue Page Burning ENDS

    // Issue of Securities to Public Page Burning
    $generic_array = $db->issuesOfSharesIssueOfSecuritiesToPublic($report_id);
    if($generic_array['issue_of_securities_to_public_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $dilution_to_shareholding = $generic_array['dilution_to_shareholding'];

        $docx->addBreak(array('type' => 'page'));

        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: ISSUE OF SECURITIES TO PUBLIC",1);
        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",2);
        $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"OBJECTIVE OF THE ISSUE");
        $docx->embedHTML(htmlParser($other_text[1]['text']));
        resBlackStrip($docx,"DETAILS OF THE ISSUE");
        $resolution_text = $other_text[2]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[3]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[4]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[5]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[6]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resBlackStrip($docx,"DILUTION TO SHAREHOLDING");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $dilution_shareholding= "<tr>
                                    <td rowspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Sr. No.</td>
                                    <td rowspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Class of Shareholder</td>
                                    <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>Pre-allotment of shares</td>
                                    <td colspan='2' style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF; border-bottom: 1px solid #FFF;'>Post-allotment of shares</td>
                                </tr>";
        $dilution_shareholding.= "<tr>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>No of shares</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>% of paid up capital</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>No of shares</td>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>% of paid up capital</td>
                                </tr>";
        for($i=0;$i<count($dilution_to_shareholding);$i++) {
            if($i%2==0) {
                $dilution_shareholding.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['sno']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['class_of_shareholder']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['pre_nos']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['pre_paid_up']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['post_nos']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; '>".$dilution_to_shareholding[$i]['post_paid_up']."</td>
                                           </tr>";
            }
            else {
                $dilution_shareholding.="<tr>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['sno']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['class_of_shareholder']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['pre_nos']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['pre_paid_up']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['post_nos']."</td>
                                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; '>".$dilution_to_shareholding[$i]['post_paid_up']."</td>
                                           </tr>";
            }
        }
        $html = "<table style='border-collapse: collapse; width:98%; margin-left: 8px;'>
                <tbody>
                    $dilution_shareholding
                </tbody>
              </table>";
        $docx->embedHtml($html);
        $docx->embedHTML("<p style='font-size: 1; padding-top: 4px; padding-bottom: 4px;'>&nbsp;</p>");
        resBlackStrip($docx,"CONFLICT OF INTERESTS");
        $docx->embedHTML(htmlParser($other_text[7]['text']));
        resBlackStrip($docx,"OTHER DISCLOSURES");
        $resolution_text = $other_text[8]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '><span style='font-weight: bold;'>Relevant Date:</span> ".$other_text[9]['text']."</p>";
        $docx->embedHTML($resolution_text);
        $resolution_text = $other_text[10]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[11]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[12]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="") {
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }
    // Issue of Securities to Public Burning ENDS

    // Issue of preference shares Page Burning
    $generic_array = $db->issuesOfSharesIssueOfPreferenceShares($report_id);
    if($generic_array['issue_of_preference_shares_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: ISSUE OF PREFERENCE SHARES",1);
        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",2);
        $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"OBJECTIVE OF THE ISSUE");
        $docx->embedHTML(htmlParser($other_text[1]['text']));
        resBlackStrip($docx,"TERMS OF THE ISSUE");
        $resolution_text = $other_text[2]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[3]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[4]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[5]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resBlackStrip($docx,"FINANCIAL POSITION (CAPACITY TO PAY DIVIDENDS TO PREFERENCE SHAREHOLDERS)");
        $docx->embedHTML(htmlParser($other_text[6]['text']));
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="") {
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }
    // Issue of preference shares Burning ENDS

    // Issue of shares with differential voting Rights Page Burning
    $generic_array = $db->issuesOfSharesIssueOfSharesWithDifferentialVotingRights($report_id);
    if($generic_array['issue_of_shares_with_differential_voting_rights_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));

        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: ISSUE OF SHARES WITH DIFFERENTIAL VOTING RIGHTS",1);
        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",2);
        $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $docx->embedHTML(htmlParser($other_text[1]['text']));
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }
    // Issue of shares with differential voting Rights Page Burning ENDS

}
function schemeOfArrangement($docx,$report_id){

    $db = new ReportBurning();
    $generic_array = $db->schemeOfArrangement($report_id);

    if($generic_array['scheme_arrangement_exists']) {
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $profiles = $generic_array['profiles'];
        $pattern = $generic_array['pattern'];
        $capital = $generic_array['capital'];
        print_r($profiles);
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: SCHEME OF ARRANGEMENT/AMALGAMATION",1);
        $docx->embedHTML(htmlParser($other_text[0]['text']));
        resHeading($docx,"SES RECOMMENDATION",2);
        $docx->embedHTML(htmlParser($recommendation_text['recommendation_text'],1));
        resHeading($docx,"THE SCHEME",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"OVERVIEW");
        $docx->embedHTML(htmlParser($other_text[1]['text']));

        resBlackStrip($docx,"PROFILES OF THE COMPANIES");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $change_in_sharholding_table= "<table style='width:98%; margin-left: 8px; border-collapse: collapse; '>";
        $change_in_sharholding_table.="<tr >
                                <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: left; border-right:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF; color: #FFFFFF;'></th>";
        for($i=0; $i<count($profiles);$i++){
            $change_in_sharholding_table.="<th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color:#808080; text-align: left; border-right:1px solid #FFFFFF; border-bottom:2px solid #FFFFFF; color: #FFFFFF; '>".$profiles[$i]['company_name']."</th>";
        }
        $change_in_sharholding_table.=" </tr>";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Background</td>";
        for($i=0; $i<count($profiles);$i++){
            $change_in_sharholding_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;'>".$profiles[$i]['background']."</td>";
        }
        $change_in_sharholding_table.="</tr>";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Nature of Business</td>";
        for($i=0; $i<count($profiles);$i++){
            $change_in_sharholding_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$profiles[$i]['nature_of_bussiness']."</td>";
        }
        $change_in_sharholding_table.="</tr>";

        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Authorized Capital</td>";
        for($i=0; $i<count($profiles);$i++){
            $change_in_sharholding_table.=" <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$profiles[$i]['aurthorized_capital']."</td>";
        }
        $change_in_sharholding_table.="</tr>  ";

        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Issued, Subscribed and Paid-up Capital</td>";
        for($i = 0; $i < count($profiles);$i++){
            $change_in_sharholding_table.="<td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$profiles[$i]['issued_capital']."</td>";
        }

        $change_in_sharholding_table.="</tr>  ";

        $change_in_sharholding_table.="</table>";
        $docx->embedHTML($change_in_sharholding_table);

        $docx->embedHTML("<p style='font-size: 1;'>&nbsp; </p>");

        $docx->embedHTML(htmlParser($other_text[2]['text']));

        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");

        resBlackStrip($docx,"RATIONALE FOR THE SCHEME");
        $docx->embedHTML(htmlParser($other_text[3]['text']));

        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");

        resBlackStrip($docx,"KEY STEPS IN THE SCHEME");
        $docx->embedHTML(htmlParser($other_text[4]['text']));


        resBlackStrip($docx,"THE SCHEME OF ARRANGEMENT");
        $docx->embedHTML(htmlParser($other_text[5]['text']));

        $change_in_sharholding_table="<table style='width:98%; margin-left: 8px; border-collapse: collapse; '>
                                <tr >
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; border-right:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF; '>Consideration</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; border-right:1px solid #FFFFFF; border-bottom:2px solid #FFFFFF;  '>".htmlParserForTable($other_text[6]['text'])."</td>
                                </tr>";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Valuation / Fairness Opinion</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;'>".htmlParserForTable($other_text[7]['text'])."</td>
                                    </tr>  ";
        $change_in_sharholding_table.="<tr >
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; border-right:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF; '>Payment of Consideration</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; border-right:1px solid #FFFFFF; border-bottom:2px solid #FFFFFF;'>".htmlParserForTable($other_text[8]['text'])."</td>
                                </tr>";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Transfer of Assets/ Liabilities</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;'>".htmlParserForTable($other_text[9]['text'])."</td>
                                    </tr>  ";
        $change_in_sharholding_table.="<tr >
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; border-right:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;'>Remaining Business</td>
                                <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: left; border-right:1px solid #FFFFFF; border-bottom:2px solid #FFFFFF;  '>".htmlParserForTable($other_text[10]['text'])."</td>
                                </tr>";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Type of Transaction</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: left; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;'>".htmlParserForTable($other_text[11]['text'])."</td>
                                    </tr>";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #d9d9d9; text-align: left;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Time Line</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #d9d9d9; text-align: left; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;'>".htmlParserForTable($other_text[12]['text'])."</td>
                                    </tr> </table> ";
        $docx->embedHTML($change_in_sharholding_table);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"CHANGE IN SHAREHOLDING PATTERN");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $change_in_sharholding_table= "<table style='width:98%; margin-left: 8px; border-collapse: collapse; '>";
        $change_in_sharholding_table.="<tr >
                                <th rowspan='2' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF; color: #FFFFFF;'>Category</th>
                                <th colspan='2' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right:1px solid #FFFFFF; border-bottom:2px solid #FFFFFF; color: #FFFFFF; '>Pre Arrangement</th>
                                <th colspan='2' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-bottom:2px solid #FFFFFF; color: #FFFFFF;'>Post Arrangement</th>
                               </tr>
                               <tr>
                                    <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; color: #FFFFFF; '>Number of shares</th>
                                    <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; color: #FFFFFF;'>% shareholding</th>
                                    <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; color: #FFFFFF;'>Number of shares</th>
                                    <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #808080; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; color: #FFFFFF;'>% shareholding</th>
                                </tr>";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Promoter group</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;'>".$pattern[0]['pre_nos']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$pattern[0]['pre_percent']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$pattern[0]['post_nos']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$pattern[0]['post_percent']."</td>
                                    </tr>  ";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Public (Institutional)</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$pattern[1]['pre_nos']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$pattern[1]['pre_percent']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;'>".$pattern[1]['post_nos']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$pattern[1]['post_percent']."</td>
                                    </tr>  ";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Other Public</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;'>".$pattern[2]['pre_nos']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$pattern[2]['pre_percent']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$pattern[2]['post_nos']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$pattern[2]['post_percent']."</td>
                                    </tr>  ";
        $total_pre_percent =  $pattern[0]['pre_nos'] + $pattern[1]['pre_nos'] + $pattern[2]['pre_nos'];
        $total_post_percent =  $pattern[0]['post_nos'] + $pattern[1]['post_nos'] + $pattern[2]['post_nos'];
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Total</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$total_pre_percent."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>100</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;'>".$total_post_percent."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>100</td>
                                    </tr>  ";
        $change_in_sharholding_table.="</table>";
        $docx->embedHTML($change_in_sharholding_table);

        $docx->embedHTML(htmlParser($other_text[13]['text']));

        resBlackStrip($docx,"CHANGE IN CAPITAL STRUCTURE");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        $change_in_sharholding_table= "<table style='width:98%; margin-left: 8px; border-collapse: collapse; '>";
        $change_in_sharholding_table.="<tr >
                                    <th colspan='5' style='border-right: 1px solid #FFFFFF; font-size: 10; color: #FFF; background-color: #808080; text-align: center; border-right:1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;'>Share Capital Structure</th>
                                   </tr>
                                <tr>
                                <th style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; border-right:1px solid #FFFFFF; border-bottom:2px solid #FFFFFF; color: #FFFFFF;'>&nbsp;</th>
                                <th colspan='2' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; border-right:1px solid #FFFFFF; border-bottom:2px solid #FFFFFF; '>Pre-scheme of arrangement</th>
                                <th colspan='2' style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center; border-bottom:2px solid #FFFFFF; '>Post-scheme of arrangement</th>
                               </tr>

                               ";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Authorized</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center; border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF;'>".$capital[0]['pre_scheme']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$capital[1]['pre_scheme']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$capital[0]['post_scheme']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$capital[1]['post_scheme']."</td>
                                    </tr>  ";
        $change_in_sharholding_table.="<tr>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>Issued</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$capital[2]['pre_scheme']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$capital[3]['pre_scheme']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF; border-bottom:1px solid #FFFFFF;'>".$capital[2]['post_scheme']."</td>
                                    <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; text-align: center;border-right: 1px solid #FFFFFF;border-bottom:1px solid #FFFFFF; '>".$capital[3]['post_scheme']."</td>";


        $change_in_sharholding_table.="</table>";
        $docx->embedHTML($change_in_sharholding_table);
        $docx->embedHTML(htmlParser($other_text[14]['text']));
        resBlackStrip($docx,"COMPANY'S DECLARATIONS");
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp; </p>");
        $resolution_text = $other_text[16]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[17]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resBlackStrip($docx,"CONFLICT OF INTERESTS");
        $resolution_text = $other_text[18]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[19]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES ANALYSIS OF THE SCHEME",1);
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="") {
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        }
        if($analysis_txt!="")
            $docx->embedHTML(htmlParser($analysis_txt));
    }
}
function alterrationInMoaAoa($docx,$report_id) {

    $db = new ReportBurning();

    // Change in Objects Clause Page Burning
    $generic_array = $db->alterationMoaAoaChangeInObjectsClause($report_id);
    if($generic_array['change_in_object_clause_exists']) {
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: CHANGE IN OBJECT CLAUSE",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }
    // Change in Objects Clause Page Burning ENDS

    // Change in Quorum Requirements Page Burning
    $generic_array = $db->alterationMoaAoaChangeInQuorumRequirements($report_id);
    if($generic_array['change_in_quorum_requirements_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));

        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: CHANGE IN QUORUM REQUIREMENTS",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }
    // Change in Quorum Requirements Burning ENDS

    // Change in name of the Company Page Burning
    $generic_array = $db->alterationMoaAoaChangeInNameCompany($report_id);
    if($generic_array['change_in_name_of_the_company_exists']) {
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));

        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: CHANGE IN NAME OF THE COMPANY",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[2]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[3]['text'];
        $docx->embedHTML(htmlParser($resolution_text));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="")
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }
    // Change in name of the Company Page Burning Ends

    // Change in Registered office of the Company Page Burning
    $generic_array = $db->alterationMoaAoaChangeInRegisteredOffice($report_id);
    if($generic_array['change_in_registered_office_company_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: CHANGE IN REGISTERED OFFICE OF THE COMPANY",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }
    // Change in Registered office of the Company Page Burning Ends

    // Change in Authorized Capital Burning
    $generic_array = $db->alterationMoaAoaChangeInAuthorizedCapital($report_id);
    if($generic_array['change_in_authorized_capital_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));

        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);

        resHeading($docx,"RESOLUTION []: CHANGE IN AUTHORIZED CAPITAL",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="")
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));

    }
    // Change in Authorized Capital Burning Ends

    // Increase in Board Strength Burining
    $generic_array = $db->alterationMoaAoaIncreaseInBoardStrength($report_id);
    if($generic_array['increase_in_board_strength_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));

        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []:  INCREASE IN BOARD STRENGTH",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="")
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));

    }
    // Increase in Board Strength Burining Ends

    // Changes due to shareholders' Agreements Burining
    $generic_array = $db->alterationMoaAoaChangesDueToShareholdersAgreements($report_id);
    if($generic_array['changes_shareholders_agreements_exists']) {
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));

        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: CHANGES DUE TO SHAREHOLDERS'S AGREEMENTS",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="")
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));

    }
    // Changes due to shareholders' Agreements Burining Ends

    // Removal of clauses due to termination of shareholders' Agreement Burining
    $generic_array = $db->alterationMoaAoaRemovalOfClauses($report_id);
    if($generic_array['removal_clauses_termination_of_shareholders_agreement_exists']) {

        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $docx->addBreak(array('type' => 'page'));
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []:  REMOVAL OF CLAUSES DUE TO TERMINATION OF SHAREHOLDERS' AGREEMENT",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text)-1;$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt=="")
            $analysis_txt = $analysis_text[count($analysis_text)-1]['analysis_text'];
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }
    // Removal of clauses due to termination of shareholders' Agreement Burining Ends

}
function fillInvestmentLimits($docx,$report_id){
    $db = new ReportBurning();
    $generic_array = $db->fillInvestmentLimits($report_id);
    if($generic_array['fill_investment_limits_exist']) {

        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: FII INVESTMENT LIMITS",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");

        // Graph Start

        $average_commision = new WordFragment($docx,"aslk");
        $average_commision->addExternalFile(array('src'=>'FiiShareholding.docx'));
        $total_commision = new WordFragment($docx,"aslk");
        $total_commision->addExternalFile(array('src'=>'PromoterShareholding.docx'));
        $valuesTable = array(
            array(
                array('value' =>$average_commision, 'vAlign' => 'top','textAlign'=>'center'),
                array('value' =>$total_commision, 'vAlign' => 'top','textAlign'=>'center'),
            )
        );
        $widthTableCols = array(6000,6000);
        $paramsTable = array(
            'border' => 'nil',
            'borderWidth' => 8,
            'borderColor' => 'cccccc',
            'columnWidths' => $widthTableCols
        );
        $docx->addTable($valuesTable, $paramsTable);

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }

}
function delistingOfShares($docx,$report_id){
    $db = new ReportBurning();
    $generic_array = $db->delistingOfShares($report_id);
    if($generic_array['delisting_of_shares_exist']) {
        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: DELISTING OF SHARES",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }
}
function donationToCharitableTrust($docx,$report_id){
    $db = new ReportBurning();
    $generic_array = $db->donationsToCharitableTrust($report_id);
    if($generic_array['donation_to_charitable_trusts_exist']) {
        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: DONATIONS TO CHARITABLE TRUSTS",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");

        // Graph Start
        $average_commision = new WordFragment($docx,"aslk");
        $average_commision->addExternalFile(array('src'=>'CSRContribution.docx'));
        $total_commision = new WordFragment($docx,"aslk");
        $total_commision->embedHTML(htmlParser($other_text[1]['text']));
        $valuesTable = array(
            array(
                array('value' =>$average_commision, 'vAlign' => 'top','textAlign'=>'center'),
                array('value' =>$total_commision, 'vAlign' => 'top','textAlign'=>'center'),
            )
        );
        $widthTableCols = array(6000,6000);
        $paramsTable = array(
            'border' => 'nil',
            'borderWidth' => 8,
            'borderColor' => 'cccccc',
            'columnWidths' => $widthTableCols
        );
        $docx->addTable($valuesTable, $paramsTable);

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }

}
function officeOfProfit($docx,$report_id){
    $db = new ReportBurning();
    $generic_array = $db->officeOfProfit($report_id);
    if($generic_array['office_of_profit_exist']) {
        $docx->addBreak(array('type' => 'page'));
        $other_text = $generic_array['other_text'];
        $recommendation_text = $generic_array['recommendation_text'];
        $analysis_text = $generic_array['analysis_text'];
        $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
        $docx->embedHTML($p_text);
        resHeading($docx,"RESOLUTION []: OFFICE OF PROFIT",1);
        $resolution_text = $other_text[0]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        resHeading($docx,"SES RECOMMENDATION",2);
        $resolution_text = $recommendation_text['recommendation_text'];
        $docx->embedHTML(htmlParser($resolution_text,1));
        resHeading($docx,"SES ANALYSIS",2);
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"PROFILE OF APPOINTEE");
        $resolution_text = $other_text[1]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"REMUNERATION");
        $resolution_text = $other_text[2]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $resolution_text = $other_text[3]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
        resBlackStrip($docx,"SELECTION PROCESS");
        $resolution_text = $other_text[4]['text'];
        $docx->embedHTML(htmlParser($resolution_text));
        $docx->embedHtml(htmlParser($other_text[5]['text']));

        $analysis_txt = "";
        for($i=0;$i<count($analysis_text);$i++) {
            if($analysis_text[$i]['analysis_text']!="" && $analysis_text[$i]['analysis_text']!="&nbsp;") {
                $analysis_txt .= $analysis_text[$i]['analysis_text'];
            }
        }
        if($analysis_txt!="")
            $docx->embedHtml(htmlParser($analysis_txt));
    }

}
?>
