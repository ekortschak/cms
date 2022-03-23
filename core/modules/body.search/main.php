<?php

$fnd = ENV::get("search");
$fil = ENV::get("prv");
$dir = dirname($fil);

// ***********************************************************
// show search details in body pane
// ***********************************************************
incCls("search/swrap.php");

$obj = new swrap();
$ref = $obj->getInfo($fil);
$tit = $obj->getTitle($fil);
$txt = $obj->getIt();

$sec = "preview"; if (! $txt) $sec = "none";

$tpl = new tpl();
$tpl->read("design/templates/modules/search.tpl");
$tpl->merge($ref);
$tpl->show($sec);

if (! $txt) return;

// ***********************************************************
// show content
// ***********************************************************
HTM::cap($tit, "h3");

$txt = STR::mark($txt, $fnd);
echo $txt;

?>
