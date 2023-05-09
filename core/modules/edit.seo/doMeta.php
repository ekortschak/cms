<?php

$lng = CUR_LANG;
$oid = OID::register();

OID::set($oid, "what", $wht);

$ini = new ini(CUR_PAGE);
$dat = $ini->get("$lng.$wht");

// ***********************************************************
// show editor
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/seo.meta.tpl");
$tpl->copy("hint.$wht", "hint");
$tpl->set("oid",  $oid);
$tpl->set("data", $dat);
$tpl->show();

// ***********************************************************
// show page for reference
// ***********************************************************
# this is done by the page template

?>
