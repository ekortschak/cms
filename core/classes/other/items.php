<?php
/* ***********************************************************
// INFO
// ***********************************************************
Initially designed to simplify handling of table column features.
Modified to handle all kinds of object items.

You can only set properties for "registered" items, so you
need to call addItem() first.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/items.php");

$itm = new items();
$itm->addItem($item);
$itm->setProp($item, $prop, $value);

*/

incCls("other/item.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class items extends objects {
	protected $itm = array(); // collection of items
	protected $col = array(); // links item names to item indices
	protected $cnt = 0;       // item count

function __construct() {}

// ***********************************************************
// handling items
// ***********************************************************
public function addItems($arr) {
    foreach ($arr as $itm) {
        $this->addItem($itm);
    }
}
public function addItem($item, $props = array()) {
	$idx = $this->cnt++;

    $this->itm[$idx] = new item($item);
    $this->col[$idx] = $item;

	$this->setProps($idx, $props);
}

// ***********************************************************
public function isItem($item) {
	if (is_numeric($item)) return $item < $this->cnt;
	return in_array($item, $this->col);
}
public function count() {
    return $this->cnt;
}

// ***********************************************************
// retrieving properties
// ***********************************************************
public function getItems() {
	$out = array();

	foreach ($this->col as $idx => $name) {
		$out[$name] = $this->itm[$idx]->getValues();
	}
	return $out;
}
public function getItem($item) {
	$idx = $this->getIndex($item);
	$out = $this->itm[$idx]->getValues();
	return $out;
}

public function getProp($item, $prop, $default = false) {
	$idx = $this->getIndex($item);
	return $this->itm[$idx]->get($prop, $default);
}

// ***********************************************************
public function getInfo($prop = "head", $default = "") {
    $out = array(); // retrieve "$prop" of all items

	foreach ($this->col as $idx => $key) {
		$out[$idx] = $this->itm[$idx]->get($prop, $default);
    }
    return $out;
}

// ***********************************************************
// setting properties
// ***********************************************************
public function setProps($item, $arr) {
	$idx = $this->getIndex($item);

	foreach ($arr as $key => $val) {
		$this->itm[$idx]->set($key, $val);
	}
}
public function setProp($item, $prop, $value) {
	$idx = $this->getIndex($item); if (! isset($this->itm[$idx])) return;
	$this->itm[$idx]->set($prop, $value);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getIndex($key) {
	if (is_numeric($key)) {
		if ($key < 0) return 2;
		if ($key > $this->cnt - 1) return 2;
		return $key;
	}
	return intval(array_search($key, $this->col));
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
