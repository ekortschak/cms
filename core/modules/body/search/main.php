<?php

DBG::file(__FILE__);

// ***********************************************************
// check for reset
// ***********************************************************
if (ENV::getParm("search.reset")) {
	ENV::set("search.what",  false);
	ENV::set("search.parms", false);
	ENV::set("search.last",  false);
}

// ***********************************************************
// creating search form
// ***********************************************************
incCls("search/search.php");

$obj = new search();
$opt = $obj->getScope();
$fnd = $obj->findWhat();
$lst = $obj->getResults($fnd);

$tpl = new tpl();
$tpl->load("modules/search.tpl");
$tpl->set("range",  $opt);
$tpl->set("search", $fnd);
$tpl->show();

// ***********************************************************
// showing results
// ***********************************************************
APP::inc(__DIR__, "results.php");

?>
