<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/localMenu.php");

*/

incCls("menus/dropbox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class localMenu extends dbox {

function __construct() {
	parent::__construct();
    $this->read("design/templates/menus/localMenu.tpl");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>