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
function logx($msg = "hier", $info = "dbg") {
	DBG::text($msg, $info);
}

function dump($obj) {
	var_dump($obj);
}
// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class DBG {
	public static $dest = "web";	// or coammand line
	private static $max = 7;

// ***********************************************************
// debugging tools
// ***********************************************************
public static function text($msg, $info) {
	if (is_array($msg)) {
		$msg = array_slice($msg, 0, 15);
		return self::vector($msg, $info);
	}
	if (self::$dest == "cl") { // command line
		echo "$info: $msg\n";
		return;
	}
	echo "\n<li><blue>$info</blue>: $msg</li>";
}
public static function html($msg, $info = "htm") { // show html code
	$msg = VEC::implode($msg, "\n");
	self::text(htmlspecialchars($msg), $info);
}
public static function path($msg, $info = "path") { // show path info
	$msg = str_replace("/",  " / ",  $msg);
	self::text($msg, $info);
}

// ***********************************************************
public static function vector($arr, $info = "arr") {
	$out = print_r($arr, true);
	$out = str_replace("Array\n", "Array ", $out);
	$out = trim($out);

	if (self::$dest == "cl") {
		echo "$info = $out";
		return;
	}
	echo "<div class='pre'>$info = $out</div>";
}

public static function list($arr, $info) {
	echo "<h5>$info</h5>";
	echo "<div class='pre'>";

	foreach ($arr as $key => $val) {
		echo "[$key] = $val\n";
	}
	echo "</div>";
}

// ***********************************************************
// boxed output: strings, arrays, objects ...
// ***********************************************************
public static function box($var, $info = "dbg") {
	if ($var === false) $var = "FALSE";

	if (is_object($var)) self::obj($var, $info); else
	if (is_array($var))  self::arr($var, $info); else
	                     self::str($var, $info);
}

private static function str($msg, $pfx = "str") {
	$tmp = htmlspecialchars($msg); if ($tmp) $msg = $tmp;
	self::tooltip($msg, $pfx);
}

private static function obj($obj, $pfx = "obj") {
	$msg = var_export($obj, true);
	self::str($msg, $pfx);
}

private static function arr($arr, $pfx = "var") {
	$num = count($arr); if (self::$max > 0)
	$arr = array_slice($arr, 0, self::$max);
	$msg = VEC::xform($arr);

	self::tooltip($msg, "$pfx = $num recs");
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