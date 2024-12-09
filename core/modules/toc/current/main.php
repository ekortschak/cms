<?php

DBG::file(__FILE__);

// ***********************************************************
// check if applicable
// ***********************************************************
# if (APP::isView())
# if (TAB_TYPE == "sel") return;

// ***********************************************************
$ini = new ini(TAB_HOME);
$tit = $ini->title();
$uid = $ini->UID();

// ***********************************************************
$tit = HTM::href("?pge=$uid", $tit);
$loc = PGE::dir();

$sel = ""; if (TAB_HOME == $loc)
$sel = "sel";

// ***********************************************************
// show current topic
// ***********************************************************
$tpl = new tpl();
$tpl->load("menus/curTopic.tpl");
$tpl->set("selected", $sel);
$tpl->set("title", $tit);

if (VMODE == "abstract") {
	$tpl->substitute("nav", "nav.back");
}

$tpl->show();

?>
