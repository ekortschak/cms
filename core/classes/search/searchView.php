<?php
/* ***********************************************************
// INFO
// ***********************************************************
view search results

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/searchView.php");

$vew = new searchView();
$xxx = $vew->showNav();
$fls = $vew->getSnips();

*/

incCls("menus/dropMenu.php");
incCls("menus/dropNav.php");
incCls("search/swrap.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class searchView extends tpl {
	private $dat = array();

function __construct() {
	$this->load("modules/search.tpl");
	$this->chkReset();

	$this->dat = ENV::get("search.last");
}

// ***********************************************************
// show nav objects
// ***********************************************************
public function showNav() {
	$lst = $this->getData();

	$tpc = ENV::get("search.topic");
	$dir = ENV::get("search.dir");

	$mnu = new dropMenu();
#	$xxx = $mnu->set("sep", "");
	$tpc = $mnu->getKey("search.topic", $lst, $dir);

	$arr = VEC::get($this->dat, $tpc);

	$box = new dropNav();
	$dir = $box->getKey("search.dir", $arr, $dir);

	if ($arr) {
		$uid = PGE::getUID($dir, "props.uid", $dir);

		$this->set("topic", $tpc);
		$this->set("page", $uid);
		$this->show("prv.goto");
	}
	$this->show("preview");

	if (! $arr) return false;

	$mnu->show();
	$box->show();
}

// ***********************************************************
// return data
// ***********************************************************
public function getData() {
	$lst = VEC::keys($this->dat);
	return $this->chkData($lst);
}

public function getSnips() {
	$dir = ENV::get("search.dir");
	$fnd = ENV::get("search");

	$obj = new swrap();
	return $obj->getSnips($dir, $fnd);
}

public function getMode() {
	return ENV::get("search.mod");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function chkReset() {
	$rst = ENV::getParm("search.reset"); if (! $rst) return;
	ENV::set("search.last", false);
}

private function chkData($arr) {
	foreach ($arr as $dir => $val) {
		$arr[$dir] = PGE::getTitle($val);
	}
	return $arr;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
