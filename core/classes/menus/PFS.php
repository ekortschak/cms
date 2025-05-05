<?php
/* ***********************************************************
// INFO
// ***********************************************************
picks up all infos available on pages in a website
i.e. tree from fs and ini file information

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menues/PFS.php");

PFS::read();

$arr = PFS::tree($dir);	    // list of dirs including $dir
$arr = PFS::items($dir);	// list of subdirs excludint $dir
$inf = PFS::item($index);
$dat = PFS::data($index);
*/

incCls("files/redirector.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class PFS {
	private static $dat = array();  // menu items & props
	private static $idx = array();  // menu index list
	private static $vrz = array();  // menu dirs list
	private static $vdr = array();  // list of virtual dirs
	private static $num = array();  // chapter numbers

	private static $dir = "";       // current topic
	private static $fil = "";       // name of static menu file
	private static $cnt = 0;        // menu items count
	private static $syn = 1;        // menu items with identical uids

	private static $max = 9;        // max. toc depth

public static function init($dir = TAB_HOME) {
	PFS::$dir = $dir; // set root dir
	PFS::$fil = FSO::join("static", $dir, "pfs.stat");
	PFS::$num = array_pad(PFS::$num, 10, 0);

	if (! PFS::recall()) {
		PFS::read($dir); $tpc = TAB_HOME;

		SSV::set("$tpc.data", PFS::data(), "pfs");
		SSV::set("$tpc.reload", 0, "pfs");
	}
 // set current page
	$uid = ENV::getPage();

	switch (ENV::getParm("pfs.nav")) {
		case "prev": $uid = PFS::findNext($uid, -1); break;
		case "next": $uid = PFS::findNext($uid, +1); break;
		default:     $uid = PFS::findGood($uid);
	}
	ENV::setPage($uid);
	ENV::set("pfs.clang", CUR_LANG);
	ENV::set("pfs.vmode", VMODE);
}

// ***********************************************************
// reading fs tree - ini files
// ***********************************************************
public static function read($dir = NV) {
	if (PFS::import()) return;
	if ($dir === NV) $dir = PFS::$dir;

	$ofs = FSO::level(APP::relPath($dir));

	PFS::append($dir, $dir);
	PFS::readDir($dir, $dir, $ofs);
}

private static function readDir($top, $vir, $ofs) {
 // $vir = virtual path to redirected pages
	$top = APP::dir($top); $col = "";
 	$drs = FSO::dTree($top, ! IS_LOCAL);

	$red = new redirector($top, $ofs);

	foreach ($drs as $dir => $nam) {
		$arr = $red->load($dir, $vir); extract($arr);

		PFS::append($dir, $vdir, $level, $iscol); if ($type == "red")
		PFS::readDir($target, $vdir, $ofs);
	}
}

public static function count() {
	return PFS::$cnt;
}

// ***********************************************************
// reading & handling properties
// ***********************************************************
private static function append($dir, $vdr, $lev = 0, $col = false) { // single page info
	$ini = new ini($dir);
	$uid = $ini->UID(); $uid = PFS::uniq($uid);
	$trg = $ini->target(); $cnt = PFS::$cnt++;
	$typ = $ini->type();
	$hed = $ini->head();

	PFS::set($uid, "uid",   $uid);
	PFS::set($uid, "fpath", $dir);
	PFS::set($uid, "head",  $hed);
	PFS::set($uid, "title", $ini->title());
	PFS::set($uid, "dtype", $typ);

	PFS::set($uid, "vpath", $vdr);
	PFS::set($uid, "level", $lev);
	PFS::set($uid, "iscol", $col);

	PFS::set($uid, "mtype", PFS::mnuType($dir, $typ, $trg));
	PFS::set($uid, "state", PFS::mnuState($uid));

	$num = PFS::chapNum($lev);
	$sym = PFS::chapSym($num, $lev, $col);

	PFS::set($uid, "chnum", $num);
	PFS::set($uid, "chsym", $sym);
	PFS::set($uid, "chap",  trim("$sym $hed"));

	PFS::$idx[$cnt] = $uid;
	PFS::$vrz[$dir] = $uid; if ($trg)
	PFS::$vdr[$trg] = $uid;
}

// ***********************************************************
// retrieving data
// ***********************************************************
private static function recall() {
	if (0) {
		MSG::add("PFS::recall() is disabled!");
		return false;
	}
	if (ENV::getParm("reset")) return false;
	if (ENV::get("pfs.clang") != CUR_LANG) return false;
	if (ENV::get("pfs.vmode") != "view")   return false;
	if (! APP::isView()) return false;

	$tpc = TAB_HOME;
	$chk = SSV::get("$tpc.reload", false, "pfs"); if (  $chk) return false;
	$arr = SSV::get("$tpc.data",   false, "pfs"); if (! $arr) return false;

	PFS::$dat = $arr["dat"];
	PFS::$idx = $arr["idx"];
	PFS::$vrz = $arr["vrz"];
	PFS::$vdr = $arr["vdr"];

	PFS::$cnt = count(PFS::$idx);
	return true;
}

// ***********************************************************
public static function data($what = "*") {
	$out = array(
		"dat" => PFS::$dat,
		"idx" => PFS::$idx,
		"vrz" => PFS::$vrz,
		"vdr" => PFS::$vdr
	);
	if (isset($out[$what])) return $out[$what];
	return $out;
}

// ***********************************************************
// retrieving info
// ***********************************************************
public static function find($key = NV) { // dir, uid or num index expected !
	if ($key === NV) $key = ENV::getPage(); // will always return uid
	if ($key === false) return false;

	if (is_numeric($key)) {
		$uid = VEC::get(PFS::$idx, $key);
		if ($uid) return $uid;
	}
	$uid = VEC::get(PFS::$dat, $key); if ($uid) return $key;
	$uid = VEC::get(PFS::$vrz, $key); if ($uid) return $uid;
	$key = STR::after($key, DOM_DIR);
	return VEC::get(PFS::$vdr, $key);
}

private static function findIndex($uid) {
	$arr = array_flip(PFS::$idx);
	return VEC::get($arr, $uid);
}

private static function findNext($uid, $inc) {
	$key = PFS::findIndex($uid);
	$max = PFS::$cnt - 1;

	while (true) {
		$idx = $key + $inc; if ($idx > $max) break; if ($idx < 0) break;
		$uid = VEC::get(PFS::$idx, $idx);
		if ( ! PFS::get($uid, "iscol")) break;
	}
	return $uid;
}

private static function findGood($uid) { // in case a dir has been deleted
	$dir = PFS::get($uid, "fpath"); if (strlen($dir) > 3) return $uid;
	$dir = ENV::get("pfs.last");

	while ($dir = dirname($dir)) { // find closest parent
		if ($dir <= TAB_HOME) break; // no access outside tab path
		if (is_dir($dir)) return PFS::find($dir);
	}
	return PFS::find(TAB_HOME);
}

private static function findLast() { // find last valid UID
	$uid = ENV::get("pfs.last");
	return PFS::get($uid, "fpath");
}

// ***********************************************************
// handling properties
// ***********************************************************
private static function set($uid, $key, $value) {
	PFS::$dat[$uid][$key] = $value;
}

public static function get($index, $key, $default = false) {
	$uid = PFS::find($index);
	if (! isset(PFS::$dat[$uid][$key])) return $default;
	return PFS::$dat[$uid][$key];
}

// ***********************************************************
private static function props($uid) {
	return VEC::get(PFS::$dat, $uid, array());
}

public static function pic($dir = false) {
	if (! $dir) $dir = PGE::dir();

	$pic = FSO::files($dir, "pic.*"); $pic = key($pic);
	$pic = APP::url($pic); if (! $pic) return;

	switch (VMODE) {
		case "ebook": HTW::thumbR($pic); break;
		default:      HTW::img($pic);
	}
}

// ***********************************************************
// chapter numbering
// ***********************************************************
private static function chapNum($lev) {
	$cur = $lev - 1; // array index starts at 0!

	PFS::$num[$cur]++;
	PFS::$num[$lev] = 0;

	$out = implode(".", PFS::$num);
	return STR::before("$out.0.", ".0.");
}

private static function chapSym($cap, $lev, $col) {
	if ($col == 2) {
		$out = end(explode(".", $cap)) + 96;
		return chr($out).")";
	}
	if ($lev <  1) return "";
	if ($lev == 6) return "&bull;";
	if ($lev == 7) return "&#9702;";
	if ($lev == 8) return "§";
	if ($lev == 9) return "+";
	if ($lev  > 9) return "-";

	return $cap;
}

// ***********************************************************
// menu subtrees
// ***********************************************************
public static function tree($dir = false) { // return $dir and subdirs
	if (! $dir) $dir = PFS::$dir;
	
	$out = array(); $max = PFS::$cnt; $cnt = $top = 0;

	for ($i = 0; $i < $max; $i++) {
		$inf = PFS::item($i); if (! $inf) continue;

		$loc = $inf["vpath"]; if (! STR::begins($loc, $dir)) continue;
		$cur = $inf["fpath"]; if (PFS::isHidden($cur)) continue;
		$lev = $inf["level"]; if ($cnt < 1) $top = $lev;
		$xxx = $inf["level"] = $lev - $top + 1;
		$out[] = $inf;

		$cnt++;
	}
	return $out;
}

public static function items($dir = false) { // return subdirs of $dir
	if (! $dir) $dir = PGE::$dir;

	$out = PFS::tree($dir);
	array_shift($out);
	return $out;
}

// ***********************************************************
// menu node info
// ***********************************************************
public static function item($index = NV, $depth = 9) {
	$uid = PFS::find($index);
	$out = PFS::props($uid); if (! $out) return array();
	$dep = CHK::range($depth, 2, $depth);

	$lev = $out["level"]; if ($lev > $dep) return array();
	return $out;
}

// ***********************************************************
private static function mnuType($dir, $typ, $trg = false) {
	if ($typ == "col") {
		if (APP::isView()) return "file";
		return "menu";
	}
	if ($typ == "red") { // TODO: may there be other suits than inc?
		return PFS::mnuType($trg, "inc");
	}
	$fld = (bool) APP::dirs($dir, ! IS_LOCAL);
	$fil = (bool) APP::snip($dir);

	if ($fld && $fil) return "both";
	if ($fld) return "menu";
	return "file";
}

// ***********************************************************
private static function mnuState($dir) {
	if (PFS::isHidden($dir)) return "inactive";
	return "active";
}

// ***********************************************************
// handling static menues
// ***********************************************************
public static function isStatic() {
	return is_file(PFS::$fil);
}

public static function toggle() {
	if (PFS::isStatic()) return FSO::kill(PFS::$fil);
	PFS::export();
}

// ***********************************************************
private static function export() { // write menu info to stat file
	$fil = PFS::$fil;

	APP::write ($fil, "<?php");
	APP::append($fil, "PFS::\$dat = ".var_export(PFS::$dat, true).";");
	APP::append($fil, "PFS::\$idx = ".var_export(PFS::$idx, true).";");
	APP::append($fil, "PFS::\$vrz = ".var_export(PFS::$vrz, true).";");
	APP::append($fil, "?>");
}

private static function import() {
	if (! APP::isView())   return false;
	if (! PFS::isStatic()) return false;

	include_once PFS::$fil; // read menu info from stat file
	PFS::$cnt = count(PFS::$dat);
	return PFS::$cnt;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function uniq($uid, $pfx = "") {
	if ($pfx) $uid = "$pfx.$uid";
	$chk = VEC::get(PFS::$dat, $uid); if (! $chk) return $uid;
	$syn = PFS::$syn++;
	return PFS::uniq("§$uid.$syn");
}

private static function isHidden($dir) {
	if (APP::isView()) 
	return FSO::isHidden($dir);
	return false;
}

// ***********************************************************
// debugging
// ***********************************************************
private static function dump() {
	$arr = PFS::data("dat"); if (! $arr) return;
	echo "<pre>";
	DBG::text($arr, "pfs");
	echo "</pre>";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
