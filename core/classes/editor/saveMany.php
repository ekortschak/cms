<?php

/* ***********************************************************
// INFO
// ***********************************************************
basic functionality for saving input data
* invoked by core/include/load.save.php
* no public methods
*/

incCls("editor/iniWriter.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveMany {
	protected $oid = false;

function __construct() {
	$oid = ENV::getPost("oid");

	if ($oid) { // post data
		$this->oid = $oid;
		$this->exec();
	}
	else { // get data
		$this->exec_2();
	}
}

// ***********************************************************
// methods
// ***********************************************************
protected function exec() {
// dummy for derived classes
}
protected function exec_2() {
// dummy for derived classes
}

protected function get($key, $default = false) {
	$oid = $this->oid;
	$out = OID::get($oid, $key, NV); if ($out !== NV) return $out;
	$out = ENV::getPost($key, NV);   if ($out !== NV) return $out;
	return ENV::getParm($key, $default);
}

protected function env($key, $default = false) {
	return ENV::get($key, $default);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
