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
	private static $dbs = false; // db object


public static function init() {
	CFG::set("DB_CON",   DBS::loadDbs());
	CFG::set("DB_LOGIN", DBS::isUser());
	CFG::set("DB_ADMIN", DBS::isAdmin());
	CFG::set("USR_GRPS", DBS::ugroups());
}

// ***********************************************************
private static function loadDbs() {
	DBS::$dbs = new dbInfo();
	return DBS::$dbs->getState();
}

// ***********************************************************
// user status
// ***********************************************************
private static function isUser($usr = CUR_USER, $pwd = CUR_PASS) {
	if ( ! DB_CON) return false;

	$pwd = STR::maskPwd($pwd);
	$xxx = DBS::$dbs->setTable("dbusr");
	return DBS::$dbs->isRecord("`uname`='$usr' AND `pwd`='$pwd'");
}

private static function isAdmin($usr = CUR_USER)  {
	if (! DB_LOGIN) return false;

	$xxx = DBS::$dbs->setTable("dbxs");
	return DBS::$dbs->isRecord("cat='usr' AND spec='$usr' AND admin='m'");
}

// ***********************************************************
// user group info
// ***********************************************************
private static function ugroups($usr = CUR_USER)  {
	if (  DB_ADMIN) return "admin";
	if (! DB_LOGIN) return "www";

	$xxx = DBS::$dbs->setTable("dbxs");
	$arr = DBS::$dbs->query("cat='usr' AND spec='$usr'"); if (! $arr) return "www";
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
	$str = str_replace("(CR)", "&copy;", $str);
	$str = str_replace('"', "<dqot>", $str);
	$str = str_replace("'", "<sqot>", $str);
	$str = str_replace(";", "<scol>", $str);
	return mysqli_real_escape_string($str);
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
