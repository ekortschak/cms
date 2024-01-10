<?php

$lng = CUR_LANG;
$oid = OID::register();

OID::set($oid, "what", "keys");

$ini = new ini(PGE::$dir);
$dat = $ini->get("$lng.keys");

// ***********************************************************
// show editor
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/edit.meta.tpl");
$tpl->copy("hint.keys", "hint");
$tpl->set("oid",  $oid);
$tpl->set("data", $dat);
$tpl->show();

// ***********************************************************
// show page for reference
// ***********************************************************
# this is done by the page template

?>
