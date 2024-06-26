<?php
/* ***********************************************************
// INFO
// ***********************************************************
view search results

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/sView.php");

$vew = new sView();
$xxx = $vew->showNav();
$fls = $vew->snips();

*/

incCls("menus/dropNav.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class sView extends tpl {
	private $dat = array();

function __construct() {
	$this->load("modules/search.tpl");
	$this->chkReset();

	$this->dat = ENV::get("search.last");
}

// ***********************************************************
// show nav objects
// ***********************************************************
public function findMode() {
	$act = $this->showNav(); if (! $act) return "x";
	return ENV::get("search.mod", "p");
}

private function showNav() {
	$lst = $this->getData();

	$tpc = ENV::get("search.tpc");
	$dir = ENV::get("search.dir", $dir);
	$fnd = ENV::get("search.what"); if (! $fnd) return;

	$mnu = new dropBox("menu");
	$tpc = $mnu->getKey("search.tpc", $lst, $tpc);
	$arr = VEC::get($this->dat, $tpc); if (! $arr) return false;

	$box = new dropNav();
	$dir = $box->getKey("search.dir", $arr, $dir);
	$uid = PGE::UID($dir);

	$this->set("topic", $tpc);
	$this->set("page", $uid);
	$this->show("prv.goto");
	$this->show("preview");

	$mnu->show(); if ($tpc !== $dir)
	$box->show();
	return true;
}

// ***********************************************************
// return data
// ***********************************************************
private function getData() {
	$lst = VEC::keys($this->dat);
	return $this->chkData($lst);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function chkReset() {
	if (! ENV::getParm("search.reset")) return;
	ENV::set("search.last", false);
}

private function chkData($arr) {
	foreach ($arr as $key => $dir) {
		$arr[$key] = PGE::title($dir);
	}
	return $arr;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
