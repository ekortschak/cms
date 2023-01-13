<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to handle visual support for user orientation in selectors
* no automatic translations

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/selSection.php");

$itm = new selSection($parent_id);
$itm->init($type, $title, $value);

$out = $itm->getRow();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selSection extends tpl {
	protected $dic = false;

function __construct() {
	parent::__construct();
	$this->load("input/selSection.tpl");
}

public function init($type, $info) {
	$this->setInfo($info);
	$this->setType($type); // refers to template section
}

// ***********************************************************
// handling properties
// ***********************************************************
protected function setInfo($info) {
 // user prompt to clarify required input
	$this->set("info", $info);
}

protected function setType($value) {
	$this->set("sec", $value);
}
protected function getType() {
	if (CUR_DEST != "screen") return "txt";
	return $this->get("sec");
}

// ***********************************************************
// output
// ***********************************************************
public function rowFormat() {
	return "line";
}

public function getTitle() {
	$typ = $this->getType();
	return $this->getSection("sec.$typ");
}

public function getTool() {
	return false;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
