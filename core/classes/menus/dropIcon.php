<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/dropIcon.php");

*/

incCls("menus/dropbox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dropIcon extends dbox {

function __construct() {
	parent::__construct();
    $this->read("design/templates/menus/dropIcon.tpl");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
