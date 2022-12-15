<?php

$use = CFG::get("DB_MODE", "none");

// ***********************************************************
if ($use == "none") {
	CFG::set("DB_MODE", "none");
	CFG::set("DB_CON",  "none");
	return;
}

// ***********************************************************
incCls("dbase/dbBasics.php");

incCls("dbase/DBS.php");   // database control
incCls("dbase/TAN.php");   // database transactions

?>
