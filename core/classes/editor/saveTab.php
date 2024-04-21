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

	switch ($this->env("btn.tab")) {
		case "G": return $this->exec();
	}
}

// ***********************************************************
// methods
// ***********************************************************
protected function exec() {
	$act = $this->env("btn.tab");

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
	$cmd = $this->get("set.act"); if (! $cmd) return;
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
	$cmd = $this->get("tab.act"); if (! $cmd) return;
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
	$cmd = $this->get("sort.act");  if (! $cmd) return;
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
	$tab = $this->env("tedit.tab"); if (! $tab) return;
	$fil = FSO::join($tab, "tab.ini");

	$edt = new tabEdit($fil);
	$edt->savePost();

	ENV::set("tab", $tab);
	ENV::set("tpc", $tpc);
}

// ***********************************************************
// graphic tabs
// ***********************************************************
private function tabPics() { // execute pic related tasks
	switch (ENV::getParm("tab.act")) {
		case "add":  return $this->pngTab();
		case "drop": return $this->pngDel();
	}
}

// ***********************************************************
private function pngDel() { // remove tab pics
	foreach (LNG::get() as $lng) {
		$fil = FSO::join(TAB_ROOT, "tab.$lng.png");
		$res = FSO::kill($fil);
	}
}

// ***********************************************************
private function pngTab() { // create tab pics
	foreach (LNG::get() as $lng) {
		$fil = FSO::join(TAB_ROOT, "tab.$lng.png");
		if (is_file($fil)) continue;

		incCls("files/img.php");

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

