<?php

/* ***********************************************************
// INFO
// ***********************************************************
used to convert a topic to a single document

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("ebook/toctool.php");

$toc = new toctool();
*/

incCls("editor/iniWriter.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class toctool extends iniWriter {
	private $cnt = 1;

function __construct() {
	$fil = FSO::join(TAB_HOME, "toc.ini");

	$this->read($fil);
	$this->addSec("toc");
}

// ***********************************************************
// read info
// ***********************************************************
public function set($key, $val = "¬") {
	if (! $key) return;

	$cnt = $this->cnt++;
	$pge = $this->get($key, $val);

	if ($pge == "¬") $pge = $cnt;
	if ($pge > $cnt) $cnt = $pge;

	parent::set("toc.$key", $pge);

	$this->cnt = $pge;
}

public function get($key, $val = "-") {
	return parent::get("toc.$key", $val);
}

// ***********************************************************
public function write() {
	$arr = PGE::getToc();

	foreach ($arr as $num => $cap) {
		$this->set($num, 0);
	}
	parent::save();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
