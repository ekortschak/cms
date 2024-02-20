<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify modification of db objects.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/dbBasics.php");

$dbo = new dbBasics($dbase);
$dbo->setTable($table);
$dbo->setField($table, $fields);
$dbo->setWhere($filter);
$dbo->setOrder($order);

$inf = $dbo->getStmt($key);

*/

incCls("dbase/sqlStmt.php");
incCls("input/confirm.php");

// ***********************************************************
// Begin of Class
// ***********************************************************
class dbBasics extends sqlStmt {
	protected $dbo = false;
	protected $dbs = false;
	protected $con = false;

	protected $inf = array(); // info about last query


function __construct($dbase = "default") {
	$inf = CFG::iniGroup("dbase:$dbase"); if (! $inf) return;
	extract($inf); // set connection vars

	$ful = FSO::join(LOC_CLS, "dbase", "$type.php");
	$ful = APP::file($ful); if (! is_file($ful)) return;

	require_once($ful); // load db class

	$this->dbo = new $type($host, $file);
	$this->con = $this->dbo->connect($user, $pass);
	$this->dbs = $dbase;

	parent::__construct($type); // read syntax
}

// ***********************************************************
// retrieving dbase info
// ***********************************************************
public function isDbase($dbs) {
    $arr = $this->get1st("inf.dbs");
    return in_array($dbs, $arr);
}

public function getState() {
	return $this->con;
}

public function selectDb($dbase) {
	if (! $this->con) return;
	$this->dbo->selectDb($dbase);
}

// ***********************************************************
// executing statements / queries / scripts
// ***********************************************************
public function run($script) {
	foreach (explode(";", $script) as $sql) {
		$this->exec($sql);
	}
}
public function exec($sql) {
	if ( ! $this->con) return false;
	return $this->inf = $this->dbo->exec($sql);
}

public function query($filter = 1, $order = false) {
	$this->setWhere($filter);
	$this->setOrder($order);
	$this->setLimit(1);
	return $this->get1st("sel.sel"); // one record at a time
}

// ***********************************************************
// retrieving data
// ***********************************************************
public function getData($flt = 1) { // get data in csv format
	$xxx = $this->setWhere($flt); $out = array();
	$dat = $this->getRecs(); if (! $dat) return "";

	foreach ($dat as $num => $rec) {
		$out[] = '"' . implode('";"', $rec) . '"' ;
	}
	return implode("\n", $out);
}

public function getRecs($stmt = "sel.sel", $mds = "a") {
	if (! $this->con) return false;

	$xxx = $this->setLimit(99);
	$sql = $this->getStmt($stmt); if (! $sql) return array();
	$sql = $this->chkStmt($sql);

	return $this->dbo->fetch($sql, $mds);
}

public function get1st($stmt = "sel.sel", $mds = "a") {
	if (! $this->con) return false;

	$xxx = $this->setLimit(1);
    $sql = $this->getStmt($stmt); if (! $sql) return array();
	$sql = $this->chkStmt($sql);

	return $this->dbo->fetch1st($sql, $mds);
}

protected function getCol($recs, $field) {
	$out = array();
	foreach ($recs as $itm) {
    	$fld = $itm[$field];
		$out[$fld] = $fld;
	}
	return $out;
}

// ***********************************************************
// retrieving table info
// ***********************************************************
public function isTable($table) {
	$this->setMasks($table);
    return (bool) $this->get1st("inf.tbs");
}

public function tblProps($table) {
	$out = $this->appProps("tbl", $table);
	$txs = $this->tblPerms($table);
	$out["perms"] = $txs;
	return $out;
}

public function getPrimary() {
	$arr = $this->get1st("inf.idx"); if (! $arr) return false;
	return $arr["Column_name"];
}

// ***********************************************************
// retrieving field info
// ***********************************************************
public function isField($table, $field) {
	$this->set("tab", $table);
	$this->setMasks($table, $field);
    return (bool) $this->get1st("inf.fld");
}

public function fldProps($table, $field) {
	if (! $this->dbo) return array();

	$dbo = $this->dbo->fldProps($table, $field);
	$app = $this->appProps("fld", "$table.$field");
	$txs = $this->tblPerms($table);
	$fxs = $this->fldPerms($table, $field, $txs);

	$out = array_merge($dbo, $app); // props overruled by app
	$out["perms"] = $fxs;
	return $out;
}

public function getDVs($fields, $filter = 1, $sep = " ") {
	$this->setFields($fields, true, false);
	$this->setWhere($filter);

	$arr = $this->getRecs("sel.dvs"); if (! $arr) return false;
	$out = array();

	foreach ($arr as $rec) {
		$key = array_shift($rec);
		$val = implode($sep, $rec); if (! $val) $val = $key;
		$out[$key] = $val;
	}
	return $out;
}

// ***********************************************************
// retrieving data
// ***********************************************************
public function isRecord($filter = 1) {
	$this->setWhere($filter);
	$out = $this->get1st("sel.fnd");
	return (bool) $out;
}

public function rowCount($filter = 1) {
	$this->setWhere($filter);
	$arr = $this->get1st("sel.cnt");
	return $arr[0];
}

// ***********************************************************
// handling transactions
// ***********************************************************
public function ta_hold()     { return $this->xact("bgn"); }
public function ta_commit()   { return $this->xact("cmt"); }
public function ta_rollback() { return $this->xact("rbk"); }

protected function xact($wht) {
	if ( ! $this->con) return false;
    $qry = $this->getStmt("hold.$wht");
    return $this->exec($qry);
}

// ***********************************************************
// data manipulation
// ***********************************************************
public function askMe($value = true) {
	$this->ask = (bool) $value;
}

protected function confirm($qry) {
	if (! $this->ask) return true;

	$cnf = new confirm();
	$cnf->add($this->beautify($qry));
	$cnf->show();

	return $cnf->act();
}

// ***********************************************************
// dbo properties
// ***********************************************************
public function setPerms($perms) { // overruling access permissions
	$this->set("perms", $perms);
}

// ***********************************************************
private function appProps($cat, $idx) {
	$out = array(); if (! $this->isTable("dbobjs")) return $out;

	$sql = "SELECT * FROM `dbobjs` WHERE (cat='$cat' AND spec='$idx')";
    $arr = $this->dbo->fetch($sql); if (! $arr) return $out;

    foreach ($arr as $vls) {
		$key = VEC::get($vls, "prop");
		$val = VEC::get($vls, "value");
		$out[$key] = $val;
	}
	return $out;
}

// ***********************************************************
private function userPerms($cat, $idx) {
	if (! $this->isTable("dbxs")) return "x";

	$sql = "SELECT USR_GRPS FROM `dbxs` WHERE (cat='$cat' AND spec='$idx')";
	$arr = $this->dbo->fetch1st($sql); if (! $arr) return "x";
	return implode("", $arr);
}

// ***********************************************************
private function tblPerms($tbl) {
	$prm = $this->userPerms("tbl", $tbl);

	if (STR::contains($prm, "w")) return "w"; $out = "";
	if (STR::contains($prm, "a")) $out.= "a";
	if (STR::contains($prm, "e")) $out.= "e";
	if (STR::contains($prm, "d")) $out.= "d"; if ($out) return $out;
	if (STR::contains($prm, "r")) return "r";
	return "x";
}

private function fldPerms($tbl, $fld, $inherited = "w") {
	$prm = $this->userPerms("fld", "$tbl.$fld");

	if ($inherited == "r") return "r";
	if ($inherited == "x") return "x";

	if (STR::contains($prm, "w")) return "w";
	if (STR::contains($prm, "r")) return "r";
	return "x";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
