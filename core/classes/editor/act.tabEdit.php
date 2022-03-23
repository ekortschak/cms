<?php
/* ***********************************************************
// INFO
// ***********************************************************
web site editor, used to create and manage files

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/tabEdit.php");

$obj = new tabEdit();
$obj->exec();
*
*/

incCls("editor/iniWriter.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tabEdit {

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function exec() {
	if (EDITING != "tedit") return;
	$act = ENV::get("btn.tab");

	if ($act == "T") {
		if ($this->toggle())   return; // turn tabs on/off
		if ($this->tabAdd())   return; // create a new tab
	}
	if ($act == "P") {
		if ($this->setProps()) return; // save props
	}
	if ($act == "R") {
		if ($this->tabSort())  return; // sort tabs
	}
	if ($act == "G") {
 		if ($this->pngTab())  return; // create xx.png files
		if ($this->pngDel())  return; // delete xx.png files
	}
}

// ***********************************************************
// visibility & sort order
// ***********************************************************
private function toggle() {
	$cmd = VEC::get($_POST, "set_act"); if (! $cmd) return false;
	$vls = VEC::get($_POST, "tabs");    if (! $vls) return false;
	$set = VEC::get($_POST, "tabset");  if (! $set) return false;
	$std = VEC::get($_POST, "tab_default");

	$ini = new iniWriter("design/config/tabsets.ini");
	$ini->read("config/tabsets.ini");

	$set = basename($set);

	foreach ($vls as $key => $val) {
		if ($key == $std) $val = "default";
		$ini->set("$set.$key", $val);
	}
	$ini->save();
	return true;
}

// ***********************************************************
private function tabAdd() {
	$cmd = VEC::get($_POST, "tab_act"); if (! $cmd) return false;
	$dir = VEC::get($_POST, "tab_dir"); if (! $dir) return true;
	$set = VEC::get($_POST, "tabset");  if (! $set) return true;

	$dir = FSO::join(APP_DIR, $dir);
	$dir = FSO::force($dir);
	$fil = FSO::join($dir, "tab.ini");
	$dir = FSO::clearRoot($dir);

	$ini = new iniWriter("design/config/tabsets.ini");
	$ini->read($fil);
	$ini->save($fil);

	$fil = "config/tabsets.ini";
	$ini = new iniWriter($fil);
	$ini->set("$set.$dir", 1);
	$ini->save($fil);
	return true;
}

// ***********************************************************
private function tabSort() {
	$cmd = VEC::get($_POST, "sort_act"); if (! $cmd) return false;
	$lst = VEC::get($_POST, "slist");    if (! $lst) return true;
	$set = VEC::get($_POST, "sparm");
	$lst = VEC::explode($lst, ";");

	$ini = new iniWriter("design/config/tabsets.ini");
	$ini->read("config/tabsets.ini");
	$vls = $ini->getValues($set);
	$out = array();

	foreach ($lst as $itm) {
		if (! $itm) continue;
		$out[$itm] = VEC::get($vls, $itm, 1);
	}
	$ini->setValues($set, $out);
	$ini->save();
	return true;
}

// ***********************************************************
// methods for design/tabsets
// ***********************************************************
private function setProps() {
	$chk = VEC::get($_POST, "val_props"); if (! $chk) return false;
	$tab = ENV::get("tab");
	$fil = FSO::join($tab, "tab.ini");

	$std = $chk["std"];
	$std = STR::afterX($std, $tab);
	$chk["std"] = trim($std, "/");

	$ini = new iniWriter("design/config/tab.ini");
	$ini->read($fil);
	$ini->setVals($chk);
	$ini->save($fil);
	return true;
}

// ***********************************************************
// graphic tabs
// ***********************************************************
private function pngDel() {
	$tab = VEC::get($_GET, "tab.drop"); if (! $tab) return false;
	$fil = FSO::join($tab, "tab.png");
	$xxx = FSO::kill($fil);

	foreach (LNG::get() as $lng) {
		$fil = FSO::join($tab, "tab.$lng.png");
		$xxx = FSO::kill($fil);
	}
	return true;
}

private function pngTab() {
	$cmd = VEC::get($_POST, "tab_act");	if (! $cmd) return false;
	$tab = VEC::get($_POST, "tab_name");
	$rep = VEC::get($_POST, "tab_rep");
	$all = VEC::get($_POST, "tab_all");

	foreach (LNG::get() as $lng) {
		$this->pngMake($tab, $lng, $rep);
	}
	return true;
}

private function pngMake($tab, $lng, $rep) {
	$fil = FSO::join($tab, "tab.$lng.png");

	if (is_file($fil)) {
		if (! $rep) return;
		FSO::kill($fil);
	}
	incCls("files/img.php");

	$ini = new iniTab($tab);
	$tit = $ini->getTitle($lng);

	$img = new img();
	$img->create($tit);
	$img->save($fil);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

