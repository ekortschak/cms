<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/qikSelect.php");

*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class qikSelect extends dropBox {

function __construct() {
	parent::__construct();
    $this->read("design/templates/menus/qikSelect.tpl");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
