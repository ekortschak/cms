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

incCls("menus/dropbox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class qikScript extends dbox {

function __construct() {
	parent::__construct();
    $this->read("design/templates/menus/qikScript.tpl");
}

// ***********************************************************
// overruled methods
// ***********************************************************
private function collect($type) {
    $out = $tmp = "";

    foreach ($this->data as $unq => $vls) { // boxes
		$this->set("uniq", DIC::check("unq", $unq));
		extract ($vls);

		foreach ($dat as $key => $val) { // links
			$key = STR::replace($key, "\"", "'");

			$this->set("value",   $key);
			$this->set("caption", $val);

			$tmp.= $this->getSection("link");
		}
		$this->set("links", $tmp);

		$out.= $this->getSection("combo");
    }
   	$this->reset();
    return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
