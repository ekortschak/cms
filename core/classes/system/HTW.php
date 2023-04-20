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
	self::$tpl = new tpl();
	self::$tpl->load("other/stdObjs.tpl");
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
public static function csv($file, $sep = ";") {
	incCls("tables/csv_table.php");

	$fil = self::getLink($file);

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
public static function def($key, $val) {
	echo HTM::def($key, $val);
}

// ***********************************************************
// images
// ***********************************************************
public static function image($file) {
	self::doImage("img.org", $file);
}
public static function img($file) {
	self::doImage("img.std", $file);
}

private static function doImage($sec, $link = "") {
	if (EDITING == "xsite") return self::thumbR($link);

	self::$tpl->set("file", self::getLink($link));
	self::$tpl->show($sec);
}

// ***********************************************************
public static function thumbR($link, $wid = 200, $hgt = NV) {
	self::doThumb("thumbR", $link, $wid);
}
public static function thumbL($link, $wid = 200, $hgt = NV) {
	self::doThumb("thumbL", $link, $wid);
}
public static function thumb($link, $wid = 200, $hgt = NV) {
	self::doThumb("thumb", $link, $wid);
}

private static function doThumb($sec, $link = "", $wid = 200, $hgt = NV) {
	$lnk = self::getLink($link);

	self::$tpl->set("link", $lnk);
	self::$tpl->set("wid", $wid);
	self::$tpl->set("hgt", $hgt);
	self::$tpl->show($sec);
}

// ***********************************************************
// media
// ***********************************************************
public static function mp4($fil, $txt, $hint = "") {
	self::$tpl->set("link", $fil);
	self::$tpl->set("text", $txt);
	self::$tpl->set("hint", $hint);
	self::$tpl->show("mp4");
}

public static function ytube($ytid, $tit, $len = "", $typ = "link") {
	if (! $ytid) return;
	self::$tpl->set("ytid", $ytid);
	self::$tpl->set("title", $tit);
	self::$tpl->set("len", $len);
	self::$tpl->show("yt.$typ");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private static function getLink($link) {
	$pge = ENV::getPage();
	return STR::replace($link, ".".DIR_SEP, $pge.DIR_SEP);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
