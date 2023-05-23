<?php

incCls("editor/usrEdit.php");

// ***********************************************************
$mgr = new usrEdit();
$mgr->setScope("U");
$mgr->cnfUser("usr.drop");
$mgr->usrDrop();

?>
