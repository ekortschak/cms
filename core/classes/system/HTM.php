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
	$btn = self::tag($cap, "button");
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
	$out = self::tag($key, "dt");
	$out.= self::tag($val, "dd");
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
