<?php
/* ***********************************************************
// INFO
// ***********************************************************
turns templates as ini files

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("files/ini.php");

$ini = new iniTab($ini_file);

*/

incCls("files/ini.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniTab extends ini {
	protected $fname = "tab.ini";

function __construct($fso = TAB_ROOT) {
	parent::__construct($fso);
}

// ***********************************************************
public function getTitle($lng = CUR_LANG) {
	$out = $this->get("$lng.title"); if ($out) return $out;
	$out = $this->getDirName();
	return ucfirst($out);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
