<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to handle input items without predefined list of choices

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/selInput.php");

$itm = new selInput($parent_id);
$itm->init($type, $title, $value);
$itm->set("title", $title);
$itm->set("value", $default);
$itm->set("fname", $db_field_name);

$head = $itm->th();
$data = $itm->td();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selInput extends tpl {
	protected $pid = -1;	// parent oid

function __construct($pid) {
	parent::__construct();
	$this->read("design/templates/input/selCSV.tpl"); if (CUR_DEST == "screen")
    $this->read("design/templates/input/selInput.tpl");

	$this->set("oid", $pid);

 // TODO: implement the following
	$this->set("lf", true);		// append a "lf"
	$this->set("mask", false);	// transform values
	$this->set("perms", "w");	// table permissions

	$this->set("dhead", "x");	// dbf head
	$this->set("dtype", "x");	// dbf type
}

public function init($type, $qid, $value, $lang) {
	$cap = STR::between($qid, "[", "]"); if (! $cap) $cap = $qid;
	if ($this->xlate) $cap = DIC::get($cap, $lang);

	$this->setTitle($cap);
	$this->setFname($qid);
	$this->setValue($value);
	$this->set("sec", STR::left($type)); // refers to template section
}

public function setXlate($value) {
	$this->xlate = (bool) $value;
}

// ***********************************************************
// handling items
// ***********************************************************
public function set($prop, $value) {
	switch ($prop) {
		case "fname": $this->setFName($value); return;
		case "title": $this->setTitle($value); return;
		case "value": $this->setValue($value); return;
		case "info":  $this->setInfo($value);  return;
	}
	parent::set($prop, $value);
}

// ***********************************************************
protected function setFName($fname) {
	parent::set("fname", $fname);
}

protected function setTitle($caption) {
 // user prompt to clarify required input
	parent::set("title", $caption);
}

protected function setValue($value = NV) {
 // will receive "initial" value, actual value from session
	if (is_array($value)) $value = "Array";
	$val = str_replace('"', "'", $value);
	$val = $this->getCurrent($val);
	parent::set("curVal", $val);
}

protected function setInfo($info = "") {
 // additional information for better understanding
	$inf = DIC::get($info);
	parent::set("info", $info);
}

// ***********************************************************
public function getValue() {
	return $this->get("curVal");
}
public function getKey() {
	return $this->get("curVal");
}

// ***********************************************************
// output
// ***********************************************************
public function th() {
	if (CUR_DEST != "screen") return $this->get("title");
	return $this->gc("head");
}
public function td() {
	$typ = $this->getType();
	return $this->gc("input.$typ");
}

// ***********************************************************
protected function getCurrent($default) { // get session value
	$oid = $this->get("oid");
	$key = $this->get("fname");

	$xxx = ENV::setIf("sel.$key", $default);
	$old = ENV::get("sel.$key"); // getDefaultValue

	if ($old != $default) {
		return ENV::set("sel.$key", $default);
	}
	return $this->getOidVar("val_$key", $default);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
public function setType($value) {
	$this->set("sec", $value);
}
protected function getType() {
	$rgt = $this->get("perms");

	if (CUR_DEST != "screen") {
		if ($rgt == "h") return "skip";
		return "csv";
	}
	if ($rgt == "h") return "hid";
	if ($rgt == "r") return "ron";
	if ($rgt == "w") return $this->get("sec");
	return "noxs";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
