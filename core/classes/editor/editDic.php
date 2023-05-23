<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for editing dictionary files

// ***********************************************************
// HOW TO USE
// ***********************************************************
see parent class
*/

incCls("editor/editText.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class editDic extends editText  {

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function edit() {
	incCls("editor/dicEdit.php");

	$dic = new dicEdit();
	$dic->edit($this->file);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
