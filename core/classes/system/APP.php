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
	$arr = STR::slice($pfd, PATH_SEPARATOR);
	$arr = preg_filter('/$/', "/", $arr);

	APP::$fbk = $arr;
}

// ***********************************************************
// reducing paths to "local" paths
// ***********************************************************
public static function relPath($fso) {
	$fso = CFG::apply($fso);
	$fso = FSO::norm($fso);

	foreach (APP::$fbk as $dir) {
		$out = STR::after($fso, $dir); if ($out) return $out;
	}
	$out = STR::after($fso, SRV_ROOT); if ($out) return $out;
	return $fso;
}

private static function getFBK($reverse = false) {
	$out = APP::$fbk; if ($reverse)
	$out = VEC::sort($out, "krsort"); // FBK first
	return $out;
}

// ***********************************************************
// app dirs or files
// ***********************************************************
public static function getInc($dir, $file) {
	$inc = FSO::join($dir, $file);
	return APP::relPath($inc);
}

// ***********************************************************
// fs object lists
// ***********************************************************
public static function folders($dir) {
	$dir = APP::relPath($dir); $out = array();

	foreach (APP::$fbk as $loc) { // add dirs from app and fbk folders
		$ful = FSO::join($loc, $dir);
		$arr = FSO::folders($ful);
		APP::addFso($arr, $out);
	}
	return $out;
}

public static function files($dir, $pattern = "*") {
	$dir = APP::relPath($dir); $out = array();
	$ext = STR::slice($pattern, ",");

	foreach (APP::$fbk as $loc) { // add files from app and fbk folders
		foreach ($ext as $ptn) {
			$ful = FSO::join($loc, $dir);
			$arr = FSO::files($ful, $ptn);
			APP::addFso($arr, $out);
		}
	}
	return $out;
}

// ***********************************************************
private static function addFso($arr, &$out) {
	foreach ($arr as $fso => $nam) { // APP_DIR to prevail over APP_FBK
		$fso = APP::relPath($fso); if (isset($out[$fso])) continue;
		$out[$fso] = $nam;
	}
}

// ***********************************************************
// single fs objects
// ***********************************************************
public static function dir($dir) { // find dir in extended fs
	if (is_dir($dir)) return $dir; $dir = APP::relPath($dir);
	if (! $dir) return false;

	foreach (APP::$fbk as $loc) {
		$ful = FSO::join($loc, $dir); if (is_dir($ful)) return $ful;
	}
	return false;
}

public static function file($file) { // find file in extended fs
	if (FSO::isUrl($file)) return $file;
	if (is_file($file))    return $file;

	$fil = APP::relPath($file);

	foreach (APP::$fbk as $loc) {
		$ful = FSO::join($loc, $fil); if (is_file($ful)) return $ful;
	}
	return false;
}

public static function url($fso) {
	$ful = APP::file($fso);
	$ful = STR::clear($ful, APP_DIR);
	$ful = STR::replace($ful, APP_FBK, CMS_URL);
	$ful = STR::clear($ful, SRV_ROOT);
	return $ful;
}

// ***********************************************************
public static function find($dir, $snip = "page", $fext = "php, htm, html") {
	$fil = APP::file($dir); if ($fil) return $fil;

	$lgs = LNG::getRel(); // find language relevant content
	$ext = STR::toArray($fext);

	if (STR::contains($dir, "/$snip.")) $dir = basename($dir);

	foreach ($lgs as $lng) {
		foreach ($ext as $ptn) {
			$ful = APP::file("$dir/$snip.$lng.$ptn");
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

	$ful = APP::find($fso, $snip);
	return APP::gcFile($ful);;
}

public static function gcRec($dir, $snip) { // get content recursively
	$arr = FSO::parents($dir); if (! $arr) return "";
	$out = ""; if ($snip == "trailer") rsort($arr);

	foreach ($arr as $dir) {
		$out.= APP::gcSys($dir, $snip);
	}
	return $out;
}

// ***********************************************************
// retrieving non system content
// ***********************************************************
public static function gcMap($fso) {
	$out = APP::gcSys($fso); if ($out === NV) // usually body/include.php
	$out = APP::gcFile("LOC_MOD/sitemap.php");
	return $out;
}

// ***********************************************************
public static function gcFile($fil) {
	$ful = APP::file($fil); if (! $ful) return "";

	$xxx = ob_start(); include $ful;
	return ob_get_clean();
}

// ***********************************************************
// file ops
// ***********************************************************
public static function read($file) { // read any text
	$ful = APP::file($file); if (! $ful) return "";
	return file_get_contents($ful);
}

public static function append($file, $data) {
	return APP::writeFile($file, $data, FILE_selfEND);
}

public static function write($file, $data, $overwrite = true) {
	if (is_file($file)) if (! $overwrite) return false;
	return APP::writeFile($file, $data, false);
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
	$erg = APP::write($file, $content); if ($erg !== false) return true;
	return ERR::msg("no.write", $file);
}

// ***********************************************************
// other
// ***********************************************************
public static function lookup($txt) {
	if (APP_CALL != "index.php") return $txt;
	if (! ENV::get("lookup"))    return $txt;

	switch (VMODE) {
		case "view": case "xfer": break;
		default: return $txt;
	}
	$cls = CFG::getVal("classes:route.lookup", "lookup"); if (! $cls) return $txt;

	incCls("search/$cls.php");

	$lup = new $cls();
	$txt = $lup->insert($txt);
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
