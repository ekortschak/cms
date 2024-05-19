<?php

if (VMODE != "tedit") return;

/* ***********************************************************
// INFO
// ***********************************************************
see parent
*/

incCls("editor/tabEdit.php");
incCls("editor/iniWriter.php");

new saveTab();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveTab extends saveMany {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// methods
// ***********************************************************
protected function exec() {
	$btn = $this->env("btn.tab");
	$act = $this->get("tab.act");

	switch ($btn.$act) {
		case "TT": return $this->toggle();   // turn tabs on/off
		case "TA": return $this->tabAdd();   // create a new tab
		case "SS": return $this->tabSort();  // sort tabs
		case "GA": return $this->pngAdd();   // create tab.xx.png files
		case "GD": return $this->pngDel();   // delete tab.xx.png files

		case "P":  return $this->tabProps(); // save props
	}
}

// ***********************************************************
// visibility & sort order
// ***********************************************************
private function toggle() {
	$cmd = $this->get("tab.act"); if (! $cmd) return;
	$set = $this->get("tabset");  if (! $set) return;
	$vls = $this->get("tabs");    if (! $vls) return;
	$lcs = $this->get("tabl");
	$std = $this->get("tab.default");

	$set = basename($set);
	$frc = $lcs[$std];

	$edt = new tabEdit("config/tabsets.ini");

	foreach ($vls as $key => $val) {
		if ($key == $std) $val = "default";
		if ($frc)         $val = "$val, local";
		else {
			$lcl = VEC::get($lcs, $key);
			if ($lcl) $val = "$val, local";
		}
		$edt->set("$set.$key", $val);
	}
	$edt->save();
}

// ***********************************************************
private function tabAdd() {
	$dir = $this->get("tab.dir"); if (! $dir) return;
	$fil = FSO::join($dir, "tab.ini");
	$set = TAB_SET;

	$edt = new tabEdit("config/tabsets.ini"); // register new tab
	$edt->set("$set.$dir", 1);
	$edt->save();

	$edt = new tabEdit($fil); // create default tab.ini
	$edt->save();

	$ini = new iniWriter();
	$ini->read($dir);
	$ini->set(CUR_LANG.".title", basename($dir));
	$ini->set(GEN_LANG.".title", basename($dir));
	$ini->save();
}

// ***********************************************************
private function tabSort() {
	$lst = $this->get("sort.list"); if (! $lst) return;
	$set = $this->get("sort.parm");

	$lst = STR::split($lst, ";");

	$edt = new tabEdit("config/tabsets.ini");
	$vls = $edt->values($set);
	$out = array();

	foreach ($lst as $itm) {
		if (! $itm) continue;
		$out[$itm] = VEC::get($vls, $itm, 1);
	}
	$edt->clearSec($set);
	$edt->setValues($set, $out);
	$edt->save();
}

// ***********************************************************
// methods for design/tabsets
// ***********************************************************
private function tabProps() {
	$cmd = $this->get("act"); if (! $cmd) return;
	$fil = FSO::join(TAB_ROOT, "tab.ini");

	$edt = new tabEdit($fil);
	$edt->savePost();
}

// ***********************************************************
// graphic tabs
// ***********************************************************
private function pngDel() { // remove tab pics
	foreach (LNG::get() as $lng) {
		$fil = FSO::join(TAB_ROOT, "tab.$lng.png");
		$res = FSO::kill($fil);
	}
}

// ***********************************************************
private function pngAdd() { // create tab pics
	foreach (LNG::get() as $lng) {
		$fil = FSO::join(TAB_ROOT, "tab.$lng.png");
		if (is_file($fil)) continue;

		incCls("files/img.php");
		incCls("files/iniTab.php");

		$ini = new iniTab(TAB_ROOT);
		$tit = $ini->title($lng);

		$img = new img();
		$img->create($tit);
		$img->save($fil);
	}
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

