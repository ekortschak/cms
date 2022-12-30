<?php
/* ***********************************************************
// INFO
// ***********************************************************
Intended to handle system messages ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/tooltip.php");

$tip = new tooltip();
$tip->setData($key, $tip);
$tip->show($type);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tooltip extends tpl {

function __construct($typ = "button") {
	parent::__construct();
	$this->load("msgs/tooltip.tpl");
}

public function setData($key, $tip) {
	$this->set("key", $key);
	$this->set("tip", $tip);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************

?>
