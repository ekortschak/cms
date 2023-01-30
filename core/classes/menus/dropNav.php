<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

dropNav will return a numeric index
* not the key of the passed items array

// ***********************************************************
// HOW TO USE
// ***********************************************************
see parent class

*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dropNav extends dropBox {

function __construct($suit = "nav") {
	parent::__construct($suit);
}

// ***********************************************************
// overruled methods
// ***********************************************************
public function getKey($qid, $data, $selected = false) {
	$sel = parent::getKey($qid, $data, $selected);
	$cur = $this->setNav($data, $sel); if (! $cur) return false;
	return $sel;
}

protected function getSel($qid, $data, $sel) {
	$sel = ENV::get($qid, $sel);

	if (! is_numeric($sel))
	return parent::getSel($qid, $data, $sel);

	$arr = array_keys($data);
	$sel = $arr[$sel - 1];

	return ENV::set($qid, $sel);
}

// ***********************************************************
// display boxes
// ***********************************************************
protected function setNav($data, $sel) {
	$cur = VEC::indexOf($data, $sel) + 1; if (! $cur) return false;

	$max = $cur; if (is_array($data))
	$max = count($data);

	$this->set("prev", CHK::min($cur - 1, 1));
	$this->set("next", CHK::max($cur + 1, $max));

	if ($cur >= $max) $this->substitute("nav.right", "nav.null");
	if ($cur <= 1)    $this->substitute("nav.left",  "nav.null");

	return $cur;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
