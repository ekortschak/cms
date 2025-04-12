<?php

if (VMODE != "ebook") return;

/* ***********************************************************
// INFO
// ***********************************************************
see parent
*/

incCls("editor/tidyPage.php");

new saveBook();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveBook extends savePage {

function __construct() {
	parent::__construct();
}
// ***********************************************************
// methods
// ***********************************************************
protected function exec() {
	$btn = ENV::get("btn.ebook");

	switch ($btn) {
		case "F": $this->savePbr(); break;
		case "E": $this->saveMod(); break;
	}
}	
	
// ***********************************************************
// save changes to menu props
// ***********************************************************
private function savePbr() {	
	$act = $this->get("act"); if (! $act) return;
	$dir = $this->get("dir");

	$this->setNoprint($dir,);
	$this->setPbrB4($dir);
}	
	
// ***********************************************************
// save modifications to file content
// ***********************************************************
protected function saveMod() {	
	$act = $this->get("file.act");

	switch (STR::left($act)) {
		case "sav": return $this->savePage();
		case "dro": return $this->dropFile();
		case "res": return $this->restore();
		case "bac": return $this->backup();

		case "cle": 
			$fil = ENV::get("filName");
			return $this->dropPbr($fil);
	}
}

// ***********************************************************
// remove pagebreaks from files
// ***********************************************************
private function setNoprint($dir) {
	$new = $this->get("noprint");
	$old = $this->noprint($dir); if ($new == $old) return;

	$ini = new iniWriter();
	$ini->read($dir);
	$ini->setNoprint($new);
	$ini->save();
}

// ***********************************************************
// whole chapter
// ***********************************************************
private function setPbrB4($dir) {
	$new = $this->get("pbrB4");
	$old = $this->hasPbr($dir); if ($new == $old) return;

	$arr = FSO::ftree($dir, "page.ini");

	foreach ($arr as $fil => $nam) {
		$ini = new iniWriter();
		$ini->read($dir);
		$ini->setPbreak($new);
		$ini->save();

		$val = 0; // remove pagebreaks from sub chapters
	}

	$arr = FSO::ftree($dir, "page.".CUR_LANG.".htm");

	foreach ($arr as $fil => $nam) {
		$this->dropPbr($fil);
	}
}

// ***********************************************************
// single files
// ***********************************************************
private function noprint($dir) {
	$ini = new ini($dir);
	$out = $ini->get("props.noprint");
	return $out ? 1 : 0;
}

private function hasPbr($dir) {
	$ini = new ini($dir);
	$out = $ini->get(CUR_LANG.".pbreak");
	return $out ? 1 : 0;
}

private function dropPbr($fil) {
	APP::strip($fil, PAGE_BREAK);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
