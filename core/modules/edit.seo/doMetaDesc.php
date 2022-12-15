<?php

$loc = PFS::getLoc();
$lng = CUR_LANG;

$oid = OID::register();
OID::set($oid, "loc", $loc);

// ***********************************************************
// get info
// ***********************************************************
$ini = new ini($loc);
$dat = $ini->get("$lng.desc");

$wht = "desc";

// ***********************************************************
// show editor
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/editor/seo.meta.tpl");
$tpl->copy("hint.$wht", "hint");
$tpl->set("oid",  $oid);
$tpl->set("what", $wht);
$tpl->set("data", $dat);
$tpl->show();

// ***********************************************************
// show page for reference
// ***********************************************************
$loc = PFS::getLoc();
$ful = APP::find($loc);

echo APP::gcBody($ful);

?>
