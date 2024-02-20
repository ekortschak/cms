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

$arr = PFS::items();
$inf = PFS::item($index);
$dat = PFS::data($index);
*/

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

	private static $red = 0;        // redirection level
	private static $max = 9;        // max. toc depth

public static function init($dir = TAB_HOME) {
	PFS::$dir = $dir;
	PFS::$cnt = PFS::$red = 0;
	PFS::$fil = FSO::join("static", $dir, "pfs.stat");
	PFS::$num = array_pad(PFS::$num, 10, 0);

	if (! PFS::recall()) {
		PFS::read($dir); $tpc = TAB_HOME;

		SSV::set("$tpc.data", PFS::data(), "pfs");
		SSV::set("$tpc.reload", 0, "pfs");
	}
	$uid = ENV::getPage();

	switch (ENV::getParm("pfs.nav")) {
		case "prev": $uid = PFS::findNext($uid, -1); break;
		case "next": $uid = PFS::findNext($uid, +1); break;
		default:     $dir = PFS::verify($uid); PGE::load($dir);
	}
	ENV::set("pfs.clang", CUR_LANG);
	ENV::set("pfs.vmode", VMODE);
	ENV::set("pfs.fpath", PGE::$dir);
}

// ***********************************************************
// reading fs tree - ini files
// ***********************************************************
public static function read($dir = NV) {
	if (PFS::import()) return;
	if ($dir === NV) $dir = PFS::$dir;

	PFS::readDir($dir, $dir, PFS::$red);
}

private static function readDir($top, $cur, $pfx = "", $ofs = 0) {
 // $cur = fs branch to virtually plug in to
	$top = APP::dir($top);
 	$drs = FSO::dTree($top, ! IS_LOCAL); $old = $pid = "¬";
	$fst = FSO::level($top);
	$col = false;

	foreach ($drs as $dir => $nam) {
		$ini = new ini($dir);
		$typ = $ini->getType();
		$trg = $ini->getReDir();

		$trl = STR::clear($dir, $top); // calc trailing elements
		$vdr = FSO::join($cur, $trl);  // calc virtual dir
		$lev = FSO::level($dir);

		PFS::append($ini, $pfx, $lev - $fst + $ofs, $vdr, $col, $trg);

		if ($typ === "col") $col = $vdr;
		if ($typ === "red") { // internal redirection
			$lvl = $lev - $fst - $ofs;

			PFS::readDir($trg, $vdr, PFS::$red++, $lvl);
		}
	}
}

// ***********************************************************
// reading & handling properties
// ***********************************************************
private static function append($ini, $pfx, $lev, $par, $col, $trg) { // single page info
	$uid = $ini->getUID(); $uid = PFS::uniq($uid);
	$dir = $ini->getDir(); $cnt = PFS::$cnt;

	PFS::setPropVal($uid, "uid",   $uid);
	PFS::setPropVal($uid, "fpath", $dir);
	PFS::setPropVal($uid, "head",  $ini->getHead());
	PFS::setPropVal($uid, "title", $ini->getTitle());
	PFS::setPropVal($uid, "dtype", $ini->getType());
	PFS::setPropVal($uid, "noprn", $ini->get("props.noprint"));

	PFS::setPropVal($uid, "redir", $trg);
	PFS::setPropVal($uid, "vpath", $par);
	PFS::setPropVal($uid, "level", $lev);
	PFS::setPropVal($uid, "index", $cnt);

	PFS::setPropVal($uid, "iscol", STR::begins($par, $col));
	PFS::setPropVal($uid, "chnum", PFS::chapNum($uid));
	PFS::setPropVal($uid, "sname", PFS::statID()); // for static output

	PFS::$idx[$cnt] = $uid; PFS::$cnt++;
	PFS::$vrz[$dir] = $uid; if ($trg)
	PFS::$vdr[$red] = $uid;

	return $uid;
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
	if (VMODE != "view") return false;

	$tpc = TAB_HOME;
	$chk = SSV::get("$tpc.reload", false, "pfs"); if (  $chk) return false;
	$arr = SSV::get("$tpc.data",   false, "pfs"); if (! $arr) return false;

	PFS::$dat = $arr["dat"];
	PFS::$idx = $arr["idx"];
	PFS::$vrz = $arr["vrz"];

	PFS::$cnt = count(PFS::$idx);
	return true;
}

// ***********************************************************
public static function data() {
	return array(
		"dat" => PFS::$dat,
		"idx" => PFS::$idx,
		"vrz" => PFS::$vrz
	);
}

// ***********************************************************
// retrieving info
// ***********************************************************
public static function level($dir, $ofs = 0) {
	$lev = FSO::level($dir);
	$out = $lev + $ofs;
	return CHK::range($out, 0, PFS::$max);
}

// ***********************************************************
public static function find($key = NV) { // dir, uid or num index expected !
	if ($key === NV) $key = PGE::$dir;   // will return uid
	if ($key === false) return false;

	if (is_numeric($key)) {
		$uid = VEC::get(PFS::$idx, $key);
		if ($uid) return $uid;
	}
	$idx = VEC::get(PFS::$dat, $key); if ($idx) return $key;
	$idx = VEC::get(PFS::$vrz, $key); if ($idx) return $idx;
	return VEC::get(PFS::$vdr, $key);
}

private static function findNext($uid, $inc) {
	$key = PFS::propVal($uid, "index", 0);

	do {
		$key = CHK::range($key + $inc, 0, PFS::$cnt - 1);
		$uid = VEC::get(PFS::$idx, $key);
		$col = PFS::propVal($uid, "iscol", false); if ($col) continue;
		$dir = PFS::propVal($uid, "fpath", TAB_HOME); break;
	} while(1);

	ENV::setPage($uid);
	PGE::load($dir);
}

private static function verify($uid) {
	$dir = PFS::get($uid, "fpath"); if (strlen($dir) > 3) return $dir;

	while ($dir = dirname($dir)) { // find closest parent
		if ($dir <= TAB_HOME) break; // no access outside tab path
		if (is_dir($dir)) return FSO::trim($dir);
	}
	return TAB_HOME;
}

// ***********************************************************
// handling properties
// ***********************************************************
public static function setProp($index, $key, $value) {
	$uid = PFS::find($index); if (! $uid) return;
	PFS::setPropVal($uid, $key, $value);
}
private static function setPropVal($uid, $key, $value) {
	PFS::$dat[$uid][$key] = $value;
}

// ***********************************************************
private static function props($index) {
	$uid = PFS::find($index); if (! $uid) return array();
	return VEC::get(PFS::$dat, $uid, array());
}

public static function get($index, $key, $default = false) {
	$uid = PFS::find($index);
	return PFS::propVal($uid, $key, $default);
}

private static function propVal($uid, $key, $default) {
	if (! isset(PFS::$dat[$uid][$key])) return $default;
	return PFS::$dat[$uid][$key];
}

// ***********************************************************
// chapter numbering
// ***********************************************************
private static function chapTitle($index) {
	$num = PFS::propVal($index, "chnum", "");
	$hed = PFS::propVal($index, "head", "???");
	return "$num $hed";
}

private static function chapNum($index) {
	$lev = PFS::propVal($index, "level", 1);

	if ($lev < 1) return "";
	if ($lev > 9) return "?.?";

	PFS::$num[$lev - 1]++;
	PFS::$num[$lev + 0] = 0;
	$out = implode(".", PFS::$num);

	return STR::before("$out.0.", ".0.");
}

// ***********************************************************
// menu subtrees
// ***********************************************************
public static function items($dir = false) {
	$out = array(); $max = PFS::$cnt; $cnt = $top = 0;

	for ($i = 0; $i < $max; $i++) { // skip root element
		$inf = PFS::item($i); if (! $inf) continue;
		$loc = $inf["vpath"];

		if ($dir) { // heed selected sub tree
			if (! STR::begins($loc, $dir)) continue;
		}
		if (PFS::isHidden($loc)) continue;
		if (PFS::noPrint($inf)) continue;

		$lev = $inf["level"]; if ($cnt < 1) $top = $lev;
		$xxx = $inf["level"] = $lev - $top + 1;
		$out[] = $inf;

		$cnt++;
	}
	return $out;
}

// ***********************************************************
public static function sibs($dir) {
	$idx = PFS::find($dir);
	$dir = PFS::propVal($idx, "vpath", false);
	$out = PFS::items($dir); if (! $out) return false;
	unset($out[0]);
	return $out;
}

// ***********************************************************
// menu node info
// ***********************************************************
public static function item($index = NV, $depth = 99) {
	$idx = PFS::find($index);
	$out = PFS::props($index); if (! $out) return array();
	$dep = CHK::range($depth, 2, 15);

	$lev = $out["level"]; if ($lev > $dep) return array();
	$dir = $out["fpath"];
	$trg = $out["redir"];
	$typ = $out["dtype"];

	$out["mtype"] = PFS::mnuType($dir, $typ, $trg);
	$out["state"] = PFS::mnuState($idx);
	$out["chap"]  = PFS::chapTitle($idx);
	return $out;
}

// ***********************************************************
private static function mnuType($dir, $typ, $trg = false) {
	if ($typ == "col") {
		if (PFS::isView()) return "file";
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
private static function mnuState($idx) {
	if (PFS::isHidden($idx)) return "inactive";
	return "active";
}

// ***********************************************************
// handling static menues
// ***********************************************************
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
	if (! PFS::isView())   return false;
	if (! PFS::isStatic()) return false;

	include_once PFS::$fil; // read menu info from stat file
	PFS::$cnt = count(PFS::$dat);
	return PFS::$cnt;
}

// ***********************************************************
private static function statID() {
	return sprintf("p%05d.htm", PFS::$cnt);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
public static function count() {
	return PFS::$cnt;
}

private static function uniq($uid, $pfx = "") {
	if ($pfx) $uid = "$pfx.$uid";
	$chk = VEC::get(PFS::$dat, $uid); if (! $chk) return $uid;
	$syn = PFS::$syn++;
	return PFS::uniq("§$uid.$syn");
}

// ***********************************************************
public static function isView() {
	if (TAB_SET == "config") return false;
	if (VMODE   == "view")   return true;
	if (VMODE   == "pres")   return true;
	if (VMODE   == "xfer")   return true;
	return false;
}
private static function isHidden($dir) {
	if ( ! PFS::isView()) return false;
	return FSO::isHidden($dir);
}
private static function noPrint($inf) {
	if (VMODE != "xsite") return false;
	return $inf["noprn"];
}
public static function isStatic() {
	return is_file(PFS::$fil);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
