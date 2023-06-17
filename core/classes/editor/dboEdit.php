<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create lists for input objects for ini Files
* e.g. props, title ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("forms/dboEdit.php");

$edi = new dboEdit();
$edi->addField($prop, $vals, $val);
$edi->show();
*/

incCls("menus/dropDbo.php");
incCls("dbase/dbInfo.php");
incCls("input/selAuto.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dboEdit extends selAuto {
	private $dbs = false;	// db name
	private $tbl = false;	// db table
	private $fld = false;	// db field
	private $prp = array();	// field props from db

	private $secs = array(); // secs from ini
	private $vals = array(); // props from ini

	private $mod = "t";

function __construct($mod = "t") {
	parent::__construct();

	$mod = strtolower($mod);
	$this->mod = "t"; if ($mod == "f")
	$this->mod = "f";

	$this->forget();
	$this->readIni();
}

// ***********************************************************
// separate forms for props and lang props
// ***********************************************************
public function edit() {
	$this->showMenu($act);
	$this->readInfo();

	HTW::xtag("props");
	$this->addHidden($this->mod."cProps");
	$this->addTblProps();
	$this->show();

	HTW::xtag("lang.props");
	$this->addHidden($this->mod."lProps");
	$this->addLangs();
	$this->show();
}

// ***********************************************************
// setting ambience
// ***********************************************************
private function showMenu($act) {
	$box = new dropDbo();
	$this->dbs = $box->getDbase();
$this->dbs = "default";
	$this->tbl = $box->getTable($this->dbs); if ($this->mod == "f")
	$this->fld = $box->getField($this->dbs, $this->tbl);
	$box->show();
}

// ***********************************************************
private function readInfo() {
	$dbi = new dbInfo($this->dbs, $this->tbl);
	$this->inf = $dbi->tblProps($this->tbl);

	$this->fldProps($dbi->fldProps($this->tbl, $this->fld));
	$this->showFields($dbi->fields($this->tbl));
}

// ***********************************************************
private function readIni() {
	$fil = "LOC_CFG/db.tables.def"; if ($this->mod == "f")
	$fil = "LOC_CFG/db.fields.def";

	$ini = new ini($fil);
	$this->secs = $ini->getSecs();
	$this->vals = $ini->getValues();
}

// ***********************************************************
// retrieving db info
// ***********************************************************
private function showFields($fds) {
	if ($this->mod != "t") return;
	HTW::xtag("fds.available");

	foreach ($fds as $key => $val) {
		echo "<label>$key</label> ";
	}
}

private function fldProps($inf) {
	if ($this->mod != "f") return;
	$inf["default"] = $inf["fstd"];
	$this->prp = $inf;
}

// ***********************************************************
// adding fields
// ***********************************************************
private function addTblProps() {
	foreach ($this->secs as $prp) {
		$this->addTblProp($prp);
	}
}
private function addTblProp($prp) {
	$dat = VEC::match($this->vals, prp);
	$cap = VEC::lng(CUR_LANG, $dat, "head", $prp);

	$typ = VEC::get($dat, "dtype");
	$val = VEC::get($dat, "default");
	$vls = VEC::get($dat, "values");
	$hnt = VEC::get($dat, "hint");

	$val = VEC::get($this->inf, $prp, $val);

	$this->addField("prop[$prp]", $vls, $val);
	$this->setProp("title", $cap);
	$this->setProp("hint", $hnt);
}

// ***********************************************************
private function addFldProp($prp) {
	$dat = VEC::match($this->vals, prp);
	$cap = VEC::lng(CUR_LANG, $dat, "head", $prp);

	$typ = VEC::get($dat, "dtype");
	$val = VEC::get($dat, "default");
	$vls = VEC::get($dat, "values");
	$hnt = VEC::get($dat, "hint");

	$val = VEC::get($inf, $prp, $val);

	if ($prp == "input") {
		$this->ronly("fld.type", $typ);
		if (STR::features("mem.cur", $typ)) return;
	}
	if ($prp == "mask") {
		if (STR::features("mem", $typ)) return;
	}
	$this->addField("prop[$prp]", $vls, $val);
	$this->setProp("title", $cap);
	$this->setProp("hint", $hnt);
}

// ***********************************************************
private function addLangs() {
	$dbo = $this->tbl; if ($this->mod == "f")
	$dbo = $this->fld;

	foreach (LNG::get() as $lng) {
		$this->addLang($lng, $dbo);
	}
}
private function addLang($lng, $dbo) {
	$tit = VEC::lng($lng, $this->inf, "head", $dbo);
	$flg = HTM::flag($lng);

	$this->input("head[$lng]", $tit);
	$this->setProp("title", $flg);
}

// ***********************************************************
private function addhide($mod) {
	$this->hide("dbo", "dboEdit");
	$this->hide("dbs", $this->dbs);
	$this->hide("tbl", $this->tbl); if ($this->mod == "f")
	$this->hide("fld", $this->tbl. "." .$this->fld);
	$this->hide("chk", $mod);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
