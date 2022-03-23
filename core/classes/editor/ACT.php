<?php
/* ***********************************************************
// INFO
// ***********************************************************
- manages pending transactions
- except for DB transactions (see dbase/DBS.php)
- to be executed before any display relevant code

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/ACT.php");

$act = new ACT();
*/

ACT::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ACT  {

// ***********************************************************
// methods
// ***********************************************************
public static function init() {
	switch (EDITING) {
		case "tedit": return self::execute("tabEdit");
		case "medit": return self::execute("mnuEdit");
		case "pedit": return self::execute("genEdit");
	}
	if (VEC::get($_POST, "val_dbo") == "dboEdit") {
		return self::execute("dboEdit");
	}
	if (VEC::get($_POST, "val_user") == "usrEdit") {
		return self::execute("usrEdit");
	}
	if ($_FILES) {
		return self::fileUpload(); // upload any files
	}
}

// ***********************************************************
// check for pending operations
// ***********************************************************
private static function execute($fnc) {
	incCls("editor/act.$fnc.php");

	$edt = new $fnc();
	$edt->exec();
}

private static function fileUpload() { // upload any file to $dir
	$act = VEC::get($_POST, "opt_act"); if ($act != "upload") return;
	$ovr = VEC::get($_POST, "opt_overwrite");
	$dir = VEC::get($_POST, "val_dest");

	incCls("server/upload.php");

	$upl = new upload();
	$upl->setOverwrite($ovr);
	$upl->moveAllFiles($dir);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
