<?php

$loc = $dir;

// ***********************************************************
// retrieving page info
// ***********************************************************
$ini = new ini($dir);
$tit = $ini->getHead();
$inc = $ini->getIncFile();         if (! $inc) return;
$prn = $ini->get("props.noprint"); if (  $prn) return;

// ***********************************************************
// build and show page
// ***********************************************************
$fil = FSO::join(__DIR__, $inc); if (! is_file($fil))
$fil = FSO::join("core/modules/body", $inc);
$ful = APP::file($fil);

$frm = new tpl();
$frm->load("modules/page.tpl");
$frm->setVar("head", APP::gc($loc, "head"));
$frm->setVar("page", APP::gcBody($ful));
$frm->setVar("tail", APP::gc($loc, "tail"));
$frm->show("xsite");

?>
