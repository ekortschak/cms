<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/qikScript.php");

$cmb = new qikScript();
$cmb->getKey($qid, $values, $selected);
$cmb->getVal($qid, $values, $selected);
$cmb->show();
*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class qikScript extends dropBox {

function __construct() {
	parent::__construct();
    $this->load("menus/qikScript.tpl");
}

// ***********************************************************
// overruled methods
// ***********************************************************
protected function collect($type) {
    $out = $tmp = "";

    foreach ($this->data as $unq => $vls) { // boxes
		$this->set("uniq", DIC::getPfx("unq", $unq));
		extract ($vls);

		foreach ($dat as $key => $val) { // links
			$key = STR::replace($key, "\"", "'");

			$this->set("value",   $key);
			$this->set("caption", $val);

			$tmp.= $this->getSection("link");
		}
		$this->set("links", $tmp);

		$out.= $this->getSection();
    }
   	$this->reset();
    return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
