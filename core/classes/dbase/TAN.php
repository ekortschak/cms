<?php
/* ***********************************************************
// INFO
// ***********************************************************
Handles db transaction
* allowing for hidden values not stored

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/TAN.php");

$obj = new TAN();

$tan = $obj->open($tbl, $qid);
$inf = $obj->exec(); // will destroy all $tan related info !!!
*/

TAN::init();
TAN::exec(); // apply pending transactions

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class TAN {
	private static $tan = false;
	private static $ofs = 15;     // validity intervall in minutes

public static function init() {
	TAN::$tan = TAN::get("prop.dbtan");
}

// ***********************************************************
// methods
// ***********************************************************
public static function register($dbase, $table, $recid) {
	TAN::$tan = md5("tan.$dbase.$table.$recid");
	if ($recid < 1) $recid = -1;

	SSV::clear("tan");

	TAN::set("prop.dbtan", TAN::$tan);
	TAN::set("prop.valid", TAN::mkdate());
	TAN::set("prop.dbase", $dbase);
	TAN::set("prop.table", $table);
	TAN::set("prop.recid", $recid);

	return TAN::$tan;
}

public static function close() {
	SSV::wipe("tan");
}

// ***********************************************************
// setting & retrieving values
// ***********************************************************
public static function set($key, $val) {
	return SSV::set($key, $val, "tan");
}
private static function get($key, $default = false) {
	return SSV::get($key, $default, "tan");
}

// ***********************************************************
// executing transaction
// ***********************************************************
public static function exec() {
	if (! DB_LOGIN) return false; $arr = OID::getLast();
	if (! $arr) return false;

	if (! isset($arr["tan"])) return false;

	if (! TAN::chkTan($arr["tan"])) return false;
	if (! TAN::chkTime()) return ERR::assist("dbase", "tan.outdated", TAN::$tan);

	$dbs = TAN::get("prop.dbase"); if (! $dbs) return false;
	$tbl = TAN::get("prop.table"); if (! $tbl) return false;
	$qid = TAN::get("prop.recid");

	$vls = TAN::getVals($arr);
	$erg = TAN::doQuery($dbs, $tbl, "ID='$qid'", $vls);
	$xxx = TAN::close();
	return $erg;
}

private static function getVals($arr) {
	unset($arr["tan"]); unset($arr["rec_act"]);
	unset($arr["oid"]); unset($arr["act"]);

	$hid = SSV::getValues("tan");

	foreach ($hid as $key => $val) {
		if (STR::begins($key, "prop_")) continue;
		$arr[$key] = $val;
	}
	return $arr;
}

private static function doQuery($dbs, $tbl, $flt, $vls) {
	incCls("dbase/dbQuery.php");

	$dbq = new dbQuery($dbs, $tbl);
	$dbq->askMe(false);

	switch (ENV::getPost("rec.act")) {
		case "a": return $dbq->insert($vls);
		case "e": return $dbq->update($vls, $flt);
		case "d": return $dbq->delete($flt);
	}
	return false;
}

// ***********************************************************
// timestamps
// ***********************************************************
private static function mkdate() {
	return time() + TAN::$ofs * 60;
}
private static function chkTime() {
	$now = time();
	$chk = TAN::get("prop.valid");
	return ($now < $chk);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function chkTan($tan) {
	$chk = TAN::get("prop.dbtan");	if (! $chk) return false;
	return ($tan == $chk);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
