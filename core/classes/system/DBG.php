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
// BEGIN OF CLASS
// ***********************************************************
class DBG {
	private static $watch = "";	    // content to watch for
	private static $dest = "web";	// or cl = coammand line
	private static $max = 9;        // max array items to show

	const LEN = 65;

// ***********************************************************
// handling options
// ***********************************************************
public static function setDest($val) {
	if ($val == "cl") DBG::$dest = $val;
	DBG::$dest = "web";
}

public static function setMax($val = 99) {
	$val = intval($val);
	$val = CHK::range($val, 7, 49);

	DBG::$max = $val;
}

// ***********************************************************
// print to screen: strings, arrays, objects ...
// ***********************************************************
public static function text($msg, $info = "dbg") {
	$msg = DBG::convert($msg); DBG::save($info, $msg);

	if (DBG::$dest == "cl") { // write to command line
		echo "$info: $msg\n"; return;
	}
	echo "<dbg><blue>$info</blue> $msg</dbg>";
}

public static function path($msg, $info = "path") { // show path info
	$msg = str_replace("/",  "|",  $msg);
	DBG::text($msg, $info);
}

// ***********************************************************
// show file info
// ***********************************************************
public static function file($file) {
	if (! DEBUG) return;
	$lev = ""; if (STR::misses($file, "main.php")) $lev = 2;
	$fil = CFG::encode($file);
	echo "<dbg class='hint$lev'>§ $fil</dbg>";
}

// ***********************************************************
// present data as tree view: arrays
// ***********************************************************
public static function tview($arr, $info = "arr") {
	incCls("menus/tview.php"); DBG::save($info, $arr);

	foreach ($arr as $key => $val) {
		$arr[$key] = htmlspecialchars($val);
	}
	$tvw = new tview();
	$tvw->setData($arr);
	$tvw->set("info", $info);
	$tvw->show("debug");
}

// ***********************************************************
// boxed output: strings, arrays, objects ...
// ***********************************************************
public static function box($msg, $info = "dbg") {
	incCls("other/tooltip.php"); DBG::save($info, $msg);

	$tpl = new tooltip();
	$tpl->setData($info, DBG::convert($msg));
	$tpl->show("error");
}

// ***********************************************************
// watch
// ***********************************************************
public static function watch($what) {
	DBG::$watch = $what;
}

public static function check($what, $info = "watch") {
	if (! DBG::$watch) return;
	if (STR::misses($what, DBG::$watch)) return;
	DBG::text($what, $info);
}

// ***********************************************************
// convert msgs
// ***********************************************************
private static function convert($msg) {
	$msg = DBG::toString($msg);
	$msg = htmlspecialchars($msg);
	return $msg;
#	return STR::trunc($msg, DBG::LEN);
}

private static function toString($msg) {
	if ($msg === false)  return "FALSE";

	if (is_object($msg)) return var_export($obj, true);
	if (is_array( $msg)) return VEC::xform($msg, DBG::$max);
	return $msg;
}

// ***********************************************************
// copy info to SSV
// ***********************************************************
private static function save($msg, $info) {
	if (is_object("SSV")) SSV::set($info, $msg, "dbg");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
