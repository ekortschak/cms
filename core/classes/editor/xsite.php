<?php

// used to convert a topic to a single document

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class xsite extends tpl {
	private $num = array(); // chapter numeration
	private $toc = array(); // tabel of contents
	private $nts = array(); // end notes
	private $chk = array(); // list of end note keys
	private $dat = array(); // list of page contents

	private $dir = TAB_HOME;
	private $top = 1;		// top menu level
	private $lvl = 4;       // max depth of ToC (+ 1)

	static  $skp = "";

function __construct() {
	$this->num = array_pad($this->num, 10, 0);

	parent::load("modules/xsite.tpl");
}

// ***********************************************************
// read all selected files
// ***********************************************************
public function read($dir) {
	$inf = PFS::mnuInfo($dir);

	$this->dir = $dir;
	$this->top = $inf["level"];

	$arr = array($dir => "start"); $skp = "";
	$arr+= FSO::dtree($dir);

	foreach($arr as $dir => $nam) {
		if (STR::contains($dir, HIDE)) continue;

		$inf = PFS::mnuInfo($dir);    if (! $inf) continue;
		$uid = VEC::get($inf, "uid"); if (! $uid) continue;
		$lev = VEC::get($inf, "level");

		ENV::setPage($dir); // set focus to this page
		set_time_limit(10); // reset timeout

		$ini = new ini($dir);
		$npr = $ini->get("props.skip");
		$pbr = $ini->get(CUR_LANG.".pbreak");

		if ($this->skip($dir, $npr)) continue;

		$this->pbreak($pbr, $lev);
		$this->doPage($inf, $dir, $lev);
	}
	$this->stripNotes();

 // restore current page
	PGE::restore();
}

// ***********************************************************
// display output
// ***********************************************************
public function show($sec = "dummy") {
	echo $this->getToc();
	echo $this->dat;
	echo $this->getNotes();
}

// ***********************************************************
// handling page content
// ***********************************************************
private function doPage($inf, $dir) {
	$hed = APP::gcSys($dir, "head"); if ($hed) $hed = HTM::tag($hed, "div");
	$ftr = APP::gcSys($dir, "tail"); if ($ftr) $ftr = HTM::tag($ftr, "div");
	$txt = APP::gcSys($dir, "page");

	$txt = APP::lookup($txt);
	$txt = ACR::clean($txt);

	$txt = $this->cnvHeads($txt);
	$tit = $this->getTitle($inf);

	$pic = ""; if (! STR::contains($txt, "pic.png"))
	$pic = APP::file("$dir/pic.png"); if ($pic)
	$pic = $this->getSection("pic");

	$this->setX("head", $tit.$hed);
	$this->setX("pic",  $pic);
	$this->setX("text", $txt);
	$this->setX("tail", $ftr);

	$this->dat[] = parent::gc();
}

// ***********************************************************
private function cnvHeads($txt) {
	$txt = STR::replace($txt, "h1>", "h4>");
	$txt = STR::replace($txt, "h2>", "h4>");
	$txt = STR::replace($txt, "h3>", "h4>");
	$txt = STR::replace($txt, "<h4>", "<p><b><u>"); $txt = STR::replace($txt, "</h4>", "</u></b></p>");
	$txt = STR::replace($txt, "<h5>", "<p><u><i>");	$txt = STR::replace($txt, "</h5>", "</i></u></p>");
	$txt = STR::replace($txt, "<h6>", "<p><i>");    $txt = STR::replace($txt, "</h6>", "</i></p>");
	return $txt;
}

// ***********************************************************
// handling page title
// ***********************************************************
private function getTitle($inf) {
	$lev = $inf["level"];
	$hed = $inf["head"]; if (! $hed)
	$hed = $inf["title"];

	$pfx = $this->getIndent($lev);
	$num = $this->getKapNum($lev);
	$xxx = $this->addToc($lev, "$pfx $num $hed");

	$hed = trim("$num $hed");

	$out = HTM::tag($hed, "h$lev");
	return $out;
}

// ***********************************************************
private function getIndent($lev) {
	$lev-= $this->top + 1; if ($lev < 1) return "";
	return str_repeat("&nbsp; ", $lev);
}

private function getKapNum($lev) {
	$lev-= $this->top; if ($lev < 1) return "";

	$this->num[$lev - 1]++;
	$this->num[$lev + 0] = 0;
	$out = implode(".", $this->num);
	return STR::before("$out.0.", ".0.");
}

// ***********************************************************
// handling toc
// ***********************************************************
private function getToc() {
	$out = HTM::tag("Inhaltsverzeichnis", "h2");
	$out.= implode("<br>\n", $this->toc);
	return $out;
}

private function addToc($lev, $tit) {
	if ($lev >= $this->lvl) return; // top 3 levels only
	$this->toc[] = trim($tit);
}

// ***********************************************************
// handling notes
// ***********************************************************
private function getNotes() {
	if (! $this->nts) return "";

	$out = HTM::lf("pbr");
	$out.= HTM::tag("Endnoten", "h1");
	$out.= implode("<br>\n", $this->nts);
	return $out;
}

private function stripNotes() {
	$out = implode(" ", $this->dat); $lst = array();

	$rba = "<refbox>";  $rca = "<refbody>";
	$rbe = "</refbox>"; $rce = "</refbody>";

	$arr = STR::find ($out, "$rba", "$rbe");
	$out = PRG::clear($out, "$rca@ANY$rce");

	foreach ($arr as $itm) {
		$key = STR::before( $itm, $rca);
		$val = STR::between($itm, $rca, $rce);
		$lst[$key] = trim($val);
	}
	$cnt = 1;

	foreach ($lst as $key => $val) {
		$idx = VEC::get($this->chk, $key, $cnt);
		$sup = "<fnote>$idx</fnote>";
		$out = PRG::replace($out, $rba.$key.$rbe, "$key<sup>$sup</sup>");

		if ($idx < $cnt) continue;

		$this->set("idx", $idx);
		$this->set("key", $key);
		$this->set("val", $val);

		$this->nts[$idx] = $this->gc("fnote");
		$cnt++;
	}
	$this->dat = $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function skip($dir, $npr) {
	if ($npr) { // noprint
		HTW::tag("skipping: $dir", "li");
		$this->skp = $dir;
		return true;
	}
	if ($this->skp) { // skip subfolders as well
		if (STR::begins($dir, $skp)) return true;
	}
	$this->skp = "";
	return false;
}

// ***********************************************************
private function pbreak($pbr, $lev) {
	if ($lev > 1) if (! $pbr) return;
	$this->dat[] = HTM::lf("pbr");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
