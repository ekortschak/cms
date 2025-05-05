<?php
/* ***********************************************************
// INFO
// ***********************************************************
use for menues based on stylesheets only
* depends on data from class PFS

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/toc.php");

$toc = new toc($tpl);
$toc->show();
*/

REG::add("LOC_SCR/toc.view.js");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class toc extends tpl {
	private $dat = array();

function __construct() {
	parent::__construct();

 	$this->load("menus/toc.view.tpl"); if (! APP::isView())
	$this->load("menus/toc.edit.tpl");

	$arr = PFS::tree(); array_shift($arr);
	$this->dat = $arr;
}

// ***********************************************************
// display methods
// ***********************************************************
public function gc($sec = "main") {
	$cur = PGE::$dir; $out = ""; $cnt = 0;
	$kap = PFS::get(NV, "chnum");

	foreach ($this->dat as $inf) {
		$this->merge($inf); extract($inf);

		if ($skp) { // skip collection dirs
			if (STR::begins($vpath, $skp)) continue;
			$skp = false;
		}
		$this->set("index", $cnt++);
		$this->set("level", $level - 1);
		$this->set("active", $state);

		$this->set("sel", $this->isCurrent($kap, $chnum)); // highlighted
		$this->set("pos", $this->isOpenFld($kap, $chnum)); // expanded
		$this->set("vis", $this->isVisible($kap, $chnum)); // visible
		$this->set("hid", $this->isHidden($fpath)); // show only in edit mode

		$typ = $this->chkType($mtype);
		$out.= $this->getSection($typ)."\n";

		if ($dtype == "col")
		if (APP::isView()) $skp = $vpath;
    }
    $this->set("items", $out);
    return parent::gc($sec);
}

// ***********************************************************
private function chkType($typ) {
	if (ENV::get("output") !== "static") return "link.$typ";

	if ($typ == "both") return "static.dir";
	if ($typ == "file") return "static.file";
	return $typ;
}

// ***********************************************************
// determine display features
// ***********************************************************
private function isCurrent($kap, $num) { // show highlighted
	if ($kap !== $num) return "";
	return "sel";
}
private function isHidden($fpath) {
	if (FSO::isHidden($fpath)) return "hidden";
	return "";
}

// ***********************************************************
private function isVisible($kap, $num) { // show parents and siblings
	if (STR::misses($num, ".")) return "show";  // always show first level

	$num = STR::split($num, "."); array_pop($num);
	$num = implode(".", $num);

	if (STR::begins($kap, $num)) return "show";
	return "hide";
}
private function isOpenFld($kap, $num) { // show open folder
	if (STR::begins($kap, $num)) return "open";
	return "closed";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
