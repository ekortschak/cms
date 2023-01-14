<?php

if (! FS_ADMIN) {
	incMod("stop.php");
	return;
}

incCls("editor/seoEdit.php");
incCls("menus/buttons.php");

// ***********************************************************
// react to previous commands
// ***********************************************************
$obj = new seoEdit();

// ***********************************************************
HTW::xtag("seo", "h3");
// ***********************************************************
$nav = new buttons("seo", "L", __DIR__);

$nav->add("L", "doLinks");
$nav->add("K", "doMetaKeys");
$nav->add("D", "doMetaDesc");
$nav->show();

?>
