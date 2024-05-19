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
	$this->oid = ENV::getPost("oid");
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
protected function exec() {
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
