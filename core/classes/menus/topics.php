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
$tpc->getTopics();
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
		$cap = PGE::title($dir);
		$lnk = APP::relPath($dir);

		$this->dat[$lnk] = $cap;
	}
}

// ***********************************************************
// methods
// ***********************************************************
public function getMarked() {
	$out = $this->getTopics();

	foreach ($out as $key => $val) { // mark hidden topics
		if (STR::contains($key, "~")) $out[$key] = "# $val";
	}
	return $out;
}

public function getTopics() {
	return $this->dat;
}

// ***********************************************************
public function getTopic($tab, $std) {
	$out = FSO::join($tab, $std);
	$chk = VEC::get($this->dat, $out); if ($out) return $out;
	return array_key_first($this->dat);
}

public function verify($tab, $std) {
	$arr = $this->getTopics();

	$std = FSO::join($tab, $std);
	$chk = VEC::get($arr, $std, NV); if ($chk !== NV) return $std;
	return array_key_first($arr);
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
