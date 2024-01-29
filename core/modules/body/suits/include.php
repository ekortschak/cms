<?php

DBG::file(__FILE__);

// ***********************************************************
$loc = PGE::dir();
$pic = PGE::pic();

$htm = APP::gcSys($loc, "page");
$htm = APP::lookup($htm);
$htm = ACR::clean($htm);

if (! $htm) $htm = NV;

// ***********************************************************
if (VMODE == "view") {
	$htm = STR::replace($htm, '<hr class="pbr">', "");
}

// ***********************************************************
// show page
// ***********************************************************
$tpl = new tpl();
$tpl->load("pages/include.tpl");

$tpl->set("text", $htm);
$tpl->set("pic",  $pic);

if (! $pic) {
	$tpl->clearSec("pic");
}
$tpl->show();

?>
