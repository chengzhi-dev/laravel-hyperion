<?php
// Burning Appointment Of Auditors At PSU
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
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>".$other_text[0]['text']."</p>";
    $docx->embedHTML($resolution_text);
    resHeading($docx,"SES RECOMMENDATION",1);
    $resolution_text = "<p style='margin:0; padding-top: 8px; padding-bottom: 8px; font-size: 10;line-height:135%; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>".$recommendation_text['recommendation_text']."</p>";
    $docx->embedHTML($resolution_text);
    resHeading($docx,"SES ANALYSIS",1);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>".$other_text[1]['text']."</p>";
    $docx->embedHTML($resolution_text);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    $analysis_txt = "";
    for($i=0;$i<count($analysis_text);$i++) {
        if($analysis_text[$i]['analysis_text']!="") {
            $analysis_txt .= "<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0;'>".$analysis_text[$i]['analysis_text']."</p>";;
        }
    }
    $docx->embedHtml($analysis_txt);
}
// Burning Appointment Of Auditors At PSU ENDS

// Burning Appointment of Branch Auditors
$generic_array = $db->appointmentOfAuditorsAppointmentOfBranchAuditors($report_id);
if($generic_array['appointment_branch_auditors_exists']) {
    $other_text = $generic_array['other_text'];
    $recommendation_text = $generic_array['recommendation_text'];
    $analysis_text = $generic_array['analysis_text'];
    $docx->addBreak(array('type' => 'page'));
    $p_text = "<p style='font-size: 1;'>&nbsp;</p>";
    $docx->embedHTML($p_text);
    resHeading($docx, "RESOLUTION []: APPOINTMENT OF BRANCH AUDITORS", 1);
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>" . $other_text[0]['text'] . "</p>";
    $docx->embedHTML($resolution_text);
    resHeading($docx, "SES RECOMMENDATION", 1);
    $resolution_text = "<p style='margin:0; padding-top: 8px; padding-bottom: 8px; font-size: 10;line-height:135%; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>" . $recommendation_text['recommendation_text'] . "</p>";
    $docx->embedHTML($resolution_text);
    resHeading($docx, "SES ANALYSIS", 1);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    resBlackStrip($docx, "COMPANY'S JUSTIFICATION");
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>" . $other_text[1]['text'] . "</p>";
    $docx->embedHTML($resolution_text);
    $analysis_txt = "";
    for ($i = 0; $i < count($analysis_text); $i++) {
        if ($analysis_text[$i]['analysis_text'] != "") {
            $analysis_txt .= "<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0;'>" . $analysis_text[$i]['analysis_text'] . "</p>";
        }
    }
    $docx->embedHtml($analysis_txt);
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
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>" . $other_text[0]['text'] . "</p>";
    $docx->embedHTML($resolution_text);
    resHeading($docx, "SES RECOMMENDATION", 1);
    $resolution_text = "<p style='margin:0; padding-top: 8px; padding-bottom: 8px; font-size: 10;line-height:135%; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>" . $recommendation_text['recommendation_text'] . "</p>";
    $docx->embedHTML($resolution_text);
    resHeading($docx, "SES ANALYSIS", 1);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    resBlackStrip($docx, "COMPANY'S JUSTIFICATION");
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>" . $other_text[1]['text'] . "</p>";
    $docx->embedHTML($resolution_text);
    $analysis_txt = "";
    for ($i = 0; $i < count($analysis_text); $i++) {
        if ($analysis_text[$i]['analysis_text'] != "") {
            $analysis_txt .= "<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0;'>" . $analysis_text[$i]['analysis_text'] . "</p>";
        }
    }
    $docx->embedHtml($analysis_txt);
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
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>".$other_text[0]['text']."</p>";
    $docx->embedHTML($resolution_text);
    resHeading($docx,"SES RECOMMENDATION",1);
    $resolution_text = "<p style='margin:0; padding-top: 8px; padding-bottom: 8px; font-size: 10;line-height:135%; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>".$recommendation_text['recommendation_text']."</p>";
    $docx->embedHTML($resolution_text);
    resHeading($docx,"SES ANALYSIS",1);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    resBlackStrip($docx,"COMPANY'S JUSTIFICATION");
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>".$other_text[1]['text']."</p>";
    $docx->embedHTML($resolution_text);
    $analysis_txt = "";
    for($i=0;$i<count($analysis_text);$i++) {
        if($analysis_text[$i]['analysis_text']!="") {
            $analysis_txt .= "<p style='font-size: 10; line-height:135%; text-align: justify; padding-top: 8px; padding-bottom: 8px; margin: 0;'>".$analysis_text[$i]['analysis_text']."</p>";
        }
    }
    $docx->embedHtml($analysis_txt);
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
    $resolution_text = "<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>".$other_text[0]['text']."</p>";
    $docx->embedHTML($resolution_text);
    resHeading($docx,"SES RECOMMENDATION",1);
    $resolution_text = "<p style='margin:0; padding-top: 8px; padding-bottom: 8px; font-size: 10;line-height:135%; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>".$recommendation_text['recommendation_text']."</p>";
    $docx->embedHTML($resolution_text);
    resHeading($docx,"SES ANALYSIS",1);
    $docx->embedHTML("<p style='font-size: 1;'>&nbsp;</p>");
    resBlackStrip($docx,"DISCLOSURES");
    $no_auditors = $triggers['triggers'];
    $inner="";
    for($i=0;$i<$no_auditors;$i++) {
        $inner .= "<tr>
                        <td style='text-align: left; width:40%; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>Name of the auditor up for appointment</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>&nbsp;</td>
                      </tr>";
        $inner .= "<tr>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>Auditors' eligibility for appointment</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>&nbsp;</td>
                      </tr>";
        $inner .= "<tr>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>Auditors' independence certificate</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #d9d9d9;'>&nbsp;</td>
                      </tr>";
        $inner .= "<tr>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>Auditor's Network</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>&nbsp;</td>
                      </tr>";
    }
    $html = "<table style='border-collapse: collapse; width: 100%; '>
                    <tbody>$inner</tbody>
                </table>";
    $docx->embedHTML($html);
    $docx->embedHTML("<p style='font-size: 3;'>&nbsp;</p>");
    resBlackStrip($docx,"AUDITORS' INDEPENDENCE");
    $inner = "<tr>
                        <td colspan='2' style='text-align: left; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #808080;'>Auditors</td>
                        <td colspan='2' style='text-align: left; color: #FFFFFF; font-weight: bold; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #808080;'>Audit Partners</td>
                    </tr>";
    for($i=0;$i<$no_auditors;$i++) {
        $inner .= "<tr>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$other_text[$i+1]['text']."</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$other_text[$i+5]['text']."</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$other_text[$i*2+13]['text']."</td>
                        <td style='text-align: left; color: #000000; border-bottom: 1px solid #FFF;border-right: 1px solid #FFF; font-size: 10; background-color: #f2f2f2;'>".$other_text[$i*2+14]['text']."</td>
                    </tr>";
    }
    $html = "<table style='border-collapse: collapse; width: 100%; '>
                        <tbody>$inner</tbody>
                    </table>";
    $docx->embedHTML($html);
    $resolution_text = "<p style='margin:0; padding-top: 8px; padding-bottom: 8px; font-size: 10;line-height:135%; text-align: justify; '>".$analysis_text[6]['analysis_text']."</p>";
    $docx->embedHTML($resolution_text);
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
}
?>