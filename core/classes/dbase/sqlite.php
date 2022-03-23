<?php

/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify handling of sqlite database queries

// ***********************************************************
// HOW TO USE
// ***********************************************************
apt-get install php5-sqlite
service apache2 restart

see MySQL object
*/

incCls("dbase/mysql.php");

// ***********************************************************
// Begin of Class
// ***********************************************************
class dBase extends mysql {

// ***********************************************************
function __construct($dbas = DB_FILE) {
	if (! function_exists("sqlite3_connect")) {
		return ERR::msg("db.module", "sqlite3");
	}
    $this->dbs = $dbas;
}

// ***********************************************************
// connecting to db
// ***********************************************************
public function connect($dbas = DB_FILE, $user = DB_USER, $pass = DB_PASS) {
	$this->con = new SQLite3($dbas);

	if ($this->con->connect_error) {
		$this->con = false;
	}
	$this->con->set_charset("utf8");
	return true;
}

// ***********************************************************
// retrieving query related info
// ***********************************************************
private function fldType($typ) {
	switch (STR::left($typ)) {
		case "int": return "int";
		case "flo": return "num";
		case "blo": return "mem";
	}
	return "var";
}

private function fldLen($typ) {
	switch (STR::left($typ)) {
		case "int": return 10;
		case "flo": return 14;
		case "tex": return 25;
	}
	return 0;
}

// ***********************************************************
// auxilliary functions
// ***********************************************************
private function getMode($mds) {
	if ($mds == "a") return SQLITE3_ASSOC;
	if ($mds == "b") return SQLITE3_BOTH;
	return SQLITE3_NUM;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
