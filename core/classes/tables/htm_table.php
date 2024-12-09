<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended to simplify handling of tables
- including row totals
- aligning right by default

// ***********************************************************
// HOW TO USE
// ***********************************************************
For a full description see
http://gim.glaubeistmehr.at/?tab=cms
*/

incCls("tables/tblCols.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class htm_table extends tpl {
    protected $cls;             // column info object
	protected $dat = array();   // table data rows

	protected $lns = 35;        // max lines per current
	protected $max = 250;       // max lines per screen

function __construct() {
	parent::__construct();

	$tpl = "tables/std.tpl"; if (CUR_DEST == "csv")
	$tpl = "tables/csv.tpl";
	parent::load($tpl);

    $this->cls = new tblCols();
    $this->register();
}

// ***********************************************************
// handling columns
// ***********************************************************
public function addCols($hed) {
    foreach ($hed as $itm) {
        $this->addCol($itm);
    }
}
public function addCol($col, $inf = array()) {
	$this->cls->add($col, $inf);
}

public function setHeads($colheads) {
	$arr = STR::split($colheads, ","); $cnt = 0;

	foreach ($arr as $val)
		$this->cls->set($cnt++, "head", $val);
}

public function setLines($num) {
	$this->lns = CHK::range($num, 500, 1);
}

// ***********************************************************
public function mergeProps($arr) { // $arr set by items->items();
	foreach ($arr as $col => $props) {
		$this->cls->merge($col, $props);
	}
}
public function setProps($col) { // collection
	foreach ($col as $name) {
		$this->cls->merge($col, $name);
	}
}
public function setProp($col, $prop, $value) {
	$this->cls->set($col, $prop, $value);
}

// ***********************************************************
// handling rows
// ***********************************************************
public function addRows($data) { // record set
	if (! is_array($data)) return;
	$this->dat = array_values($data);
}
public function addRow($data) { // single record
	if (! is_array($data)) return;
	$this->dat[] = array_values($data);
}

public function addArray($data, $pfx = "") {
	$this->cls->add("Key");
	$this->cls->add("Value");

	foreach ($data as $key => $val) {
		$this->dat[] = array($pfx.$key, $val);

		if (is_array($val)) {
			if (count($val) < 1) $val = "-"; else
			$this->addArray($val, "$pfx&nbsp;&nbsp;");
		}
	}
}

// ***********************************************************
// DISLPLAY
// ***********************************************************
public function gc($sec = "main") {
    $rcs = count($this->dat);

    if ($rcs < 1) {
		parent::load("tables/empty.tpl");
		$out = $this->getSection("main");
		return "$out\n";
	}
	$dat = $this->tblData();
	$hed = $this->tblRow("rh", $this->cls->items()); // header
	$fut = $this->tblRow("rf", $this->cls->sums());  // footer

	if ($rcs < $this->lns) {
		$this->clearSec("stats");
		$this->clearSec("nav");
	}
	$out = $this->tblCode($hed.$dat.$fut);
	return "$out\n";
}

// ***********************************************************
// handling rows
// ***********************************************************
public function rowCount() {
	return count($this->dat);
}

protected function tblData() {
	$pge = $this->current(); $out = "";

    $fst = $this->page($pge);
    $lst = $fst + $this->lns;

    for ($i = $fst; $i < $lst; $i++) {
		$rec = $this->getRec($i); if (! $rec) continue;
		$out.= $this->tblRow("rw", $rec);
	}
    return $out;
}

// ***********************************************************
protected function tblRow($style, $arr) {
	if (! $arr) return "";
    if (count($arr) < 1) return ""; $out = ""; $cnt = 0;

    foreach ($arr as $fld => $val) {
        $inf = $this->cls->getInfo($cnt++, $val);
		switch ($style) { // apply functions to data only
			case "rh": $sec = "THead"; break;
			case "rf": $sec = "TFoot"; break;
			default:   $sec = "TData";
		}
        $out.= $this->tblCell($sec, $inf)."\n";
	}
	$qid = VEC::get($arr, "ID", -1);
    $out = $this->tblRowTpl($out, $style, $qid);
	return $out."\n";
}

// ***********************************************************
protected function tblRowTpl($data, $style, $qid) {
	switch ($style) {
		case "rf": $sec = "TSums"; break;
		case "rh": $sec = "TCols"; break;
		default:   $sec = "TRows";
	}
	$this->set("recid", $qid);
	$this->set("class", $style);
	$this->set("data",  $data);

    return $this->getSection($sec);
}

// ***********************************************************
protected function tblCell($sec, $inf) {
	if ($inf["hide"]) return "";

	$xxx = $this->merge($inf);
    return $this->getSection($sec);
}

// ***********************************************************
// retrieving current values
// ***********************************************************
public function getRec($index = 0) {
	return VEC::get($this->dat, $index);
}

protected function recID($arr) {
	return VEC::get($arr, "ID", 0);
}

// ***********************************************************
// handling navigation
// ***********************************************************
protected function current() {
    $lst = count($this->dat);
    $pge = $this->recall("cur", 0);

    switch (ENV::getParm("act", "x")) {
        case "f": $pge = 0;        break;
        case "p": $pge = $pge - 1; break;
        case "n": $pge = $pge + 1; break;
        case "l": $pge = 9999;
    }
    $max = $this->pages($lst); $pge = CHK::range($pge, $max);
    $xxx = $this->hold("cur", $pge);
    return $pge;
}

protected function pages($idx) {
//  with 3 lines per current:
//	0, 1, 2 => 1
//	3, 4, 5 => 2

    return intval(($idx - 1) / $this->lns);
}

protected function page($pge) {
	$fst = $pge * $this->lns;
	$lst = count($this->dat) - 1; #$this->lns;
	return CHK::range($fst, $lst);
}

// ***********************************************************
// filling templates
// ***********************************************************
protected function tblCode($body) {
    if (! $body) return "";

    $lst = count($this->dat); $lst = $this->pages($lst);
    $pge = $this->recall("cur", 0);

	$this->set("body", $body);
    $this->set("qid",  $this->oid);
    $this->set("1st",  $pge + 1);
    $this->set("cnt",  $lst + 1);

    return $this->getSection("main");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
