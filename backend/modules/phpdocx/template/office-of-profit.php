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
                    <tr><td colspan='8' style='font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>PROFILE OF APPOINTEE</td></tr>
                </tbody>
            </table>";

$docx->embedHTML($html);
$resolution_text = "<p style='font-size: 10; text-align: justify; '>Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here</p>";
$docx->embedHTML($resolution_text);

$html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10; color: #FFFFFF; background-color: #464646; font-weight: bold;'>REMUNERATION</td></tr>
                </tbody>
            </table>";

$docx->embedHTML($html);
$resolution_text = "<p style='font-size: 10; text-align: justify; '><b>Annual Remuneration: </b>Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here</p>";
$resolution_text .= "<p style='font-size: 10; text-align: justify; '><b>Is the remuneration comparable to remuneration of other employees in similar position/grade: </b>Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here</p>";
$docx->embedHTML($resolution_text);

$html="<table style='width:100%; border-collapse: collapse; '>
                <tbody>
                    <tr><td colspan='8' style='font-size: 10;color: #FFFFFF; background-color: #464646; font-weight: bold;'>SELECTION PROCESS</td></tr>
                </tbody>
            </table>";

$docx->embedHTML($html);
$resolution_text = "<p style='font-size: 10; text-align: justify; '>Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here</p>";
$resolution_text .= "<p style='font-size: 10; text-align: justify; '><b>Suitability of candidate: </b>Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here Resolution text of office of profit goes here</p>";
$docx->embedHTML($resolution_text);
$docx->createDocx('try2');
?>