<?php

incCls("editor/ediMgr.php");

// ***********************************************************
$edi = new ediMgr();
$edi->edit(LOC_TPL, "*.tpl");

?>
