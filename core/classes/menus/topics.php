<?php
/* ***********************************************************
// INFO
// ***********************************************************
Handles topic navigation

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/tabs.php");

$tpc = new topics($dir);
$tpc->items();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class topics {
	private $dat = array();

function __construct($dir = TAB_ROOT) {
	$vis = (! IS_LOCAL);
	$arr = FSO::dirs($dir, $vis);

	foreach ($arr as $dir => $nam) {
		$key = APP::relPath($dir);
		$cap = PGE::title($dir); if (STR::contains($key, "~"))
		$cap = "# $cap";

		$this->dat[$key] = $cap;
	}
}

// ***********************************************************
// methods
// ***********************************************************
public function items() {
	$out = $this->dat; if (IS_LOCAL) return $out;

	foreach ($out as $key => $val) { // mark hidden topics
		if (STR::begins($val, "#")) unset($out[$key]);
	}
	return $out;
}

// ***********************************************************
public function getTopic($tab, $std) {
	$out = FSO::join($tab, $std);
	$chk = VEC::get($this->dat, $out); if ($out) return $out;
	return array_key_first($this->dat);
}

// ***********************************************************
public function getTypes() {
	return array(
		"root"   => "single topic",
		"select" => "multiple topics"
	);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
