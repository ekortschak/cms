<?php

$arc = CFG::getVal("backup", "local.archive", SRV_ROOT);
CFG::set("ARCHIVE", $arc); // if not yet set

// ***********************************************************
incCls("editor/saveMany.php");

incCls("editor/saveTab.php");
incCls("editor/saveMenu.php");
incCls("editor/saveFile.php");
incCls("editor/saveDbo.php");
incCls("editor/saveSeo.php");

// ***********************************************************
incCls("editor/saveCfg.php");

?>
