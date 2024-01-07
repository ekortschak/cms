<?php
/* ***********************************************************
// INFO
// ***********************************************************
Just "save as" ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/LNG.php");

$lgs = LNG::get();
$chk = LNG::isCurrent($lang);
$lng = LNG::find($lang);

*/

LNG::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class LNG {

public static function init() {
	$std = STR::before(LANGUAGES, ".");
	$lng = ENV::find("lang", $std);

	CFG::set("STD_LANG", $std);
	CFG::set("CUR_LANG", $lng);
}

// ***********************************************************
// retrieving correspondig files
// ***********************************************************
public static function file($file, $lang) {
	$cur = CUR_LANG;
	return STR::replace($file, ".$cur.", ".$lang.");
}

// ***********************************************************
// retrieving available languages
// ***********************************************************
public static function get($lang = CUR_LANG) {
	$lgs = LNG::join($lang, LANGUAGES);
	return LNG::getArr($lgs);
}
public static function getGen($lang = CUR_LANG) {
	$lgs = LNG::join($lang, CUR_LANG, GEN_LANG);
	return LNG::getArr($lgs);
}
public static function getOthers() {
	$lgs = LNG::get(); unset($lgs[CUR_LANG]);
	return $lgs;
}
public static function getRel($blank = false) {
	$lgs = LNG::join(CUR_LANG, "xx", GEN_LANG);
	return LNG::getArr($lgs);
}

// ***********************************************************
// verifying language
// ***********************************************************
public static function isLang($lang) {
	$lgs = LANGUAGES; if (! $lang) return false;
	return STR::features($lgs, $lang);
}

public static function find($lang) {
	if (LNG::isLang($lang)) return $lang;
	if ($lang == "xx") return CUR_LANG;
	return GEN_LANG;
}

// ***********************************************************
public static function isCurrent($file) {
	$fil = basename($file); $lng = CUR_LANG;

	if (STR::features($fil, $lng)) return true;
	if (STR::features($fil, "xx")) return true;
	return false;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function getArr($langs) {
	$lgs = explode(".", $langs);
	$out = array();

	foreach ($lgs as $lng) {
		if (! $lng) continue;
		$out[$lng] = $lng;
	}
	return $out;
}

private static function join() {
	$out = implode(".", func_get_args());
	return ".$out.";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
