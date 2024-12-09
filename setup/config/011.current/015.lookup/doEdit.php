<?php

incCls("editor/ediMgr.php");

// ***********************************************************
$edi = new ediMgr();
$edi->edit("lookup", "*.ini");

?>
