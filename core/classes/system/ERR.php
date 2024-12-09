<?php
/* ***********************************************************
// INFO
// ***********************************************************
error handling is actually handled by load.err.php

- Handling log messages
- Debugging

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/ERR.php");

ERR::msg($msg, $parm);
ERR::raise($msg);
ERR::trace();

*/

errMode(false);

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ERR {
	private static $err = array(); // error information
	private static $hst = array(); // trace history

// ***********************************************************
// adding messages
// ***********************************************************
public static function msg($msg, $val = NV) {
	if (ERR::isknown($msg)) return "";
	return MSG::err($msg, $val);
}

public static function sql($msg, $sql) {
	$chk = STR::between($msg, "to use near", " "); if ($chk)
	$msg = "SQL error near: $chk\n";
	MSG::sql($msg, $sql);
}

// ***********************************************************
// custom errors
// ***********************************************************
public static function raise($msg) {
	if (is_array($msg)) $msg = print_r($msg, true);
	trigger_error($msg, E_USER_WARNING);
}

// ***********************************************************
// error tracing
// ***********************************************************
public static function trace() {
	$tpl = new tpl();
	$tpl->load("msgs/error.tpl");
	$tpl->set("items", ERR::getStack());
	$tpl->show("trace");
}

private static function getStack($sec = "short") {
	$arr = ERR::getList(); // get list of calling functions

	$tpl = new tpl();
	$tpl->load("msgs/error.tpl");
	$out = "";

	foreach ($arr as $itm) {
		$xxx = $tpl->merge($itm);
		$out.= $tpl->getSection($sec);
	}
	$out = CFG::encode($out);
	return $out;
}

// ***********************************************************
// reading backtrace info into array
// ***********************************************************
private static function getList() {
	$arr = debug_backtrace(); $out = array();

	foreach ($arr as $itm) {
		unset ($itm["object"]);

		$fil = VEC::get($itm, "file", false);  if (! $fil) continue;
		$cls = VEC::get($itm, "class", "app"); if ($cls == "ERR") continue;
		$fnc = VEC::get($itm, "function");     if ($fnc == "getBlock") break;
		$arg = VEC::get($itm, "args", array());

		if (ERR::ignore($fnc)) continue;

		$itm["file"] = ERR::fmtFName($fil);
		$itm["args"] = ERR::fmtArgs($arg);

		$out[] = $itm;
	}
	return $out;
}

// ***********************************************************
// formatting
// ***********************************************************
private static function fmtFName($file) {
	$ful = CFG::encode($file); // reduce path
	$fil = basename($file);
	return STR::replace($ful, $fil, "<b>$fil</b>");
}

private static function fmtArgs($arg, $max = 250) {
	if (! is_array($arg)) return $arg; $lst = array();

	foreach ($arg as $itm) {
		$lst[] = ERR::getArg($itm, $max);
	 }
	$arg = implode("'; '", $lst);
	$arg = strip_tags($arg); if (strlen($arg) > $max)
	$arg = substr($arg, 0, $max)." <red>~</red>";
	$arg = str_replace("'; '", "<red>,</red> ", $arg);
	return $arg;
}

private static function getArg($itm, $max) {
	$typ = gettype($itm);

	if (is_array($itm)) return "Array";
	if (is_object($itm)) return "Object";
	if (STR::contains($typ, "resource")) return "Ressource";
	if (STR::contains($itm, "<?php")) return "PHP-Code";
	if (STR::contains($itm, "</")) return "HTML-Code";

	return STR::left($itm, $max, false);
}

// ***********************************************************
// long messages
// ***********************************************************
public static function box() {
	$tpl = new tpl();
	$tpl->load("msgs/error.tpl");
	$tpl->merge(ERR::$err);
	$tpl->show();
}

public static function assist($cat, $key, $parm = "") {
	if (! ERR_SHOW) return;
	if (ERR::isknown("$cat.$key")) return "";

	$tpl = new tpl();
	$tpl->read(FSO::join("design/errors", "main.tpl"));
	$tpl->read(FSO::join("design/errors", "$cat.tpl"));

	$tpl->set("parm", $parm);
	$tpl->merge(ERR::$err);
	$tpl->substitute("howto", $key);
	$tpl->show();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function isknown($msg) {
	$md5 = md5($msg); if (isset(ERR::$hst[$md5])) return true;
	ERR::$hst[$md5] = $msg;
	return false;
}

private static function ignore($fnc) {
	$ign = ".shutDown.errHandler.trace.";
	$ign.= ".include.include_once.require.require_once.";
	$ign.= ".incCls.mod.";

	return (STR::contains($ign, $fnc));
}

private static function mailto($num, $msg) {
	if (IS_LOCAL) return;
	error_log("Error: [$num] $msg", 1, TEST_MASTER, "From: ".MAIL_MASTER);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
