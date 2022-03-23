<?php
/* ***********************************************************
// INFO
// ***********************************************************
Designed to handle input items without predefined list of choices

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/selImage.php");

$itm = new selImage($parent_id);
$itm->init($type, $title, $value);
$itm->set("title", $title);
$itm->set("value", $default);
$itm->set("fname", $db_field_name);

$head = $itm->th();
$data = $itm->td();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class selImage extends selInput {

function __construct($pid) {
	parent::__construct($pid);
	if (CUR_DEST == "screen")
    $this->read("design/templates/input/selImage.tpl");
}

public function init($type, $qid, $value, $lang) {
	parent::init($type, $qid, $value, $lang);
	$this->set("pos", $value * -20);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
