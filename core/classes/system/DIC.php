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
	self::read("design/dictionary");
}

// ***********************************************************
// read dic files
// ***********************************************************
public static function read($dir) {
	foreach (LNG::get() as $lng) {
		$ptn = FSO::join($dir, $lng, "*.dic");
		$arr = APP::files($ptn);

		if ($lng == "xx") $lng = GEN_LANG;
		if ($lng == "")   $lng = GEN_LANG;

		$cod = new code();

		foreach ($arr as $fil => $nam) {
			$cod->read($fil); // no merging needed
		}
	}
}

public static function reWrite() {
	$lng = CUR_LANG;
 	$ptn = FSO::join(APP_FBK, "design/dictionary", $lng, "*.dic");
	$fls = FSO::files($ptn);
	$sec = "[dic.$lng]";

 	foreach ($fls as $fil => $nam) {
		$txt = APP::read($fil);
		$arr = explode("\n", $txt); sort($arr);
		$out = array();

		foreach ($arr as $lin) {
			if (! STR::contains($lin, "=")) continue;
			if (STR::begins($lin, "prop.")) continue;
			if (STR::begins($lin, "btn."))  continue;
			$out[] = $lin;
		}
		$txt = "$sec\n".implode("\n", $out);
		$xxx = APP::write($fil, $txt);
	}
}

// ***********************************************************
// setting items
// ***********************************************************
public static function append($arr, $lang) {
	if (! $lang) $lang = GEN_LANG;

	foreach ($arr as $key => $val) {
		self::set($key, $val, $lang);
	}
}

public static function set($key, $value, $lang = CUR_LANG) {
	$lng = self::getLang($lang);
	$key = self::norm($key);
	$val = CFG::insert($value);

	self::$dat[$lng][$key] = $value;
}

// ***********************************************************
// retrieving items
// ***********************************************************
public static function get($key, $lang = CUR_LANG) {
	$old = $key;
	$key = self::norm($key); if (! $key) return $old;
	$out = self::find($key, $lang); if ($out) return $out;
	return self::store($key, $old, $lang);
}

public static function check($pfx, $key, $lang = CUR_LANG) {
	$key = self::norm($key); if (! $key) return $key;

	$idx = $key; if (! STR::contains($key, "."))
	$idx = self::norm("$pfx.$key");
	$out = self::find($idx, $lang);

	if ($out) return $out;
	$out = self::find($key, $lang); if ($out) return $out;

	$xxx = self::store($idx, ucfirst($key), $lang);
	return "<i>$key</i>";
}

// ***********************************************************
// translate strings
// ***********************************************************
public static function xlate($text, $lang = CUR_LANG) {
	$arr = STR::find($text, "<!DIC:", "!>"); if (! $arr) return $text;

	foreach ($arr as $key) {
		$repl = self::check("dic", $key, $lang);
		$text = str_replace("<!DIC:$key!>", $repl, $text);
	}
	return $text;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function getLang($lang) {
	$lgs = LANGUAGES;

	if ($lang == CUR_LANG) return CUR_LANG;
	if (STR::contains(".$lgs.", ".$lang.")) return $lang;
	return GEN_LANG;
}
private static function norm($key) {
	$key = STR::afterX($key, "@");
	return strtolower(STR::norm($key));
}

private static function find($key, $lng, $default = false) {
	$idx = self::norm($key); if (! $idx) return $default;
	$lgs = LNG::get();

	foreach ($lgs as $lng) {
		$arr = VEC::get(self::$dat, $lng); if (! $arr) continue;

		$out = VEC::get($arr, $idx); if ($out) return $out;
	}
	return $default;
}

private static function store($key, $val, $lang) { // trace missing dic entries
	if (! IS_LOCAL) return $key;

	if ($key != strip_tags($key)) return $key; // html code
	if ($key == strtoupper($key)) return $key; // constants
	if (STR::begins($key, "dic.")) return $key; // internal call
	if (STR::begins($key, "[")) return $key; // ini section
	if (STR::contains($key, "@")) return $key; // email
	if (strlen($key) > 50) return $key; // text
	if (strlen($key) <  3) return $key;

	$mod = EDITING; if (STR::begins(TOP_PATH, "setup"))
	$mod = basename(TOP_PATH);

 	$fil = FSO::join(APP_FBK, "design/dictionary", $lang, "$mod.dic");
 	$txt = APP::read($fil);
 	$val = ucfirst($val);
 	$itm = "$key = $val*\n";

 	if (STR::contains($txt, "$key = ")) return $key;
	APP::append($fil, $itm);
	return "$key*";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
