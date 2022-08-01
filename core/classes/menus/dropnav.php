<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

dropnav will return a numeric index
* not the key of the passed items array

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/dropnav.php");

$cmb = new dropnav();
$cmb->getKey($qid, $values, $selected);
$cmb->getVal($qid, $values, $selected);
$cmb->show();
*/

incCls("menus/dropbox.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dropnav extends dbox {
	private $lst = array();

function __construct() {
	parent::__construct();
    $this->read("design/templates/menus/dropnav.tpl");
}

// ***********************************************************
// overruled methods
// ***********************************************************
public function getKey($qid, $data, $selected = false) {
	$sel = parent::getKey($qid, $data);
	$cnt = $cur = 0;

	foreach ($data as $key => $val) {
		$cnt++; if ($key != $sel) continue;
		$cur = $cnt;
	}
	if (! $cur) return false;

	$this->set("prev", CHK::min($cur - 1, 1));
	$this->set("next", CHK::max($cur + 1, $cnt - 1));
	$this->lst = $data;

	if ($cur < 2) $this->substitute("nav.left", "nav.null");
	if ($cur > $cnt - 2) $this->substitute("nav.right", "nav.null");

	return $sel;
}

// ***********************************************************
public function decode($qid, $find, $default = false) {
	foreach ($this->lst as $key => $val) {
		if ($key == $find) return $val;
		if ($val == $find) return $key;
	}
	return $default;
}

// ***********************************************************
// display boxes
// ***********************************************************
public function show($sec = "main") {
	echo $this->gc($sec);
}
public function gc($sec = "main") {
	$this->set("items", $this->collect($sec));
    return $this->getSection($sec);
}

// ***********************************************************
private function collect($type) {
    $out = "";

    foreach ($this->data as $unq => $vls) { // boxes
		extract ($vls);

		$this->set("parm", $unq); $tmp = ""; $cnt = 0;
		$this->set("uniq", DIC::check("unq", $unq));
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
			$sec = "table.text";
		}
		$nav = intval($sel);
		$this->set("prev", $nav - 1);
		$this->set("next", $nav + 1);
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
