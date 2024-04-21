<?php

DBG::file(__FILE__);

// ***********************************************************
// check for reset
// ***********************************************************
if (ENV::getParm("search.reset")) {
	ENV::set("search.what",  false);
	ENV::set("search.parms", false);
	ENV::set("search.last",  false);
	ENV::set("search.help",  0);
}

// ***********************************************************
// show help or not
// ***********************************************************
$hlp = ENV::get("search.help", 0);

// ***********************************************************
// creating search form
// ***********************************************************
incCls("search/search.php");

$obj = new search();
$opt = $obj->scope();
$fnd = $obj->findWhat();
$lst = $obj->results($fnd);

$tpl = new tpl();
$tpl->load("modules/search.tpl");
$tpl->set("range",  $opt);
$tpl->set("search", $fnd);

if ($fnd && $hlp)
$tpl->substitute("help", "nohelp");
$tpl->show();

if ((! $fnd) || ($hlp))
$tpl->show("howto");

// ***********************************************************
// showing results
// ***********************************************************
APP::inc(__DIR__, "results.php");

?>
