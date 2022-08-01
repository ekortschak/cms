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

	switch ($act) {
		case "P": if ($this->setProps()) return; // save props
		case "T": if ($this->toggle())   return; // turn tabs on/off
		          if ($this->tabAdd())   return; // create a new tab
		case "S": if ($this->tabSort())  return; // sort tabs
		case "G": if ($this->pngTab())   return; // create xx.png files
		          if ($this->pngDel())   return; // delete xx.png files
	}
}

// ***********************************************************
// visibility & sort order
// ***********************************************************
private function toggle() {
	$cmd = ENV::getPost("set.act"); if (! $cmd) return false;
	$set = ENV::getPost("tabset");  if (! $set) return false;
	$vls = ENV::getPost("tabs");    if (! $vls) return false;
	$lcs = ENV::getPost("tabl");
	$std = ENV::getPost("tab.default");

	$ini = new iniWriter("design/config/tabsets.ini");
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
	return true;
}

// ***********************************************************
private function tabAdd() {
	$cmd = ENV::getPost("tab_act"); if (! $cmd) return false;
	$dir = ENV::getPost("tab_dir"); if (! $dir) return true;
	$set = APP_CALL;

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
	$cmd = ENV::getPost("sort_act"); if (! $cmd) return false;
	$lst = ENV::getPost("slist");

	if (! $lst) return true;
	$set = ENV::getPost("sparm");
	$lst = VEC::explode($lst, ";");

	$ini = new iniWriter("design/config/tabsets.ini");
	$ini->read("config/tabsets.ini");
	$vls = $ini->getValues($set);
	$out = array();

	foreach ($lst as $itm) {
		if (! $itm) continue;
		$out[$itm] = VEC::get($vls, $itm, 1);
	}
	$ini->clearSec($set);
	$ini->setValues($set, $out);
	$ini->save();
	return true;
}

// ***********************************************************
// methods for design/tabsets
// ***********************************************************
private function setProps() {
	$chk = ENV::getPost("val_props"); if (! $chk) return false;
	$tab = ENV::get("tab");
	$fil = FSO::join($tab, "tab.ini");

	$std = $chk["std"];
	$std = STR::afterX($std, $tab);
	$chk["std"] = trim($std, "/");

	$ini = new iniWriter("design/config/tab.ini");
	$ini->read($fil);
	$ini->getPost();
	$ini->setVals($chk);
	$ini->save($fil);
	return true;
}

// ***********************************************************
// graphic tabs
// ***********************************************************
private function pngDel() {
	$tab = ENV::getParm("tab.drop"); if (! $tab) return false;
	$fil = FSO::join($tab, "tab.png");
	$xxx = FSO::kill($fil);

	foreach (LNG::get() as $lng) {
		$fil = FSO::join($tab, "tab.$lng.png");
		$xxx = FSO::kill($fil);
	}
	return true;
}

private function pngTab() {
	$cmd = ENV::getPost("tab.act");	if (! $cmd) return false;
	$tab = ENV::getPost("tab.name");
	$rep = ENV::getPost("tab.rep");
	$all = ENV::getPost("tab.all");

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

