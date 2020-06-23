<?php
require_once '../classes/CreateDocx.inc';
require_once '../classes/DocxUtilities.inc';
require_once 'burning-functions.php';
try {
	$report_id = $_GET['report_id'];
	$docx_index = new CreateDocxFromTemplate('index_page_template.docx');
	createIndexPage($docx_index, $report_id);
	$docx_index->createDocx('index_page');
	$docx = new CreateDocx();
	$docx->modifyPageLayout('A4', array('marginRight' => '1000', 'marginLeft' => '1000', 'marginHeader' => '200', 'marginFooter' => '0'));
	$docx->setDefaultFont('Calibri');
	addHeader($docx, $report_id);
	addFooter($docx, $report_id);
	$text_box_1 = "<p style='font-size: 18; padding: 0; margin: 0; color: #FFF; text-align: center; font-family: Cambria;'><span style='font-size: 20;'>SES R</span>ECOMMENDATIONS</p>";
	addOrangeTextBox($docx, $text_box_1);
	agendaItemsAndRecommendations($docx, $report_id);
	$docx->addBreak(array('type' => 'page'));
	$text_box_2 = "<p style='font-size: 18; padding: 0; margin: 0; color: #FFF; text-align: center; font-family: Cambria;'><span style='font-size: 20;'>C</span>OMPANY <span style='font-size: 20;'>B</span>ACKGROUND</p>";
	addOrangeTextBox($docx, $text_box_2);
	companyBackground($docx, $report_id);
	$docx->addBreak(array('type' => 'page'));
	$text_box_3 = "<p style='font-size: 18; padding: 0; margin: 0; color: #FFF; text-align: center; font-family: Cambria;'><span style='font-size: 20;'>B</span>OARD <span style='font-size: 20;'>O</span>F <span style='font-size: 20;'>D</span>IRECTORS</p>";
	addOrangeTextBox($docx, $text_box_3);
	boardOfDirectorInfo($docx, $report_id);
	$docx->addBreak(array('type' => 'page'));
	$text_box_4 = "<p style='font-size: 18; padding: 0; margin: 0; color: #FFF; text-align: center; font-family: Cambria;'><span style='font-size: 20;'>R</span>EMUNERATION <span style='font-size: 20;'>A</span>NALYSIS</p>";
	addOrangeTextBox($docx, $text_box_4);
	remunerationAnalysis($docx, $report_id);
	$docx->addBreak(array('type' => 'page'));
	$text_box_5 = "<p style='font-size: 18; padding: 0; margin: 0; color: #FFF; text-align: center; font-family: Cambria;'><span style='font-size: 20;'>D</span>ISCLOSURES</p>";
	addOrangeTextBox($docx, $text_box_5);
	disclosures($docx, $report_id);
	adoptionOfAccounts($docx, $report_id);
	declarationOfDividend($docx, $report_id);
	appointmentOfAuditors($docx, $report_id);
	appointmentOfDirectors($docx, $report_id);
	directorsRemuneration($docx, $report_id);
	esops($docx, $report_id);
	relatedPartyTransaction($docx, $report_id);
	intercorporateLoans($docx, $report_id);
	schemeOfArrangement($docx, $report_id);
	corporateAction($docx, $report_id);
	issuesOfShares($docx, $report_id);
	alterrationInMoaAoa($docx, $report_id);
	fillInvestmentLimits($docx, $report_id);
	delistingOfShares($docx, $report_id);
	donationToCharitableTrust($docx, $report_id);
	officeOfProfit($docx, $report_id);
	disclaimerPage($docx);
	$com_name = getName($report_id);
	$compnay_name=$com_name['company_name'];
	$meeting_type=$com_name['meeting_type'];
	$meeting_date=$com_name['meeting_date'];
	$db_date = $meeting_date;
	$formated_day = date_format(date_create_from_format('Y-m-d', $db_date), 'd-m-Y');
	$docx->createDocx('try');
	$docx = new DocxUtilities();
	$source = 'try.docx';
	$target = 'try2.docx';
	$docx->watermarkDocx($source, $target, $type = 'image', $options = array('image' => 'bg.png', 'height' => 900, 'width' => 780, 'decolorate' => false));
//$docx->watermarkDocx($source, $target, $type = 'image', $options = array('image' => 'bg.png','height'=>900,'width'=>500,'decolorate'=>false));
	require_once '../classes/MultiMerge.inc';
	$merge = new MultiMerge();
	$merge->mergeDocx('index_page.docx', array('try2.docx'), "$compnay_name"."_SES Proxy Advisory Report_"."$meeting_type"."_"."$formated_day".".docx", array());
	burnExcel($report_id);
	$zip_files_array = array(
		'AuditorsRemuneration.docx',
		'AverageCommission.docx',
		'BoardComposition.docx',
		'CSRContribution.docx',
		'DividendAndEarning.docx',
		'DividendPayoutRatio.docx',
		'EDRemuneration.docx',
		'ExecutiveCompensation.docx',
		'ExecutiveRemuneration.docx',
		'MasterExcelFile.xlsx',
		'PromoterShareholding.docx',
		'RemunerationComponents.docx',
		'RetireByRotation.docx',
		'ShareholdingPattern.docx',
		'StockPerformance.docx',
		'StockPrice.docx',
		'TotalCommission.docx',
		'UtilizationBorrowingLimits.docx',
		'VariationInDirectorsRemuneration.docx',
		"$compnay_name"."_SES Proxy Advisory Report_"."$meeting_type"."_"."$formated_day".".docx",
		'graph_excel.xlsx'
	);
	$zip = new ZipArchive;
	if ($zip->open("$compnay_name.zip", ZipArchive::CREATE)) {
		foreach ($zip_files_array as $zip_file_name) {
			$zip->addFile($zip_file_name);
		}
	}
	$zip->close();
	$zip_file = "$compnay_name.zip";
	header('Content-type: application/zip');
	header('Content-Disposition: attachment; filename="' . basename($zip_file) . '"');
	header("Content-length: " . filesize($zip_file));
	header("Pragma: no-cache");
	header("Expires: 0");
	ob_clean();
	flush();
	readfile($zip_file);
	unlink($zip_file);
	exit;
}
catch(Exception $e) {
	echo $e->getMessage();
}
?>