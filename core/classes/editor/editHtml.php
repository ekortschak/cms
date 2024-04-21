<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for editing html files

// ***********************************************************
// HOW TO USE
// ***********************************************************
see parent class
*/

incCls("menus/dropBox.php");
incCls("editor/editText.php");
incCls("editor/tidyPage.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class editHtml extends editText {

function __construct() {
	parent::__construct();
	DBG::cls(__CLASS__);
}

protected function content() {
	$tdy = new tidyPage();
	return $tdy->read($this->file, true);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
