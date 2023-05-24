<?php
/* ***********************************************************
// INFO
// ***********************************************************
Handles top navigation

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/menu.php");

$nav = new menu();
$nav->setData($arr); // $arr as from PFS::mnuInfo();
$nav->show();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class menu extends tpl {
	private $top = array();
	private $dat = array();

function __construct($typ = "menu") {
	parent::__construct();
	$this->load("menus/$typ.tpl");
}

// ***********************************************************
// methods
// ***********************************************************
public function setData($arr, $ofs = 0) { // $arr as from PFS::mnuInfo();
	$top = "default";

	foreach ($arr as $key => $inf) {
		$lev = VEC::get($inf, "level") + $ofs; if ($lev < 2) continue;

		switch ($lev) {
			case 2: $this->top[$key] = $inf; $top = $key; break;
			case 3:	$this->dat[$top][$key] = $inf; break;
			default: // menues only support 1st sublevel
		}
	}
}

// ***********************************************************
// display
// ***********************************************************
public function gc($sec = "main") {
	$its = "";

	foreach ($this->top as $dir => $inf) {
		$sub = $this->getEntries($dir);

		$box = "item";  if (! $sub)
		$box = "empty"; if (VMODE != "view")
		$box = "edit";

		$this->set("class", $this->getClass($inf["fpath"]));
		$this->set("entry", $sub);

		$its.= $this->getItem($box, $inf);
	}
	$xxx = $this->set("items", $its);
	return $this->getSection($sec);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getEntries($top) {
	$dat = VEC::get($this->dat, $top); if (! $dat) return "";
	$out = "";
	foreach ($dat as $key => $inf) {
		$out.= $this->getItem("entry", $inf);
	}
	return $out;
}

private function getItem($sec, $inf) {
	$this->set("link", $inf["plink"]);
	$this->set("text", $inf["title"]);
	return $this->getSection($sec);
}

private function getClass($dir) {
	if (STR::begins(PGE::$dir, $dir)) return "active";
	return "std";
}

private function getOS() {
	$cos = $_SERVER["HTTP_USER_AGENT"];

	$bad = ".chrom.safari.opera.ie.microsoft.";
	$bad = VEC::explode($bad, ".");

	if (STR::contains($cos, $bad)) return "MS";
	return "";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
