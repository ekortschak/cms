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

	$csv = new csv_table();
	$csv->load($file, $sep);
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
public static function href($lnk, $cap, $trg = "_self") {
	echo HTM::href($lnk, $cap, $trg);
}
public static function button($lnk, $cap, $trg = "_self") {
	$lnk = HTM::button($lnk, $cap, $trg);
	echo "<div style='margin-bottom: 3px;'>$lnk</div>";
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
	if (VMODE == "xsite") return HTW::thumbRH($link);

	HTW::$tpl->set("file", PGE::path($link));
	HTW::$tpl->show($sec);
}

// ***********************************************************
public static function ico($file, $wid = 50) {
	HTW::doThumb("thumb", $file, $wid);
}

public static function thumbRH($file, $wid = THUMB_WID) {
	HTW::doThumb("thumbR", $file, $wid);
}
public static function thumbR($file, $wid = THUMB_WID, $hgt = THUMB_HGT) {
	HTW::doThumb("thumbR", $file, $wid, $hgt);
}
public static function thumbL($file, $wid = THUMB_WID, $hgt = THUMB_HGT) {
	HTW::doThumb("thumbL", $file, $wid, $hgt);
}
public static function thumb($file, $wid = THUMB_WID, $hgt = THUMB_HGT) {
	HTW::doThumb("thumb", $file, $wid, $hgt);
}

private static function doThumb($sec, $file, $wid, $hgt = "") {
	$lnk = APP::url($file);

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
} // END OF CLASS
// ***********************************************************
?>
