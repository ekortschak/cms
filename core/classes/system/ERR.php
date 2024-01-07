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

// ***********************************************************
// error handling
// ***********************************************************
function shutDownTpl() {
	ERR::shutDown();
}
function errHandlerTpl($num, $msg, $file, $line) {
	ERR::handler($num, $msg, $file, $line);
}

// ***********************************************************
// define error options
// ***********************************************************
#register_shutdown_function("shutDown"); // defined above
#set_error_handler("errHandler");        // defined above

ERR::mode(0);


// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class ERR {
	private static $err = array(); // error information
	private static $hst = array(); // trace history
	private static $done = 0;	// only first error will be displayed

    const DEPTH = 7;  // call stack depth to display

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
		default:   error_reporting(null);
	}
}

// ***********************************************************
// error handling
// ***********************************************************
public static function handler($num, $msg, $file, $line) {
	if (! ERR_SHOW) return; if (! $num) return;

	if (ERR::suppress()) return; // do not show suppressed errors
	if (ERR::$done++) return; // handle only first error

	$tpl = new tpl();
	$tpl->load("msgs/error.tpl");
	$tpl->set("errID", "$num:$line");
	$tpl->set("line",   $line);
	$tpl->set("errNum", ERR::fmtNum($num, $msg));
	$tpl->set("errMsg", ERR::fmtMsg($msg));
	$tpl->set("file",   ERR::fmtFName($file));
	$tpl->set("items",  ERR::getStack("item"));
	$tpl->show();
}

// ***********************************************************
public static function shutDown() {
	if (! ERR_SHOW) {
		die("A fatal error occured ...");
	}
	$inf = error_get_last(); extract($inf); if (! $inf) return;
	$fil = APP::relPath($file);

	$tpl = new tpl();
	$tpl->load("msgs/error.tpl");
	$tpl->set("type", $type);
	$tpl->set("file", $fil);
	$tpl->set("line", $line);
	$tpl->set("message", $message);
	$tpl->show("fatal");
}

// ***********************************************************
public static function state() {
	return (count(ERR::$hst) > 0);
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
	$arr = ERR::getList(0, ERR::DEPTH); // get list of calling functions

	$tpl = new tpl();
	$tpl->load("msgs/error.tpl");
	$out = "";

	foreach ($arr as $itm) {
		$xxx = $tpl->merge($itm);
		$out.= $tpl->getSection($sec);
	}
	$md5 = md5($out); if (VEC::get(ERR::$hst, $md5)) return "";
	return trim($out);
}

// ***********************************************************
// reading backtrace info into array
// ***********************************************************
private static function getList($fst = 0, $cnt = NV) {
	if ($cnt === NV) $cnt = ERR::DEPTH;

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

		$itm["file"] = ERR::fmtFName($fil);
		$itm["args"] = ERR::fmtArgs($arg);

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
	if (strlen($itm) > $max) return substr($itm, 0, $max);
	return $itm;
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
