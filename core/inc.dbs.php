<?php

$use = CFG::get("DB_MODE"); if (! $use) return;

// ***********************************************************
incCls("dbase/dbBasics.php");

incCls("dbase/DBS.php");   // database control
incCls("dbase/TAN.php");   // database transactions

?>
