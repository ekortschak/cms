<?php

switch (DB_MODE) {
	case "true": case 1: case true; break;
	default: return;
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
