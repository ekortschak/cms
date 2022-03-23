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
$dbe->findRec($filter);
$dbe->permit("w | ae, ad, ed, a, e, d | r | x"); // set table perms
$dbe->show();

*/

incCls("dbase/fldEdit.php");
incCls("dbase/fldFilter.php");
incCls("dbase/dbBasics.php");
incCls("dbase/dbInfo.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class recEdit extends dbBasics {
	protected $fds = array(); // arry of fields in $tbl
	protected $rec = array(); // current record

	protected $txs = "x"; // permissions (table and fields)
	protected $neu = true;
	protected $sel;
	protected $btn = "";

function __construct($dbase, $table) {
	parent::__construct($dbase, $table);

	$this->setOID();
	$this->fds = new items();

	$inf = $this->tblProps($table);
	$this->permit($inf["perms"]);
}

// ***********************************************************
// setting field info
// ***********************************************************
public function findRec($recID = -1) {
	$this->rec = $this->findDefaults($recID); $qid = $this->rec["ID"];
	$this->neu = (! $qid);

	$tan = TAN::open($this->dbs, $this->tbl, $qid);
	$this->set("tan", $tan);

	$vls = $this->getOIDs(); // provide last value entered

    foreach ($this->rec as $fld => $val) {
		$inf = $this->fldProps($this->tbl, $fld);

		$inf["value"] = $val; if (! $qid) // provide default values
		$inf["value"] = VEC::get($vls, $fld, $val);

		$this->fds->addItem($fld, $inf);
    }
}

// ***********************************************************
// retrieve data or default values
// ***********************************************************
public function findDefaults($recID) {
	$flt = $recID; if (is_numeric($recID)) $flt = "ID='$recID'";
	$arr = $this->query($flt); if ($arr) return $arr;
	$out = array("ID" => -1); // no data

	$dbi = new dbInfo($this->dbn, $this->tbl);
	$fds = $dbi->fields($this->tbl); if (!$fds) return $out;

	foreach ($fds as $fld => $val) {
		$inf = $this->fldProps($this->tbl, $fld);
		$out[$fld] = VEC::get($inf, "fstd", "");
	}
	return $out;
}

// ***********************************************************
// retrieving current values
// ***********************************************************
public function getRec() {
	return $this->rec;
}
public function getCurVal($colIndex, $default = NV) {
	return VEC::get($this->rec, $colIndex, $default);
}

private function chkVal($inf, $prm) {
	$out = VEC::get($inf, "fstd"); if ($prm != "a")
	return VEC::get($inf, "value", $out);
	return $out;
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
public function setProp($field, $prop, $val) {
	$this->fds->setProp($field, $prop, $val);
}
public function setType($field, $type) {
	$this->fds->setProp($field, "dtype", $type);
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
	$txs = $this->getTPerms(); $cnt = 0;
	$fds = $this->fds->getItems();

	$sel = new fldEdit();
	$sel->set("oid", $this->get("oid"));
	$sel->set("tan", $this->get("tan"));

	foreach ($fds as $fld => $inf) {
		$fxs = $this->getFPerms($inf); if ($fxs == "x") continue;
		$val = $this->chkVal($inf, $txs);
		$cnt++;

		$sel->add($inf, $fxs, $val);
	}
	if ($cnt < 1) {
		return $sel->getSection("no.perms");
	}
	$sel->set("perms", $txs);
	if (! STR::contains($this->btn, "t")) $sel->setSec("tblLink", "");

	return $sel->gc();
}

public function act() {
	return ENV::getPost("rec.act", false);
}

// ***********************************************************
// handling permissions
// ***********************************************************
public function permit($perms = "r") { // table perms only
	$this->txs = $perms; // $key => table.field
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
// debugging
// ***********************************************************
public function dump() {
	$this->fds->dump();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
