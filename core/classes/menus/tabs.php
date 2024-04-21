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

		$img = APP::snip($tab, "tab", "png");
		$itm = "item"; if ($img)
		$itm = "item.img";

		$this->set("link",  APP::relPath($tab));
		$this->set("text",  $cap);
		$this->set("img",   $img);
		$this->set("class", $this->getClass($tab));
		$this->set("vmode", $this->vmode($tab));
		$this->set("agent",	$this->agent($cap));

		$out.= $this->getSection($itm);
	}
	$xxx = $this->set("items", $out);
	$out = $this->getSection($sec);
	return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getClass($dir) {
	if (STR::begins(TAB_HOME, $dir)) return "vtab_selected";
	return "std";
}

private function vmode() {
	if (VMODE == "search") return "view";
	return VMODE;
}

private function agent($cap) {
	$chk = strip_tags($cap); if (strlen($chk) < 2) return "";
	$uag = $_SERVER["HTTP_USER_AGENT"];
	$gut = "Firefox";

	if (STR::misses($uag, $gut)) return "";
	return "_moz";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
