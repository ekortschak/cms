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
public function gc($sec = "main") {
	$arr = PFS::toc(); $its = "";

	foreach ($arr as $inf) {
		$this->merge($inf); extract($inf); if ($level != 2) continue;

		$sub = $this->getEntries($uid);
		$cls = $this->getClass($fpath);
		$box = $this->getBox($sub);

		$this->set("class", $cls);
		$this->set("subitems", $sub);

		$its.= $this->item($box, $inf);
	}
	$xxx = $this->set("items", $its);
	return $this->getSection($sec);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getEntries($dir) {
	$arr = PFS::subtree($dir); if (! $arr) return;
	$out = "";
	foreach ($arr as $inf) {
		$out.= $this->item("subItem", $inf);
	}
	return $out;
}

private function item($sec, $inf) {
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
	if (! APP::isView()) return "edit";
	return "item";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
