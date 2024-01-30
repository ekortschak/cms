<?php
/* ***********************************************************
// INFO
// ***********************************************************
methods used for binding books
*/

incCls("menus/tabs.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class PRN {
	public static $nts = array(); // list of footnotes

	private static $hst = array(); // list of already handled menu items
	private static $inf = array(); // menu item info
	private static $skp = "";      // skip printing
	private static $pgs = 1;       // printed pages

	private static $loc = "";

public static function reset() {
	PRN::$hst = array(); PRN::$skp = "";
	PRN::$nts = array(); PRN::$pgs = 1;
}

public static function load($dir) {
	PRN::$loc = $dir;
	PRN::$inf = PFS::item($dir);
	PRN::$hst[$dir] = 1;
}

// ***********************************************************
// methods for printing (xsite)
// ***********************************************************
public static function title() {
	return PRN::$inf["chap"];
}

public static function content() {
	return APP::gcSys(PRN::$loc);
}

public static function level() {
	return PRN::$inf["level"];
}

// ***********************************************************
// handling standard pics
// ***********************************************************
public static function pic() {
	$pic = FSO::join(PRN::$loc, "pic.png"); if (! is_file($pic)) return "";
	return APP::url($pic);
}

// ***********************************************************
// handling footnotes
// ***********************************************************
public static function notes() {
	return PRN::$nts;
}

public static function note($key) {
	return VEC::get(PRN::$nts, $key);
}

public static function noteAdd($key, $value) {
	PRN::$nts[$key] = $value;
	return count(PRN::$nts);
}

// ***********************************************************
// specials
// ***********************************************************
public static function pbreak() {
	$cnt = PRN::$pgs++; if ($cnt < 1) return ; // never on first page
	return PGE::get(CUR_LANG.".pbreak");
}

public static function skip() {
	if (PGE::get("props.noprint")) {
		PRN::$skp = PRN::$loc;
		return true;
	}
	if (PRN::$skp) { // skip subfolders as well
		if (STR::begins(PRN::$loc, PRN::$skp)) return true;
	}
	PRN::$skp = "";
	return false;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
