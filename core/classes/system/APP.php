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

	self::$rvs = self::$fbk = $arr;
	krsort(self::$rvs);
}

// ***********************************************************
// reducing paths to "local" paths
// ***********************************************************
public static function relPath($fso) {
	$arr = APP::getFBK();

	foreach ($arr as $dir) {
		$out = STR::after($fso, $dir); if ($out !== false) return $out;
	}
	return $fso;
}

// ***********************************************************
// fs object lists
// ***********************************************************
public static function bkpDir($dir = "", $root = SRV_ROOT, $pfx = "bkp") {
	if (! $dir) $dir = "$pfx.".date("Y.m.d");
	return FSO::join($root, "cms.backup", APP_NAME, $dir);
}
public static function tempDir($dir = "", $sub = "") {
	return FSO::join(SRV_ROOT, "temp", APP_NAME, $dir, $sub);
}
public static function genDir($dir = "", $sub = "") {
	return FSO::join(SRV_ROOT, "temp", $dir, $sub);
}

public static function getFBK() {
	return self::$fbk;
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
	$dir = self::relPath($dir); $out = array();

	foreach (self::$rvs as $loc) { // add dirs from app and fbk folders
		$ful = FSO::join($loc, $dir);
		$arr = FSO::folders($ful); if (! $arr) continue;

		foreach ($arr as $vrz => $nam) {
			$out[$nam] = $vrz; // only last concordance will be returned
		}
	}
	$out = array_flip($out);
	return $out;
}

public static function files($pattern, $ext = false, $visOnly = true) {
	$ptn = self::relPath($pattern); if (! STR::contains($ptn, "*"))
	$ptn = FSO::join($ptn, "*.*");
	$ext = STR::toArray($ext); $out = array();

	foreach (self::$rvs as $loc) { // add files from app and fbk folders
		$ful = FSO::join($loc, $ptn);
		$arr = FSO::files($ful, $visOnly); if (! $arr) continue;

		foreach ($arr as $fil => $nam) {
			if ($ext) {
				$chk = FSO::ext($fil);
				if (! in_array($chk, $ext)) continue;
			}
			$out[$nam] = $fil; // only last concordance will be returned
		}
	}
	$out = array_flip($out);
	return $out;
}

// ***********************************************************
// single fs objects
// ***********************************************************
public static function dir($dir) { // find dir in extended fs
	if (strlen($dir) < 3) return false;
	if (is_dir($dir)) return $dir;

	$dir = self::relPath($dir); if (! $dir) return false;

	foreach (self::$fbk as $loc) {
		$ful = FSO::join($loc, $dir);
		if (is_dir($ful)) return $ful;
	}
	return false;
}

public static function file($fso) { // find file in extended fs
	if (FSO::isUrl($fso)) return $fso; if (! $fso) return "";
	if (is_file($fso)) return $fso;
	if (is_dir($fso)) return false;

	$fso = self::relPath($fso);

	foreach (self::$fbk as $loc) {
		$ful = FSO::join($loc, $fso);
		if (is_file($ful)) return $ful;
		if (is_dir($ful))  return false;
	}
	return false;
}

public static function url($fso) { // convert file to url
	if (FSO::isUrl($fso)) return ""; if (! $fso) return "";

	if (STR::begins($fso, ".".DIR_SEP)) { // e.g. local pics
		$loc = PFS::getLoc();  $fil = substr($fso, 2);
		return FSO::join($loc, $fil);
	}
	$ful = self::file($fso);
	if (STR::begins($ful, APP_DIR)) return STR::after($ful, APP_DIR);
	if (STR::begins($ful, APP_FBK)) {
		$out = FSO::join(CMS_URL, STR::after($ful, APP_FBK));
		if (FSO::isUrl($out)) return $out;
		return STR::afterX($out, SRV_NAME);
	}
	if (STR::begins($ful, SRV_ROOT)) return STR::after($ful, SRV_ROOT);
	return $fso;
}

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
public static function getBlock($file) {
	if (! is_file($file)) return false;
	$xxx = ob_start(); include($file);
	$out = ob_get_clean();
	return trim($out);
}

public static function gc($fso, $snip = "") { // find lang file
	if (! is_file($fso)) $fso = self::find($fso, $snip);
	return self::gcFil($fso);
}
public static function gcFil($ful) { // get content
	$blk = ENV::get("blockme"); if ($blk) return "";
	$ful = self::file($ful);
	return self::getBlock($ful);
}

public static function gcBody($ful) {
	$blk = ENV::get("blockme"); if ($blk) return "";
	$out = self::gc($ful); if ($out !== NV) return $out;
	$fil = APP::file("core/modules/sitemap.php");
	return self::getBlock($fil);
}

public static function gcRec($dir, $snip = "banner", $revert = false) { // get content recursively
	$arr = FSO::parents($dir); if (! $arr) return "";
	$out = ""; if ($revert) rsort($arr);

	foreach ($arr as $dir) {
		$out.= self::gc($dir, $snip);
		$blk = ENV::get("blockme");	if ($blk) return $out;
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
	$mod = is_file($file);
	return self::write($file, $data, true, $mod);
}

public static function write($file, $data, $overwrite = true, $append = false) {
	if (is_dir($file)) return false;
	if (is_file($file)) if (! $overwrite) return false;

	$xxx = FSO::backup($file);
	$dir = FSO::force(dirname($file));
	$txt = VEC::xform($data);
	$txt = trim($txt)."\n";

	if ($append) {
		$txt = "\n".trim($txt);
		$erg = file_put_contents($file, $txt, FILE_APPEND);
	}
	else {
		$erg = file_put_contents($file, $txt);
	}
	FSO::permit($file);
	return ($erg !== false);
}

public static function writeTell($file, $content, $overwrite = true) {
	$fil = APP::relPath($file);

	if (! $overwrite)
	if (is_file($file)) return MSG::add("file.exists", $fil);

	$erg = self::write($file, $content); if ($erg !== false) return true;
	return ERR::msg("no.write", $fil);
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

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
