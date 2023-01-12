<?php

/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify modification of db objects.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/dbAlter.php");

$ddl = new dbAlter($dbs, $tbl);
$ddl->t_add($tbl);
$ddl->f_add($tbl, $fld, $typ, $len, $std, $nul);
*/

incCls("dbase/dbBasics.php");
incCls("input/confirm.php");

// ***********************************************************
// Begin of Class
// ***********************************************************
class dbAlter extends dbBasics {
	protected $ask = true; // ask for confirmation
	protected $tell = true;

function __construct($dbase, $table = NV) {
	parent::__construct($dbase);

	$this->setTable($table);
}

// ***********************************************************
// handling databases
// ***********************************************************
public function db_add($dbase) {
	if ($this->isDBase($dbase)) return $this->doMsg("dbs.known", $dbase);

	$xxx = $this->set("dbs", $dbase);
	$qry = $this->getStmt("dbase.add");

	$cnf = $this->confirm($qry); if (! $cnf) return false;
	return $this->dbo->exec($qry);
}
public function db_rename($dbase, $newName) {
	$xxx = $this->set("dest", $newName);
	return $this->exDbs("dbase.rename", $dbase);
}
public function db_drop($dbase) {
	return $this->exDbs("dbase.drop", $dbase);
}
public function db_backup($dbase, $dest) {
	$xxx = $this->set("dest", $dest);
	return $this->exDbs("dbase.backup", $dbase);
}

// ***********************************************************
private function exDbs($stmt, $dbs) { // key => section.key
	if (! $this->con) return $this->doMsg("no.connection");

	$xxx = $this->set("dbs", $dbs);
	$qry = $this->getStmt($stmt);

	$cnf = $this->confirm($qry); if (! $cnf) return false;
	return $this->dbo->exec($qry);
}

// ***********************************************************
// handling tables
// ***********************************************************
public function t_ddl($ddl) {
	if (! $this->dbo->exec($ddl)) return false;
	return true;
}

// ***********************************************************
public function t_add($table) {
	if (! $this->con) return $this->doMsg("no.connection");
	if ($this->dbo->isTable($table)) return $this->doMsg("tbl.known",  $table);

	$this->setTable($table); $qry = $this->getStmt("table.add");

	$cnf = $this->confirm($qry); if (! $cnf) return false;
	return $this->dbo->exec($qry);
}
public function t_drop($table) {
	return $this->exTable("table.drop", $table);
}
public function t_trunc($table) {
	return $this->exTable("table.trunc", $table);
}
public function t_sort($table, $order, $dir = "ASC") {
	$this->set("order", $order);
	$this->set("sort", $dir);
	return $this->exTable("table.sort", $table);
}
public function t_copy($table, $newTable) {
	$this->set("new", $newTable);
	return $this->exTable("table.copy", $table);
}
public function t_rename($table, $newName) {
	if ($table  == $newName) return $this->doMsg("no.effect");
	if ($this->dbo->isTable($newName)) return $this->doMsg("tbl.known", $newName);
	$this->set("new", $newName);
	return $this->exTable("table.rename", $table);
}

// ***********************************************************
private function exTable($stmt, $tbl) {
	if ( ! $this->dbo->isTable($tbl)) return $this->doMsg("tbl.unknown", $tbl);
	return $this->exDDL($stmt, $tbl);
}

// ***********************************************************
// handling fields
// ***********************************************************
public function f_add($tbl, $fld, $typ, $len = 15, $std = "", $nul = "NULL") {
	if ($this->dbo->isField($tbl, $fld)) return $this->doMsg("fld.known", $fld);
	$this->setType($typ, $len, $std, $nul);
	return $this->exDDL("field.add", $tbl, $fld);
}
public function f_copy($tbl, $src, $dst) {
	if (! $this->dbo->isField($tbl, $src)) { // create field if necessary
		$inf = $this->getInfo($bl, $src); extract($inf);
		$this->f_add($dst, $ftype, $flen, $fstd, $fnull);
	}
	$this->set("fld", $src); // copy data
	$this->set("new", $dst);
	return $this->exDDL("field.copy", $tbl, $src);
}
public function f_merge($tbl, $src, $dst) {
	$inf = $this->getInfo($bl, $src); extract($inf);
	$this->set("fld", $src);
	$this->set("new", $dst);

	if ($ftype == "text")
	return $this->exDDL("field.merge.text", $tbl, $fld);
	return $this->exDDL("field.merge.std", $tbl, $fld);
}
public function f_modify($tbl, $fld, $typ, $len = 0, $std = "", $nul = "NULL") {
	$this->setType($typ, $len, $std, $nul);
	return $this->exField("field.modify", $tbl, $fld);
}
public function f_drop($tbl, $fld) {
	return $this->exField("field.drop", $tbl, $fld);
}
public function f_move($tbl, $fld, $after) {
	if ($fld == $after) return $this->doMsg("no.effect");
	$this->set("after", $after);
	return $this->exField("field.move", $tbl, $fld);
}
public function f_rename($tbl, $fld, $new) {
	if ($fld == $new) return $this->doMsg("no.effect");
	if ($this->isField($tbl, $new)) return $this->doMsg("fld.known", $fld);
	$this->set("new", $new);
	return $this->exField("field.rename", $tbl, $fld);
}

// ***********************************************************
private function exDDL($stmt, $tbl, $fld = "") { // key => section.key
	if (! $this->con) return $this->doMsg("no.connection");
	$this->setField($tbl, $fld);

	$qry = $this->getStmt($stmt);
	$cnf = $this->confirm($qry); if (! $cnf) return false;
	return $this->dbo->exec($qry);
}

private function exField($stmt, $tbl, $fld) {
	if (! $this->con) return $this->doMsg("no.connection");
	if (! $this->isField($tbl, $fld)) return $this->doMsg("fld.unknown", $fld);

    return $this->exDDL($stmt, $tbl, $fld);
}

// ***********************************************************
// recreate dbobjs
// ***********************************************************
public function getDDL($table) {
	$this->setTable($table);
	$arr = $this->get1st("inf.ddl", "n"); if (! $arr) return false;
	$ddl = $arr[1];
	$ddl = STR::before($ddl, "ENGINE=");
	return "$ddl;\n\n";
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getInfo($tbl, $fld) {
	return $this->dbo->fldProps($tbl, $fld);
}

private function setType($typ, $len, $std, $nul) { // TODO: db specific checking
	$this->set("size", $len); $typ = STR::left($typ);
	$this->set("std",  $std);
	$this->set("null", $nul); $def = $this->getStmt("ftypes.$typ");
	$this->set("def",  $def);
}

// ***********************************************************
// data manipulation
// ***********************************************************
public function askMe($value = true) {
	$this->ask = (bool) $value;
}

public function tellMe($value = true) {
	$this->tell = (bool) $value;
}

private function doMsg($msg, $prm = NV) {
	if (! $this->tell) return;
	if ($prm !== NV) return MSG::now($msg, $prm);
	MSG::now($msg);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
