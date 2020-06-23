<?php
function burnExcel($report_id) {
    $db = new ReportBurning();
    $generic = $db->getGraphData($report_id);
    $share_holding_patterns = $generic['share_holding_patterns'];
    $variation_director_remuneration = $generic['variation_director_remuneration'];
    $remuneration_growth = $generic['remuneration_growth'];
    $board_independence = $generic['board_independence'];
    $dividend_and_earnings = $generic['dividend_and_earnings'];
    $dividend_payout_ratio = $generic['dividend_payout_ratio'];


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

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save("graph_excel.xlsx");
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
    return "<span style='font-size: 10;'>".$formated_day."<sup>$super</sup>"." ".$formated_month." ".$formated_year."</span>";
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
    $date_in_format = getDocxFormatDate($company_and_meeting_details['e_voting_start_date']);
    $docx_index->replaceVariableByHTML("e_voting_start_date","inline",$date_in_format);
    $date_in_format = getDocxFormatDate($company_and_meeting_details['e_voting_end_date']);
    $docx_index->replaceVariableByHTML("e_voting_end_date","inline",$date_in_format);
    $date_in_format = getDocxFormatDate($company_and_meeting_details['meeting_date']);
    $docx_index->replaceVariableByHTML("meeting_date","inline",$date_in_format);
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

    $date = date_create($company_report_details['meeting_date']);
    $meeting_date = date_format($date, 'd-F-Y');

    $headerDate->addText('Meeting Date: '.$meeting_date, $textOptions2);
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
function addFooter($docx,$report_id) {
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
    $docx->addFooter(array('default' => $footerTable));
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
    $html = "<p style='font-size:10;margin-top:5;margin-bottom: 0;'><i><span style='font-weight: bold;'>C - Compliance: </span>The Company has not met statutory compliance requirements</i></p>";
    $html .= "<p style='font-size:10; margin: 0;'><i><span style='font-weight: bold;'>F - Fairness: </span>The Company has proposed steps which may lead to undue advantage of a particular class of shareholders and can have adverse impact on non-controlling shareholders including minority shareholders</i></p>";
    $html .= "<p style='font-size:10;margin: 0;'><i><span style='font-weight: bold;'>G - Governance: </span>SES questions the governance practices of the Company. The Company may have complied with the statutory requirements in letter. However, SES finds governance issues as per its standards.</i></p>";
    $html .= "<p style='font-size:10; margin: 0;'><i><span style='font-weight: bold;'>T - Disclosures &amp; Transparency: </span>The Company has not made adequate disclosures necessary for shareholders to make an informed decision. The Company has intentionally or unintentionally kept the shareholders in dark.</i></p>";
    $docx->embedHTML($html);
    $html = "<h2 style='font-size:11;'>EXPLANATION</h2>";
    $html.="<p style='font-size:10; text-align: justify;'>In view of the fact that E-Voting neither has any scope of interaction of shareholders with the management, nor there is any possibility for amendment of resolution and management cannot explain its rationale any further than what is provided in Notice, therefore to ease decision making and e-voting process for the users of the reports SES has discontinued using recommendations such as -MODIFY, SPLIT, WITHDRAW and CONDITIONAL FOR/ AGAINST. Henceforth SES will give only FOR or AGAINST recommendation. However in Analysis section of the Report, SES will continue to analyse and indicate any of the discontinued recommendations subject to further disclosures etc. This will enable the companies to draft the future notices in a manner which will give relevant information to shareholders to take a considered decision.</p>";
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
                                    <td style='width:22%; color: #FFFFFF;border-bottom: 2px solid #000000;font-weight: bold; font-size: 10; background-color: #464646; text-align:center;'>".$peer_comparision[0]['financial_year']."</td>
                                    <td style='width:22%; color: #FFFFFF;font-weight: bold; font-size: 10;border-bottom: 2px solid #000000; background-color: #464646;text-align:center;'>".$peer_comparision[1]['financial_year']."</td>
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
    //$docx->addSection('continuous','A4', array('marginRight' => '1000','marginLeft' => '1000','marginTop'=>0,'marginBottom'=>0,'marginHeader'=>'200','marginFooter'=>'0'));
    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    $html = "<table style='border-collapse: collapse; width:100%; margin-bottom: 0; display: block;'>
                <tbody>
                    <tr><td colspan='4' style='font-size: 8; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'><i>Standalone Data ; Source: Capitaline</i></td><td>&nbsp;&nbsp;</td><td style='font-size: 8; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>* As on [date]</td><td colspan='2' style='font-size: 8; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>\"Based on EPS for FY []</td></tr>
                    <tr><td colspan='4' style='font-size: 10; padding-bottom: 2px; border-bottom: 2px solid #000000;'>TABLE 3: FINANCIAL INDICATORS (STANDALONE)</td><td>&nbsp;&nbsp;</td><td colspan='2' style='font-size: 10; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>TABLE 4: PEER COMPARISON ([year])</td></tr>
                    $table_financial_indicators
                    <tr><td colspan='4' style='font-size: 8; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'><i>Dividend pay-out includes Dividend Distribution Tax. Source: Capitaline</i></td><td>&nbsp;&nbsp;</td><td colspan='2' style='font-size: 8; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>&nbsp;</td></tr>";
    $html.="</table>";
    $docx->embedHTML($html);
    //$docx->addSection('continuous','A4', array('marginRight' => '1000','marginLeft' => '1000','marginTop'=>0,'marginBottom'=>0,'marginHeader'=>'200','marginFooter'=>'0'));
    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    $html ="<table style='border-collapse: collapse; width:100%; margin-bottom: 0; margin-top: 0;'>
                <tr><td colspan='2' style='font-size: 10; padding-bottom: 2px; border-bottom: 2px solid #000000;'>TABLE 5: MAJOR PUBLIC SHAREOLDERS (MAR'15)</td><td>&nbsp;&nbsp;</td><td colspan='2' style='font-size: 10; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>TABLE 6: MAJOR PROMOTERS (MAR'15)</td></tr>
                $table_public_share_holders_major_promoters
                <tr><td colspan='2' style='font-size: 2; padding-top: 0px; padding-bottom: 0px; border-bottom: 2px solid #000000;'>&nbsp;</td><td>&nbsp;</td><td colspan='2' style='font-size: 2; padding-top: 0px; padding-bottom: 0px; border-bottom: 2px solid #000000;'>&nbsp;</td></tr>
                <tr><td colspan='2' style='font-size: 10; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px solid #000000;'>SHAREHOLDING PATTERN (%) (DECEMBER)</td><td>&nbsp;&nbsp;</td><td colspan='2' style='font-size: 10; padding-top: 2px; padding-bottom: 2px; border-bottom:2px solid #000000;'>DISCUSSION</td></tr>
              </table>";
    $docx->embedHTML($html);
    //$docx->addSection('continuous','A4', array('marginRight' => '1000','marginLeft' => '1000','marginTop'=>0,'marginBottom'=>0,'marginHeader'=>'200','marginFooter'=>'0'));
    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    $new_fragment = new WordFragment($docx,"aslk");
    $new_fragment->addExternalFile(array('src'=>'ShareholdingPattern.docx'));
    $valuesTable = array(
        array(
            array('value' =>$new_fragment, 'vAlign' => 'center'),
            array('value' =>"Matter", 'vAlign' => 'center'),
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
}
function boardOfDirectorInfo($docx,$report_id) {
    $table_financial_indicators= "<tr>
                                        <td rowspan='2' style='width: 30%; border-right: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Director</td>
                                        <td rowspan='2' style='text-align:center; border-right: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>&nbsp;</td>
                                        <td colspan='2' style='text-align: center; border-right: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Classification</td>
                                        <td rowspan='2' style='text-align:center; vertical-align: middle; border-right: 1px solid #FFFFFF;color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Expertise/Specialization</td>
                                        <td rowspan='2' style='text-align:center; border-right: 1px solid #FFFFFF;color: #FFFFFF;font-weight: bold; font-size: 9; background-color: #464646;'>Tenure (Year)</td>
                                        <td rowspan='2' style='text-align:center; border-right: 1px solid #FFFFFF;color: #FFFFFF;font-weight: bold; font-size: 9; background-color: #464646;'>Directorship</td>
                                        <td rowspan='2' style='text-align:center; border-right: 1px solid #FFFFFF; color: #FFFFFF;font-weight: bold; font-size: 9; background-color: #464646;'><sup>[1]</sup>Committee Membership</td>
                                        <td rowspan='2' style='text-align:center; color: #FFFFFF;font-weight: bold; font-size: 9; background-color: #464646;'>Pay(<span style='font-family: Rupee Foradian;'>`</span> Lakh)</td>
                                    </tr>";
    $table_financial_indicators .="<tr>
                                        <td style='text-align: center; border-right: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>Company</td>
                                        <td style='text-align:center; border-right: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 9; background-color: #464646;'>SES</td>
                                    </tr>";

    $db = new ReportBurning();
    $company_id = 681;
    $financial_year = 2015;
    $generic = $db->companyBoardOfDirectors($report_id,$company_id,$financial_year);
    $board_directors = $generic['board_directors'];
    $standard_text = $generic['standard_text'];
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
    $table_financial_indicators.="<tr><td colspan='9' style='font-size: 8; padding-top: 5px; padding-bottom: 5px; '><i>Reference: ID - Independent director, NED - Non-executive director, ED - Executive director, C - Chairman, P - Promoter, MD - Managing Director</i></td></tr>";
    $table_financial_indicators.="<tr><td colspan='9' style='font-size: 8; padding-top: 5px; padding-bottom: 5px; '><b>[1]</b><i>Committee memberships include committee chairmanships &nbsp;&nbsp;Up - Director up for appointment/ reappointment</i></td></tr>";
    $table_financial_indicators.="<tr><td colspan='9' style='font-size: 8; padding-top: 5px; padding-bottom: 5px; '><i>Note: Directorships, committee membership and committee chairmanship includes such positions in [Company full Name]</i></td></tr>";
    $table_financial_indicators.="<tr><td colspan='9' style='font-size: 9; padding-top: 5px; padding-bottom: 5px; text-align: justify; '>$standard_text</td></tr>";
    $html = "<p style=''></p>";
    $html .= "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    <tr><td colspan='9' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000; border-bottom: 2px solid #000000; '>TABLE 7 - BOARD PROFILE </td></tr>
                    $table_financial_indicators
                    <tr><td colspan='9' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-bottom: 2px solid #000000; border-top: 2px solid #000000; '>GRAPH 2 - BOARD PROFILE OF THE BOARD MEMBERS ON VARIOUS PARAMETERS IS AS UNDER:</td></tr>
                </tbody>
              </table>";
    $docx->embedHTML($html);

    // Graph
    $retire_fragment = new WordFragment($docx,"aslk");
    $retire_fragment->addExternalFile(array('src'=>'RetireByRotation.docx'));
    $board_compositions_fragment = new WordFragment($docx,"aslk");
    $board_compositions_fragment->addExternalFile(array('src'=>'BoardComposition.docx'));
    $retire_fragment_text = new WordFragment($docx,"standardtext");
    $retire_fragment_text->addText("As per provisions of Section 149 and 152 of the Companies Act, 2013 Independent Directors shall not be liable to retire by rotation and unless provided by the Articles of the Company at least 2/3rd of the Non-Independent Directors should be liable to retire by rotation.",array('fontSize' => 9, 'color' => '000000', 'textAlign' => 'both'));
    $board_compositions_fragment_text = new WordFragment($docx,"standardtext");
    $board_compositions_fragment_text->addText("As per Clause 49(ii)(A) of the Listing Agreement, the Company should have at least 33% Independent Directors if the Chairman of the Board is a Non-Executive Director and should have at least 50% independent directors if the Board Chairman is a promoter or an executive director.",array('fontSize' => 9, 'color' => '000000', 'textAlign' => 'both'));
    $valuesTable = array(
        array(
            array('value' =>$retire_fragment, 'vAlign' => 'center','textAlign'=>'center'),
            array('value' =>$board_compositions_fragment, 'vAlign' => 'center','textAlign'=>'center'),
        ),
        array(
            array('value' =>$retire_fragment_text),
            array('value' =>$board_compositions_fragment_text)
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
                    <tr><td colspan='8' style='font-size: 8; padding-top: 5px; padding-bottom: 5px; border-bottom: 2px solid #000;'><i>Reference: ID - Independent director, NID - Non-Independent director, ED - Executive director, C - Chairman, P - Promoter</i></td></tr>
                    <tr><td colspan='8' style='font-size: 8; padding-top: 5px; padding-bottom: 5px; '><i>&nbsp;</td></tr>
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
    $remuneration_analysis= "<tr>
                                <td colspan='2' style='border-bottom: 2px solid #FFF; text-align: left; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>In <span style='font-family: Rupee Foradian;'>`</span> Crore</td>
                                <td colspan='2' style='border-bottom: 2px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>".$remuneration_analysis_data[0]['rem_first_year']."</td>
                                <td colspan='2' style='border-bottom: 2px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>".$remuneration_analysis_data[0]['rem_second_year']."</td>
                                <td colspan='2' style='border-bottom: 2px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>".$remuneration_analysis_data[0]['rem_third_year']."</td>
                            </tr>";
    $remuneration_analysis .= "<tr>
                                    <td colspan='2' style='border-right: 1px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>&nbsp;</td>
                                    <td style='border-right: 1px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Fixed Pay</td>
                                    <td style='border-right: 1px solid #FFF; text-align:center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Total Pay</td>
                                    <td style='border-right: 1px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Fixed Pay</td>
                                    <td style='border-right: 1px solid #FFF; text-align:center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Total Pay</td>
                                    <td style='border-right: 1px solid #FFF; text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Fixed Pay</td>
                                    <td style='text-align:center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Total Pay</td>
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
                                       </tr>";
        }
    }
    $html = "<p style=''></p>";
    $html .= "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000;border-bottom: 2px solid #000000; '>TABLE 10 - EXECUTIVE DIRECTORS' REMUNERATION ANALYSIS</td></tr>
                    $remuneration_analysis
                    <tr><td colspan='8' style='border-top: 2px solid #000; font-size: 8; padding-top: 5px; padding-bottom: 5px; '><i>Note: Fixed pay includes basic pay, perquisites &amp; allowances. P - Promoter; NP - Non-Promoter</i></td></tr>
                    <tr><td colspan='8' style='font-size: 9; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000; border-bottom: 2px solid #000000; '>DISCUSSION - INDEXED TSR vs. EXECUTIVE REMUNERATION GROWTH</td></tr>
                </tbody>
              </table>";
    $docx->embedHTML($html);

    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    //$docx->addSection('continuous','A4', array('marginRight' => '1000','marginLeft' => '1000','marginTop'=>0,'marginBottom'=>0,'marginHeader'=>'200','marginFooter'=>'0'));
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
    //$docx->addSection('continuous','A4', array('marginRight' => '1000','marginLeft' => '1000','marginTop'=>0,'marginBottom'=>0,'marginHeader'=>'200','marginFooter'=>'0'));
    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-bottom: 2px solid #000000; '>TABLE 11- EXECUTIVE REMUNERATION - PEER COMPARISON</td></tr>
                    $executive_remuneration
                </tbody>
              </table>";
    $docx->embedHTML($html);
}
function disclosures($docx,$report_id){
    $db = new ReportBurning();
    $generic = $db->disclosures($report_id);
    $disclosures_data = $generic['disclosures'];
    $total_rows = count($disclosures_data);
    $disclosures = "";
    $questions = array(
        "Corporate Social Responsibility Committee Composition",
        "Risk Management Policy",
        "Corporate Social Responsibility Policy",
        "Performance evaluation of Board, Committees and Directors",
        "Corporate Social Responsibility Activities",
        "Related Party Transactions",
        "Corporate Social Responsibility Spending",
        "Ratio of the remuneration of each director to the median employees remuneration",
        "Extract of the Annual Return",
        "Secretarial Audit Report",
        "Company's policy of appointment and remuneration of directors, KMP and employees",
        "Statement to the effect that independent director possesses appropriate balance of skills, experience and knowledge",
        "Criteria for determining qualifications, positive attributes, director's independence",
        "Receipt of commission by a director from the holding company or subsidiary company",
        "Declaration by Independent Directors",
        "Establishment of Vigil Mechanism",
        "Particulars of loans, guarantees or investments",
        "Voting rights not exercised directly by employees for shares to the ESOP scheme"
    );
    for($i=0;$i<$total_rows/2;$i++) {
        $disclosures.="<tr><td style='padding-top: 7px; padding-bottom: 7px; font-size: 10;border-bottom: 2px solid #dddddd;'><input type='checkbox' checked/></td>";
        if($disclosures_data[$i]['status']=="no")
            $disclosures.="<td style='border-bottom: 2px solid #dddddd; font-size: 10; color: #F00;'>".$questions[$i]."</td><td>&nbsp;</td>";
        else
            $disclosures.="<td style='border-bottom: 2px solid #dddddd; font-size: 10;'>".$questions[$i]."</td><td>&nbsp;</td>";
        $disclosures.="<td style='border-bottom: 2px solid #dddddd;'><img src='http://localhost/patool/phpdocx/template/checked.png' alt='askja'/></td>";
        if($disclosures_data[$i+1]['status']=="no")
            $disclosures.="<td style='border-bottom: 2px solid #dddddd; font-size: 10; color: #F00;'>".$questions[$i+1]."</td></tr>";
        else
            $disclosures.="<td style='border-bottom: 2px solid #dddddd; font-size: 10;'>".$questions[$i+1]."</td></tr>";
    }
    $html = "<p style=''></p>";
    $html .= "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    <tr><td colspan='5' style='font-weight: bold; font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000; '>DISCLOSURE REQUIRED IN DIRECTOR'S REPORT</td></tr>
                    <tr><td colspan='5' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 2px solid #000000; border-bottom: 2px solid #000000; text-align: justify;'>The Companies Act, 2013 and Listing Agreement requires the listed companies to make certain disclosures in Directors' Report section of the Annual Report. The table below shows the status of compliance of such some important requirements by the Company.</td></tr>
                    $disclosures
                </tbody>
              </table>";
    $docx->embedHTML($html);
}
function adoptionOfAccounts($docx,$report_id) {

    $db = new ReportBurning();
    $generic_array = $db->adoptionOfAccount($report_id);
    $other_text = $generic_array['other_text'];
    $recommendation_text = $generic_array['recommendation_text'];
    $triggers = $generic_array['triggers'];
    $analysis_text = $generic_array['analysis_text'];
    $unaudited_statements_table = $generic_array['unaudited_statements_table'];
    $financial_indicators = $generic_array['financial_indicators'];
    $contingent_liabilities = $generic_array['contingent_liabilities'];
    $adoption_of_accounts_rpt = $generic_array['adoption_of_accounts_rpt'];
    $standalone_consolidated_acc = $generic_array['standalone_consolidated_acc'];



    $p_text = "<p style='font-size: 10;'>&nbsp;</p>";
    $docx->embedHTML($p_text);
    $html="<table style='width:100%; border-collapse: collapse;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>RESOLUTION []: ADOPTION OF ACCOUNTS </td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>".$other_text[0]['text']."</p>";
    $docx->embedHTML($resolution_text);
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES RECOMMENDATION</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $resolution_text = "<p style='margin:0; padding-top: 8px; padding-bottom: 8px; font-size: 10;line-height:135%; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>".$recommendation_text['recommendation_text']."</p>";
    $docx->embedHTML($resolution_text);
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES ANALYSIS</td></tr>
                    <tr><td colspan='8' style='font-size: 9;'><p style='line-height: 135%; margin:0; padding-top: 8px; padding-bottom: 8px;'><i>Note: Detailed analysis of the accounts is not within the scope of SES' activities. SES accepts the Report of the Directors and the Auditors to be true and fair representation of the company's financial position. The analysis below is aimed at enabling shareholders engage in discussions with the Board/ Management during the AGM.</i></p></td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>AUDIT QUALIFICATIONS</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);

    $audit_qualification_headings = array(
        "Qualifications",
        "Company's Comments",
        "SES Opinion"
    );

    if($triggers[0]['triggers']=='yes') {
        $audit_text = "";
        for($i=0;$i<=2;$i++) {
            if($analysis_text[$i]['analysis_text']!="")
                $audit_text .= "<p style='font-size: 10; line-height: 135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0; '><span style='font-weight: bold;'>$audit_qualification_headings[$i]: </span>".$analysis_text[$i]['analysis_text']."</p>";
        }
        $docx->embedHTML($audit_text);
    }
    else {
        $audit_text = "";
        for($i=3;$i<=5;$i++) {
            if($analysis_text[$i]['analysis_text']!="")
                $audit_text .= "<p style='font-size: 10; line-height: 135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0; '><span style='font-weight: bold;'>".$audit_qualification_headings[$i-3].":</span>".$analysis_text[$i]['analysis_text']."</p>";
        }
        $docx->embedHTML($audit_text);
    }

    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>AUDITORS' COMMENTS ON STANDALONE ACCOUNTS</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);

    if($triggers[1]['triggers']=='yes') {
        $text ="<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0; '>".$analysis_text[6]['analysis_text']."</p>";
        $docx->embedHTML($text);
    }
    else {
        $text ="<p style='font-size: 10; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0; '>".$analysis_text[7]['analysis_text']."</p>";
        $docx->embedHTML($text);
    }

    if($triggers[2]['triggers']=='yes' && $triggers[3]['triggers']=='yes') {
        $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>AUDITORS' COMMENTS ON CONSOLIDATED ACCOUNTS</td></tr>
                </tbody>
            </table>";
        $docx->embedHTML($html);
        $text ="<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0; '>".$analysis_text[8]['analysis_text']."</p>";
        $docx->embedHTML($text);
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
        $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $text
                </tbody>
              </table>";
        $docx->embedHTML($html);
        $text ="<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0; '>".$other_text[1]['text']."</p>";
        $docx->embedHTML($text);
    }
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>ACCOUNTING POLICIES</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $text ="<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0; '>".$other_text[2]['text']."</p>";
    $docx->embedHTML($text);

    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>FINANCIAL INDICATORS</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html."<p style='font-size:1;'>&nbsp;</p>");

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
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$financial_indicators[$i]['company_discussion']."</td>
                           </tr>";
        }
        else {
            $text.="<tr>
                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$financial_indicators[$i]['field_name']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$financial_indicators[$i]['fi_current']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$financial_indicators[$i]['fi_previous']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$financial_indicators[$i]['shift']."%</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$financial_indicators[$i]['company_discussion']."</td>
                           </tr>";
        }
    }
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $text
                    <tr><td colspan='5' style='text-align:left; font-size: 8;'><i>Source: Company's Annual Reports / Capitaline/ Moneycontrol</i></td></tr>
                </tbody>
              </table>";
    $docx->embedHTML($html);
    $text ="<p style='font-size: 9; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0; '><i>SES is of the opinion that board should take note of structural shift (positive and negative both) in various financial parameters which have a bearing on company's future performance and positioning in market place and disclose an analysis of the same to shareholders. SES believes that 25% change either way should be the threshold for triggering analysis and disclosure requirements.</i></p>";
    $docx->embedHTML($text);


    // CONTINGENT LIABILITIES

    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>CONTINGENT LIABILITIES</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html."<p style='font-size:1;'>&nbsp;</p>");
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
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $text
                    <tr><td colspan='5' style='text-align:left; font-size: 8;'><i>Source: Company's Annual Reports/ Capitaline</i></td></tr>
                </tbody>
              </table>";
    $docx->embedHTML($html);
    $text ="<p style='font-size: 10; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0; line-height:135%;'>".$other_text[4]['text']."</p>";
    $docx->embedHTML($text);

    // related party transactions

    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>RELATED PARTY TRANSACTIONS</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html."<p style='font-size:1;'>&nbsp;</p>");

    $text= "<tr>
                <td style='text-align: center; width: 35%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;border-right: 1px solid #FFF;'>Outstanding (<span style='font-family: Rupee Foradian;'>`</span> Crore)</td>
                <td style='text-align: center; width: 10%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>".$generic_array['fiscal_month']."' ".substr($adoption_of_accounts_rpt[0]['rpt_year1'],2,2)."</td>
                <td style='text-align: center; width: 10%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080; border-right: 1px solid #FFF;'>".$generic_array['fiscal_month']."' ".substr($adoption_of_accounts_rpt[0]['rpt_year2'],2,2)."</td>
                <td style='text-align: center; width: 45%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #808080;'>Comments</td>
            </tr>";
    for($i=0;$i<count($adoption_of_accounts_rpt);$i++) {
        if($i%2==0) {
            $text.="<tr>
                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$adoption_of_accounts_rpt[$i]['field_name']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$adoption_of_accounts_rpt[$i]['rpt_current_year']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$adoption_of_accounts_rpt[$i]['rpt_previous_year']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2;'>".$adoption_of_accounts_rpt[$i]['rpt_comments']."</td>
                           </tr>";
        }
        else {
            $text.="<tr>
                            <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$adoption_of_accounts_rpt[$i]['field_name']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$adoption_of_accounts_rpt[$i]['rpt_current_year']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$adoption_of_accounts_rpt[$i]['rpt_previous_year']."</td>
                            <td style='text-align:right; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$adoption_of_accounts_rpt[$i]['rpt_comments']."</td>
                           </tr>";
        }
    }
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $text
                    <tr><td colspan='5' style='text-align:left; font-size: 8;'><i>Source: Company's Annual Reports</i></td></tr>
                </tbody>
              </table>";
    $docx->embedHTML($html);
    $text ="<p style='font-size: 10; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0; line-height:135%;'>".$other_text[5]['text']."</p>";
    $docx->embedHTML($text);

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

    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>STANDALONE VS CONSOLIDATED ACCOUNTS</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html."<p style='font-size:1;'>&nbsp;</p>");
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $standalone_consolidated_acc_str
                </tbody>
              </table>";
    $docx->embedHTML($html);

    $analysis_txt = "";
    for($i=12;$i<count($analysis_text)-1;$i++) {
        if($analysis_text[$i]['analysis_text']!="") {
            $analysis_txt .= "<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0;'>".$analysis_text[$i]['analysis_text']."</p>";;
        }
    }

    if($analysis_txt=="") {
        $analysis_txt = "<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0;'>".$analysis_text[count($analysis_text)-1]['analysis_text']."</p>";;
    }

    $docx->embedHTML($analysis_txt);
}
function declarationOfDividend($docx,$report_id) {

    $db = new ReportBurning();
    $generic_array = $db->declarationOfDevidend($report_id);
    $other_text = $generic_array['other_text'];
    $recommendation_text = $generic_array['recommendation_text'];
    $analysis_text = $generic_array['analysis_text'];

    $p_text = "<p style='font-size: 10;'>&nbsp;</p>";
    $docx->embedHTML($p_text);
    $html="<table style='width:100%; border-collapse: collapse;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>RESOLUTION []: DECLARATION OF DIVIDEND</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $resolution_text = "<p style='font-size: 10; line-height:135%; text-align: justify; margin: 0; padding-top: 8px; padding-bottom: 8px; '>".$other_text[0]['text']."</p>";
    $docx->embedHTML($resolution_text);
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES RECOMMENDATION</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $resolution_text = "<p style='margin:0; font-size: 10;line-height:135%; padding-left: 10px; padding-top: 8px; padding-bottom: 8px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>".$recommendation_text['recommendation_text']."</p>";
    $docx->embedHTML($resolution_text);
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES ANALYSIS</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");

    // Graph Start

    $dividend_and_earning = new WordFragment($docx,"aslk");
    $dividend_and_earning->addExternalFile(array('src'=>'DividendAndEarning.docx'));
    $dividend_payout_ratio = new WordFragment($docx,"aslk");
    $dividend_payout_ratio->addExternalFile(array('src'=>'DividendPayoutRatio.docx'));
    $valuesTable = array(
        array(
            array('value' =>$dividend_and_earning, 'vAlign' => 'center','textAlign'=>'center'),
            array('value' =>$dividend_payout_ratio, 'vAlign' => 'center','textAlign'=>'center'),
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

    $analysis_txt = "";
    for($i=0;$i<count($analysis_text)-1;$i++) {
        if($analysis_text[$i]['analysis_text']!="") {
            $analysis_txt .= "<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0;'>".$analysis_text[$i]['analysis_text']."</p>";;
        }
    }

    if($analysis_txt=="") {
        $analysis_txt = "<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0;'>".$analysis_text[count($analysis_text)-1]['analysis_text']."</p>";;
    }

    $docx->embedHTML($analysis_txt);
}
function esops($docx,$report_id) {
    $db = new ReportBurning();
    $generic_array = $db->esops($report_id);
    $other_text = $generic_array['other_text'];
    $recommendation_text = $generic_array['recommendation_text'];
    $analysis_text = $generic_array['analysis_text'];

    $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
    $docx->embedHTML($p_text);
    $html="<table style='width:100%; border-collapse: collapse;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>RESOLUTION []: APPROVAL OF ESOP SCHEME</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>".$other_text[0]['text']."</p>";
    $docx->embedHTML($resolution_text);
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES RECOMMENDATION</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $resolution_text = "<p style='margin:0; padding-top: 8px; padding-bottom: 8px; font-size: 10;line-height:135%; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>".$recommendation_text['recommendation_text']."</p>";
    $docx->embedHTML($resolution_text);
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES ANALYSIS</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>ESOP DISCLOSURES</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);


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
                        <td style='text-align:left;; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$other_text[$i]['text']."</td>
                       </tr>";
        }
        else {
            $text.="<tr>
                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$other_text[$i]['used_in']."</td>
                        <td style='text-align:left; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$other_text[$i]['text']."</td>
                       </tr>";
        }
    }
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $text
                </tbody>
              </table>";
    $docx->embedHTML($html);
    $docx->embedHtml("<p style='font-size: 1;'>&nbsp;</p>");
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>SCHEME ADMINISTRATION</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
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
                        <td style='text-align:left;; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #F2F2F2; '>".$other_text[$i]['text']."</td>
                       </tr>";
        }
        else {
            $text.="<tr>
                        <td style='border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$other_text[$i]['used_in']."</td>
                        <td style='text-align:left; border-right: 1px solid #FFFFFF; font-size: 10; background-color: #D9D9D9;'>".$other_text[$i]['text']."</td>
                       </tr>";
        }
    }
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $text
                </tbody>
              </table>";
    $docx->embedHTML($html);
    $para = "<p style='font-size: 10; text-align: justify;padding-top: 8px; padding-bottom: 8px; margin: 0;'><span style='font-weight: bold;'>Total outstanding options across all schemes: </span>".$other_text[16]['text']."</p>";
    $docx->embedHtml($para);

    $analysis_txt = "";
    for($i=0;$i<count($analysis_text)-1;$i++) {
        if($analysis_text[$i]['analysis_text']!="") {
            $analysis_txt .= "<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0;'>".$analysis_text[$i]['analysis_text']."</p>";;
        }
    }

    if($analysis_txt=="") {
        $analysis_txt = "<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0;'>".$analysis_text[count($analysis_text)-1]['analysis_text']."</p>";;
    }
    $docx->embedHtml($analysis_txt);

    // ESOP RE-PRICING

    $docx->addBreak(array('type' => 'page'));

    $generic_array = $db->esposRePricing($report_id);
    $other_text = $generic_array['other_text'];
    $optios_being_repriced = $generic_array['optios_being_repriced'];
    $analysis_text = $generic_array['analysis_text'];


    $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
    $docx->embedHTML($p_text);
    $html="<table style='width:100%; border-collapse: collapse;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>RESOLUTION []: ESOP RE-PRICING</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>".$other_text[0]['text']."</p>";
    $docx->embedHTML($resolution_text);
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES RECOMMENDATION</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $resolution_text = "<p style='margin:0; padding-top: 8px; padding-bottom: 8px; font-size: 10;line-height:135%; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>".$recommendation_text['recommendation_text']."</p>";
    $docx->embedHTML($resolution_text);
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES ANALYSIS</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>OPTIONS BEING RE-PRICED</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);


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
    $html = "<table style='border-collapse: collapse; width:100%;'>
                <tbody>
                    $text
                </tbody>
              </table>";
    $docx->embedHTML($html);
    $docx->embedHtml("<p style='font-size: 5;'>&nbsp;</p>");
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>COMPANY'S JUSTIFICATION</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);

    $html = "<p style='font-size: 10; line-height:135%; text-align: justify; margin: 0; padding-top: 8px; padding-bottom: 8px; '>".$other_text[1]['text']."</p>";
    $docx->embedHTML($html);

    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>STOCK PERFORMANCE VERSUS BENCHMARKS</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);

    // Graph Start
    $docx->embedHtml("<p style='font-size: 2;'>&nbsp;</p>");

    $stock_perrformance = new WordFragment($docx,"aslk");
    $stock_perrformance->addExternalFile(array('src'=>'StockPerformance.docx'));
    $stock_perrformance_comments = new WordFragment($docx,"aslk");
    $stock_perrformance_comments->addText("Comments");
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

    $para = "<p style='font-size: 10; text-align: justify;padding-top: 8px; padding-bottom: 8px; margin: 0;'><span style='font-weight: bold;'>Factors leading to Decline in Stock Price: </span>".$other_text[2]['text']."</p>";
    $docx->embedHtml($para);

    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>SES' OPINION ON RE-PRICING</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);

    $para = "<p style='font-size: 10; text-align: justify;padding-top: 8px; padding-bottom: 8px; margin: 0;'>".$other_text[3]['text']."</p>";
    $docx->embedHtml($para);

    $analysis_txt = "";
    for($i=0;$i<count($analysis_text);$i++) {
        if($analysis_text[$i]['analysis_text']!="") {
            $analysis_txt .= "<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0;'>".$analysis_text[$i]['analysis_text']."</p>";;
        }
    }
    $docx->embedHtml($analysis_txt);
}
function intercorporateLoans($docx,$report_id) {
    $db = new ReportBurning();
    $generic_array = $db->intercorporateLoans($report_id);
    $other_text = $generic_array['other_text'];
    $recommendation_text = $generic_array['recommendation_text'];
    $the_recipient = $generic_array['the_recipient'];
    $existing_transactions = $generic_array['existing_transactions'];

    $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
    $docx->embedHTML($p_text);
    $html="<table style='width:100%; border-collapse: collapse;'>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>RESOLUTION []: INTERCORPORATE LOANS/GUARANTEES/INVESTMENTS</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>".$other_text[0]['text']."</p>";
    $docx->embedHTML($resolution_text);
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES RECOMMENDATION</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $resolution_text = "<p style='margin:0; padding-top: 8px; padding-bottom: 8px; font-size: 10;line-height:135%; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>".$recommendation_text['recommendation_text']."</p>";
    $docx->embedHTML($resolution_text);
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES ANALYSIS</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>THE RECIPIENT</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
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
    $other_txt = "<p style='font-size: 10; text-align: justify;padding-top: 8px; padding-bottom: 8px; margin: 0;'><span>About Recipient Company: </span>".$other_text[1]['text']."</p>";
    $other_txt .= "<p style='font-size: 10; text-align: justify;padding-top: 8px; padding-bottom: 8px; margin: 0;'><span>Relationship with the Company: </span>".$other_text[2]['text']."</p>";
    $other_txt .= "<p style='font-size: 10; text-align: justify;padding-top: 8px; padding-bottom: 8px; margin: 0;'><span>Effect on balance sheet of Lender Company: </span>".$other_text[3]['text']."</p>";
    $docx->embedHTML($other_txt);

    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>EXISTING TRANSACTIONS WITH THE RECIPIENT</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
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
    $html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='padding-top: 5px; padding-left: 1px; padding-bottom: 5px; font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>PURPOSE OF THE TRANSACTION</td></tr>
                </tbody>
            </table>";
    $docx->embedHTML($html);
}
?>
