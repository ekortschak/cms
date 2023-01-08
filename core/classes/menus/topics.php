<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to display page topics

*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class topics extends dropBox {
	protected $data = array();
	protected $type = "button";

function __construct() {
	parent::__construct();
    $this->load("menus/topics.tpl");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
