<?php
/* ***********************************************************
// INFO
// ***********************************************************
Handles tab navigation (vertical tabs)

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/tabs.php");

$nav = new tabs("tabs" | "tabs.top");
$nav->setData($arr);
$nav->show();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tabs extends tpl {
	private $dat = array();

function __construct($typ = "tabs.left") {
	parent::__construct();
	$this->load("menus/$typ.tpl");
}

// ***********************************************************
// methods
// ***********************************************************
public function setData($arr) {
	$this->dat = $arr;
}

// ***********************************************************
// display
// ***********************************************************
public function gc($sec = "main") {
	$lng = CUR_LANG; $out = "";

	foreach ($this->dat as $tab => $cap) {
		if (! APP::dir($tab)) continue;

		$img = APP::find($tab, "tab", "png");
		$itm = "item"; if ($img)
		$itm = "item.img";

		$this->set("link",  APP::relPath($tab));
		$this->set("mode",  $this->getMode());
		$this->set("text",  $cap);
		$this->set("class", $this->getClass($tab));
		$this->set("dir",   $this->getOrientation($cap));
		$this->set("img",   $img);

		$out.= $this->getSection($itm);
	}
	$xxx = $this->set("items", $out);
	$out = $this->getSection($sec);
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getMode() {
	if (STR::contains(VMODE, "edit")) return VMODE;
	return "view";
}

private function getClass($dir) {
	if (STR::begins(TAB_HOME, $dir)) return "vtab_selected";
	return "std";
}

private function getOrientation($cap) {
	$chk = strip_tags($cap); if (strlen($chk) < 2) return "";
	return "vertical";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
