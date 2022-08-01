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

LOG::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class LOG {
	private static $tim;           // timer
	private static $dir = false;   // log dir
	private static $dbg = false;
	private static $hed = "";
	private static $dat = array();

public static function init() {
	if (! self::isLocal()) return;

	self::$dir = self::chkDir();
	self::$dbg = self::isDebug();
	self::$tim = new timer();

	$fil = $_SERVER["PHP_SELF"];
	if (stripos($fil, "css") > 0) return;

	self::write("timer.log", "", 0);   // error messages (system)
	self::write("error.log", "", 0);   // error messages (system)
	self::write("debug.log", "", 0);   // debug messages (app)
	self::write("modules.log", "", 0); // loaded modules
	self::saveParms();
}

// ***********************************************************
private static function chkDir() {
	if (! SRV_ROOT) return false;
	$app = basename(APP_DIR);
	$dir = SRV_ROOT."temp/$app/log"; if (! is_dir($dir))
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
// writing content to file
// ***********************************************************
public static function module($data) {
	self::write("modules.log", $data);
}
public static function debug($data) {
	$out = $data; if (is_array($out)) $out = print_r($out, true);
	self::write("debug.log", $out);
}

// ***********************************************************
private static function saveParms() {
	if (! self::$dir) return;

	$min = 11;
	$fls = print_r($_FILES, true); if (strlen($fls) < $min) $fls = false;
	$pst = print_r($_POST, true);  if (strlen($pst) < $min) $pst = false;
	$get = print_r($_GET, true);   if (strlen($get) < $min) $get = false;

	if ($fls) $fls = "FILES = $fls\n\n";
	if ($pst) $pst = "POST = $pst\n\n";
	if ($get) $get = "GET = $get\n\n";

	$log = self::$dir."/parms.log";
	$sep = "*** TIME = ";
	$max = 5;

	$txt = ""; if (is_file($log))
	$txt = file_get_contents($log);
	$arr = explode($sep, $txt);
	$fst = count($arr);
	$arr = array_slice($arr, $fst, $max);

	$out = $sep.date("H:i:s")."\n";
	$out.= $get.$pst.$fls."\n";
	$out.= implode($sep, $arr);

    self::write($log, $out, 0);
}

// ***********************************************************
// timer methods
// ***********************************************************
public static function lapse($msg = "timer") {
	if (! self::$dir) return;

	$inf = self::$tim->lapse();
	$inf = sprintf("%1.3fs", $inf);
	self::write("timer.log", "<p>L $inf $msg</p>");
}
public static function total($msg = "total") {
	if (! self::$dir) return;

	$inf = self::$tim->total();
	$inf = sprintf("%1.3fs", $inf);
	self::write("timer.log", "<p>T $inf $msg</p>");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
