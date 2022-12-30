<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/localSubMenu.php");

*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class localSubMenu extends dropBox {

function __construct() {
	parent::__construct();
    $this->load("menus/localMenu.tpl");
    $this->set("class", "submenu");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
