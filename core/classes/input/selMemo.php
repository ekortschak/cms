<?php
/* ***********************************************************
// INFO
// ***********************************************************
Modified to handle specifically memo fields in ini files

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/selMemo.php");
# see selector.php
*/

incCls("input/selInput.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selMemo extends selInput {

function __construct($pid) {
	parent::__construct($pid);
    $this->load("input/selMemo.tpl");
}

// ***********************************************************
// output
// ***********************************************************
public function rowFormat() {
	return "span";
}

public function title() {
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
