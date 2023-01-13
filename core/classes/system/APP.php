<?php
/* ***********************************************************
// INFO
// ***********************************************************
- contains application specific methods

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/APP.php");

*/

APP::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class APP {
	private static $fbk = array();
	private static $rvs = array();

public static function init() {
	$pfd = get_include_path();
	$arr = explode(PATH_SEPARATOR, $pfd);
	$arr = preg_filter('/$/', "/", $arr);

	self::$fbk = $arr;
}

// ***********************************************************
// reducing paths to "local" paths
// ***********************************************************
public static function relPath($fso) {
	$fso = CFG::insert($fso);
	$fso = FSO::norm($fso);

	foreach (self::$fbk as $dir) {
		$out = STR::after($fso, $dir); if ($out) return $out;
	}
	return $fso;
}

private static function getFBK($reverse = false) {
	$out = self::$fbk; if ($reverse) krsort($out);
	return $out;
}

// ***********************************************************
// fs object lists
// ***********************************************************
public static function bkpDir($dir = "", $root = SRV_ROOT, $pfx = "bkp") {
	if (! $dir) $dir = "$pfx.".date("Y.m.d");
	return FSO::join($root, "cms.backup", APP_NAME, $dir);
}
public static function logDir($dir = "") {
	return FSO::join(SRV_ROOT, "cms.log", APP_NAME, $dir);
}
public static function tempDir($dir = "", $sub = "") {
	return FSO::join(SRV_ROOT, "cms.temp", APP_NAME, $dir, $sub);
}
public static function genDir($dir = "", $sub = "") {
	return FSO::join(SRV_ROOT, "cms.temp", $dir, $sub);
}

public static function fbkDir($dir) {
	$dir = STR::afterX($dir, APP_NAME);
	$dir = trim($dir, DIR_SEP);
	return APP_FBK.$dir;
}

// ***********************************************************
// fs object lists
// ***********************************************************
public static function folders($dir) {
	$arr = self::getFBK(true); $out = array();
	$dir = self::relPath($dir);

	foreach ($arr as $loc) { // add dirs from app and fbk folders
		$ful = FSO::join($loc, $dir);
		$arr = FSO::folders($ful); if (! $arr) continue;

		foreach ($arr as $vrz => $nam) {
			$out[$nam] = $vrz; // APP_DIR to prevail over APP_FBK
		}
	}
	$out = array_flip($out);
	return $out;
}

public static function files($pattern, $ext = false, $visOnly = true) {
	$arr = self::getFBK(true); $out = array();
	$ptn = self::relPath($pattern);
	$ptn = self::addJoker($ptn);
	$ext = STR::toArray($ext);

	foreach ($arr as $loc) { // add files from app and fbk folders
		$ful = FSO::join($loc, $ptn);
		$arr = FSO::files($ful, $visOnly); if (! $arr) continue;

		foreach ($arr as $fil => $nam) {
			if ($ext) {
				$chk = FSO::ext($fil);
				if (! in_array($chk, $ext)) continue;
			}
			$out[$nam] = $fil; // APP_DIR to prevail over APP_FBK
		}
	}
	$out = array_flip($out);
	return $out;
}

private static function addJoker($fso, $ptn = "*") {
	if (STR::contains($fso, "*")) return $fso;
	return FSO::join($fso, $ptn);
}

// ***********************************************************
// single fs objects
// ***********************************************************
public static function dir($dir) { // find dir in extended fs
	if (is_dir($dir)) return $dir; $dir = self::relPath($dir);
	if (! $dir) return false;

	foreach (self::$fbk as $loc) {
		$ful = FSO::join($loc, $dir); if (is_dir($ful)) return $ful;
	}
	return false;
}

public static function file($fso) { // find file in extended fs
	if (FSO::isUrl($fso)) return $fso;
	if (is_file($fso)) return $fso;

	$fso = self::relPath($fso); if (! $fso) return false;

	foreach (self::$fbk as $loc) {
		$ful = FSO::join($loc, $fso); if (is_file($ful)) return $ful;
	}
	return false;
}

// ***********************************************************
public static function find($dir, $snip = "", $fext = false) {
	$lgs = LNG::getRel($snip); // find language relevant content

	foreach ($lgs as $lng) {
		$ptn = FSO::join($dir, "$snip.$lng.*");
		$arr = self::files($ptn, $fext, ! IS_LOCAL); if (! $arr) continue;
		$fls = array();

		foreach ($arr as $fil => $nam) {
			$ext = FSO::ext($fil, true);
			$fls[$ext] = $fil;
		}
		if (! $fext) {
			$fil = VEC::get($fls, "php");  if ($fil) return $fil;
			$fil = VEC::get($fls, "htm");  if ($fil) return $fil;
			$fil = VEC::get($fls, "html"); if ($fil) return $fil;
		}
		else {
			$fil = VEC::get($fls, $fext);  if ($fil) return $fil;
		}
	}
	return false;
}

// ***********************************************************
// retrieving content
// ***********************************************************
public static function gc($fso, $snip = "") {
	if (self::isLocked()) return "";

	$ful = self::file($fso);        if (! $ful)
	$ful = self::find($fso, $snip); if (! $ful) return "";

	$xxx = ob_start(); include($ful);
	$out = ob_get_clean();
	return trim($out);
}

public static function gcBody($fso) {
	$out = self::gc($fso); if ($out) return $out;
	return self::gc("core/modules/sitemap.php");
}

public static function gcRec($dir, $snip = "banner") { // get content recursively
	$arr = FSO::parents($dir); if (! $arr) return "";
	$out = ""; if ($snip == "trailer") rsort($arr);

	foreach ($arr as $dir) {
		$out.= self::gc($dir, $snip);
		if (self::isLocked()) return $out;
	}
	return $out;
}

// ***********************************************************
// file ops
// ***********************************************************
public static function read($file) { // read any text
	$ful = self::file($file); if (! $ful) return "";
	$out = file_get_contents($ful);
	$out = str_replace("\r", "", $out);
	return trim($out);
}

public static function append($file, $data) {
	return self::writeFile($file, $data, FILE_APPEND);
}

public static function write($file, $data, $overwrite = true) {
	if (is_file($file)) if (! $overwrite) return false;
	return self::writeFile($file, $data, false);
}

private static function writeFile($file, $data, $overwrite = false) {
	if (is_dir($file)) return false;

	$dir = FSO::force(dirname($file));
	$txt = VEC::xform($data);
	$txt = trim($txt)."\n";

	$erg = file_put_contents($file, $txt, $overwrite);
	$xxx = FSO::permit($file);
	return ($erg !== false);
}

public static function writeTell($file, $content, $overwrite = true) {
	if (is_file($file)) if (! $overwrite) return MSG::add("file.exists", $fil);
	$erg = self::write($file, $content); if ($erg !== false) return true;
	return ERR::msg("no.write", $file);
}

// ***********************************************************
// other
// ***********************************************************
public static function lookup($txt) {
	if (APP_CALL != "index.php") return $txt;
	if (EDITING  != "view")      return $txt;
	if (! ENV::get("lookup"))    return $txt;

	$cls = CFG::getVar("classes", "route.lookup", "lookup"); if (! $cls) return $txt;

	incCls("search/$cls.php");

	$lup = new $cls();
	$txt = $lup->insert($txt);
	return $txt;
}

public static function isView() {
	if (  EDITING == "view")  return true;
	return false;
}

private static function isLocked() {
	return ENV::get("blockme");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
