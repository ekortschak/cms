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


public static function init() {
	CFG::set("DB_CON",   self::loadDbs());
	CFG::set("DB_LOGIN", self::isUser());
	CFG::set("DB_ADMIN", self::isAdmin());
	CFG::set("USR_GRPS", self::ugroups());
}

// ***********************************************************
private static function loadDbs() {
	self::$dbs = new dbInfo();
	self::$con = self::$dbs->getState();
	return self::$con;
}

// ***********************************************************
// querying db state
// ***********************************************************
public static function dbases() {
	return self::$dbs->dbases();
}
public static function tables($dbs) {
	return self::$dbs->tables();
}
public static function fields($dbs, $tbl, $key = false) {
	$out = self::$dbs->fields($tbl); if (! $key) unset($out["ID"]);
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

public static function ugroups($usr = CUR_USER)  {
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

public static function pgroups($dbs, $mds = false) { // public groups (may be edited)
	$out = self::$dbs->usrGroups($mds); if (! $out) $out = "?";
	return $out;
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
