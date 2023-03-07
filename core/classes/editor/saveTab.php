<?php
/* ***********************************************************
// INFO
// ***********************************************************
web site editor, used to create and manage files

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/saveTab.php");

$obj = new saveTab();
$obj->exec();
*
*/

incCls("editor/iniWriter.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveTab {

function __construct() {
	if (EDITING != "tedit") return;
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
private function exec() {
	$act = ENV::get("btn.tab");

	switch ($act) {
		case "T": return $this->toggle();   // turn tabs on/off
		case "A": return $this->tabAdd();   // create a new tab
		case "P": return $this->tabProps(); // save props
		case "S": return $this->tabSort();  // sort tabs
		case "G": return $this->tabPics();  // handle tab.xx.png files
	}
}

// ***********************************************************
// visibility & sort order
// ***********************************************************
private function toggle() {
	$cmd = ENV::getPost("set.act"); if (! $cmd) return;
	$set = ENV::getPost("tabset");  if (! $set) return;
	$vls = ENV::getPost("tabs");    if (! $vls) return;
	$lcs = ENV::getPost("tabl");
	$std = ENV::getPost("tab.default");

	$ini = new iniWriter("LOC_CFG/tabsets.def");
	$ini->read("config/tabsets.ini");

	$set = basename($set);
	$frc = $lcs[$std];

	foreach ($vls as $key => $val) {
		if ($key == $std) {
			$val = "default";
		}
		if ($frc) $val = "$val, local";
		else {
			$lcl = VEC::get($lcs, $key);
			if ($lcl) $val = "$val, local";
		}
		$ini->set("$set.$key", $val);
	}
	$ini->save();
}

// ***********************************************************
private function tabAdd() {
	$cmd = ENV::getPost("tab_act"); if (! $cmd) return;
	$dir = ENV::getPost("tab_dir"); if (! $dir) return;
	$set = APP_CALL;

	$dir = FSO::join(APP_DIR, $dir);
	$dir = FSO::force($dir);
	$fil = FSO::join($dir, "tab.ini");
	$dir = APP::relPath($dir);

	$ini = new iniWriter("LOC_CFG/tabsets.def");
	$ini->read($fil);
	$ini->save($fil);

	$fil = "config/tabsets.ini";
	$ini = new iniWriter($fil);
	$ini->set("$set.$dir", 1);
	$ini->save($fil);
}

// ***********************************************************
private function tabSort() {
	$cmd = ENV::getPost("sort_act"); if (! $cmd) return;
	$lst = ENV::getPost("slist");

	if (! $lst) return;
	$set = ENV::getPost("sparm");
	$lst = VEC::explode($lst, ";");

	$ini = new iniWriter("LOC_CFG/tabsets.def");
	$xxx = $ini->read("config/tabsets.ini");
	$vls = $ini->getValues($set);
	$out = array();

	foreach ($lst as $itm) {
		if (! $itm) continue;
		$out[$itm] = VEC::get($vls, $itm, 1);
	}
	$ini->clearSec($set);
	$ini->setValues($set, $out);
	$ini->save();
}

// ***********************************************************
// methods for design/tabsets
// ***********************************************************
private function tabProps() {
	$arr = ENV::getPost("props"); if (! $arr) return;
	$tab = ENV::get("tedit.tab");
	$fil = FSO::join($tab, "tab.ini");

	$std = $arr["std"];
	$stp = STR::afterX($std, $tab);
	$arr["std"] = trim($stp, "/");

	$ini = new iniWriter("LOC_CFG/tab.def");
	$ini->read($fil);
	$ini->setVals($arr);
	$ini->save($fil);

	if ($arr["typ"] == "select") {
		ENV::set("tab", $tab);
		ENV::set("tpc", $std);
	}
	else {
		ENV::set("tab", $tab);
		ENV::set("tpc", "");
	}
}

// ***********************************************************
// graphic tabs
// ***********************************************************
private function tabPics() { // execute pic related tasks
	$act = ENV::getParm("tab.act"); if (! $act) return;

	switch ($act) {
		case "add":  return $this->pngTab();
		case "drop": return $this->pngDel();
	}
}

// ***********************************************************
private function pngDel() { // remove tab pics
	foreach (LNG::get() as $lng) {
		$fil = FSO::join(TAB_ROOT, "tab.$lng.png");
		$xxx = FSO::kill($fil);
	}
}

// ***********************************************************
private function pngTab() { // create tab pics
	foreach (LNG::get() as $lng) {
		$fil = FSO::join(TAB_ROOT, "tab.$lng.png");
		if (is_file($fil)) continue;

		incCls("files/img.php");

		$ini = new iniTab(TAB_ROOT);
		$tit = $ini->getTitle($lng);

		$img = new img();
		$img->create($tit);
		$img->save($fil);
	}
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

