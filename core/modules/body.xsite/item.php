<?php

# included by xsite->getText();
# $dir is inherited from calling method

// ***********************************************************
// retrieving page info
// ***********************************************************
$nop = PGE::get("props.noprint"); if (  $nop) return;
$inc = PGE::getIncFile();         if (! $inc) return;

// ***********************************************************
// build and show page
// ***********************************************************
$fil = FSO::join(__DIR__, $inc); if (! is_file($fil))
$fil = FSO::join(LOC_MOD, "body", $inc);

$frm = new tpl();
$frm->load("modules/page.tpl");
$frm->setVar("head", APP::gcMod($dir, "head"));
$frm->setVar("page", APP::gcMap($fil));
$frm->setVar("tail", APP::gcMod($dir, "tail"));
$frm->show("xsite");

?>
