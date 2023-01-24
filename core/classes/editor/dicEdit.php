<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create lists for input objects for ini Files
* e.g. props, title ...

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("forms/dicEdit.php");

$obj = new dicEdit();
$obj->addInput($lang, $key, $val);
$obj->show();
*/

incCls("input/selector.php");
incCls("menus/dropNav.php");
incCls("editor/dicWriter.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dicEdit extends selector {

function __construct() {
	parent::__construct();

	$this->load("input/selDic.tpl");
}

// ***********************************************************
// react to previous editing
// ***********************************************************
public function exec($file, $lang) {
	$act = ENV::getPost("act"); if ($act != "OK") return;
	$arr = OID::getLast($this->oid); if (! $arr) return;
	$key = VEC::get($arr, "ckey"); if (! $key) return;

	$dir = dirname(dirname($file));
	$fil = basename($file);

	foreach ($arr as $lng => $val) {
		if (! STR::begins($lng, "lang_")) continue;
		$lng = STR::after($lng, "lang_"); if (! $lng) continue;
		$ful = FSO::join($dir, $lng, $fil);

		$erg = $this->save($fil, $lng, $key, $val);
	}
}

private function save($fil, $lng, $key, $val) {
	$dic = new dicWriter();
	$dic->read($fil);
	$dic->modify($lng, $key, $val);
}

// ***********************************************************
// display editof
// ***********************************************************
public function show($fil, $lng = CUR_LANG) {
	parent::show("title");

	$arr = $this->getItems($fil, $lng);
	$key = $this->showSel($arr);
	$xxx = $this->showEdit($key);

	OID::set($this->oid, "file", $fil);
	OID::set($this->oid, "clng", $lng);
	OID::set($this->oid, "ckey", $key);

	$cnt = $this->count(APP_FBK, $key);
	$xxx = $this->set("count", $cnt);
	parent::show("usage");
}

// ***********************************************************
// collect info
// ***********************************************************
private function getItems($fil, $lng) {
	$dic = new dicWriter();
	$xxx = $dic->read($fil);
	return $dic->getKeys("dic.$lng");
}

private function showSel($arr) {
	$box = new dropNav();
	$key = $box->getKey("dic.item", $arr);
	$xxx = $box->setClass("submenu");
	$xxx = $box->show();
	return $key;
}

private function showEdit($key) {
	$arr = DIC::getAll($key);

	foreach ($arr as $lng => $val) {
		$this->addInput($lng, $key, $val);
		$this->setProp("fname", "lang.$lng");
	}
	parent::show();
}

private function addInput($lang, $key, $val) {
	$flg = HTM::flag($lang);
	$out = $this->input($flg, $val);
	return $out;
}

// ***********************************************************
// goodies
// ***********************************************************
private function count($dir, $key) {
	$fls = FSO::ftree($dir); $cnt = 0;

	foreach ($fls as $fil => $nam) {
		$txt = APP::read($fil); if (STR::misses($txt, $key)) continue;
		$cnt+= substr_count($txt, "\"$key\"");
		$cnt+= substr_count($txt, "<!DIC:$key!>");
	}
	return $cnt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
