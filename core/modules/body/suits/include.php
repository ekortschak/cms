<?php

DBG::file(__FILE__);

// ***********************************************************
$loc = PGE::dir();

$htm = APP::gcSys($loc, "page");
$htm = APP::lookup($htm);
$htm = ACR::clean($htm);

if (! $htm) $htm = NV;

// ***********************************************************
if (APP::isView()) {
	$htm = STR::replace($htm, PAGE_BREAK, "");
}

// ***********************************************************
// show page
// ***********************************************************
$tpl = new tpl();
$tpl->load("pages/include.tpl");
$tpl->set("text", $htm);
$tpl->show();

?>
