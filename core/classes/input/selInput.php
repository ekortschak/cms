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
	protected $dic = false;
	protected $pid = -1;	// parent oid
	protected $uid = -1;	// identifier

function __construct($pid) {
	parent::__construct();

	$this->register($pid);
	$this->load("input/selInput.tpl");
	$this->set("perms", "w"); // table permissions
}

public function init($type, $qid, $default) {
	$this->uid = $qid;

	$this->setTitle($qid);
	$this->setFname($qid);
	$this->setValue($default);
	$this->setType($type); // refers to template section
}

// ***********************************************************
// handling properties
// ***********************************************************
public function setProps($props, $dic = true) {
	$this->merge($props);
	$this->dic = (bool) $dic;
}

public function setProp($prop, $value) {
	$this->set($prop, $value);
}

// ***********************************************************
// handling items
// ***********************************************************
public function set($prop, $value) {
	switch ($prop) {
		case "fname": $this->setFName($value); return;
		case "title": $this->setTitle($value); return;
		case "value": $this->setValue($value); return;
		case "fnull": $this->setNull($value);  return;
		case "info":  $this->setInfo($value);  return;
	}
	parent::set($prop, $value);
}

// ***********************************************************
protected function setFName($fname) {
	$nam = STR::replace($fname, ".", "_");
	parent::set("fname", $nam);
}

protected function setTitle($caption) {
 // user prompt to clarify required input
	$cap = STR::between($caption, "[", "]"); if (! $cap) $cap = $caption;
	$cap = $this->xlate($cap);

	parent::set("title", $cap);
}

protected function setValue($default = NV) {
 // will receive "initial" value, actual value from session
	$val = $this->getValue($default);
	parent::set("curVal", $val);
}

protected function setNull($value = NV) {
 // force input ?
	$val = $value ? "" : "*";
	parent::set("fnull", $val);
}

protected function setInfo($info = "") {
 // additional information for better understanding
	$inf = $this->xlate($info);
	parent::set("info", $inf);
}

// ***********************************************************
// output
// ***********************************************************
public function rowFormat() {
	$typ = $this->getType();
	if ($typ == "hid") return "hidden";
	return "rows";
}

public function title() {
	return $this->getSection("head");
}
public function getTool() {
	$typ = $this->getType();
	return $this->getSection("input.$typ");
}

// ***********************************************************
public function setSec($sec, $value = "") {
	parent::setSec($sec, $value);
}

// ***********************************************************
public function post($default = NV) { // get session value
	$key = $this->get("fname");
	return $this->recall($key, $default);
}

public function getValue($default = NV) { // get session value
	$out = $this->get("curVal", NV); if ($out !== NV) return $out;
	$out = $this->post($default);
	return self::secure($out);
}

// ***********************************************************
// translations
// ***********************************************************
private function xlate($cap, $lang = CUR_LANG) {
	if (! $this->dic) return $cap;
	return DIC::get($cap, $lang);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
public function setType($value) {
	$this->set("typ", $value);
}
public function getType() {
	$typ = $this->get("typ");
	$rgt = $this->get("perms"); if ($typ == "hid") $rgt = "h";

	if (CUR_DEST != "screen") {
		if ($rgt == "h") return "skip";
		return "txt";
	}
	if ($rgt == "h") return "hid";
	if ($rgt == "r") return "ron";
	if ($rgt == "w") return $typ;
	return "noxs";
}

private function secure($val) {
	$val = str_replace('"', "<dqot>", $val);
	return $val;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
