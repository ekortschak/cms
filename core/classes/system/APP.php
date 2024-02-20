<?php
/* ***********************************************************
// INFO
// ***********************************************************
- contains application specific methods

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/APP.php");

$drs = APP::dirs($dir);
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
		APP::$fbk[$dir] = $dir;
	}
}

// ***********************************************************
// app dirs or files
// ***********************************************************
public static function addPath($dir) {
	if (! $dir) return;
	if (isset(APP::$fbk[$dir])) return;

	$pfd = get_include_path();
	$xxx = set_include_path($pfd.PATH_SEPARATOR.$dir);

	APP::$fbk[$dir] = $dir;
}

public static function inc($dir, $file) {
	$fil = FSO::join($dir, $file);
	$fil = APP::file($fil); if (! $fil) return;
	include $fil;
}

public static function mod($mod) {
	$inc = FSO::join(LOC_MOD, $mod, "main.php");
	$inc = APP::file($inc);
	if ($inc) return include $inc;

	$inc = FSO::join(LOC_MOD, "$mod.php");
	$inc = APP::file($inc);
	if ($inc) include $inc;
}

// ***********************************************************
public static function prjFile($dir, $file = "") {
	return APP::join(APP_DIR, $dir, $file);
}
public static function fbkFile($dir, $file = "") {
	return APP::join(FBK_DIR, $dir, $file);
}

private static function join($rep, $dir, $file = "") {
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
		if (STR::misses($fso, $dir)) continue;
		return STR::after($fso, $dir);
	}
	return $fso;
}

// ***********************************************************
// fs object lists
// ***********************************************************
public static function parents($dir) {
	if (  is_file($dir)) $dir = dirname($dir);
	if (! is_dir ($dir)) $dir = APP::dir($dir);
	if (! is_dir ($dir)) return array();

	$dir = APP::relPath($dir);
	$out[] = $dir;

	while ($dir = dirname($dir)) {
		if ($dir == "/") break; // no access outside app path
		if ($dir == ".") break; // no access outside app path
		$out[] = $dir;
	}
	sort($out);
	return $out;
}

public static function dirs($dir) {
	$dir = APP::relPath($dir); $out = array();

	foreach (APP::$fbk as $loc) { // add dirs from app and fbk folders
		$ful = FSO::join($loc, $dir);
		$arr = FSO::dirs($ful);
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
	if (! $arr) return;

	foreach ($arr as $fso => $nam) { // APP_DIR to prevail over FBK_DIR and others
		$fso = APP::relPath($fso); if (isset($out[$fso])) continue;
		$out[$fso] = $nam;
	}
}

// ***********************************************************
// tree listings
// ***********************************************************
public static function dTree($dir, $visOnly = true) {
 // list all subfolders of $dir, including symbolic links
	$out = $arr = APP::dirs($dir, $visOnly); if (! $arr) return array();

	foreach ($arr as $dir => $nam) {
		$lst = APP::dTree($dir, $visOnly); if ($lst)
		$out = array_merge($out, $lst);
	}
	return VEC::sort($out);
}

// ***********************************************************
// single fs objects by priority
// ***********************************************************
public static function dir($dir) { // find dir in extended fs
	if (is_dir($dir)) return $dir;
	$dir = APP::relPath($dir); if (! $dir) return false;

	foreach (APP::$fbk as $loc) {
		$ful = FSO::join($loc, $dir); if (is_dir($ful)) return $ful;
	}
	return false;
}

public static function file($file) { // find file in extended fs
	if (is_file($file)) return $file; $fil = APP::relPath($file);

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

// ***********************************************************
public static function url($fso) {
	if (FSO::isUrl($fso)) return $fso;

	$out = APP::file($fso); if (! $out)
	$out = APP::dir($fso);  if (! $out) return $fso;

	if (STR::begins($out, APP_DIR)) return STR::after(  $out, APP_DIR.DIR_SEP);
	if (STR::begins($out, FBK_DIR)) return STR::replace($out, FBK_DIR, CMS_URL);
	return STR::clear($out, TOP_DIR);
}

public static function link($trg) { // convert file to request uri
	$dir = APP::dir($trg);
	$hme = APP::home($dir, "tab.ini");
	$idx = APP::home($dir, "index.php");
	$uid = PGE::UID($dir);

	$hme = STR::after($hme, $idx.DIR_SEP);
	$idx = STR::after($idx, TOP_DIR);

	return "$idx?tpc=$hme&pge=$uid";
}

public static function home($dir, $file) { // get TAB_HOME
	$arr = FSO::parents($dir);

	foreach ($arr as $itm) {
		$fil = FSO::join($itm, $file);
		if (is_file($fil)) return $itm;
	}
	return "???";
}

// ***********************************************************
public static function snip($dir, $snip = "page", $fext = "php, htm, html") {
	$lgs = LNG::getRel(); // find language relevant content
	$ext = STR::toArray($fext);

	foreach ($lgs as $lng) {
		foreach ($ext as $ptn) {
			$fil = FSO::join($dir, "$snip.$lng.$ptn");
			$ful = APP::file($fil);
			if (is_file($ful)) return $ful;
		}
	}
	return false;
}

// ***********************************************************
// retrieving system content
// ***********************************************************
public static function gcRec($dir, $snip) { // show banner/trailer
	$arr = APP::parents($dir); if (! $arr) return "";
	$out = ""; if ($snip == "trailer") rsort($arr);

	foreach ($arr as $dir) {
		$out.= APP::gcSys($dir, $snip);
	}
	return $out;
}

public static function gcSys($fso, $snip = "page") { // show any part of page
	if (ENV::get("blockme")) return "";

	$ful = APP::snip($fso, $snip); if (! $ful) return "";
	return APP::gcFile($ful);
}

public static function gcMap($fso) { // show page or sitemap
	$out = APP::gcFile($fso); if (trim($out)) return $out;
	return APP::gcFile("LOC_MOD/sitemap.php");
}

// ***********************************************************
// retrieving any content
// ***********************************************************
public static function gcFile($fil) {
	$ful = APP::file($fil); if (! $ful) return "";

	$xxx = ob_start(); include $ful;
	$out = ob_get_clean();

	if (! PFS::isView()) return $out;
	return CFG::apply($out);
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
	if (! ENV::get("lookup")) return $txt;
	if (! PFS::isView())      return $txt;

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
