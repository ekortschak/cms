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
	$fso = APP::dir($fso);
	parent::__construct($fso);
}

// ***********************************************************
public function isVisible($tab) {
	if (EDITING != "view") return true;

	$xxx = $this->read($tab);
	return $this->get("props.sts", true);
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
