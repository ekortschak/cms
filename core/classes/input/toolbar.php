<?php
/* ***********************************************************
// INFO
// ***********************************************************
will create a floating toolbar

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/toolbar.php");

$obj = new toolbar();
$obj->add($url_req, $capiton);
$obj->show();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class toolbar extends tpl {
	private $dat = array();

function __construct() {
	parent::__construct();
	$this->load("menues/toolbar.tpl");
}

// ***********************************************************
// methods
// ***********************************************************
public function item($ref, $caption, $confirm = false) {
	$this->set("confirm", ($confirm) ? "confirm" : "noconfirm");
	$this->set("href", $ref);
	$this->set("text", $caption); $lin = $this->getSection("item");
	$this->add($ref, $lin);
}
public function icon($ref, $file, $confirm = false) {
	$this->set("confirm", ($confirm) ? "confirm" : "noconfirm");
	$this->set("href", $ref);
	$this->set("icon", $file); $lin = $this->getSection("icon");
	$this->add($ref, $lin);
}

private function add($ref, $item) {
	$this->dat[$ref] = $item;
}

// ***********************************************************
// output
// ***********************************************************
public function gc($sec = "main") {
	$out = VEC::implode($this->dat);

	$this->set("items", $out);
	return $this->getSection($sec);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
