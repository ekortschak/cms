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
	public static $cnt = 0;

	private static $fbk = array();
	private static $rvs = array();

public static function init() {
	$pfd = get_include_path();
	$arr = STR::split($pfd, PATH_SEPARATOR);
	$arr = preg_filter('/$/', "/", $arr);

	foreach ($arr as $dir) {
		APP::addPath($dir);
	}
}

// ***********************************************************
// app dirs or files
// ***********************************************************
public static function addPath($dir) {
	if (! $dir) return;
	$pfd = get_include_path(); if (STR::contains($pfd, $dir)) return;
	$xxx = set_include_path($pfd.PATH_SEPARATOR.$dir);

	APP::$fbk[$dir] = $dir;
}

public static function inc($dir, $file) {
	$dir = APP::relPath($dir);
	appInclude("$dir/$file");
}

public static function incFile($dir, $file) {
	$fil = FSO::join($dir, $file);
	$fil = APP::relPath($fil);
	return appFile($fil);
}

// ***********************************************************
public static function prjFile($dir, $file = "") {
	return APP::findFile(APP_DIR, $dir, $file);
}
public static function fbkFile($dir, $file = "") {
	return APP::findFile(APP_FBK, $dir, $file);
}

public static function findFile($rep, $dir, $file = "") {
	$dir = APP::relPath($dir);
	$out = FSO::join($rep, $dir, $file);
	return rtrim($out, DIR_SEP);
}

// ***********************************************************
// reducing paths to "local" paths
// ***********************************************************
public static function relPath($fso) {
	$fso = CFG::apply($fso);
	$fso = FSO::norm($fso);

	foreach (APP::$fbk as $dir) {
		if ( ! STR::contains($fso, $dir)) continue;
		return STR::after($fso, $dir);
	}
	return $fso;
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

	foreach (APP::$fbk as $loc) { // add files from app and fbk folders
		$ful = FSO::join($loc, $dir); if (! is_dir($ful)) continue;
		$arr = FSO::files($ful, $pattern);
		APP::addFso($arr, $out);
	}
	return $out;
}

// ***********************************************************
private static function addFso($arr, &$out) {
	foreach ($arr as $fso => $nam) { // APP_DIR to prevail over APP_FBK and others
		$fso = APP::relPath($fso); if (isset($out[$fso])) continue;
		$out[$fso] = $nam;
	}
}

// ***********************************************************
// single fs objects by priority
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
	if ($file == null)     return false;
	if (is_file($file))    return $file;
	if (FSO::isUrl($file)) return $file;

	$fil = APP::relPath($file);

	foreach (APP::$fbk as $loc) {
		$ful = FSO::join($loc, $fil); if (is_file($ful)) return $ful;
	}
	return false;
}

public static function layout($name) {
	$arr = array(LAYOUT => LAYOUT, "default" => "default");

	foreach ($arr as $lyt) {
		$fil = FSO::join(LOC_LAY, $lyt, "$name.tpl");
		$fil = APP::file($fil); if ($fil) return $fil;
	}
	return false;
}

public static function url($file) {
	$fil = APP::file($file);
	$fil = STR::replace($fil, APP_FBK, CMS_URL);
	return STR::clear($fil, DOC_ROOT);
}

// ***********************************************************
public static function firstDir($dir) {
	$arr = APP::folders($dir);
	return array_key_first($arr);
}

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

	$ful = APP::find($fso, $snip); if (! $ful) return "";
	return APP::gcFile($ful);
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
	$out = APP::gcSys($fso); if (! $out) // usually body/include.php
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
	return APP::writeFile($file, $data, FILE_APPEND);
}

public static function write($file, $data, $overwrite = true) {
	if (! $overwrite) if (is_file($file)) return false;
	return APP::writeFile($file, $data, false);
}

private static function writeFile($file, $data, $overwrite = false) {
	if (is_dir($file)) return false;

	$dir = FSO::force(dirname($file));
	$txt = VEC::xform($data);
	$txt = trim($txt)."\n";

	return FSO::write($file, $txt);
}

public static function writeTell($file, $content, $overwrite = true) {
	if (is_file($file)) if (! $overwrite) return MSG::add("file.exists", $fil);
	if (APP::write($file, $content) !== false) return true;
	return ERR::msg("no.write", $file);
}

// ***********************************************************
// other
// ***********************************************************
public static function lookup($txt) {
	if (VMODE != "view")      return $txt;
	if (! ENV::get("lookup")) return $txt;

	switch (VMODE) {
		case "view": case "xfer": break;
		default: return $txt;
	}
	$cls = CFG::iniVal("classes:route.lookup", "lookup"); if (! $cls) return $txt;

	incCls("search/$cls.php");

	$lup = new $cls();
	$txt = $lup->insert($txt);
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
