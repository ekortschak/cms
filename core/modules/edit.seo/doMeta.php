<?php

$oid = OID::register();
OID::set($oid, "loc", $loc);

// ***********************************************************
// show editor
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/seo.meta.tpl");
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
