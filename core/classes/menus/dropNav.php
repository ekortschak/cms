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
incCls("menus/dropNav.php");

$cmb = new dropNav();
$cmb->getKey($qid, $values, $selected);
$cmb->getVal($qid, $values, $selected);
$cmb->show();
*/

incCls("menus/dropBox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dropNav extends dropBox {

function __construct() {
	parent::__construct();
    $this->load("menus/dropNav.tpl");
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
	if (is_numeric($sel)) {
		$arr = array_keys($data);
		$sel = $arr[$sel - 1];
		return ENV::set($qid, $sel);
	}
	return parent::getSel($qid, $data, $sel);
}

// ***********************************************************
// display boxes
// ***********************************************************
public function show($sec = "main") {
	echo $this->gc($sec);
}
public function gc($sec = "main") {
	if (! $this->data) return "";

	$this->set("items", $this->collect($sec));
    return $this->getSection($sec);
}

protected function setNav($data, $sel) {
	$cur = VEC::indexOf($data, $sel) + 1; if (! $cur) return false;
	$max = count($data);

	$this->set("prev", CHK::min($cur - 1, 1));
	$this->set("next", CHK::max($cur + 1, $max));

	if ($cur >= $max) $this->substitute("nav.right", "nav.null");
	if ($cur <= 1)    $this->substitute("nav.left",  "nav.null");

	return $cur;
}

// ***********************************************************
protected function collect($type) {
    $out = "";

    foreach ($this->data as $unq => $vls) { // boxes
		extract ($vls);

		$this->set("parm", $unq); $tmp = ""; $cnt = 0;
		$this->set("uniq", DIC::getPfx("unq", $unq));
		$this->set("current", $cur);

		foreach ($dat as $key => $val) { // links
			$this->set("value",   $key); $cnt++;
			$this->set("caption", $val);

			if ($key == $sel) continue;
			$tmp.= $this->getSection("link");
		}
		if ($typ == "cmb") {
			$sec = "$type.box"; if ($cnt < 2)
			$sec = "$type.one";
		}
		else {
			continue;
		}
		$this->set("links", $tmp);

		$out.= $this->getSection($sec);
    }
   	$this->reset();
    return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
