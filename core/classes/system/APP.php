<?php
/* ***********************************************************
// INFO
// ***********************************************************
- contains application specific methods

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/APP.php");

$drs = APP::folders($dir);
$fls = APP::files($dir, "*.ext");

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
	$out = self::$fbk; if ($reverse)
	$out = VEC::sort($out, "krsort"); // FBK first
	return $out;
}

// ***********************************************************
// app dirs or files
// ***********************************************************
public static function tempDir($dir = "temp", $sub = "") { // always local dirs
	return self::arcDir(ARCHIVE, $dir, $sub);
}

public static function arcDir($root, $dir, $sub = "") { // archive
	return FSO::join($root, "cms.archive", APP_NAME, $dir, $sub);
}

// ***********************************************************
public static function getInc($dir, $file) {
	$inc = FSO::join($dir, $file);
	return self::relPath($inc);
}

// ***********************************************************
// fs object lists
// ***********************************************************
public static function folders($dir) {
	$dir = self::relPath($dir); $out = array();

	foreach (self::$fbk as $loc) { // add dirs from app and fbk folders
		$ful = FSO::join($loc, $dir);
		$arr = FSO::folders($ful);
		self::addFso($arr, $out);
	}
	return $out;
}

public static function files($dir, $pattern = "*") {
	$dir = self::relPath($dir); $out = array();
	$ext = VEC::explode($pattern, ",");

	foreach (self::$fbk as $loc) { // add files from app and fbk folders
		foreach ($ext as $ptn) {
			$ful = FSO::join($loc, $dir);
			$arr = FSO::files($ful, $ptn);
			self::addFso($arr, $out);
		}
	}
	return $out;
}

// ***********************************************************
private static function addFso($arr, &$out) {
	foreach ($arr as $fso => $nam) { // APP_DIR to prevail over APP_FBK
		$fso = self::relPath($fso); if (isset($out[$fso])) continue;
		$out[$fso] = $nam;
	}
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

public static function file($file) { // find file in extended fs
	if (FSO::isUrl($file)) return $file;
	if (is_file($file))    return $file;

	$fil = self::relPath($file);

	foreach (self::$fbk as $loc) {
		$ful = FSO::join($loc, $fil); if (is_file($ful)) return $ful;
	}
	return false;
}

// ***********************************************************
public static function find($dir, $snip = "page", $fext = "php, htm, html") {
	$fil = self::file($dir); if ($fil) return $fil;

	$lgs = LNG::getRel(); // find language relevant content
	$ext = STR::toArray($fext);

	if (STR::contains($dir, "/$snip.")) $dir = basename($dir);

	foreach ($lgs as $lng) {
		foreach ($ext as $ptn) {
			$ful = self::file("$dir/$snip.$lng.$ptn");
			if (is_file($ful)) return $ful;
		}
	}
	return false;
}

// ***********************************************************
// retrieving system content
// ***********************************************************
public static function gcSys($fso, $snip = "page") {
	if (ENV::get("blockme")) return "";

	$ful = self::find($fso, $snip);
	return self::gcFile($ful);;
}

public static function gcRec($dir, $snip) { // get content recursively
	$arr = FSO::parents($dir); if (! $arr) return "";
	$out = ""; if ($snip == "trailer") rsort($arr);

	foreach ($arr as $dir) {
		$out.= self::gcSys($dir, $snip);
	}
	return $out;
}

// ***********************************************************
// retrieving non system content
// ***********************************************************
public static function gcMap($fso) {
	$out = self::gcSys($fso); if ($out === NV) // usually body/include.php
	$out = self::gcFile("LOC_MOD/sitemap.php");
	return $out;
}

// ***********************************************************
public static function gcFile($fil) {
	$ful = self::file($fil); if (! $ful) return "";

	$xxx = ob_start(); include $ful;
	return ob_get_clean();
}

// ***********************************************************
// file ops
// ***********************************************************
public static function read($file) { // read any text
	$ful = self::file($file); if (! $ful) return "";
	$out = file_get_contents($ful);
	$out = STR::replace($out, "\r", "");
#	$out = STR::replace($out, "\n", "\r\n");
	return $out;
}

public static function append($file, $data) {
	return self::writeFile($file, $data, FILE_selfEND);
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
	if (VMODE    != "view")      return $txt;
	if (! ENV::get("lookup"))    return $txt;

	$cls = CFG::getVal("classes", "route.lookup", "lookup"); if (! $cls) return $txt;

	incCls("search/$cls.php");

	$lup = new $cls();
	$txt = $lup->insert($txt);
	return $txt;
}

public static function isView() {
	if (VMODE == "view")  return true;
	return false;
}

public static function lock($value = false) {
	ENV::set("blockme", $value);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
