<?php

$fnd = ENV::get("search");
$fil = ENV::get("prv");
$tpc = ENV::get("tab");

// ***********************************************************
// show search details in body pane
// ***********************************************************
incCls("search/swrap.php");

$obj = new swrap();
$ref = $obj->getInfo($fil);
$tit = $obj->getTitle($fil);
$txt = $obj->getSnips($fil, $fnd);

$sec = "preview"; if (! $txt) $sec = "none";

$tpl = new tpl();
$tpl->read("design/templates/modules/search.tpl");
$tpl->set("topic", $tpc);
$tpl->merge($ref);
$tpl->show($sec);

LOG::lapse("body.search ready");

if (! $txt) return;

// ***********************************************************
// show content
// ***********************************************************
HTM::cap($tit, "h3");

$txt = STR::mark($txt, $fnd);
echo $txt;

LOG::lapse("body.search done");

?>
