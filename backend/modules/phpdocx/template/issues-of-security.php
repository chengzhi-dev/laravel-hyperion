<?php
require_once '../classes/CreateDocx.inc';
$docx = new CreateDocx();
$docx->modifyPageLayout('A4', array('marginRight' => '1000','marginLeft' => '1000'));
$docx->setDefaultFont('Calibri');
$html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>RESOLUTION []: OFFICE OF PROFIT</td></tr>
                </tbody>
            </table>";
$docx->embedHTML($html);
$resolution_text = "<p style='font-size: 10; text-align: justify; '>Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here</p>";
$docx->embedHTML($resolution_text);
$html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES RECOMMENDATION</td></tr>
                </tbody>
            </table>";
$docx->embedHTML($html);
$resolution_text = "<p style='font-size: 10; padding-left: 10px; border-left: 10px solid #464646;background-color:#D9D9D9; text-align: justify; '>qwkl Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here</p>";
$docx->embedHTML($resolution_text);
$html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #000000;border-bottom: 1px solid #000000; font-weight: bold;'>SES ANALYSIS</td></tr>
                </tbody>
            </table>";
$docx->embedHTML($html);

$html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>OBJECTIVE OF THE ISSUE</td></tr>
                </tbody>
            </table>";

$docx->embedHTML($html);
$resolution_text = "<p style='font-size: 10; text-align: justify; '>Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here</p>";
$docx->embedHTML($resolution_text);

$html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>DETAILS OF THE ISSUE</td></tr>
                </tbody>
            </table>";

$docx->embedHTML($html);
$resolution_text = "<p style='font-size: 10; text-align: justify; '><b>Securities to be issued: </b>Resolution text of office of profit goes here </p>";
$resolution_text .= "<p style='font-size: 10; text-align: justify; '><b>Issue Type: </b>Resolution text of office of profit goes here </p>";
$resolution_text .= "<p style='font-size: 10; text-align: justify; '><b>Issue Size: </b>Resolution text of office of profit goes here </p>";
$resolution_text .= "<p style='font-size: 10; text-align: justify; '><b>Issue Price: </b>Resolution text of office of profit goes here </p>";
$resolution_text .= "<p style='font-size: 10; text-align: justify; '><b>Eligible investors: </b>Resolution text of office of profit goes here</p>";
$docx->embedHTML($resolution_text);


$dilution_table_rows= "<tr>
                                    <td rowspan='2' style='text-align: center; width: 7%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Sr. No.</td>
                                    <td rowspan='2' style='text-align: center; width: 20%; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Class of Shareholder</td>
                                    <td colspan='2' style='text-align: center; width: 30%; border-bottom: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Pre-allotment of shares</td>
                                    <td colspan='2' style='text-align: center; width: 30%; border-bottom: 1px solid #FFFFFF; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>Post-allotment of shares</td>
                                </tr>";
$dilution_table_rows .= "<tr>
                                    <td style='text-align: center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>No of shares</td>
                                    <td style='text-align:center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>% of paid up capital</td>
                                    <td style='text-align:center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>No of shares</td>
                                    <td style='text-align:center; color: #FFFFFF; font-weight: bold; font-size: 10; background-color: #464646;'>% of paid up capital</td>
                                </tr>";
$dilution_table_rows.="<tr>
                                        <td style=' font-size: 9; background-color: #F2F2F2; text-align: center;'>1</td>
                                        <td style='font-size: 9; background-color: #F2F2F2;  text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #F2F2F2;  text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #F2F2F2;  text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #F2F2F2;  text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #F2F2F2;  text-align: center;'>&nbsp;</td>
                                   </tr>";
$dilution_table_rows.="<tr>
                                        <td style=' font-size: 9; background-color: #D9D9D9;  text-align: center;'>2</td>
                                        <td style='font-size: 9; background-color: #D9D9D9;  text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #D9D9D9;  text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #D9D9D9;  text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #D9D9D9;  text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #D9D9D9;  text-align: center;'>&nbsp;</td>
                                   </tr>";
$dilution_table_rows.="<tr>
                                        <td style=' font-size: 9; background-color: #F2F2F2; text-align: center;'>3</td>
                                        <td style='font-size: 9; background-color: #F2F2F2; text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #F2F2F2; text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #F2F2F2; text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #F2F2F2; text-align: center;'>&nbsp;</td>
                                        <td style='font-size: 9; background-color: #F2F2F2; text-align: center;'>&nbsp;</td>
                                   </tr>";
$dilution_table = "<table style='width: 100%; border-collapse: collapse;'>
                            <tbody>
                                $dilution_table_rows
                            </tbody>
                        </table>";
$docx->embedHTML($dilution_table);
$resolution_text = "<p style='font-size: 10; text-align: justify; '>Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here</p>";
$docx->embedHTML($resolution_text);

$html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>CONFLICT OF INTERESTS</td></tr>
                </tbody>
            </table>";
$docx->embedHTML($html);

$resolution_text = "<p style='font-size: 10; text-align: justify; '>Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here</p>";
$docx->embedHTML($resolution_text);

$html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>OTHER DISCLOSURES</td></tr>
                </tbody>
            </table>";
$docx->embedHTML($html);

$resolution_text = "<p style='font-size: 10; text-align: justify; '><b>Compliance with minimum public shareholding norms: </b>Resolution text of office of profit </p>";
$resolution_text .= "<p style='font-size: 10; text-align: justify; '><b>Relevant Date: </b>Resolution text of office of profit goes </p>";
$resolution_text .= "<p style='font-size: 10; text-align: justify; '><b>Allotment to promoter group: </b>Resolution text of office of profit goes here </p>";
$resolution_text .= "<p style='font-size: 10; text-align: justify; '><b>Reservations (in any): </b>Resolution text of office of profit goes here </p>";
$resolution_text .= "<p style='font-size: 10; text-align: justify; '><b>Past changes in share capital:  </b>Resolution text of office of profit goes here </p>";
$docx->embedHTML($resolution_text);

$docx->createDocx('try2');
?>