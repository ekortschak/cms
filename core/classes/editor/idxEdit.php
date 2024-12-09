<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create checkList boxes in selectors.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/checkList.php");

$lst = new checkList($name);
$lst->addItem($key, $value)
$lst->show();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class idxEdit extends objects {

function __construct() {
}

// ***********************************************************
// methods
// ***********************************************************
public function save($key, $value = "") {
	$arr = OID::values();

	foreach ($arr as $fil => $val) {
		$fil = $this->getFile($fil);

		switch ($val) {
			case true: $this->saveKey($fil, $key, $value); break;
			default:   $this->dropKey($fil, $key);
		}
	}
}

private function saveKey($fil, $key, $val) {
	$ini = new iniWriter();
	$ini->read($fil);
	$ini->set("data.$key", $val);
	$ini->save();
}

private function dropKey($fil, $key) {
	$ini = new iniWriter();
	$ini->read($fil);
	$ini->dropKey("data.$key");
	$ini->save();
}

public function isIndex($fil, $key) {
	$ini = new ini($fil);
	return $ini->isKey("data.$key");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getFile($key) {
	$drs = FSO::fTree("index");
	$drs = array_flip($drs);
	return VEC::get($drs, "$key.ini");
}

// ***********************************************************
// retrieving properties
// ***********************************************************
public function title($fil) {
	$ini = new ini($fil);
	return $ini->title();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function section($key) {
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
