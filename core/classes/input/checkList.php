<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create checkList boxes in selectors.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/checkList.php");

$lst = new checkList($name);
$lst->addItem($key, $value)
$lst->show();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class checkList extends tpl {
	private $dat = array();
	private $cnt = 0;

function __construct() {
	parent::__construct();
    $this->load("input/checkList.tpl");
	$this->register();
}

// ***********************************************************
// methods
// ***********************************************************
public function addSection($caption) {
	$this->cnt++;
	$this->addItem("sec.$cnt", $caption);
}

public function addItem($key, $caption, $value = false) {
	$this->dat[$key] = array(
		"hed" => $caption,
		"val" => (bool) $value
	);
}

// ***********************************************************
// output
// ***********************************************************
public function gc($dummy = false) {
	$opt = "";

    foreach ($this->dat as $key => $inf) {
		extract($inf);

		$sec = $this->section($key);
		$sel = $this->checked($val);

		$this->set("fname", $key);
		$this->set("text", $hed);
		$this->set("checked", $sel);

        $opt.= $this->getSection($sec);
    }
	if (! $opt) return "";

	$xxx = $this->set("items", $opt);
    return $this->getSection();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function section($key) {
	if (STR::begins($key, "sec.")) return "section";
	return "item";
}

private function checked($val) {
	return ($val) ? "CHECKED" : "";
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
