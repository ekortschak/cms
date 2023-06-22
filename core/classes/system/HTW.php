<?php
/* ***********************************************************
// INFO
// ***********************************************************
wrapper for HTM output whenever that shold be echoed immediately

*/

incCls("files/tpl.php");

HTW::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class HTW  {
	private static $tpl;

public static function init() {
	HTW::$tpl = new tpl();
	HTW::$tpl->load("other/stdObjs.tpl");
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
public static function csv($file, $sep = ";", $wid = "100%") {
	incCls("tables/csv_table.php");

	$fil = HTW::getLink($file);

	$csv = new csv_table();
	$csv->load($fil, $sep);
	$csv->show();
}

// ***********************************************************
// handling standard objects
// ***********************************************************
public static function tag($text, $tag = "h4") {
	echo HTM::tag($text, $tag);
}
public static function xtag($text, $tag = "h4") {
	echo HTM::xtag($text, $tag);
}
public static function lf($tag = "hr") {
	echo HTM::lf($tag);
}

public static function pre($text) {
	echo HTM::tag($text, "pre");
}

// ***********************************************************
// standard tags
// ***********************************************************
public static function button($lnk, $cap, $trg = "_self") {
	echo HTM::button($lnk, $cap, $trg);
}
public static function href($lnk, $cap, $trg = "") {
	echo HTM::href($lnk, $cap, $trg);
}
public static function vspace($size) {
	echo HTM::vspace($size);
}

// ***********************************************************
// images
// ***********************************************************
public static function image($file) {
	HTW::doImage("img.org", $file);
}
public static function img($file) {
	HTW::doImage("img.std", $file);
}

private static function doImage($sec, $link = "") {
	if (VMODE == "xsite") return HTW::thumbR($link);

	HTW::$tpl->set("file", HTW::getLink($link));
	HTW::$tpl->show($sec);
}

// ***********************************************************
public static function thumbR($link, $wid = 200, $hgt = NV) {
	HTW::doThumb("thumbR", $link, $wid);
}
public static function thumbL($link, $wid = 200, $hgt = NV) {
	HTW::doThumb("thumbL", $link, $wid);
}
public static function thumb($link, $wid = 200, $hgt = NV) {
	HTW::doThumb("thumb", $link, $wid);
}

private static function doThumb($sec, $link = "", $wid = 200, $hgt = NV) {
	$lnk = HTW::getLink($link);

	HTW::$tpl->set("link", $lnk);
	HTW::$tpl->set("wid", $wid);
	HTW::$tpl->set("hgt", $hgt);
	HTW::$tpl->show($sec);
}

// ***********************************************************
// media
// ***********************************************************
public static function mp4($fil, $txt, $hint = "") {
	HTW::$tpl->set("link", $fil);
	HTW::$tpl->set("text", $txt);
	HTW::$tpl->set("hint", $hint);
	HTW::$tpl->show("mp4");
}

public static function ytube($ytid, $tit, $len = "", $typ = "link") {
	if (! $ytid) return;
	HTW::$tpl->set("ytid", $ytid);
	HTW::$tpl->set("title", $tit);
	HTW::$tpl->set("len", $len);
	HTW::$tpl->show("yt.$typ");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function getLink($link) {
	$pge = ENV::getPage();
	return STR::replace($link, "./", $pge.DIR_SEP);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
