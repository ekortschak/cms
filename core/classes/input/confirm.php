<?php
/* ***********************************************************
// INFO
// ***********************************************************
currently used only for db transactions

used to ask for user confirmation before
execution of sensible tasks

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("forms/confirm.php");

$cnf = new confirm();
$cnf->add($msg);
$cnf->addSql($sql);
$cnf->show();

if ($cnf->act()) ...
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class confirm extends tpl {
	private $msg = array();
	private $val = "done";

function __construct() {
	parent::__construct();
	$this->setOID();
	$this->read("design/templates/input/confirm.tpl");
}

// ***********************************************************
// methods
// ***********************************************************
public function head($msg) {
	$this->msg[] = "<b>".trim($msg)."</b>";
}

public function addSql($sql) {
	$this->add($this->doSQL($sql));
}
public function add($msg) {
	$this->msg[] = trim($msg);
}

public function button($msg, $value) {
	$this->set("button", DIC::get($msg));
	$this->val = $value;
}

// ***********************************************************
// output
// ***********************************************************
public function gc($sec = "main") {
	if ($this->act()) {
		return $this->getSection("Done");
	}
	$tpl = "$sec.item"; $out = "";

	foreach ($this->msg as $key => $msg) {
		$xxx = $this->set("msg", $msg);
		$out.= $this->getSection($tpl);
	}
	$this->set("items", $out);
	return $this->getSection($sec);
}

// ***********************************************************
public function act() {
	$vgl = ENV::getPost("oid");	    if (! $vgl) return false;
	$act = ENV::getPost("cnf_act"); if (! $act) return false;
	return $this->val;
}
public function checked() {
	$vgl = ENV::getPost("oid");	    if (! $vgl) return false;
	$act = ENV::getPost("cnf_chk"); if (! $act) return false;
	return true;
}

// ***********************************************************
// beautify sql
// ***********************************************************
public function doSQL($msg) {
	$msg = "@@@ $msg ";
	$msg = $this->doLFs($msg, "SELECT.FROM.WHERE.GROUP BY.HAVING.ORDER BY.LIMIT");
	$msg = $this->doLFs($msg, "INSERT.INTO.DELETE.UPDATE.TRUNCATE.SET");
	$msg = $this->doLFs($msg, "CREATE.ALTER.DROP.RENAME.ADD.CHANGE.MODIFY");
	$msg = $this->doLFs($msg, " ) ");
	$msg = $this->doKeys($msg);
	$msg = str_replace("  ", "\n  ", $msg);

	$msg = STR::clear($msg, "@@@ <br>");
	$msg = STR::clear($msg, "@@@");
	$msg = str_replace(",", ", ", $msg);
	return "$msg";
}

private function doLFs($msg, $set) {
	$set = explode(".", $set);
	foreach ($set as $key) {
		if (! $key) continue;
		$msg = str_replace($key, "<br><b>$key</b>", $msg);
	}
	return $msg;
}

private function doKeys($msg) { // reserved words
	$rwd = explode(".", "TABLE.EXISTS.PRIMARY.KEY"
		. "DISTINCT.ASC.DESC.UNION.JOIN.INNER.OUTER.ON."
		. "NOT.LIKE.IN.BETWEEN.AND.OR.XOR.TRUE.FALSE.NULL."
		. "LEFT.MID.RIGHT.SUBSTRING.TRIM.LOWER.UPPER.FORMAT.REVERSE.LOCATE.INSTR.LENGTH.REPEAT.CONCAT_WS.CONCAT."
		. "YEAR.QUARTER.MONTH.WEEK.WEEKDAY.DAY.HOUR.DATE.NOW.SYSDATE.CURDATE.CURTIME.DATE_ADD.DATE_SUB."
		. "POW.SQRT.ROUND.CEILING.FLOOR.RAND.LN.LOG.CHAR.ORD."
		. "ALL.AS.IS.IF.TO.AFTER"
		. "SUM.COUNT.AVG.STD.MAX.MIN.FIRST.LAST."
		. "CRC32.MD5.SHA1.SHA2");

	foreach ($rwd as $key) {
		if (! $key) continue;
		$msg = str_replace(" $key ", " <blue>$key</blue> ", $msg);
	}
	return $msg;
}
//	$ops = explode(" ", " <> != <= >= && || < > ! = ^ & | ( ) , . ; + - * /");

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
