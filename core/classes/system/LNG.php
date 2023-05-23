<?php
/* ***********************************************************
// INFO
// ***********************************************************
Just "save as" ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/LNG.php");

$fls = LNG::files();
$lgs = LNG::get();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class LNG {

// ***********************************************************
// methods
// ***********************************************************
public static function get($lang = CUR_LANG) {
	return self::getArr("$lang.".LANGUAGES);
}

public static function getGen($lang = CUR_LANG) {
	return self::getArr("$lang.".CUR_LANG.".".GEN_LANG);
}

public static function getOthers() {
	$out = self::get(); unset($arr[CUR_LANG]);
	return $out;
}

public static function getRel($blank = false) {
	return self::getArr(CUR_LANG.".xx.".GEN_LANG);
}
// ***********************************************************
public static function isCurrent($file) {
	$fil = basename($file); $lng = CUR_LANG;

	if (STR::contains(".$fil", ".$lng.")) return true;
	if (STR::contains(".$fil", ".xx."))   return true;
	return false;
}

// ***********************************************************
public static function find($lang) {
	$lgs = LANGUAGES; if (! $lang) return GEN_LANG;
	if (STR::contains(".$lgs.", ".$lang.")) return $lang;
	return GEN_LANG;
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

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
