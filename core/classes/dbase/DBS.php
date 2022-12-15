<?php

/* ***********************************************************
// INFO
// ***********************************************************
used to control databases

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/DBS.php");

*/

incCls("dbase/dbInfo.php");

DBS::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class DBS {
	private static $con = false;   // db connection
	private static $dbs = false;   // db object
	private static $inf = array(); // fld prop cache


public static function init() {
	CFG::set("DB_CON",   self::loadDbs());
	CFG::set("DB_LOGIN", self::isUser());
	CFG::set("DB_ADMIN", self::isAdmin());
	CFG::set("USR_GRPS", self::getGroups());
}

// ***********************************************************
private static function loadDbs() {
	self::$dbs = new dbBasics(NV, "dummy");
	self::$con = self::$dbs->getState();
	return self::$con;
}

// ***********************************************************
// querying db state
// ***********************************************************
public static function getState($sec = "main") { // tpl section
	if (DB_MODE == "none") return "nodb";
	if (! DB_CON)   return "nocon";
	if (! DB_LOGIN) return "nouser";
	return $sec;
}

public static function dbases() {
	$dbi = new dbInfo();
	return $dbi->dbases();
}
public static function tables($dbs) {
	$dbi = new dbInfo($dbs);
	return $dbi->tables();
}
public static function fields($dbs, $tbl, $key = false) {
	$dbi = new dbInfo($dbs);
	$out = $dbi->fields($tbl); if (! $key) unset($out["ID"]);
	return $out;
}

// ***********************************************************
// user status
// ***********************************************************
public static function isUser($usr = CUR_USER, $pwd = CUR_PASS) {
	if ( ! DB_CON) return false;
	$pwd = STR::maskPwd($pwd);

	$xxx = self::$dbs->setTable("dbusr");
	return self::$dbs->isRecord("`uname`='$usr' AND `pwd`='$pwd'");
}

public static function isAdmin($usr = CUR_USER)  {
	if (! DB_LOGIN) return false;

	$xxx = self::$dbs->setTable("dbxs");
	return self::$dbs->isRecord("cat='usr' AND spec='$usr' AND admin='m'");
}

// ***********************************************************
// user group info
// ***********************************************************
public static function isDbGroup($grp, $usr = CUR_USER)  {
	if (! DB_CON) return false;
	if (STR::contains("ID.cat.spec", ".$grp."))  return false;

	$xxx = self::$dbs->setTable("dbxs");
	return self::$dbs->isField($grp);
}

public static function getGroups($usr = CUR_USER)  {
	if (  DB_ADMIN) return "admin";
	if (! DB_LOGIN) return "www";

	$xxx = self::$dbs->setTable("dbxs");
	$arr = self::$dbs->query("cat='usr' AND spec='$usr'"); if (! $arr) return "www";
	$out = STR::toArray("www,user");

	foreach ($arr as $key => $val) {
		if ("$val" == "m") $out[$key] = $key;
	}
	return implode(",", $out);
}

// ***********************************************************
// string functions
// ***********************************************************
public static function secure($str) {
	$str = str_replace('"', "<dqot>", $str);
	$str = str_replace("'", "<sqot>", $str);
	$str = str_replace(";", "<scol>", $str);
	return $str;
}
public static function restore($str) {
	$str = str_replace("<dqot>", '"', $str);
	$str = str_replace("<sqot>", "'", $str);
	$str = str_replace("<scol>", ";", $str);
	return $str;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
