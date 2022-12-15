<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/topics.php");

$box = new topics();
$box->setSpaces($before, $after);
$box->getKey($qid, $values, $selected);
$box->getVal($qid, $values, $selected);
$box->show();
*/

incCls("menus/dropbox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class topics extends dbox {
	protected $data = array();
	protected $type = "button";

function __construct() {
	parent::__construct();
    $this->read("design/templates/menus/topics.tpl");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>