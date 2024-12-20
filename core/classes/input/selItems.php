<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to handle input instances for selector

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/selItems.php");

$itm = new selItems($pid);
$itm->add($uid, $input_object);

$out = $itm->getRow();
*/

incCls("input/selSection.php");

incCls("input/selInput.php");
incCls("input/selCombo.php");
incCls("input/selCheck.php");
incCls("input/selMulti.php");
incCls("input/selDate.php");
incCls("input/selImage.php");
incCls("input/selMemo.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selItems extends objects {
	private $itm = array();
	private $dic = true; // allow translations
	private $cur = "";   // last added item

function __construct($pid) {
	$this->register($pid);
}

private function add($uid, $inp) { // register an input object
	$this->itm[$uid][] = $inp; $idx = count($this->itm[$uid]) - 1;
	$this->cur = &$this->itm[$uid][$idx];
}

// ***********************************************************
// handling properties
// ***********************************************************
public function setProp($prop, $value) {
	$this->cur->set($prop, $value);
}

// ***********************************************************
// wrapper for text fields of all kinds
// ***********************************************************
private function inpTBox($class, $type, $uid, $value = "") {
	$inp = new $class($this->oid);
	$inp->setProps($this->vls, $this->dic);
	$inp->init($type, $uid, $value);

	$this->add($uid, $inp);
	return $inp->getValue($value);
}

// ***********************************************************
public function addInput($type, $uid, $value = "") {
	return $this->inpTBox("selInput", $type, $uid, $value);
}
public function addDate($type, $uid, $value) {
	return $this->inpTBox("selDate", $type, $uid, $value);
}
public function addCheck($type, $uid, $value) {
	return $this->inpTBox("selCheck", $type, $uid, $value);
}
public function addImage($type, $uid, $value = "") {
	return $this->inpTBox("selImage", $type, $uid, $value);
}

// ***********************************************************
// wrapper for multiple choice fields
// ***********************************************************
private function inpDBox($class, $type, $uid, $vls, $sel = NV) {
	if ($sel === NV) $sel = key($vls);

	$inp = new $class($this->oid);
	$inp->setProps($this->vls, $this->dic);
	$inp->init($type, $uid, $sel);
	$inp->setChoice($vls);

	$this->add($uid, $inp);
	return $inp->getValue($sel);
}

// ***********************************************************
public function addCombo($type, $uid, $vls, $sel = NV) {
	return $this->inpDBox("selCombo", $type, $uid, $vls, $sel);
}
public function addMulti($type, $uid, $vls, $sel = NV) {
	if ($sel === true) {
		$sel = array();

		foreach ($vls as $key => $val) {
			$sel[$key] = true;
		}
	}
	return $this->inpDBox("selMulti", $type, $uid, $vls, $sel);
}

// ***********************************************************
// wrapper for info
// ***********************************************************
public function inpHelp($class, $type, $info = "") {
	$inp = new $class();
	$inp->init($type, $info);

	$this->add(uniqid(), $inp);
}

public function inpMemo($type, $uid, $value = "") {
	$inp = new selMemo($this->oid);
	$inp->setProps($this->vls, $this->dic);
	$inp->init($type, $uid, $value);

	$this->add($uid, $inp);
	return $inp->getValue($value);
}

// ***********************************************************
// get output
// ***********************************************************
public function getData() {
	$out = array();

	foreach ($this->itm as $uid => $itm) {
		$inp = $this->itm[$uid][0];

		$out[$uid]["type"] = $inp->rowFormat();
		$out[$uid]["head"] = $inp->title();
		$out[$uid]["vals"] = $inp->values();
		$out[$uid]["data"] = $this->compact($uid);
	}
	return $out;
}

private function compact($uid) {
	$itm = $this->itm[$uid]; $out = "";

	foreach ($itm as $uid => $inp) {
		$out.= $inp->getTool();
	}
	return $out;
}

// ***********************************************************
public function toROnly() {
	$this->load("input/selView.tpl"); // display form data as plain text

	foreach ($this->itm as $itm) {
		foreach ($itm as $uid => $inp) {
			$inp->setType("txt");
		}
	}
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
