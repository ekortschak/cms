<?php

// used to convert a topic to a single document

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class xsite {
	protected $num = array(); // chapter numeration
	protected $toc = array(); // tabel of contents
	protected $nts = array(); // end notes
	private   $hst = array(); // list of end note keys

	protected $lvl = 4;  // max depth of ToC (+ 1)
	protected $dat = ""; // transformed string
	protected $dbg = 0;  // debug mode (off)

function __construct($cnt = 3) {
	$this->num = array_pad($this->num, 10, 0);
	$this->dbg = $cnt; // number of items handled in debug mode
}

// ***********************************************************
// read all selected files
// ***********************************************************
public function read($pfs) {
	$pge = ENV::getPage(); // backup current page
	$skp = $old = ""; $cnt = 0;

	foreach($pfs as $dir => $nam) {
		if (STR::contains($dir, HIDE)) continue;

		$inf = PFS::mnuInfo($dir);    if (! $inf) continue;
		$uid = VEC::get($inf, "uid"); if (! $uid) continue;

		$ini = new ini($dir);
		$prn = $ini->get("props.noprint");
		$pbr = $ini->get(CUR_LANG.".pbreak");

		if ($this->dbg) if ($cnt++ > $this->dbg) break;

		ENV::setPage($dir);
		set_time_limit(10);

		if ($prn) { // noprint
			HTW::tag("skipping: $dir", "li");
			$skp = $dir; continue;
		}
		if ($skp) { // skip subfolders as well
			if (STR::begins($dir, $skp)) continue;
			$skp = "";
		}
		$this->addContent($inf, $pbr, $dir);
	}
	$this->dat = $this->stripNotes();

	ENV::setPage($pge); // restore current page
}

// ***********************************************************
// display output
// ***********************************************************
public function show() {
	echo $this->gc();
}

protected function gc() {
	$out = $this->toc();
	$out.= $this->dat;
	$out.= $this->endnotes();
	return $out;
}

// ***********************************************************
// handling parts (ToC, content, endnotes)
// ***********************************************************
protected function addContent($inf, $pbr, $dir) {
	$this->dat.= $this->getLF($inf, $pbr);
	$this->dat.= "\n<section style='clear: both;'>\n";

	$pic = ""; if (is_file("$dir/pic.png"))
	$pic = "<img src='$dir/pic.png', align='right' width=198 style='margin: 0px 0px 5px 10px;' />\n";
	$tit = $this->getTitle($inf);
	$txt = $this->getText($dir);

	if (STR::contains($txt, "pic.png")) $pic = "";

	$this->dat.= $pic.$tit.$txt;
	$this->dat.= "\n</section>\n";
}

protected function toc() {
	$out = HTM::tag("Inhaltsverzeichnis", "h1");
	$out.= implode("<br>\n", $this->toc);
	return $out;
}

protected function endnotes() {
	if (! $this->nts) return "";

	$out = HTM::lf("pbr");
	$out.= HTM::tag("Endnoten", "h1");
	$out.= implode("<br>\n", $this->nts);
	return $out;
}

// ***********************************************************
// handling content
// ***********************************************************
protected function getText($dir) {
	$xxx = ob_start(); include("core/modules/body.xsite/item.php");
	$txt = ob_get_clean();

	$txt = STR::replace($txt, "h1>", "h4>");
	$txt = STR::replace($txt, "h2>", "h4>");
	$txt = STR::replace($txt, "h3>", "h4>");
	$txt = STR::replace($txt, "<h4>", "<p><b><u>"); $txt = STR::replace($txt, "</h4>", "</u></b></p>");
	$txt = STR::replace($txt, "<h5>", "<p><u><i>");	$txt = STR::replace($txt, "</h5>", "</i></u></p>");
	$txt = STR::replace($txt, "<h6>", "<p><i>");    $txt = STR::replace($txt, "</h6>", "</i></p>");
	return $txt;
}

// ***********************************************************
protected function stripNotes() {
	$out = $this->dat; $lst = array(); $cnt = 0;

	$arr = STR::find($out, "<refbox", "</refbox>");
	$out = PRG::replace($out, "<refbox-content>@ANY</refbox-content>", "");

	foreach ($arr as $itm) {
		switch ($cnt++ % 2) {
			case 1:  $key = STR::between($itm, ">", "-content"); break;
			default: $val = STR::after($itm, "-content>", "</ref");
				$lst[$key] = trim($val);
		}
	}
	$cnt = 1;

	foreach ($lst as $key => $val) {
		$num = $cnt++;
		$tmp = VEC::get($this->hst, $key); if ($tmp) $num = $tmp;
		$out = PRG::replace($out, "<refbox>$key", "$key<sup><fnote>$num</fnote></sup>");

		if ($cnt != $num) continue;
		$this->nts[$cnt] = "<div><fnote>$num</fnote> <b>$key</b><br>$val</div>";
	}
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function getTitle($inf) {
	$lev = $inf["level"];
	$hed = $inf["head"]; if (! $hed)
	$hed = $inf["title"];

	$pfx = $this->getIndent($lev);
	$num = $this->getKapNum($lev);
	$xxx = $this->addToc($lev, "$pfx $num $hed");

	return HTM::tag("$num $hed", "h$lev");
}

// ***********************************************************
protected function getIndent($lev) {
	return str_repeat("&nbsp; ", $lev);
}

protected function getKapNum($lev) {
	$this->num[$lev - 1]++; if (! $lev) return "";
	$this->num[$lev + 0] = 0;
	$out = implode(".", $this->num);
	$out = STR::before("$out.0.", ".0.");
	$out = STR::after($out, "1."); if ($out) return $out;
	return "1.";
}

protected function addToc($lev, $tit) {
	if ($lev >= $this->lvl) return; // top 3 levels only
	$this->toc[] = trim($tit);
}

// ***********************************************************
protected function getLF($inf, $pbr) {
	$npg = HTM::lf("pbr");
	$lev = ($inf["level"] < 2);

	if ($lev) return $npg;
	if ($pbr) return $npg;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
