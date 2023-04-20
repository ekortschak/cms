<?php
/* ***********************************************************
// INFO
// ***********************************************************
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

error_reporting(E_ALL);

ini_set("ignore_repeated_errors", 1);
ini_set("error_log", LOG::file("error.log"));

// ***********************************************************
// error handling
// ***********************************************************
function shutDown() { ERR::shutDown(); }
function errHandler($num, $msg, $file, $line) {
	ERR::handler($num, $msg, $file, $line);
}

// ***********************************************************
// define error options
// ***********************************************************
if (class_exists("ERR")) {
	register_shutdown_function("shutDown"); // defined above
	set_error_handler("errHandler");        // defined above
}

// ***********************************************************
// define syntax colors
// ***********************************************************
ini_set("highlight.comment", "red");
ini_set("highlight.default", "navy");
ini_set("highlight.html", "purple");
ini_set("highlight.keyword", "green");
ini_set("highlight.string", "orange");

ERR::mode(ERR_SHOW);


// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ERR {
	private static $err = array(); // error information
	private static $hst = array(); // trace history

    private static $depth = 7;  // call stack depth to display
	private static $done = 0;	// only first error will be displayed


// ***********************************************************
// add messages
// ***********************************************************
public static function msg($msg, $val = NV) {
	return MSG::err($msg, $val);
}

public static function sql($msg, $sql) {
	$chk = STR::after($msg, "to use near");
	if ($chk) {
		$chk = STR::before($chk, " ");
		$msg = "SQL error near: $chk\n";
	}
	MSG::sql($msg, $sql);
}

// ***********************************************************
// turning errors on or off
// ***********************************************************
public static function mode($value = true) {
	switch ($value) {
		case true: error_reporting(E_ALL); break;
		default:   error_reporting(E_CORE_ERROR);
	}
	ini_set("display_startup_errors", $value);
	ini_set("display_errors", $value);
}

// ***********************************************************
// error handling
// ***********************************************************
public static function handler($num, $msg, $file, $line) {
	if (! ERR_SHOW) return;
	if (self::suppress()) return; // do not show suppressed errors
	if (self::$done++) return; // handle only first error

	if (class_exists("tpl")) self::show($file, $num, $msg, $line);
	else self::tell($file, $num, $msg, $line);
}

// ***********************************************************
public static function shutDown() {
	$inf = error_get_last(); if (! $inf) return;
	extract($inf);

	echo "<hr>Error #$type<hr>in $file on <b>$line</b><br />";
	HTW::tag($message, "pre"); if (! IS_LOCAL) return;

	$lnk = HTM::href("?vmode=pedit", "edit mode");
	$rst = HTM::href("?reset=1", "session");

	HTW::tag("What can I do?", "h1");
	HTW::tag("Enter $lnk", "li");
	HTW::tag("Reset $rst", "li");
}

// ***********************************************************
public static function state() {
	return (count(self::$hst) > 0);
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
	$tpl->set("items", self::getStack());
	$tpl->show("trace");
}

private static function getStack($sec = "short") {
	$arr = self::getList(0, self::$depth); // get list of calling functions

	$tpl = new tpl();
	$tpl->load("msgs/error.tpl");
	$out = "";

	foreach ($arr as $itm) {
		$xxx = $tpl->merge($itm);
		$out.= $tpl->getSection($sec);
	}
	$md5 = md5($out); if (VEC::get(self::$hst, $md5)) return "";
	return trim($out);
}

// ***********************************************************
// reading backtrace info into array
// ***********************************************************
private static function getList($fst = 0, $cnt = NV) {
	if ($cnt == NV) $cnt = self::$depth;

	$ign = ".shutDown.errHandler.trace.";
	$ign.= ".include.include_once.require.require_once.";
	$ign.= ".doInc.incCls.incMod.incFnc.";

	$arr = debug_backtrace();
	$out = array();

	foreach ($arr as $itm) {
		unset ($itm["object"]);

		$fil = VEC::get($itm, "file", false);  if (! $fil) continue;
		$cls = VEC::get($itm, "class", "app"); if ($cls == "ERR") continue;
		$fnc = VEC::get($itm, "function");     #if (STR::contains($ign, $fnc)) continue;
		$arg = VEC::get($itm, "args", array());

		if ($fnc == "getBlock") break;

		$itm["file"] = self::fmtFName($fil);
		$itm["args"] = self::fmtArgs($arg);

		$out[] = $itm;
	}
	return $out;
	return array_slice($out, $fst, $cnt);
}

// ***********************************************************
// formatting
// ***********************************************************
private static function fmtNum($num, $msg) {
	$msg = STR::before($msg, ":");
	return "$num: $msg";
}

private static function fmtMsg($msg) {
	$msg = STR::after($msg, ":"); if (! $msg) return "";
	$msg = preg_replace("~\((\d+)\/(\d+)\):~", "",  $msg);
	$msg = str_ireplace(":", "<br>", $msg);
	$msg = str_ireplace("\n", "<br>\n", $msg);
	return $msg;
}

private static function fmtFName($file) {
	$ful = APP::relPath($file); // reduce path
	$fil = basename($file);
	return str_replace($fil, "<b>$fil</b>", $ful);
}

private static function fmtArgs($arg, $max = 250) {
	if (! is_array($arg)) return $arg; $lst = array();

	foreach ($arg as $itm) {
		$lst[] = self::getArg($itm, $max);
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
	if (strlen($itm) > $max) return substr($itm, 0, $max);
	return $itm;
}

// ***********************************************************
// long messages
// ***********************************************************
private static function show($file, $num, $msg, $line) {
	$tpl = new tpl();
	$tpl->load("msgs/error.tpl");
	$tpl->set("errID", "$num:$line");
	$tpl->set("line",   $line);
	$tpl->set("errNum", self::fmtNum($num, $msg));
	$tpl->set("errMsg", self::fmtMsg($msg));
	$tpl->set("file",   self::fmtFName($file));
	$tpl->set("items",  self::getStack("item"));
	$tpl->show();
}

private static function tell($file, $num, $msg, $line) {
	echo "<pre>";
	echo "Error $num on line $line in $file:\n";
	echo $msg;
	echo "</pre>";
}

// ***********************************************************
// long messages
// ***********************************************************
public static function box() {
	$tpl = new tpl();
	$tpl->load("msgs/error.tpl");
	$tpl->merge(self::$err);
	$tpl->show();
}

public static function assist($cat, $key, $parm = "") {
	if (! ERR_SHOW) return;

	$tpl = new tpl();
	$tpl->read(FSO::join("design/errors", "main.tpl"));
	$tpl->read(FSO::join("design/errors", "$cat.tpl"));

	$tpl->set("parm", $parm);
	$tpl->merge(self::$err);
	$tpl->substitute("howto", $key);
	$tpl->show();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function suppress() {
	return (! error_get_last());
}

private static function mailto($num, $msg) {
	if (IS_LOCAL) return;
	error_log("Error: [$num] $msg", 1, TEST_MASTER, "From: ".MAIL_MASTER);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
