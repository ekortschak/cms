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
$nav->setData($arr); // $arr as from PFS::item();
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
public function setData($arr, $ofs = 0) { // $arr as from PFS::item();
	$top = "default";

	foreach ($arr as $key => $inf) {
		$lev = VEC::get($inf, "level") + $ofs; if ($lev < 1) continue;

		switch ($lev) {
			case 1: $this->top[$key] = $inf; $top = $key; break;
			case 2:	$this->dat[$top][$key] = $inf; break;
			default: // menues only support 1st sublevel
		}
	}
}

// ***********************************************************
// display
// ***********************************************************
public function gc($sec = "main") {
	$its = "";

	foreach ($this->top as $key => $inf) {
		$this->merge($inf); extract($inf);

		$sub = $this->getEntries($key);
		$cls = $this->getClass($fpath);
		$box = $this->getBox($sub);

		$this->set("class", $cls);
		$this->set("subitems", $sub);

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
		$out.= $this->getItem("subItem", $inf);
	}
	return $out;
}

private function getItem($sec, $inf) {
	$this->set("link", $inf["uid"]);
	$this->set("text", $inf["title"]);
	return $this->getSection($sec);
}

private function getClass($dir) {
	if (STR::begins(PGE::$dir, $dir)) return "active";
	return "std";
}

private function getBox($sub) {
	if (! $sub) return "empty";
	if (! PFS::isView()) return "edit";
	return "item";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
