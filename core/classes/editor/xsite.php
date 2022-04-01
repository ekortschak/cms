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
// read all ini files
// ***********************************************************
public function read($pfs) {
	$pge = ENV::getPage(); // back up current page
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
			echo "<li>skipping: $dir</li>";
			$skp = $dir; continue;
		}
		if ($skp) { // skip subfolders as well
			if (STR::begins($dir, $skp)) continue;
			$skp = "";
		}
		$this->getPage($inf, $pbr, $dir);
	}
	$this->dat = $this->getNotes();

	ENV::setPage($pge); // restore current page
}

protected function getPage($inf, $pbr, $dir) {
	$this->dat.= $this->getLF($inf, $pbr);
	$this->dat.= "\n<section style='clear: both';>\n";

	$pic = ""; if (is_file("$dir/pic.png"))
	$pic = "<img src='$dir/pic.png', align='right' width=198 style='margin: 0px 0px 5px 10px;' />\n";
	$tit = $this->getTitle($inf);
	$txt = $this->getText($dir);

	if (STR::contains($txt, "pic.png")) $pic = "";

	$this->dat.= $pic.$tit.$txt;
	$this->dat.= "\n</section>\n";
}

public function save($fil) {
	$out = $this->get();
	$lnk = STR::startingat($fil, "temp/");

	MSG::now("file.saved", "<a href='/$lnk'>$fil</a>");
	APP::write($fil, $out);
}
public function show() {
	echo $this->get();
}

// ***********************************************************
// handling components
// ***********************************************************
protected function toc() {
	$out = "<h1>Inhaltsverzeichnis</h1>\n";
	$out.= implode("<br>\n", $this->toc);
	return $out;
}

protected function endnotes() {
	if (! $this->nts) return "";

	$out = "\n\n<hr class='pbr'>\n\n";
	$out.= "<h1>Endnoten</h1>\n";
	$out.= implode("<br>\n", $this->nts);
	return $out;
}

protected function get() {
	$out = $this->toc();
	$out.= $this->dat;
	$out.= $this->endnotes();
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function getLF($inf, $pbr) {
	$npg = "\n\n<hr class='pbr'>";
	$lev = ($inf["level"] < 2);

	if ($lev) return $npg;
	if ($pbr) return $npg;
}

protected function getTitle($inf) {
	$lev = $inf["level"];
	$hed = $inf["head"]; if (! $hed)
	$hed = $inf["title"]; $tag = "h$lev";

	$pfx = trim(str_repeat("&nbsp; ", $lev));
	$num = $this->getNum($lev); if ($lev < $this->lvl)
	$this->toc[] = "$pfx $num $hed"; // top 3 levels only

	return "<$tag>$num $hed</$tag>\n";
}

protected function getNum($lev) {
	$this->num[$lev - 1]++; if (! $lev) return false;
	$this->num[$lev + 0] = 0;
	$out = implode(".", $this->num);
	$out = STR::before("$out.0.", ".0.");
	return STR::after($out, "1.");
}

protected function getText($dir) {
	$xxx = ob_start(); include("core/modules/body.xsite/item.php");
	$txt = ob_get_clean();

	$txt = STR::replace($txt, "h1>", "h4>");
	$txt = STR::replace($txt, "h2>", "h4>");
	$txt = STR::replace($txt, "h3>", "h4>");
	$txt = STR::replace($txt, "<h4>", "<p><b><u>"); $txt = STR::replace($txt, "</h4>", "</u></b></p>");
	$txt = STR::replace($txt, "<h5>", "<p><u><i>");	$txt = STR::replace($txt, "</h5>", "</i></u></p>");
	$txt = STR::replace($txt, "<h6>", "<p><i>");    $txt = STR::replace($txt, "</h6>", "</i></p>");

#	$txt = $this->lookup($txt);
	return $txt;
}

protected function lookup($txt) {
	incCls("search/lookup.php");
	$arr = APP::files("lookup");

	foreach ($arr as $fil => $nam) {
		$lup = new lookup();
		$lup->addRef($fil, $txt);
	}
	$txt = $lup->insert($txt);
	return $txt;
}

protected function getNotes() {
	$out = $this->dat;
	$arr = STR::find($out, "<refbox", "</refbox>");
	$out = PRG::replace($out, "<refbox-content>@ANY</refbox-content>", "");
	$lst = array();
	$cnt = 0;

	foreach ($arr as $itm) {
		$cnt++;

		switch ($cnt % 2) {
			case 1:  $key = STR::between($itm, ">", "-content"); break;
			default: $val = STR::after($itm, "-content>", "</ref");
				$lst[$key] = trim($val);
		}
	}
	$cnt = 0;

	foreach ($lst as $key => $val) {
		$num = ++$cnt;
		$tmp = VEC::get($this->hst, $key); if ($tmp) $num = $tmp;
		$out = PRG::replace($out, "<refbox>$key", "$key<sup><fnote>$num</fnote></sup>");

		if ($cnt != $num) continue;
		$this->nts[$cnt] = "<div><fnote>$num</fnote> <b>$key</b><br>$val</div>";
	}
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
