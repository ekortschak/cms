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
			$cod->read($fil); // will set DIC::$dat
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
public static function get($key, $lang = CUR_LANG, $default = NV) {
	if ($default === NV) $default = $key;
	return DIC::find($key, $lang, $default);
}

private static function find($key, $lng, $default) {
	$lgs = LNG::getGen($lng); if (! $key) return $default;
	$dic = DIC::$dat;

	foreach ($lgs as $lng) {
		$arr = VEC::get($dic, $lng); if (! $arr) continue;
		$out = VEC::get($arr, $key); if ($out)
		return CFG::apply($out);
	}
	return $default;
}

public static function getPfx($pfx, $key, $lang = CUR_LANG) {
	$key = STR::norm($key); if (! $key) return $key;
	$idx = $key; if (STR::misses($key, "."))
	$idx = "$pfx.$key";

	$out = DIC::get($idx, $lang); if ($out) return $out;
	$out = DIC::get($key, $lang); if ($out) return $out;
	return "<i>$key</i>";
}

// ***********************************************************
// translate strings, e.g. in templates
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
} // END OF CLASS
// ***********************************************************
?>
