<?php

CFG::set("ARCHIVE", SRV_ROOT); // if not yet set

// ***********************************************************
if (APP_CALL == "x.edit.php") {
// ***********************************************************
	incCls("editor/saveTab.php");
	incCls("editor/saveMenu.php");
	incCls("editor/saveFile.php");
	incCls("editor/saveDbo.php");
	incCls("editor/saveSeo.php");
}

// ***********************************************************
if (APP_CALL == "config.php") {
// ***********************************************************
#	incCls("editor/saveCfg.php");

dbg($_POST);
}

?>
