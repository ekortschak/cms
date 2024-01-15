<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify handling of data editing using selectors

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/recEdit.php");

$dbe = new recEdit($dbase, $table);
$dbe->setDefault($field, $value);
$dbe->setProp($field, $prop, $value);
$dbe->findRec($filter);
$dbe->permit("w | ae, ad, ed, a, e, d | r | x"); // set table perms
$dbe->show();

*/

incCls("dbase/fldEdit.php");
incCls("dbase/fldFilter.php");
incCls("dbase/dbBasics.php");
incCls("dbase/dbInfo.php");

incCls("other/items.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class recEdit extends dbBasics {
	protected $fds = array(); // array of fields in $tbl; class = items
	protected $std = array(); // current default values

	protected $txs = "x"; // permissions (table and fields)
	protected $qid = -1;
	protected $neu = true;
	protected $btn = "";

function __construct($dbase = "default", $table = NV) {
	parent::__construct($dbase, $table);

	$this->register("$dbase.$table");
	$this->setTable($table);
	$this->forget();

	$this->fds = new items();
	$inf = $this->tblProps($table);

	$this->permit($inf["perms"]);
	$this->findDefaults();
}

// ***********************************************************
// setting field info
// ***********************************************************
public function findRec($recID = -1) {
	$flt = $recID; if (is_numeric($recID)) $flt = "ID='$recID'";
	$arr = $this->query($flt);

	$this->qid = -1;
	$this->fds = $this->std; if (! $arr) return;

	foreach ($arr as $fld => $val) {
		$this->fds->addItem($fld);
		$this->fds->setProp($fld, "value", $val);
	}
	$this->qid = $this->fds->getProp("ID", "value", -1);
	$this->neu = ($this->qid < 1);
}

// ***********************************************************
// retrieve default values
// ***********************************************************
public function findDefaults() {
	$this->std = new items();
	$this->qid = -1;

	$dbi = new dbInfo($this->dbs, $this->tbl);
	$fds = $dbi->fields($this->tbl); if (!$fds) return;

	foreach ($fds as $fld => $hed) {
		$inf = $this->fldProps($this->tbl, $fld);
		$this->std->addItem($fld);

		foreach ($inf as $prp => $val) {
#			$val = CFG::apply($val);
			if ($prp == "value")
			$val = $this->recall($fld, $val);

			$this->std->setProp($fld, $prp, $val);
		}
		$this->std->setProp($fld, "head", $hed);
	}
}

// ***********************************************************
// retrieving current values
// ***********************************************************
public function getRec() {
	$out = array();
	foreach ($this->fds as $fld => $inf) {
		$out[$fld] = VEC::get($inf, "value");
	}
	return $out;
}
public function getCurVal($field, $default = NV) {
	$rec = $this->getRec();
	return VEC::get($rec, $field, $default);
}

private function chkVal($inf, $prm) {
	if ($prm == "a")
	return VEC::get($inf, "fstd");
	return VEC::get($inf, "value");
}

// ***********************************************************
// setting properties
// ***********************************************************
public function mergeProps($arr) { // $arr set by items->getitems();
	foreach ($arr as $name => $props) {
		foreach ($props as $key => $val) {
			$this->setProp($name, $key, $val);
		}
	}
}

public function setDefault($field, $val) {
	$this->setProp($field, "fstd", $val);
}

public function setProp($field, $prop, $val) {
	$this->std->setProp($field, $prop, $val); if ($prop == "fstd")
	$this->std->setProp($field, "value", $val); ;
}
public function setType($field, $type) {
	$this->std->setProp($field, "dtype", $type);
}

// ***********************************************************
public function hide($fields) { $this->setFProps($fields, "perms", "h"); }
public function lock($fields) {	$this->setFProps($fields, "perms", "r"); }
public function skip($fields) {	$this->setFProps($fields, "perms", "x"); }

private function setFProps($fields, $prop, $value) {
	$arr = STR::toArray($fields);

	foreach ($arr as $fld) {
		$this->setProp($fld, $prop, $value);
	}
}

// ***********************************************************
// disable features
// ***********************************************************
public function enable($button = "t") {
	$this->btn.= $button;
}

// ***********************************************************
// output form
// ***********************************************************
public function show() {
	echo $this->gc();
}

public function gc() {
	$fds = $this->fds->getItems(); $cnt = 0;
	$txs = $this->getTPerms();

	$tan = TAN::register($this->dbs, $this->tbl, $this->qid);
	$xxx = $this->hold("tan", $tan);

	$fed = new fldEdit($this->dbs);
	$fed->set("oid", $this->oid);
	$fed->set("tan", $tan);
	$fed->set("perms", $txs);

	foreach ($fds as $fld => $inf) {
		$val = $this->chkVal($inf, $txs); $cnt++;
		$fed->add($inf, $val);
	}
	$sec = "main"; if ($cnt < 1)
	$sec = "no.perms";

	if (STR::misses($this->btn, "t")) $fed->clearSec("buttons");
	return $fed->gc($sec);
}

public function act() {
	return ENV::getPost("rec.act", false);
}

// ***********************************************************
// handling permissions
// ***********************************************************
public function permit($perms = "r") { // table perms only
	if (! DB_LOGIN) $perms = "r";
	$this->txs = $perms;
}

// ***********************************************************
protected function getTPerms() {
	$txs = $this->txs;

	if ($txs == "x") return "x";
	if ($txs == "r") return "r"; if ($this->neu) return "a";
	return $txs;
}
protected function getFPerms($inf) {
	$txs = $this->txs;
	if ($txs == "x") return "x";
	if ($txs == "r") return "r";

	return $inf["perms"];
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
