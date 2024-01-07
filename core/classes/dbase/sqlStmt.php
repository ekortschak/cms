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

$sql = new sqlStmt($dbtype);

*/

#incCls("files/ini.php");
#incCls("other/items.php");

// ***********************************************************
// Begin of Class
// ***********************************************************
class sqlStmt extends objects {
	protected $tbl = NV;

public function __construct($dbtype) {
	$typ = strtolower($dbtype);

	$ini = new ini(NV);
	$ini->read("dbase/syntax/$typ/sql.ini");
	$ini->read("dbase/syntax/$typ/ddl.ini");
	$ini->read("dbase/syntax/$typ/def.ini");

	$this->merge($ini->getValues());
	$this->setMasks();
}

// ***********************************************************
// tables and fields
// ***********************************************************
public function setTable($table) {
	$this->tbl = $table;
	$this->set("tab", $this->quoteClr($table));
	$this->set("fld", "*");

	$this->setWhere(1); $this->setOrder("");
    $this->setLimit(0);
}

public function setField($table, $field) {
	$this->setTable($table);
	$this->set("fld", $this->quoteDbo($field));
}

public function setFields($fields = "*", $distinct = false, $order = true) {
	$fds = "*"; if ($fields) $fds = $fields;
	$fds = $this->quoteDbo($fields);
	$this->set("fld", $fds);
	$this->setDistinct($distinct);
	$this->setOrder($fds);
}

// ***********************************************************
// functions related to SELECT statements
// ***********************************************************
public function setWhere($filter = false) {
	$flt = 0; if ($filter)
	$flt = $filter; if (is_array($filter))
	$flt = $this->quotePairs($filter, " AND ");

	$this->set("flt", $flt);
	$this->set("flt", $this->getStmt("parts.whr"));
}
public function setOrder($fields = false) {
	$str = $fields; if ($str == "*") $str = false;
	$ord = "ID";    if ($str) $ord = $str;
	$this->set("ord", $this->quoteDbo($ord));
	$this->set("ord", $this->getStmt("parts.ord"));
}
public function setOrderMan($crit) {
	$this->set("ord", $crit);
}

public function setMasks($table = "%", $field = "%") {
	$this->set("tmask", $table);
	$this->set("fmask", $field);
}
protected function setDistinct($value = false) {
	$dvs = ""; if ($value) $dvs = $this->getStmt("parts.dvs");
	$this->set("dvs", $dvs);
}

// ***********************************************************
// data transformation values
// ***********************************************************
public function setProps($values) {
	if (! is_array($values)) return;
	$this->set("fld", $this->quoteDbo(array_keys($values)));
	$this->set("vls", $this->quoteVls(array_values($values)));
	$this->set("par", $this->quotePairs($values));
}

// ***********************************************************
// handling limits
// ***********************************************************
public function setLimit($count = 1, $first = 0) {
	$this->set("lim", ""); $this->set("fst", $first);
	$this->set("rng", ""); $this->set("max", $count);

	$what = "rng"; if ($first < 1)
	$what = "lim";

	$this->set($what, $this->getStmt("parts.$what"));
}

// ***********************************************************
// retrieving statements
// ***********************************************************
public function getStmt($stmt = "sel.all") { // $stmt => section.key
	$sql = $this->get($stmt); if (! $sql) return false;
	$sql = $this->insVars($sql);
	return $sql;
}

protected function chkStmt($sql) {
	if (STR::contains($sql, "dbobjs")) return $sql;

	$out = $sql;
	$out = STR::replace($out, "CURRENT_TIMESTAMP", date("Y-m-d H:i"));
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
	$dbo = $this->quoteClr($dbo);
	$dbo = $this->quoteAdd($dbo);
	return $dbo;
}

private function quoteClr($dbo) {
	$dbo = STR::clear($dbo, $this->get("props.qot1", "`"));
	$dbo = STR::clear($dbo, $this->get("props.qot2", "`"));
	return $dbo;
}
private function quoteAdd($dbo) {
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
		$lst = DBS::secure(trim($lst));
		return $qot.$lst.$qot;
	}

    foreach ($lst as $itm) {
		$str = DBS::secure(trim($itm));
		$out[] = $qot.$str.$qot;
    }
    return implode($sep, $out);
}

// ***********************************************************
// improve readability of sql statement
// ***********************************************************
public function beautify($msg) {
	$msg = "@@@ $msg ";
	$msg = $this->doLFs($msg, "SELECT.FROM.WHERE.GROUP BY.HAVING.ORDER BY.LIMIT");
	$msg = $this->doLFs($msg, "INSERT.INTO.DELETE.UPDATE.TRUNCATE.SET");
	$msg = $this->doLFs($msg, "CREATE.ALTER.DROP.RENAME.ADD.CHANGE.MODIFY");
	$msg = $this->doLFs($msg, "TO DISK");
	$msg = $this->doLFs($msg, " ) ");
	$msg = $this->doKeys($msg);
	$msg = str_replace("  ", "\n  ", $msg);

	$msg = STR::clear($msg, "@@@ <br>");
	$msg = STR::clear($msg, "@@@");
	$msg = str_replace(",", ", ", $msg);
	return "$msg";
}

private function doLFs($msg, $set) {
	$set = STR::split($set, ".");

	foreach ($set as $key) {
		if (! $key) continue;
		$msg = str_replace($key, "<br><b>$key</b>", $msg);
	}
	return $msg;
}

private function doKeys($msg) { // reserved words
	$rwd = STR::split("TABLE.EXISTS.PRIMARY.KEY"
		. "DISTINCT.ASC.DESC.UNION.JOIN.INNER.OUTER.ON."
		. "NOT.LIKE.IN.BETWEEN.AND.OR.XOR.TRUE.FALSE.NULL."
		. "LEFT.MID.RIGHT.SUBSTRING.TRIM.LOWER.UPPER.FORMAT.REVERSE.LOCATE.INSTR.LENGTH.REPEAT.CONCAT_WS.CONCAT."
		. "YEAR.QUARTER.MONTH.WEEK.WEEKDAY.DAY.HOUR.DATE.NOW.SYSDATE.CURDATE.CURTIME.DATE_ADD.DATE_SUB."
		. "POW.SQRT.ROUND.CEILING.FLOOR.RAND.LN.LOG.CHAR.ORD."
		. "ALL.AS.IS.IF.TO.AFTER"
		. "SUM.COUNT.AVG.STD.MAX.MIN.FIRST.LAST."
		. "CRC32.MD5.SHA1.SHA2", ".");

	foreach ($rwd as $key) {
		if (! $key) continue;
		$msg = str_replace(" $key ", " <blue>$key</blue> ", $msg);
	}
	return $msg;
}
//	$ops = STR::split(" <> != <= >= && || < > ! = ^ & | ( ) , . ; + - * /", " ");

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
