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

// ***********************************************************
// handling standard objects
// ***********************************************************
public static function tag($text, $tag = "h4") {
	if (! $text) return "";
	if (is_array($text)) $text = print_r($text, true);

	$end = STR::before($tag, " ");

	return "<$tag>$text</$end>\n";
}

public static function xtag($text, $tag = "h4") {
	$out = DIC::get($text);
	return HTM::tag($out, $tag);
}

// ***********************************************************
// standard tags
// ***********************************************************
public static function href($lnk, $cap, $trg = "_self") {
	if (! $trg) return "<a href='$lnk'>$cap</a>";
	return "<a href='$lnk' target='sf'>$cap</a>";
}

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


public static function vspace($size) {
	$siz = intval($size)."px";
	return "\n<div name='vspace' style='margin-top: $siz;'></div>\n";
}

public static function prvPic($fil = "") {
	$tpl = new tpl();
	$tpl->load("other/stdObjs.tpl");
	$tpl->set("link", $fil);

	return $tpl->gc("thumbR");
}
// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
