<?php

require_once '../classes/CreateDocx.inc';

$report_id=$_GET['report_id'];
//$docx_index = new CreateDocxFromTemplate('index_page_template.docx');
//createIndexPage($docx_index,$report_id);
//$docx_index->createDocx('index_page');
$docx = new CreateDocx();
$docx->modifyPageLayout('A4', array('marginRight' => '1000','marginLeft' => '1000','marginHeader'=>'200','marginFooter'=>'0'));
$docx->setDefaultFont('Calibri');
//addHeader($docx,$report_id);
//addFooter($docx,$report_id);

function htmlParser($text) {
    $text = str_replace('<p style="margin-left: 40px;">',"<p style='font-size: 10; margin-left: 30px; margin-top: 0; margin-bottom: 0; margin-right: 0; line-height:135%; padding-top: 8px; padding-bottom: 8px; text-align: justify; '>",$text);
    $text = str_replace("<p>","<p style='font-size: 10; line-height:135%; padding-top: 8px; padding-bottom: 8px; margin: 0; text-align: justify; '>",$text);
    $text = str_replace("<ul>","<ul style='font-size: 10;'>",$text);
    return $text;
}
$text = '<p style="margin-left: 40px;">Not Added</p><p>No concern has been identified regarding adoption of accounts of the Company and shareholders may vote FOR the resolution. However, shareholders may note that the Company has granted unsecured loans to entity(ies) covered under Section 189 of the Companies Act, 2013. However, Auditors have mentioned in their Report that the terms of the said loan(s) is/ are not prejudicial to the interest of the Company. (In case it is prejudicial or the quantum is high with a simultaneous high debt) SES is of the opinion that as a good governance practice, the Company should make proper disclosure on the mentioned issues. Shareholders may seek clarification from the Company on the reasons for disbursing [] amount of money as an unsecured loans.</p><p>No concern has been identified regarding the adoption of accounts of the Company and SES recommends that shareholders vote FOR the resolution. However, shareholders may note that [] is the Internal Auditors and the Statutory Auditors of the Company. SES is of the opinion that Internal Auditors are first line of defence against mis-appropriation by the management. The statutory Auditors comment on the adequacy of internal control system of the Company. In case the Internal and statutory Auditors are same, this may lead to conflict of interest and therefore, as a good governance practice, there should be separate Internal and statutory Auditors of the Company.</p>';
$docx->embedHTML(htmlParser($text));
$docx->createDocx('try');
?>