<?php

require_once '../classes/CreateDocx.inc';
require_once '../classes/DocxUtilities.inc';

$docx = new CreateDocx();
$docx->modifyPageLayout('A4', array('marginRight' => '1000','marginLeft' => '1000','marginHeader'=>'200','marginFooter'=>'0'));
$docx->setDefaultFont('Calibri');
$docx->createDocx('try-image');


$docx = new DocxUtilities();
$source = 'try-image.docx';
$target = 'try-image.docx';
$docx->watermarkDocx($source, $target, $type = 'image', $options = array('image' => 'bg.png','height'=>500,'width'=>780));

?>