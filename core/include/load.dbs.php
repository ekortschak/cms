<?php

if (! DB_MODE) {
	CFG::set("DB_CON", 0);
	CFG::set("DB_LOGIN", 0);
	CFG::set("DB_ADMIN", 0);
	CFG::set("USR_GRPS", "www");
	return;
}

// ***********************************************************
incCls("dbase/dbBasics.php");

incCls("dbase/DBS.php");   // database control
incCls("dbase/TAN.php");   // database transactions

// ***********************************************************
// benchmark
// ***********************************************************
# TMR::punch("inc.dbs");

?>
