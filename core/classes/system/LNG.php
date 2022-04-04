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
	$lgs = LANGUAGES;
	return self::getArr("$lang.$lgs");
}

public static function getAll() {
	$out = self::get();
	$out["xx"] = "xx";
	return $out;
}

public static function getRel($snip = true) {
	$out = array(
		CUR_LANG => CUR_LANG, "xx" => "xx",
		GEN_LANG => GEN_LANG
	);
	if ($snip) $out[""] = "";
	return $out;
}

// ***********************************************************
public static function isCurLang($file) {
	$fil = basename($file); $lng = CUR_LANG;

	if (STR::begins($fil, "$lng.")) return true;
	if (STR::begins($fil, "xx.")) return true;

	if (STR::contains($fil, ".$lng.")) return true;
	if (STR::contains($fil, ".xx.")) return true;
	return false;
}

// ***********************************************************
public static function find($lang) {
	$lgs = LANGUAGES;
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
