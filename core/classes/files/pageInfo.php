<?php
/* ***********************************************************
// INFO
// ***********************************************************
This is used to handle file information

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("files/pageInfo.php");

$obj = new pageInfo($file);
*/

incCls("files/fileInfo.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class pageInfo extends fileInfo {
	private $txt = "";

function __construct($file = NV) {
	parent::__construct($file);
}

// ***********************************************************
// setting & retrieving info
// ***********************************************************
public function load($file = NV) {
	$this->init($file);
	$this->txt = file_get_contents($file);
	return $this->txt;
}

public function setContent($text) { $this->txt = $text; }
public function append($text)     {	$this->txt.= $text; }
public function reset()           {	$this->txt = "";    }

public function getLink($after = "", $mode = "view") {
	$url = $this->get("path");
	$cap = $this->get("full"); if ($after) $cap = STR::afterX($cap, $after);
	$lst = ($after) ? "~" : "";
	return HTM::href("?pge=$url&vmode=$mode", $lst.$cap);
}

public function save() {
	if ($file === NV) $file = $this->file;
	return file_get_contents($file);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
