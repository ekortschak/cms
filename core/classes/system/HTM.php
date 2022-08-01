<?php
/* ***********************************************************
// INFO
// ***********************************************************
contains public static functions for standard htm tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("system/HTM.php");

HTM::ytLink($ytid, "title", $len");
*/

incCls("files/tpl.php");
HTM::init();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class HTM  {
	private static $tpl;

public static function init($tpl = "design/templates/other/stdObjs.tpl") {
	self::$tpl = new tpl();
	self::$tpl->read($tpl);
}

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
	incCls("files/csv.php");

	$pge = ENV::getPage();
	$fil = STR::replace($file, "./", "$pge/");

	$csv = new csv($sep);
	$csv->read($fil);
	$csv->show();
}

// ***********************************************************
// handling standard objects
// ***********************************************************
public static function cap($text, $tag = "h4") {
	echo "<$tag>$text</$tag>";
}
public static function tag($text, $tag = "h4", $dic = true) {
	$out = $text; if ($dic) $out = DIC::check("tag", $text); if (! $out) return "";
	$arr = explode(".", $tag);

	foreach ($arr as $tag) {
		$out = "<$tag>$out</$tag>";
	}
	echo "$out\n";
}

public static function def($key, $val) {
	echo "<dt>$key</dt>\n<dd>$val</dd>\n\n";
}
public static function fnc($key, $val) {
	echo "<li>$key = $val</li>\n";
}

public static function wSrc($link, $text) {
	self::$tpl->set("link", $link);
	self::$tpl->set("text", $text);
	self::$tpl->show("img.src");
}

public static function wPic($dir, $fil) {
	$fil = FSO::join($dir, $fil);
	self::img($fil);
}
public static function image($file) {
	self::doImage("img.org", $file);
}
public static function img($file) {
	self::doImage("img.std", $file);
}

private static function doImage($sec, $link = "") {
	$mds = ENV::get("vmode"); if ($mds == "xsite") return self::thumbR($link);
	$pge = ENV::getPage();
	$lnk = self::getLink($link, "./", "$pge/");

	self::$tpl->set("file", $lnk);
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
	$pge = ENV::getPage();
	$lnk = self::getLink($link, "./", "$pge/");

	self::$tpl->set("link", $lnk);
	self::$tpl->set("wid", $wid);
	self::$tpl->set("hgt", $hgt);
	self::$tpl->show($sec);
}

// ***********************************************************
public static function mp4($fil, $txt, $hint = "") {
	self::$tpl->set("link", $fil);
	self::$tpl->set("text", $txt);
	self::$tpl->set("hint", $hint);
	self::$tpl->show("mp4");
}

public static function ytLink($ytid, $tit, $len = "", $typ = "link") {
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
	return STR::replace($link, "./", "$pge/");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
