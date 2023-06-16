<?php
/* ***********************************************************
// INFO
// ***********************************************************
This is used to handle file information

Thumbs are expected to be found in a subdir of

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("files/csv.php");

$csv = new csv($sep, $heads = true);
$csv->read($fil);
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class csv {
	protected $heds = array();
	protected $data = array();
	protected $cRow = array();

	protected $rows = 0;
	protected $rIdx = 0;

	protected $file = "";
	protected $tpl = "";
	protected $sep = ",";
	protected $fst = false; // first line contains col heads

// ***********************************************************
function __construct($sep = ",", $heads = true) {
	$this->sep = $sep; if ($heads)
	$this->fst = true;
}

// ***********************************************************
// reading & writing
// ***********************************************************
public function read($file = "") {
	$this->file = $file;
	$rws = file($file); if (! $rws) return false;

    foreach ($rws as $lin) {
		if (! trim($lin)) continue; if (STR::begins($lin, "#")) continue;
        $out[] = str_getcsv($lin, $this->sep);
    }
	$this->setData($out);
}

public function setTemplate($file) {
	$this->tpl = $file;
}

// ***********************************************************
public function write($file = NV) {
	if ($file === NV) $file = $this->file;

	$out = array();
	$hed = "No Headers!"; if ($this->heds) $hed = implode($this->sep, $this->heds);
	$out[] = $hed;

	foreach ($this->data as $lin) {
		$out[] = implode($this->sep, $lin);
	}
	$out = implode("\n", $out);
	$out = strip_tags($out);
	$out = str_replace("&check;", "✓", $out);
	$out = str_replace("&cross;", "✗", $out);

	return APP::write($file, $out);
}

// ***********************************************************
// setting & retrieving data
// ***********************************************************
public function setData($arr) {
	$out = array(); $cnt = 0;

	foreach ($arr as $row) {
		foreach ($row as $val) {
			$out[$cnt][] = trim($val);
		}
		$cnt++;
	}
    $this->heds = array_shift($out);
	$this->data = $out;
    $this->rows = count($out);
	$this->rIdx = 0;
}

public function getHeads() {
	return $this->heds;
}
public function getData() {
	return $this->data;
}

public function getRecs($arr = "*") {
	$out = array();
	foreach ($this->data as $row) {
		$out[] = array_combine($this->heds, $row);
	}
	return $out;
}

// ***********************************************************
// filtering data
// ***********************************************************
public function filter($val) {
	$out = array();

	foreach ($this->data as $row) {
		$rec = "|".implode("|", $row)."|";
		if (STR::misses($rec, $val)) continue;
		$out[] = array_combine($this->heds, $row);
	}
	return $out;
}

// ***********************************************************
// retrieving column info
// ***********************************************************
public function getColumns() {
	return $this->heds;
}
public function getRec($cols = "*") {
 // returns specified columns only of current record
 // $cols = array("colName" => "caption")

	if ($cols == "*") $cols = $this->getColumns();
	$out = array();

	foreach ($cols as $key => $caption) {
		$out[$caption] = $this->getVal($key);
	}
	return $out;
}

// ***********************************************************
// retrieving data pairs
// ***********************************************************
public function getPairs($kidx, $vidx = false) {
	$out = array(); if (! $vidx) $vidx = $kidx;
	$kidx = $this->getIndex($kidx);
	$vidx = $this->getIndex($vidx);

	foreach ($this->data as $row) {
		$key = VEC::get($row, $kidx); if (! $key) continue;
		$val = VEC::get($row, $vidx);
		$out[$key] = $val;
	}
	return $out;
}

// ***********************************************************
// rows
// ***********************************************************
public function findRow() {
	if ($this->rIdx >= $this->rows) return false;
	$this->cRow = $this->data[$this->rIdx++];
	return true;
}

// ***********************************************************
// retrieving values
// ***********************************************************
public function getInt($hed, $default = "") {
	$out = $this->getVal($hed, $default);
	$out = STR::before("$out,", ",");
	$out = STR::clear($out, ".");
	return intval($out);
}
public function getDec($hed, $default = "") {
	$out = $this->getVal($hed, $default);
	$out = STR::clear($out, ".");
	$out = str_replace(",", ".", $out);
	return floatval($out);
}

public function getVal($hed, $default = "") {
	if (! $this->cRow) $this->findRow();
	$hed = $this->getIndex($hed);
	return VEC::get($this->cRow, $hed, $default);
}

private function getIndex($hed) {
	if (! is_array($this->heds)) return false;
	if (is_numeric($hed)) return $hed;
	return array_search($hed, $this->heds);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
