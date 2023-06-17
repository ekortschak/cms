<?php
/* ***********************************************************
// INFO
// ***********************************************************
Just "save as" ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/DIC.php");

DIC::read($file);
DIC::set($key, $val, $lang);

$txt = DIC::get($key, $lang);
$txt = DIC::xlate($anyString, $lang);

*/

incCls("files/code.php");
DIC::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class DIC {
	private static $dat = array();

public static function init() {
	DIC::read(LOC_DIC);
}

// ***********************************************************
// read dic files
// ***********************************************************
public static function read($dir) {
	$cod = new code();

	foreach (LNG::get() as $lng) {
		$ptn = FSO::join($dir, $lng);
		$arr = APP::files($ptn, "*.dic");

		foreach ($arr as $fil => $nam) {
			$cod->read($fil); // will set $this->dat
		}
	}
}

// ***********************************************************
// setting items
// ***********************************************************
public static function append($arr, $lang) {
	$lng = LNG::find($lang);

	foreach ($arr as $key => $val) {
		DIC::set($key, $val, $lng);
	}
}

public static function set($key, $value, $lang = CUR_LANG) {
	DIC::$dat[$lang][$key] = $value;
}

// ***********************************************************
// retrieving items
// ***********************************************************
public static function get($key, $lang = CUR_LANG) {
	$old = $key;
	$key = STR::norm($key);         if (! $key) return $old;
	$out = DIC::find($key, $lang); if (  $out) return $out;
	return DIC::save($key, $old, $lang);
}

public static function getPfx($pfx, $key, $lang = CUR_LANG) {
	$key = STR::norm($key); if (! $key) return $key;

	$idx = $key; if (STR::misses($key, "."))
	$idx = STR::norm("$pfx.$key");
	$out = DIC::find($idx, $lang); if ($out) return $out;
	$out = DIC::find($key, $lang); if ($out) return $out;
	$xxx = DIC::save($idx, ucfirst($key), $lang);
	return "<i>$key</i>";
}

public static function getAll($key) {
	$lgs = LNG::get(); $out = array();

	foreach ($lgs as $lng) {
		$out[$lng] = DIC::get($key, $lng);
	}
	return $out;
}

// ***********************************************************
// translate strings
// ***********************************************************
public static function xlate($text, $lang = CUR_LANG) {
	$arr = STR::find($text, "<!DIC:", "!>"); if (! $arr) return $text;

	foreach ($arr as $key) {
		$repl = DIC::get($key, $lang);
		$text = str_replace("<!DIC:$key!>", $repl, $text);
	}
	return $text;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function find($key, $lng, $default = false) {
	$idx = STR::norm($key); if (! $idx) return $default;
	$lgs = LNG::getGen($lng);

	foreach ($lgs as $lng) {
		$arr = VEC::get(DIC::$dat, $lng); if (! $arr) continue;
		$out = VEC::get($arr, $idx); if ($out)
		return CFG::apply($out);
	}
	return $default;
}

// ***********************************************************
// auto-maintain dictionaries
// ***********************************************************
private static function save($key, $val, $lang) { // trace missing dic entries
return $key;

	if (! IS_LOCAL) return $key;
	if (STR::misses(".cms.gim.", APP_NAME)) return $key;

	if ($key != strip_tags($key)) return $key; // html code
	if ($key == strtoupper($key)) return $key; // constants
	if (STR::begins($key, "[")) return $key;   // section
	if (STR::contains($key, "@")) return $key; // email

	if (strlen($key) > 50) return $key; // text
	if (strlen($key) <  3) return $key;

	$mod = VMODE; if (STR::begins(TAB_HOME, "setup"))
	$mod = basename(TAB_HOME);

 	$fil = FSO::join(APP_FBK, LOC_DIC, $lang, "$mod.dic");
 	$txt = APP::read($fil);
 	$val = ucfirst($val);
 	$itm = "$key = $val*";

 	if (STR::contains($txt, "$key = ")) return $key;
	APP::append($fil, $itm);
	return "$key*";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
