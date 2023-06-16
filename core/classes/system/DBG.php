<?php
/* ***********************************************************
// INFO
// ***********************************************************
- Debugging

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/DBG.php");

DBG::$dest = "web | cl";
DBG::text($msg, $info);

*/

// ***********************************************************
// shortcuts
// ***********************************************************
function dbg($msg = "hier", $info = "dbg") { // list as <li>text
	DBG::text($msg, $info);
}
function dbgbox($any, $info = "dbg") { // show boxed info
	DBG::box($any, $info);
}
function dbght($msg, $info = "htm") { // show html code
	echo "<pre>"; DBG::html($msg, $info);
	echo "</pre>";
}
function dbgpi($msg, $info = "path") { // show path info
	DBG::path($msg, $info);
}

function dump($obj) {
	var_dump($obj);
}
// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class DBG {
	public static $dest = "web";	// or cl = coammand line
	private static $max = 7;

// ***********************************************************
// debugging tools
// ***********************************************************
public static function text($msg, $info = "dbg") {
	if (is_object($msg)) return DBG::obj($msg, $info);
	if (is_array($msg)) {
		if (count($msg) > 15) {
			$msg = array_slice($msg, 0, 15);
			$msg["+"] = "...";
		}
		return DBG::vector($msg, $info);
	}
	if (DBG::$dest == "cl") { // command line
		echo "$info: $msg\n";
		return;
	}
	if (is_object("SSV")) SSV::set($info, $msg, "dbg");
	echo "\n<li><blue>$info</blue>: $msg</li>";
}
public static function html($msg, $info = "htm") { // show html code
	if (is_array($msg)) {
		DBG::vector($msg, $info);
		return;
	}
	DBG::text(htmlspecialchars($msg), $info);
}
public static function path($msg, $info = "path") { // show path info
	$msg = str_replace("/",  " / ",  $msg);
	DBG::text($msg, $info);
}

// ***********************************************************
public static function vector($arr, $info = "arr") {
	SSV::set($info, $arr, "dbg");

	if (DBG::$dest == "cl") {
		$out = print_r($arr, true);
		$out = str_replace("Array\n", "Array ", $out);
		$out = trim($out);

		echo "$info = $out";
		return;
	}
	incCls("menus/tview.php");

	$tvw = new tview();
	$tvw->setData($arr);
	$tvw->set("info", $info);
	$tvw->show("debug");
}

// ***********************************************************
// boxed output: strings, arrays, objects ...
// ***********************************************************
public static function box($var, $info = "dbg") {
	if ($var === false) $var = "FALSE";

	if (is_object($var)) DBG::obj($var, $info); else
	if (is_array($var))  DBG::arr($var, $info); else
	                     DBG::str($var, $info);
}

private static function str($msg, $pfx = "str") {
	$tmp = htmlspecialchars($msg); if ($tmp) $msg = $tmp;
	DBG::tooltip($msg, $pfx);
}

private static function obj($obj, $pfx = "obj") {
	$msg = var_export($obj, true);
	DBG::str($msg, $pfx);
}

private static function arr($arr, $pfx = "var") {
	$num = count($arr); if (DBG::$max > 0)
	$arr = array_slice($arr, 0, DBG::$max);
	$msg = VEC::xform($arr);

	DBG::tooltip($msg, "$pfx = $num recs");
}

// ***********************************************************
// write output
// ***********************************************************
private static function tooltip($tip, $key = "") {
	incCls("other/tooltip.php");

	$tpl = new tooltip();
	$tpl->setData($key, $tip);
	$tpl->show("error");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
