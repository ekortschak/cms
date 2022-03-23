<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create user input filters (forms)

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/selector.php");

$sel = new selector();
$sel->input("TITEL", "TEXT");
$sel->setProp("title", "Titel");
$sel->show();

*/

incCls("other/items.php");

incCls("input/selInput.php");
incCls("input/selCombo.php");
incCls("input/selCheck.php");
incCls("input/selMulti.php");
incCls("input/selDate.php");
incCls("input/selImage.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selector extends tpl {
	protected $xlate = true;
	protected $focus = ""; // address of current item
	protected $itm = array();
	protected $lng = CUR_LANG;
	protected $cnt;

function __construct() {
	parent::__construct();
	$this->read("design/templates/input/selector.tpl");	if (CUR_DEST != "screen")
	$this->read("design/templates/input/selROnly.tpl");

	$this->setOID();
	$this->set("tan", -1);
	$this->reset();
}

private function reset() {
	$this->cnt = 1;
	$this->itm = $this->idx = array();
}

public function forget() {
	ENV::forget($this->get("oid"));
}

// ***********************************************************
// basic input types
// ***********************************************************
private function add($uid, $inp) { // register an input object
	$this->itm[$uid][] = $inp;
	$this->cnt++;

#	TODO: $inp->merge($this->vls);

	$idx = count($this->itm[$uid]) - 1;
	$this->focus = "$uid:$idx";
	return $inp->getValue();
}

// ***********************************************************
private function addInput($type, $uid, $value = "") {
	$oid = $this->get("oid");

	$inp = new selInput($oid);
	$inp->setXlate($this->xlate);
	$inp->init($type, $uid, $value, $this->lng);

	return $this->add($uid, $inp);
}

// ***********************************************************
private function addImage($type, $uid, $value = "") {
	$oid = $this->get("oid");

	$inp = new selImage($oid);
	$inp->setXlate($this->xlate);
	$inp->init($type, $uid, $value, $this->lng);

	return $this->add($uid, $inp);
}

// ***********************************************************
private function addCombo($type, $uid, $vls, $sel = NV) {
	if (! $vls) $vls = array("0", "Array Empty");
	if ($sel == NV) $sel = VEC::getFirst($vls);

	$oid = $this->get("oid");

	$inp = new selCombo($oid);
	$inp->setXlate($this->xlate);
	$inp->merge($this->vls);
	$inp->setChoice($vls);
	$inp->init($type, $uid, $sel, $this->lng);

	return $this->add($uid, $inp);
}

// ***********************************************************
private function addMulti($type, $uid, $vls, $sel = NV) {
	if (! is_array($sel)) $sel = array($sel);

	$oid = $this->get("oid");
	$sel = $this->getOIDs($uid, $sel);

	$inp = new selMulti($oid);
	$inp->setXlate($this->xlate);
	$inp->init($type, $uid, NV, $this->lng);
	$inp->setMChoice($vls, $sel);

	return $this->add($uid, $inp);
}

// ***********************************************************
private function addCheck($type, $uid, $value) {
	$oid = $this->get("oid");

	$inp = new selCheck($oid);
	$inp->setXlate($this->xlate);
	$inp->init($type, $uid, $value, $this->lng);
	$inp->setChoice("YES / NO");

	return $this->add($uid, $inp);
}

// ***********************************************************
private function addDate($type, $uid, $value) {
	$oid = $this->get("oid");

	$inp = new selDate($oid);
	$inp->setXlate($this->xlate);
	$inp->init($type, $uid, $value, $this->lng);

	return $this->add($uid, $inp);
}

// ***********************************************************
private function addHidden($type, $uid, $val) {
	$xxx = $this->set("fname", $uid);
	$xxx = $this->set("value", $val);

	$hid = $this->get("hidden", "");
	$hid.= $this->getSection("input.hid");
	$xxx = $this->set("hidden", $hid);
	return $val;
}

// ***********************************************************
// visual support for user
// ***********************************************************
public function ronly($caption, $val = "") { // locked input
	$out = $this->addInput("ron", $caption, $val);
	$xxx = $this->setProp("perms", "r");
	return $out;
}
public function info($caption, $val = "") { // comment
	return $this->addInput("inf", $caption, $val);
}
public function key($caption, $val) { // primary key
	return $this->addInput("key", $caption, $val);
}

public function section($caption = NV) { // add a section heading
	if ($this->cnt++ > 1) $this->space();

	$cap = DIC::get($caption); if ($cap == "<hr>") $cap = "";
	$xxx = $this->set("title", $cap);
	$sec = $this->getSection("SubSection");
	$this->itm[uniqid()][] = $sec;
}
private function space() { // add a section heading
	$sec = $this->getSection("spacer");
	$this->itm[uniqid()][] = $sec;
}

public function glue($caption, $glue) {
	$cap = DIC::get($caption); if ($cap == "<hr>") $cap = "";
	$this->itm[$cap][] = $glue;
}

// ***********************************************************
// standard input tools
// ***********************************************************
public function tarea($caption, $val = "", $rows = 4) { // text area
	$out = $this->addInput("box", $caption, $val);
	$xxx = $this->setProp("rows", $rows);
	return $out;
}

public function input($caption, $value = "") {
	return $this->addInput("std", $caption, $value);
}
public function number($caption, $value = "") {
	return $this->addInput("num", $caption, $value);
}
public function email($caption, $val = "") {
	return $this->addInput("eml", $caption, $val);
}
public function pwd($caption) { // password - no value !
	return $this->addInput("pwd", $caption, "");
}

// ***********************************************************
public function hidden($key, $val) { // hidden values
	return $this->addHidden("hid", $key, $val);
}

public function date($caption, $val) {
	return $this->addDate("dat", $caption, $val);
}

public function upload($caption) {
	return $this->addInput("upl", $caption);
}

// ***********************************************************
// clickable input fields
// ***********************************************************
public function multi($caption, $vls, $sel = NV) { // multiple choice
	return $this->addMulti("mul", $caption, $vls, $sel);
}

public function combo($caption, $vls, $sel = NV) { // combo
	return $this->addCombo("cmb", $caption, $vls, $sel);
}

public function range($caption, $sel, $min = 0, $max = 100) { // slider
	$vls = range($min, $max);
	return $this->addCombo("rng", $caption, $vls, $sel);
}

public function radio($caption, $options, $sel = NV) { // radio buttons
	return $this->addCombo("opt", $caption, $options, $sel);
}

public function check($caption, $value = 0) { // check box
	return $this->addCheck("chk", $caption, $value);
}

// ***********************************************************
public function image($caption, $value, $file) { // image button
 // TODO: set divisions, height ... (e.g. rating)
	$fil = APP::file($file); if (! $fil)
	$fil = APP::file(FSO::join("core/icons/input", $fil));

	$out = $this->addImage("img", $caption, $value);
	$xxx = $this->setProp("file", $fil);
	return $out;
}

public function color($caption, $val = "") { // color
	return $this->addInput("col", $caption, $val);
}

// ***********************************************************
// other methods
// ***********************************************************
public function setProps($col) { // collection
	if (! is_array($col)) return;

	foreach ($col as $name => $arr) {
		foreach ($arr as $prop => $val) {
			$this->setProp($prop, $val);
		}
	}
}

public function setProp($prop, $value) {
	$uid = STR::before($this->focus, ":"); if (! $uid) return;
	$idx = STR::after( $this->focus, ":");

	$this->itm[$uid][$idx]->set($prop, $value);
}

public function setLang($lang = CUR_LANG) {
	$this->lng = $lang;
}

// ***********************************************************
// output
// ***********************************************************
public function xShow() {
	$act = $this->act();

	if ($act) {
		$this->read("design/templates/input/selView.tpl"); // display form data as plain text
		foreach ($this->itm as $itm) {
			foreach ($itm as $inp) {
				if (! is_object($inp)) continue;
				$inp->setType("txt ");
			}
		}
	}
	return $this->show();
}

public function show($sec = "main") {
	$htm = $this->gc($sec); echo $htm;
	$out = $this->act();
	$xxx = $this->reset();
	return $out;
}
public function gc($sec = "main") {
	$arr = $this->collect(); $out = "";

	foreach ($arr as $uid => $itm) {
		foreach ($itm as $key => $val) { // glued items
			if ($key == $uid) { // separator
				$out.= $val;
			}
			else {
				$this->set("head", $key);
				$this->set("data", $val);
				$out.= $this->getSection("rows");
			}
		}
	}
	$this->set("items", $out);
	return $this->getSection($sec);
}

// ***********************************************************
private function collect() { // collect glued entries
	$out = array();

	foreach ($this->itm as $uid => $itm) {
		$head = $uid; $cnt = 0;
		$data = "";

		foreach ($itm as $inp) {
			if (! is_object($inp)) { // glue or separator
				$data.= $inp;
			}
			else {
				$data.= $inp->td(); if ($cnt++ < 1)
				$head = $inp->th();
			}
		}
		$out[$uid] = array($head => $data);
	}
	return $out;
}

// ***********************************************************
// querying obj props
// ***********************************************************
public function act() {
	$oid = $this->get("oid");
	return ENV::getPost($oid."_act", false);
}
public function getButton() { // which button has been pressed
	return $this->getOidVar("act");
}

public function getValues($pfx = "val_") {
	$oid = $this->get("oid"); $out = array();
	return ENV::oidValues($oid, $pfx);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
