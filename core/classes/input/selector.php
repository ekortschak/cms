<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create data entry forms

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/selector.php");

$sel = new selector();
$sel->input("TITEL", "TEXT");
$sel->setProp("title", "Titel");
$sel->show();

*/

incCls("input/selItems.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selector extends tpl {
	protected $itm = false; // list of input instances
	protected $tpl = "design/templates/input/selView.tpl";

function __construct() {
	parent::__construct();
	$this->setTpl("design/templates/input/selector.tpl");

	$this->read($this->tpl);
	$this->register();
}

protected function setTpl($tpl) {
	if (CUR_DEST == "screen") $this->tpl = $tpl;
}

public function register($oid = NV, $sfx = "*") {
	parent::register($oid, $sfx);
	$this->reset();
}

public function act() {
	$chk = ENV::getPost("oid"); if ($chk != $this->oid) return false;
	return ENV::getPost("act");
}

protected function reset() {
	$this->itm = new selItems();
	$this->itm->register($this->oid);
}

// ***********************************************************
// standard input tools
// ***********************************************************
public function input($uid, $value = "") {
	return $this->itm->addInput("std", $uid, $value);
}
public function number($uid, $value = "") {
	return $this->itm->addInput("num", $uid, $value);
}
public function upload($uid) {
	return $this->itm->addInput("upl", $uid);
}
public function email($uid, $value = "") {
	return $this->itm->addInput("eml", $uid, $value);
}
public function pwd($uid) { // password - no value !
	return $this->itm->addInput("pwd", $uid);
}

// ***********************************************************
public function hidden($uid, $value) { // hidden values
	return $this->itm->addInput("hid", $uid, $value);
}

// ***********************************************************
public function date($uid, $value) {
	return $this->itm->addDate("dat", $uid, $value);
}

// ***********************************************************
public function tarea($uid, $value = "", $rows = 4) { // text area
	$out = $this->itm->addInput("tar", $uid, $value);
	$xxx = $this->itm->set("rows", $rows);
	return $out;
}

// ***********************************************************
// clickable input fields
// ***********************************************************
public function check($uid, $value = 0) { // check box
	return $this->itm->addCheck("chk", $uid, $value);
}

public function radio($uid, $options, $sel = NV) { // radio buttons
	return $this->itm->addCombo("opt", $uid, $options, $sel);
}

public function combo($uid, $vls, $sel = NV) { // combo
	return $this->itm->addCombo("cmb", $uid, $vls, $sel);
}
public function range($uid, $sel, $min = 0, $max = 100) { // slider
	$vls = range($min, $max);
	return $this->itm->addCombo("rng", $uid, $vls, $sel);
}

public function multi($uid, $vls, $sel = NV) { // multiple choice
	return $this->itm->addMulti("mul", $uid, $vls, $sel);
}

// ***********************************************************
public function image($uid, $value, $file) { // image button
 // TODO: set divisions, height ... (e.g. rating)
	$fil = APP::file($file); if (! $fil)
	$fil = APP::file(FSO::join(ICONS, "input", $fil));

	$out = $this->itm->addImage("img", $uid, $value);
	$xxx = $this->itm->setProp("file", $fil);
	return $out;
}

public function color($uid, $val = "") { // color
	return $this->itm->addInput("col", $uid, $val);
}

// ***********************************************************
// read only information
// ***********************************************************
public function ronly($uid, $value = "") { // locked input
	return $this->itm->addInput("ron", $uid, $value);
}
public function boole($uid, $value = "") { // read only checkbox
	$val = ((bool) $value) ? BOOL_YES : BOOL_NO;
	return $this->itm->addInput("inf", $uid, $val);
}
public function key($uid, $value) { // primary key
	return $this->itm->addInput("key", $uid, $value);
}

public function info($uid, $value = "") { // comment
	return $this->itm->addInput("inf", $uid, $value);
}

// ***********************************************************
// visual support for user orientation
// ***********************************************************
public function section($uid = NV) { // add a section heading
	$this->itm->inpHelp("selSection", "cap", $uid);
}
public function space() { // add space between sections
	$this->itm->inpHelp("selSection", "spc");
}

// ***********************************************************
public function glue($uid, $value) {
	$this->itm->addInput("txt", $uid, $value);
}

// ***********************************************************
// handling properties
// ***********************************************************
public function setProp($prop, $value) {
	$this->itm->setProp($prop, $value);
}

// ***********************************************************
// output
// ***********************************************************
public function xShow() {
	if ($this->act()) $this->itm->toROnly();
	return $this->show();
}

public function show($sec = "main") {
	$htm = $this->gc($sec); echo $htm;
	$out = $this->act();
	$xxx = $this->reset();
	return $out;
}

public function gc($sec = "main") {
	$inp = $this->itm->getData(); $out = "";
	$vls = $this->getValues();

	$this->set("oid", $this->oid);

	foreach ($inp as $uid => $inf) {
		extract($inf);

		$this->set("head", $head);
		$this->set("data", $data);
		$this->merge($vals);

		$out.= $this->getSection($type);

		$this->vls = $vls;
	}
	$this->set("items", $out);

	return $this->getSection($sec);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
