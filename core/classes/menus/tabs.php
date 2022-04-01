<?php
/* ***********************************************************
// INFO
// ***********************************************************
Handles side navigation (vertical tabs)

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/tabs.php");

$nav = new tabs("tabs" | "tabs.top");
$nav->readCfg();
$nav->show();
*/

incCls("menus/tabset.php");
incCls("files/iniTab.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tabs extends tpl {
	private $dat = array();
	private $cos = "";

function __construct($typ = "tabs") {
	parent::__construct();

	$this->read("design/templates/menus/$typ.tpl");
	$this->cos = $this->getOS();
}

// ***********************************************************
// methods
// ***********************************************************
public function readCfg() {
	$tbs = new tabset();
	$this->dat = $tbs->getTabs();
}

public function remove($key) {
	unset($this->dat[$key]);
}

public function getTopics($dir = TAB_ROOT) {
	$vis = (! IS_LOCAL);
	$arr = FSO::folders($dir, $vis); $out = array();

	foreach ($arr as $dir => $nam) {
		$cap = HTM::pgeTitle($dir);
		$lnk = FSO::clearRoot($dir);
		$out[$lnk] = $cap;
	}
	return $out;
}

public function getTypes() {
	return array(
		"root"   => "single topic",
		"select" => "multiple topics"
	);
}

// ***********************************************************
// display
// ***********************************************************
public function gc($sec = "main") {
	$lng = CUR_LANG; $out = "";

	foreach ($this->dat as $tab => $cap) {
		if (! APP::dir($tab)) continue;

		$itm = "item";
		$img = APP::find($tab, "tab", "png"); if ($img) $itm = "item.img";

		$this->set("link",  FSO::clearRoot($tab));
		$this->set("mode",  $this->getMode());
		$this->set("text",  $cap);
		$this->set("class", $this->getClass($tab));
		$this->set("dir",   $this->getOrientation($cap));
		$this->set("os",    $this->cos);
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
	if (STR::contains(EDITING, "edit")) return EDITING;
	return "view";
}

private function getClass($dir) {
	if (STR::begins(TOP_PATH, $dir)) return "active";
	return "std";
}

private function getOrientation($cap) {
	$chk = strip_tags($cap); if (strlen($chk) < 2) return "";
	return "vertical";
}

// ***********************************************************
// client related functions
// ***********************************************************
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
