<?php

$loc = PFS::getLoc();

$ini = new ini();
$ext = $ini->get("props.ext", "pdf, txt, doc, docx");
$dox = $ini->get("props.path", $loc);
$srt = $ini->get("props.sort");
$exc = $ini->getType("inc");

// ***********************************************************
// select the template
// ***********************************************************
switch ($exc) {
    case "dow": $tpl = "design/templates/modules/fview.download.tpl"; break;
    case "mim": $tpl = "design/templates/modules/fview.mimetype.tpl"; break;
    default:    $tpl = "design/templates/modules/fview.gallery.tpl";
}

// ***********************************************************
incCls("files/dirView.php");
// ***********************************************************
$obj = new dirView();
$obj->read($tpl);
$obj->setSort($srt);
$obj->readTree($dox, $ext);
$obj->show();

?>
