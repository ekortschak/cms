<?php

/* ***********************************************************
// INFO
// ***********************************************************
Intended to abstract the handling of sql statements
so that they may be created according to the database used
e.g. mysql, sqlite ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("dbase/sqlStmt.php");

$sql = new SQL($table);

*/

#incCls("files/ini.php");
#incCls("other/items.php");

// ***********************************************************
// Begin of Class
// ***********************************************************
class sqlStmt extends objects {
	protected $vls;   // array of string values

public function __construct() {}

public function init($dbtype) {
	$typ = strtolower($dbtype);
	$ini = new ini("dbase/syntax/$typ/sql.ini"); $this->merge($ini->getValues());
	$ini = new ini("dbase/syntax/$typ/ddl.ini"); $this->merge($ini->getValues());

	$this->setMasks();
	$this->setFields(); // sets distinct and order as well
	$this->fetch();
	$this->setLimit();
}

// ***********************************************************
// queries
// ***********************************************************
public function setQuery($table, $fields = "", $filter = "", $order = "", $limit = 0) {
	$this->setTable($table);
    if ($fields) $this->setFields($fields);
	if ($filter) $this->setFilter($filter);
    if ($order)  $this->setOrder($order);
    if ($limit)  $this->setLimit($limit);
}

private function reset($table, $fields = "*") {
	$this->set("tab", $this->clearQuotes($table));
    $this->setFields($fields);
	$this->setFilter("");
    $this->setOrder("");
    $this->setLimit(0);
}

// ***********************************************************
// tables and fields
// ***********************************************************
public function setTable($table) {
	if ($table) $this->reset($table);
}
public function setField($table, $field) {
	$this->setTable($table); if (! $field) return;
	$this->set("fld", $field);
}

public function setFields($fields = "*", $distinct = false, $order = true) {
	$fds = "*"; if ($fields) $fds = $fields;
	$fds = $this->quoteDbo($fields);
	$this->set("fds", $fds);
	$this->setDistinct($distinct);
	$this->setOrder($fds);
}

// ***********************************************************
// functions related to SELECT statements
// ***********************************************************
public function setMasks($table = "%", $field = "%") {
	$this->set("tmask", $table);
	$this->set("fmask", $field);
}
public function setDistinct($value = false) {
	$dvs = ""; if ($value) $dvs = $this->fetch("parts.dvs");
	$this->set("dvs", $dvs);
}
public function setFilter($filter = false) {
	$flt = 0; if ($filter) $flt = $filter;
	if (is_array($filter)) $flt = $this->quotePairs($filter, " AND ");
	$this->set("flt", $flt);
	$this->set("flt", $this->fetch("parts.whr"));
}
public function setOrder($fields = false) {
	$str = $fields; if ($str == "*") $str = false;
	$ord = "ID";    if ($str) $ord = $str;
	$this->set("ord", $this->quoteDbo($ord));
	$this->set("ord", $this->fetch("parts.ord"));
}
public function setOrderMan($crit) {
	$this->set("ord", $crit);
}

// ***********************************************************
// data transformation values
// ***********************************************************
public function setProps($values) {
	if (! is_array($values)) return;
	$this->set("fds", $this->quoteDbo(array_keys($values)));
	$this->set("vls", $this->quoteVls(array_values($values)));
	$this->set("par", $this->quotePairs($values));
}

// ***********************************************************
// handling limits
// ***********************************************************
public function setLimit($count = 1, $first = 0) {
	$this->set("fst", $first); $what = "rng";
	$this->set("cnt", $count); if ($first < 1) $what = "lim";
	$this->set($what, $this->fetch("parts.$what"));
}

// ***********************************************************
// retrieving statements
// ***********************************************************
public function fetch($stmt = "sel.all") { // $stmt => section.key
	$sql = $this->get($stmt); if (! $sql) return "SQL not found: $stmt";
	$sql = $this->insVars($sql);
	$sql = $this->chkSql($sql);
	return $sql;
}

protected function chkSql($sql) {
	if (STR::contains($sql, "dbobjs")) return $sql;

	$out = $sql;
	$out = STR::replace($out, "CURRENT_TIMESTAMP", date("Y-m-d H.nn"));
	$out = STR::replace($out, "CURRENT_USER", CUR_USER);
	return $out;
}

// ***********************************************************
// quoting field lists
// ***********************************************************
private function quotePairs($values, $glue = ",") {
    $out = array(); if (! is_array($values)) return false;

    foreach ($values as $key => $val) {
		$key = $this->quoteDbo($key);
		$val = $this->quoteVls($val);
		$out[] = "$key=$val";
    }
    return implode($glue, $out);
}

// ***********************************************************
// quoting db objects
// ***********************************************************
private function quoteDbo($dbo) {
	if (is_array($dbo)) { $out = "";
		foreach ($dbo as $itm) {
			$out.= $this->quoteDbo($itm);
		}
		return $out;
	}
	$sep = $this->get("props.qsep", ".");
	$dbo = $this->clearQuotes($dbo);
	$dbo = $this->addQuotes($dbo);
	return $dbo;
}

private function clearQuotes($dbo) {
	$dbo = STR::clear($dbo, $this->get("props.qot1", "`"));
	$dbo = STR::clear($dbo, $this->get("props.qot2", "`"));
	return $dbo;
}
private function addQuotes($dbo) {
	$one = $this->get("props.qot1", "`");
	$two = $this->get("props.qot2", "`");
	$dbo = STR::toArray($dbo, ",");

	$out = implode("$two, $one", $dbo);
	$out = $one.$out.$two;
	$out = str_replace($one."*".$two, "*", $out);
	return preg_replace("~$one(\d*?)$two~", "$1", $out);
}

// ***********************************************************
// quoting db strings
// ***********************************************************
private function quoteVls($lst, $sep = ",") {
	$qot = $this->get("props.vqot", "'");
	$sep = $this->get("props.vsep", ",");

	if (! is_array($lst)) {
		$lst = STR::secure(trim($lst));
		return $qot.$lst.$qot;
	}

    foreach ($lst as $itm) {
		$str = STR::secure(trim($itm));
		$out[] = $qot.$str.$qot;
    }
    return implode($sep, $out);;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
