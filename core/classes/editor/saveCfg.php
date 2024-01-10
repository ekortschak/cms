<?php

if (TAB_SET != "config") return;

/* ***********************************************************
// INFO
// ***********************************************************
see parent
*/

new saveCfg();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveCfg extends saveMany {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// methods
// ***********************************************************
protected function exec() {
	$fil = $this->get("edit.file"); if (! $fil) return;

	$ini = new iniWriter();
	$ini->read($fil);
	$ini->savePost();

	$this->update($fil);
}

private function update($fil) {
	if (STR::misses($fil, "mods.ini")) return;

	foreach ($_POST as $sec => $lst) {
		foreach ($lst as $key => $val) {
			CFG::update("mods:$sec.$key", $val);
		}
	}
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

