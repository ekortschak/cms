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

$mnu = new toc($tpl);
$mnu->show();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class toc extends tpl {
	private $dir = "";
	private $dat = array();

function __construct() {
	parent::__construct();
 	$this->load("menus/toc.view.tpl"); if (EDITING != "view")
	$this->load("menus/toc.edit.tpl");

	$this->dir = ENV::getPage();
}

// ***********************************************************
// methods
// ***********************************************************
public function setData($arr) { // $arr as from PFS::mnuInfo();
	$this->dat = $arr;
}

// ***********************************************************
// display functions
// ***********************************************************
public function gc($sec = "main") {
	$trg = PFS::getPath(); $out = ""; $cnt = 0;
	$max = PFS::getLevel($trg) + 1;
	$lst = PFS::count();

	for ($i = 0; $i < $lst; $i++) {
		$inf = PFS::mnuInfo($i); if (! $inf) continue;
		$this->merge($inf); extract($inf);

		if ($level < 2) continue;

		$this->set("index",	$cnt++."");
		$this->set("vis", $this->isVisible($trg, $fpath, $level, $max)); // expandable
		$this->set("sel", $this->isSelected($trg, $fpath));
		$this->set("pos", $this->isOpen($trg, $fpath, $level));
		$this->set("hid", $this->isHidden($fpath)); // show only in edit mode
		$this->set("active", $grey);

		$typ = $this->chkType($mtype);
		$out.= $this->getSection("link.$typ")."\n";
    }
    $this->set("items", $out);
    $out = parent::gc($sec);
    return $out;
}

// ***********************************************************
private function chkType($typ) {
	$mod = ENV::get("output");

	if ($mod == "static") {
		if ($typ == "both") return "static.dir";
		if ($typ == "file") return "static.file";
	}
	return $typ;
}

// ***********************************************************
// determine display features
// ***********************************************************
private function isVisible($dir, $fpath, $lev, $max) {
	if ($lev < 3) return "block";
	if ($lev > $max) return "none"; // exclude deep level subdirs

	if (STR::begins($fpath, $dir)) return "block"; // show immediate subdirs
	if (STR::begins($dir, dirname($fpath))) return "block"; // show parents and siblings
	return "none";
}
private function isOpen($dir, $fpath, $lev) {
	if (STR::begins($dir, $fpath)) return "bottom";
	return "top";
}
private function isSelected($dir, $idx) {
	if ($idx != $dir) return "";
	return "sel";
}
private function isHidden($idx) {
	if (FSO::isHidden($idx)) return "hidden";
	return "";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
