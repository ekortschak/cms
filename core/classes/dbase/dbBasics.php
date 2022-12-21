<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify modification of db objects.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/dbBasics.php");

$dbo = new dbBasics($dbase, $table);
$dbo->setQuery($table, $fields, $filter, $order);
$dbo->setTable($table);

$inf = $dbo->fetch($key);

*/

incCls("dbase/sqlStmt.php");
incCls("input/confirm.php");

// ***********************************************************
// Begin of Class
// ***********************************************************
class dbBasics extends sqlStmt {
	protected $dbo = false;
	protected $con = false;
	protected $dbs = NV;
	protected $tbl = "dummy";

function __construct($dbase, $table = "dummy") {
	$ini = new ini("config/dbase.ini");
	$this->dbs = $ini->get("dbase.file");
	$this->usr = $ini->get("dbase.user");
	$this->pwd = $ini->get("dbase.pass");
	$this->tbl = $table;
	$typ = DB_MODE;

	if ($dbase !== NV) $this->dbs = $dbase;

	$sql = APP::file("core/classes/dbase/$typ.php"); if (! $sql) return;

	$this->init($typ); // read sql syntax
	$this->setTable($table);
	$this->setQuery($table, "*", 1);

	incCls("dbase/$typ.php");

	$this->dbo = new $typ("localhost", $this->dbs);
	$this->con = $this->dbo->connect($this->usr, $this->pwd);
}

public function isDbase($dbs) {
    $arr = $this->get1st("inf.dbs");
    return in_array($dbs, $arr);
}

public function selectDb($dbase) {
	if (! $this->con) return;
	$this->dbo->selectDb($dbase);
}

public function getState() {
	return $this->con;
}

// ***********************************************************
// user access
// ***********************************************************
public function setPerms($perms) { // overruling access permissions
	$this->set("perms", $perms);
}

// ***********************************************************
// executing statements / queries / scripts
// ***********************************************************
public function run($script) {
	foreach (explode(";", $script) as $sql) {
		$this->exec($sql);
	}
}
public function exec($sql, $mode) {
	if ( ! $this->con) return false;
	$inf = $this->dbo->exec($sql);

	switch ($mode) {
		case "ins": return $inf["lid"];
		case "upd": return $inf["aff"];
		case "del": return $inf["aff"];
	}
	return $inf["res"];
}

public function query($filter = 1, $order = false) {
	$this->setFilter($filter);
	$this->setOrder($order);
	$this->setLimit(1);
	return $this->get1st("sel.sel"); // one record at a time
}


// ***********************************************************
public function getData($flt = 1) {
	$xxx = $this->setFilter($flt); $out = array();
	$dat = $this->getRecs(); if (! $dat) return "";

	foreach ($dat as $num => $rec) {
		$out[] = '"' . implode('";"', $rec) . '"' ;
	}
	return implode("\n", $out);
}

public function getRecs($stmt = "sel.sel", $mds = "a") {
	if (! $this->con) return false;

	$xxx = $this->setLimit(99);
	$sql = $this->fetch($stmt);

	return $this->dbo->fetch($sql, $mds);
}
public function get1st($stmt = "sel.sel", $mds = "a") {
	if (! $this->con) return false;

	$xxx = $this->setLimit(1);
    $sql = $this->fetch($stmt); if (! $sql) return array();
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

public function fetch1st($sql, $mds = "a") {
	if (! $this->con) return false;
	return $this->dbo->fetch1st($sql, $mds);
}

// ***********************************************************
// retrieving dbase info
// ***********************************************************
public function setDb($file) {
	$typ = "mysql";
	incCls("dbase/$typ.php");

	$dbs = new $typ("localhost", $file);
	$con = $dbs->connect(CUR_USER, CUR_PASS);
}

public function tblProps($table) {
	return $this->dbo->tblProps($table);
}

public function fldProps($table, $field) {
	return $this->dbo->fldProps($table, $field);
}

// ***********************************************************
// retrieving table info
// ***********************************************************
public function isTable($table) {
	$this->setMasks($table);
    return (bool) $this->get1st("inf.tbs");
}

public function getPrimary() {
	$arr = $this->get1st("inf.idx"); if (! $arr) return false;
	return $arr["Column_name"];
}

// ***********************************************************
// retrieving field info
// ***********************************************************
public function isField($table, $field) {
	$this->setMasks($table, $field);
    return (bool) $this->get1st("inf.fld");
}
public function getDVs($fields, $filter = 1, $sep = " ") {
	$this->setFields($fields, true, false);
	$this->setFilter($filter);

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
	$this->setFilter($filter);
	return (bool) $this->get1st("sel.fnd");
}
public function rowCount($filter = 1) {
	$this->setFilter($filter);
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
    $qry = $this->fetch("hold.$wht");
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

	$qry = $this->beautify($qry);

	$cnf = new confirm();
	$cnf->add($qry);
	$cnf->show();
	return $cnf->act();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
