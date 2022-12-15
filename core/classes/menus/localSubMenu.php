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

incCls("menus/dropbox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class localSubMenu extends dbox {

function __construct() {
	parent::__construct();
    $this->read("design/templates/menus/localMenu.tpl");
    $this->set("class", "submenu");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
