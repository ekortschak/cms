<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

// ***********************************************************
// HOW TO USE
// ***********************************************************
see parent class

*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dropMenu extends dropBox {

function __construct() {
	parent::__construct();
    $this->load("menus/dropMenu.tpl");
}

// ***********************************************************
// display variants
// ***********************************************************
public function display($mode) {
	switch ($mode) {
		case "submenu": $this->set("class", "submenu"); return;
			# $tpl = "menus/localSubMenu.tpl"; break;
		default: return;
	}
	$this->load($tpl);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
