<?php

/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify handling of mysql database queries

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/syntax/mysql.php");

$obj = new mysql($dbase);
$xxx = $obj->connect($user, $pwd);
$arr = $obj->fetch($qry);
$arr = $obj->fetch1st($qry);

*/

// ***********************************************************
// Begin of Class
// ***********************************************************
class mysql {
	protected $host = "localhost";  // hostname
	protected $dbs = "";		    // database
	protected $con = false;		    // connection id
    protected $res = false;		    // record set id

	public $qot = array("in" => "`", "out" => "`");

// ***********************************************************
function __construct($host, $dbase) {
	$this->host = $host;
    $this->dbs = $dbase;
}

// ***********************************************************
// connecting to db
// ***********************************************************
public function connect($user, $pass) {
	if (! function_exists("mysqli_connect"))
	return ERR::msg("dbase", "db.module", "mysqli");

	$this->con = new mysqli($this->host, $user, $pass);
	$this->selectDb($this->dbs);

	if ($this->con->connect_error) {
		return $this->con = false;
	}
	$this->con->set_charset("utf8");
	return true;
}

public function selectDb($dbase) {
	$this->con->select_db($dbase);
}

// ***********************************************************
// executing sql statements like alter, drop, update ...
// ***********************************************************
public function exec($sql) { // no scripts => use run();
	$sql = strtok($sql, ";"); // only first statement will be executed

	return array(
		"sql" => $sql,
		"res" => $this->run($sql),
		"aff" => $this->con->affected_rows,
		"lid" => $this->con->insert_id
	);
}

// ***********************************************************
// retrieving records and field info
// ***********************************************************
public function fetch($sql, $mds = "a") {
	$res = $this->run($sql); if (! $res) return false;
	$mds = $this->getMode($mds); $out = array();

    while ($arr = $res->fetch_array($mds)) {
		$out[] = STR::restore($arr);
    }
    if (! $out) return false;
	return $out;
}

public function fetch1st($sql, $mds = "a") {
	$res = $this->run($sql); if (! $res) return false;
	$mds = $this->getMode($mds); $out = array();

    return $res->fetch_array($mds);
}

// ***********************************************************
// run any statement
// ***********************************************************
private function run($sql) {
	if (! $this->con) return false;
	if (! $sql) return false;

	$sql = CFG::insert($sql);
	$res = $this->con->query($sql); if ($res) return $res;

	return ERR::sql($this->con->error."\nxxx", $sql);
}

// ***********************************************************
// retrieving query related info
// ***********************************************************
public function tblProps($table) {
	$app = $this->appProps("tbl", $table);    // props overruled by app
	$prm = $this->dboPerms("tbl", $table);
	$prm = $this->chkTPerms($prm);
	$prm = array("perms" => $prm);
	return array_merge($app, $prm);
}

public function fldProps($table, $field) {
	$idx = "$table.$field";
	$dbo = $this->dboProps($table, $field); // props by dbase
	$txs = $this->dboPerms("tbl", $table);  // table permissions
	$txs = $this->chkTPerms($txs);
	$app = $this->appProps("fld", $idx);    // props overruled by app
	$fxs = $this->dboPerms("fld", $idx);    // field permissions
	$fxs = $this->chkFPerms($fxs, $txs);
	$prm = array("perms" => $fxs);

	return array_merge($dbo, $app, $prm);
}

private function dboProps($tbl, $fld = "%") {
	$dbs = $this->dbs;
	$sql = "SELECT * FROM information_schema.columns ";
	$sql.= "WHERE table_schema='$dbs' AND table_name='$tbl' AND column_name LIKE '$fld' ";
	$sql.= "LIMIT 1;";

    $inf = $this->fetch1st($sql); if (! $inf) return array();
    $out = array(
        "dbase" => $dbs,
        "table" => $tbl,
        "fname" => $fld,
        "fpos"  => $inf["ORDINAL_POSITION"],
        "fstd"  => $inf["COLUMN_DEFAULT"],
        "flen"  => $inf["CHARACTER_MAXIMUM_LENGTH"],
        "ftype" => $inf["DATA_TYPE"],
		"dtype" => $this->fldType($inf["DATA_TYPE"]),
		"dcat"  => $this->fldCat($inf["DATA_TYPE"]),

        "head"  => ucfirst($fld),
        "facc"  => intval($inf["NUMERIC_PRECISION"]),
        "fnull" => intval($inf["IS_NULLABLE"] == "YES"),
		"perms" => "x"
    );
	if ($inf["COLUMN_KEY"]) $out["dtype"] = "key";
    return $out;
}
private function appProps($cat, $idx) {
	$out = array(); if (! $this->isTable("dbobjs")) return $out;
	$sql = "SELECT * FROM `dbobjs` WHERE (cat='$cat' AND spec='$idx')";
    $arr = $this->fetch($sql); if (! $arr) return $out;

    foreach ($arr as $vls) {
		$key = VEC::get($vls, "prop");
		$val = VEC::get($vls, "value");
		$out[$key] = $val;
	}
	return $out;
}

private function dboPerms($cat, $idx) {
	if (! $this->isTable("dbxs")) return "x";
	$sql = "SELECT USR_GRPS FROM `dbxs` WHERE (cat='$cat' AND spec='$idx')";
    $arr = $this->fetch1st($sql); if (! $arr) return "x";
    return implode("", $arr);
}

// ***********************************************************
private function fldCat($typ) {
	$typ = $this->fldType($typ);
	if (STR::contains(".int.dec.key.", ".$typ."))     return "num";
	if (STR::contains(".dat.dnt.cur.tim.", ".$typ.")) return "dat";
	return $typ;
}

// ***********************************************************
private function fldType($typ) {
    if (STR::contains($typ, "int")) return "int";
    if (STR::contains($typ, "dec")) return "dec"; // float
    if (STR::contains($typ, "flo")) return "dec"; // float
    if (STR::contains($typ, "rea")) return "dec"; // real
    if (STR::contains($typ, "eti")) return "dnt"; // datetime
    if (STR::contains($typ, "sta")) return "cur"; // timestamp
    if (STR::contains($typ, "dat")) return "dat"; // date
    if (STR::contains($typ, "tim")) return "tim"; // time
    if ($typ == "text")             return "mem"; // memo
    return "var";
}

// ***********************************************************
// verify objects
// ***********************************************************
public function isTable($table) {
    $inf = $this->fetch1st("SHOW TABLES LIKE '$table'");
    return (bool) $inf;
}
public function isField($table, $field) {
	if (! $this->isTable($table)) return false;
    $inf = $this->fetch1st("SHOW COLUMNS FROM `$table` LIKE '$field'");
    return (bool) $inf;
}

// ***********************************************************
// user permissions
// ***********************************************************
private function chkTPerms($prm) {
	if (STR::contains($prm, "w")) return "w"; $out = "";
	if (STR::contains($prm, "a")) $out.= "a";
	if (STR::contains($prm, "e")) $out.= "e";
	if (STR::contains($prm, "d")) $out.= "d"; if ($out) return $out;
	if (STR::contains($prm, "r")) return "r";
	return "x";
}

private function chkFPerms($prm, $inherited = "w") {
	if ($inherited == "r") return "r";
	if ($inherited == "x") return "x";

	if (STR::contains($prm, "w")) return "w";
	if (STR::contains($prm, "r")) return "r";
	return "x";
}

// ***********************************************************
// auxilliary functions
// ***********************************************************
private function getMode($mds) {
	if ($mds == "a") return MYSQLI_ASSOC;
	if ($mds == "b") return MYSQLI_BOTH;
	return MYSQLI_NUM;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************

?>
