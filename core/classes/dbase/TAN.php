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

TAN::exec("tan"); // apply pending transactions

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class TAN {
	private static $tan = "no"; // transaction number
	private static $ofs = 15;   // time offset

// ***********************************************************
// methods
// ***********************************************************
public static function open($dbase, $table, $recid) {
	if (self::$tan != "no")
	return ERR::assist("dbase", "tan.conflict", "$table[$recid]");

	if ($recid < 1) $recid = -1;
	self::$tan = $tan = md5("tan.$table.$recid");

	self::set($tan, "dbtan", $tan);
	self::set($tan, "dbase", $dbase);
	self::set($tan, "table", $table);
	self::set($tan, "recid", $recid);
	self::set($tan, "valid", self::mkdate());
	self::set($tan, "vals",  array());
	return $tan;
}

public static function store($key, $val, $tan = NV) {
	if ($tan == NV) $tan = self::$tan;
	if (strlen($tan) != 32) return;
	$_SESSION["tans"][$tan]["vals"][$key] = $val;
}

public static function close() {
	unset($_SESSION["tans"]);
	self::$tan = "no";
}

// ***********************************************************
// setting and retrieving values
// ***********************************************************
private static function set($tan, $key, $val) {
	if (strlen($tan) != 32) return;
	$_SESSION["tans"][$tan][$key] = $val;
}
private static function get($tan, $key, $default) {
	if (strlen($tan) != 32) return $default;
	$arr = self::getTan($tan); if (! $arr) return $default;
	return VEC::get($arr, $key, $default);
}

private static function getTan($tan) {
	if (strlen($tan) != 32) return false;
	$arr = VEC::get($_SESSION, "tans"); if (! $arr) return false;
	return VEC::get($arr, $tan);
}

private static function getData($tan) {
	$oid = ENV::getPost("oid"); if (! $oid) return false;
	$ar1 = ENV::oidValues($oid);
	$ar2 = self::get($tan, "vals", array());
	$arr = array_merge($ar1, $ar2);
	$out = array();

	foreach ($arr as $key => $val) {
		$out[$key] = trim($val);
	}
	return $out;
}

// ***********************************************************
// executing transaction
// ***********************************************************
public static function exec() {
	if (! DB_CON) return false;

	$tan = ENV::getPost("tan"); if (! $tan) return false;
	$arr = self::getTan($tan);  if (! $arr) return false;

	$tim = self::chkTime($arr["valid"]);
	if (! $tim) return ERR::assist("dbase", "tan.outdated", $tan);

	$dbs = $arr["dbase"]; if (! $dbs) return false;
	$tbl = $arr["table"]; if (! $tbl) return false;
	$qid = $arr["recid"];

	$vls = self::getData($tan);
	$erg = self::doQuery($dbs, $tbl, "ID='$qid'", $vls);
	$xxx = self::close();
	return $erg;
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
	$ofs = self::$ofs;
	$now = strtotime(date("Y-m-d H:i:s"));
	$now = strtotime("+$ofs minutes", $now);
	$out = date("Y-m-d H:i:s", $now);
	return $out;
}
private static function chkTime($val) {
	$now = date("Y-m-d H:i:s");
	return ($now < $val);
}

// ***********************************************************
// debugging
// ***********************************************************
public static function dump($tan) {
	$out = print_r($_SESSION["tans"][$tan]);
	echo "<pre>$out</pre>";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
