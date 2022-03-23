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

incCls("tables/columns.php");
incCls("input/combo.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class htm_table extends tpl {
    protected $cls;             // column info object
	protected $dat = array();   // table data rows

	private $lns = 25;          // max lines per page
	private $max = 250;			// max lines per screen

function __construct() {
	parent::__construct();

	$tpl = "design/templates/tables/std.tpl"; if (CUR_DEST == "csv")
	$tpl = "design/templates/tables/csv.tpl";
	$this->read($tpl);

    $this->cls = new tblCols();
}

// ***********************************************************
// handling columns
// ***********************************************************
public function addCols($hed) {
	$this->cls->addItems($hed);
}
public function addCol($col, $inf = array()) {
	$this->cls->addItem($col, $inf);
}

public function setHeads($colheads) {
	$arr = VEC::explode($colheads, ","); $cnt = 0;

	foreach ($arr as $val)
		$this->cls->setProp($cnt++, "head", $val);
}

public function setLines($num) {
	$this->lns = CHK::range($num, 500, 1);
}

// ***********************************************************
public function mergeProps($arr) { // $arr set by items->getItems();
	foreach ($arr as $name => $props) {
		foreach ($props as $key => $val) {
			$this->setProp($name, $key, $val);
		}
	}
}
public function setProps($col) { // collection
	foreach ($col as $name) {
		$this->cls->setProps($name, $col);
	}
}
public function setProp($col, $prop, $value) {
	$this->cls->setProp($col, $prop, $value);
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

public function addArray($data) {
	$this->cls->addItem("Key");
	$this->cls->addItem("Value");

	foreach ($data as $key => $val) {
		$this->dat[] = array($key, $val);
	}
}

// ***********************************************************
// DISLPLAY
// ***********************************************************
public function gc($sec = "main") {
    $rcs = count($this->dat);

    if ($rcs < 1) {
		$this->read("design/templates/tables/empty.tpl");
		$out = $this->getSection("main");
		return "$out\n";
	}
	$dat = $this->getRows(); $fut = "";
	$hed = $this->getRow("rh", $this->cls->getInfo("head"));
	$fut = $this->getRow("rf", $this->cls->getInfo("foot"));

	if ($rcs < $this->lns) {
		$this->setSec("stats", "");
		$this->setSec("nav", "");
	}
	$out = $this->getTable($hed.$dat.$fut);
	return "$out\n";
}

// ***********************************************************
// handling rows
// ***********************************************************
public function rowCount() {
	return count($this->dat);
}

private function getRows() {
	$pge = $this->getPage(); $out = "";

    $fst = $this->getFirst($pge);
    $lst = $fst + $this->lns;

    for ($i = $fst; $i < $lst; $i++) {
		$rec = $this->getRec($i); if (! $rec) continue;
		$qid = $this->getRecID($rec);

		$xxx = $this->cls->set("recid", $qid);
		$out.= $this->getRow("rw", $rec);
	}
    return $out;
}

// ***********************************************************
private function getRow($style, $arr) {
    if (count($arr) < 1) return ""; $out = ""; $cnt = 0;

    foreach ($arr as $val) {
        $inf = $this->cls->getColInfo($cnt++, $val);
        if ($inf["hide"]) continue;

        switch ($style) { // apply functions to data only
            case "rh":
            case "rf": $sec = "THead"; break;
            default:   $sec = "TData";
        }
        $out.= $this->getCell($sec, $inf)."\n";
	}
	$qid = isset($arr["ID"]) ? $arr["ID"] : -1;
    $out = $this->getLine($out, $style, $qid);
	return $out."\n";
}

// ***********************************************************
private function getLine($data, $style, $qid) {
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
private function getCell($sec, $inf) {
	$xxx = $this->merge($inf);
    return $this->getSection($sec);
}

// ***********************************************************
// retrieving current values
// ***********************************************************
public function getRec($index = 0) {
	return VEC::get($this->dat, $index);
}
public function getCurVal($colIndex, $default = NV) {
	$rec = VEC::get($this->dat, 0);
	return VEC::get($rec, $colIndex, $default);
}

private function getRecID($arr) {
	return VEC::get($arr, "ID", 0);
}

// ***********************************************************
// handling navigation
// ***********************************************************
private function getPage() {
    $pge = $this->get("page", 0);
    $lst = count($this->dat);

    switch (ENV::getParm("act", "x")) {
        case "f": $pge = 0;        break;
        case "p": $pge = $pge - 1; break;
        case "n": $pge = $pge + 1; break;
        case "l": $pge = 9999;
    }
    $max = $this->getPageNum($lst);
    $pge = CHK::range($pge, $max);
    $xxx = $this->set("page", $pge);
    return $pge;
}

private function getPageNum($idx) {
//  with 3 lines per page:
//	0, 1, 2 => 1
//	3, 4, 5 => 2

    return intval(($idx - 1) / $this->lns);
}

private function getFirst($pge) {
	$fst = $pge * $this->lns;
	$lst = count($this->dat) - 1; #$this->lns;
	return CHK::range($fst, $lst);
}

// ***********************************************************
// filling templates
// ***********************************************************
private function getTable($body) {
    if (! $body) return "";

    $lst = count($this->dat); $lst = $this->getPageNum($lst);
    $pge = $this->get("page", 0);

	$this->set("body", $body);
    $this->set("qid",  $this->get("oid"));
    $this->set("cur",  $pge);
    $this->set("1st",  $pge + 1);
    $this->set("cnt",  $lst + 1);

    return $this->getSection("main");
}

private function getQid() {
	return VEC::get($this->dat[0], "ID", -1);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
