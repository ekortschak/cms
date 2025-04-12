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
$itm->add($item);
$itm->set($item, $prop, $value);

*/

incCls("other/item.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class items {
	protected $lst = array(); // stored item names
	protected $itm = array(); // collection of item objects
	protected $idx = array(); // links item names to item indices
	protected $cnt = 0;       // item count

function __construct() {}

// ***********************************************************
// adding items
// ***********************************************************
public function add($item, $props = array()) {
	$idx = $this->find($item); if ($idx === false)
	$idx = $this->cnt++;

	$this->lst[$item] = $idx;
    $this->itm[$idx] = new item($item);
    $this->idx[$idx] = $item;

	$this->merge($item, $props);
}

// ***********************************************************
// handling items
// ***********************************************************
public function items() {
	return $this->itm;
}

public function item($item) {
	$idx = $this->find($item); if ($idx === false) return false;
	return $this->itm[$idx]->values();
}

public function isItem($item) {
	return (bool) $this->find($item);
}

public function count() {
    return $this->cnt;
}

// ***********************************************************
// handling properties
// ***********************************************************
public function merge($item, $arr) {
	foreach ($arr as $key => $val) {
		$this->set($item, $key, $val);
	}
}
public function set($item, $prop, $value) {
	$idx = $this->find($item); if ($idx === false) $this->add($item);
	$this->itm[$idx]->set($prop, $value);
}

public function get($item, $prop, $default = false) {
	$idx = $this->find($item); if ($idx === false) return $default;
	return $this->itm[$idx]->lng($prop, $default);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function find($key) {
	$out = VEC::get($this->lst, $key, NV); if ($out !== NV) return $out;
	$out = VEC::get($this->idx, $key, NV); if ($out !== NV) return $key;
	if ($key === 0) return 0;
	return false;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
