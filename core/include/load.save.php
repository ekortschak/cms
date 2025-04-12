<?php

if (APP::isView()) return;

incCls("editor/saveMany.php");

// ***********************************************************
incCls("editor/saveTab.php");
incCls("editor/saveMenu.php");
incCls("editor/savePage.php");
incCls("editor/saveBook.php");
incCls("editor/saveDbo.php");
incCls("editor/saveSeo.php");

// ***********************************************************
incCls("editor/saveCfg.php");

?>
