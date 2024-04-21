<?php

// used to convert a topic to static pages

include_once "core/include/load.css.php";

incCls("files/css.php");
incCls("files/iniTab.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class statfs {
	private $dir = ""; // output dir
	private $tab = ""; // static pseudo tab
	private $sel = ""; // pre-selected page
	private $dbg = 0;  // debug mode (off)

	private $num = 0;  // files to process
	private $cnt = 0;  // files processed

function __construct($cnt = 3) {
	$this->tab = FSO::join(APP_NAME, basename(TAB_HOME));
	$this->dir = LOC::tempDir("static pages", STR::afterX($this->tab, APP_NAME));
	$this->dbg = $cnt; // number of items handled in debug mode

	$ini = new iniTab(TAB_HOME);
	$this->sel = $ini->get("props.std");
}

// ***********************************************************
// read all ini files
// ***********************************************************
public function pages($pfs) {
	$this->num = count($pfs);
	$this->cnt = $cnt = 0;

	ENV::set("output", "static");

	foreach($pfs as $dir => $inf) {
		PGE::load($dir); $cnt++;
		$this->doPage($dir, $inf, $cnt); // will change current page
	}
	PGE::restore(); // restore current page
	ENV::set("output", "");

	self::writeCss();
}

public function getDir() {
	return $this->dir;
}

// ***********************************************************
// status
// ***********************************************************
public function isPage() {
	$fil = FSO::join($this->dir, "index.htm");
	if (is_file($fil)) return $fil;
	return false;
}

public function report() {
	HTW::xtag("report");
	HTW::tag("Files written to: $this->dir", "p");
	HTW::tag("# of files: $this->cnt/$this->num", "p");
}

public function status() {
	if ($this->isPage()) {
		$url = APP::url($idx);
		$msg = DIC::get("static.show");
		$msg = HTM::href($url, $msg, "static");
	}
	else {
		$msg = DIC::get("static.none");
	}
	echo "<hr>$msg<hr>";
}

// ***********************************************************
// writing pages
// ***********************************************************
private function doPage($dir, $inf, $cnt) {
	set_time_limit(10); extract($inf);

	$htm = new page();
	$htm->read("LOC_LAY/LAYOUT/static.tpl");
	$htm->set("title", PRJ_TITLE);
	$htm->setModules();

	$txt = $htm->gc();
	$txt = $this->deRefSrc($txt, 'src="', '"');
	$txt = $this->deRefSrc($txt, "src='", "'");
	$txt = $this->deRefTabs($txt);

	$fil = $this->statID());
	$res = $this->writePge($fil, $uid, $txt);
	$xxx = $this->writeIdx($uid, $txt);
	$this->cnt+= $res;
}

private function writeIdx($uid, $txt) {
	$fil = FSO::join($this->dir, "index.htm");
	if ($this->cnt) if ($uid != $this->sel) return;
	APP::write($fil, $txt); // overwrite if pre-selected
}

private function writePge($fil, $uid, $txt) {
	$fil = FSO::join($this->dir, $fil);
	$res = APP::write($fil, $txt);
	return (is_file($fil));
}

private function writeCss() {
	incCls("files/css.php");

	$obj = new css();
	$txt = $obj->gc();
	$txt = $this->deRefSrc($txt, 'url("', '")');
	$txt = $this->deRefSrc($txt, "url('", "')");

	$dst = FSO::join($this->dir, "site.css");
	$res = APP::write($dst, $txt);
}

// ***********************************************************
// solving references
// ***********************************************************
private function deRefSrc($txt, $sep1, $sep2) {
	$arr = STR::find($txt, $sep1, $sep2);
	$res = DIR_SEP."res";

	foreach ($arr as $lnk) {
		$dst = FSO::join($this->dir, "res", $dst);
// TODO: CHECK ME
		$url = ltrim($dst, DIR_SEP);
		$txt = STR::replace($txt, $lnk, $url);

		if (! is_file($dst)) FSO::copy($lnk, $dst);
	}
	return $txt;
}

private function deRefTabs($txt) {
	$arr = STR::find($txt, "href=\"", "\"");

	foreach ($arr as $lnk) {
		if (STR::misses($lnk, "?tab")) continue;

		$dst = FSO::join("...", basename($lnk), "index.htm");
		$txt = str_replace($lnk, $dst, $txt);
	}
	return $txt;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function title($inf) {
	$lev = $inf["level"];
	$hed = $inf["title"]; $tag = "h$lev";

	$num = $this->getNum($lev); if ($num) if ($lev < 5)
	$this->toc[] = "$num $hed"; // top 3 levels only

	return "<$tag>$num $hed</$tag>\n";
}

private function statID($cnt) {
	return sprintf("p%05d.htm", $cnt);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
