<?php

/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify handling of mysql database queries

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/syntax/mysql.php");

$dbo = new mysql($dbase);
$xxx = $dbo->connect($user, $pwd);
$arr = $dbo->fetch($qry);
$arr = $dbo->fetch1st($qry);

*/

// ***********************************************************
// Begin of Class
// ***********************************************************
class mysql {
	protected $host = "localhost";  // hostname
	protected $dbs = false;		    // database
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
	return ERR::msg("db.module", "mysqli");

	$this->con = new mysqli($this->host, $user, $pass);

	if (! $this->con) {
		return $this->dbs = false;
	}
	$this->con->set_charset("utf8");
	$this->selectDb($this->dbs);
	return true;
}

public function selectDb($dbase) {
	$this->dbs = false;
	if (! $this->con) return;
	if (! $this->con->select_db($dbase)) return;
	$this->dbs = $dbase;
}

// ***********************************************************
// executing sql statements like alter, drop, update ...
// ***********************************************************
public function exec($sql) { // no scripts => use run();
	$sql = strtok($sql, ";"); // only first statement will be executed
	$res = $this->run($sql); if (! $res) return false;

	return array(
		"sql" => $sql,
		"res" => $res,
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
		$out[] = DBS::restore($arr);
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
	if (! $this->dbs) return false;
	if (! $sql) return false;

	$sql = CFG::insert($sql);
	$res = $this->con->query($sql); if ($res) return $res;
	$msg = $this->con->error;

	return ERR::sql($msg, $sql);
}

// ***********************************************************
// retrieving query related info
// ***********************************************************
public function fldProps($table, $field) {
	$sql = "SELECT * FROM information_schema.columns ";
	$sql.= "WHERE table_schema='$this->dbs' AND table_name='$table' AND column_name LIKE '$field' ";
	$sql.= "LIMIT 1;";

    $inf = $this->fetch1st($sql); if (! $inf) return array();
    $out = array(
        "dbase" => $this->dbs,
        "table" => $table,
        "fname" => $field,
        "fpos"  => $inf["ORDINAL_POSITION"],
        "fstd"  => $inf["COLUMN_DEFAULT"],
        "flen"  => $inf["CHARACTER_MAXIMUM_LENGTH"],
        "ftype" => $inf["DATA_TYPE"],
		"dtype" => $this->fldType($inf["DATA_TYPE"]),
		"dcat"  => $this->fldCat( $inf["DATA_TYPE"]),
        "head"  => ucfirst($field),
        "facc"  => intval($inf["NUMERIC_PRECISION"]),
        "fnull" => intval($inf["IS_NULLABLE"] == "YES"),
		"perms" => "x"
    );
	if ($inf["COLUMN_KEY"]) $out["dtype"] = "key";
    return $out;
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
