<?php
/* ***********************************************************
// INFO
// ***********************************************************
- intended to handle message logging

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/LOG.php");

*/

incCls("system/timer.php");

define("LOG_DIR",  SRV_ROOT."cms.log/");

LOG::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class LOG {
	private static $tim;           // timer
	private static $dir = false;   // log dir
	private static $hed = "";
	private static $dat = array();

public static function init() {
	if (! self::isLocal()) return;

	self::$dir = self::chkDir();
	self::$tim = new timer();

	self::write("error.log", "", 0);   // error messages (system)
	self::write("timer.log", "", 0);   // performance info
}

// ***********************************************************
private static function chkDir() {
	if (! SRV_ROOT) return false;
	$app = basename(APP_DIR);
	$dir = LOG_DIR."$app"; if (! is_dir($dir))
	$out = mkdir($dir, 0755, true);
	$out = is_dir($dir); if (! $out) return false;
	return $dir;
}
private static function isLocal() {
	if (! isset($_SERVER["SERVER_NAME"])) return false;
	$srv = $_SERVER["SERVER_NAME"];
	return (stripos($srv, "localhost") !== false);
}
private static function isDebug() {
	if (! defined("EDITING")) return false;
	return (EDITING == "debug");
}

// ***********************************************************
public static function write($file, $data, $mode = FILE_APPEND) {
	if (! self::$dir) return; // nowhere to write to

	$fil = self::file($file);
    file_put_contents($fil, "$data\n", $mode);
}

public static function dir() {
	return self::$dir;
}
public static function file($file) {
	$file = basename($file);
	return self::$dir."/$file";
}

// ***********************************************************
// basic methods
// ***********************************************************
public static function setHead($head) {
	self::$hed = $head;
}
public static function clear() {
	self::$dat = array();
}
public static function append($msg) {
	$msg = trim($msg); if (! $msg) return;
	if (is_array($msg)) $msg = implode("<br>\n", $msg);
	self::$dat[] = $msg;
}

// ***********************************************************
public static function show($msg = false) {
	if (! self::$dir) return;
	if (! self::$dat) return; self::append($msg);

	$msg = implode("<br>\n", self::$dat);
	$hed = "<b>".self::$hed."</b>";

	if (! $msg) return;
	$msg = trim("$hed<br>\n$msg");
	echo "<msg>$msg</msg>";

	self::clear();
}

// ***********************************************************
// timer methods
// ***********************************************************
public static function lapse($msg = "timer") {
	$inf = self::$tim->lapse();
	$inf = sprintf("%1.3fs", $inf);
	self::write("timer.log", "L $msg $inf");
}
public static function total($msg = "total") {
	$inf = self::$tim->total();
	$inf = sprintf("%1.3fs", $inf);
	self::write("timer.log", "T $msg $inf");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
