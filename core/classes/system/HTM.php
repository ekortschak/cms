<?php
/* ***********************************************************
// INFO
// ***********************************************************
contains functions for standard htm tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/HTM.php");

HTW::ytube($ytid, "title", $len");
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class HTM  {
	private static $tpl;

// ***********************************************************
// common
// ***********************************************************
public static function pgeTitle($fso) {
	$ini = new ini($fso);
	return $ini->getHead();
}

public static function pgeValues($fso, $sec = "") {
	$ini = new ini($fso);
	return $ini->getValues($sec);
}

public static function pgeProp($fso, $key, $default) {
	$ini = new ini($fso);
	return $ini->get($key, $default);
}

// ***********************************************************
// files
// ***********************************************************
public static function code($file, $head = "") {
	incCls("other/tutorial.php");

	$cod = new tutorial();
	$cod->sample($file, $head);
}
public static function snip($file, $head = "") {
	incCls("other/tutorial.php");

	$cod = new tutorial();
	$cod->text($file, $head);
}

// ***********************************************************
// files
// ***********************************************************
public static function noFile() {
	self::$tpl->show("no.lang");
}

public static function csv($file, $sep = ";") {
	incCls("tables/csv_table.php");

	$pge = ENV::getPage();
	$fil = STR::replace($file, "./", "$pge/");

	$csv = new csv_table();
	$csv->load($fil, $sep);
	$csv->show();
}

// ***********************************************************
// handling standard objects
// ***********************************************************
public static function wtag($text, $tag = "h4") {
	echo self::tag($text, $tag);
}
public static function tag($text, $tag = "h4") {
	return "<$tag>$text</$tag>\n";
}

public static function xtag($text, $tag = "h4") {
	$out = DIC::getPfx("tag", $text); if (! $out) return "";
	$arr = STR::toArray($tag);

	foreach ($arr as $tag) {
		$out = "<$tag>$out</$tag>";
	}
	echo "$out\n";
}

public static function lf($tag = "hr") {
	if ($tag == "pbr") $tag = "\n\n<hr class='pbr'>\n";
	echo "<$tag>\n";
}

// ***********************************************************
// standard tags
// ***********************************************************
public static function button($lnk, $cap, $trg = "_self") {
	$btn = self::cap($cap, "button");
	return self::href($lnk, $btn, $trg);
}

public static function href($lnk, $cap, $trg = "") {
	if (! $trg) return "<a href='$lnk'>$cap</a>";
	return "<a href='$lnk' target='trg'>$cap</a>";
}

public static function flag($lng) {
	$img = "ICONS/flags/$lng.gif";
	return "<img src='$img' class='flag' alt='$lng'>";
}


public static function vspace($size) {
	$siz = intval($size);
	return "<div style='margin-top: ".$siz."px;'></div>";
}

public static function def($key, $val) {
	$out = self::cap($key, "dt");
	$out.= self::cap($val, "dd");
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
