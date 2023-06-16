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
public static function tag($text, $tag = "h4") {
	if (! $text) return "";
	if (is_array($text)) $text = print_r($text, true);
	return "<$tag>$text</$tag>\n";
}

public static function xtag($text, $tag = "h4") {
	$out = DIC::getPfx("tag", $text);
	return HTM::tag($out, $tag);
}

public static function lf($tag = "hr") {
	if ($tag == "pbr") return "\n\n<hr class='pbr'>\n";
	return "<$tag>\n";
}

// ***********************************************************
// standard tags
// ***********************************************************
public static function button($lnk, $cap, $trg = "_self") {
	$btn = HTM::tag($cap, "button");
	return HTM::href($lnk, $btn, $trg);
}

public static function icon($ico, $alt = "") {
	$img = "LOC_ICO/$ico";
	return "<img src='$img' alt='$alt'>";
}

public static function flag($lng) {
	$img = "LOC_ICO/flags/$lng.gif";
	return "<img src='$img' class='flag' alt='$lng'>";
}

public static function href($lnk, $cap, $trg = "_blank") {
	if (! $trg) return "<a href='$lnk'>$cap</a>";
	return "<a href='$lnk' target='trg'>$cap</a>";
}


public static function vspace($size) {
	$siz = intval($size);
	return "<div style='margin-top: ".$siz."px;'></div>";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
