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

$edi = new dicEdit();
$edi->addInput($lang, $key, $val);
$edi->show();
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
	$arr = OID::values($this->oid); if (! $arr) return;
	$key = VEC::get($arr, "ckey");  if (! $key) return;

	$dir = dirname(dirname($file));
	$fil = basename($file);

	foreach ($arr as $lng => $val) {
		if (! STR::begins($lng, "lang_")) continue;
		$lng = STR::after($lng, "lang_"); if (! $lng) continue;
		$ful = FSO::join($dir, $lng, $fil);

		$this->save($fil, $lng, $key, $val);
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
public function edit($fil, $lng = CUR_LANG) {
	$this->show("title");

	$ful = APP::file($fil);
	$ful = STR::replace($ful, FBK_DIR, "<red>CMS</red>");
	HTW::tag("file = $ful", "hint");

	$arr = $this->items($fil, $lng);
	$key = $this->showSel($arr);
	$xxx = $this->showEdit($key);

	$this->hold("file", $fil);
	$this->hold("clng", $lng);
	$this->hold("ckey", $key);

	$cnt = $this->count(FBK_DIR, $key);
	$xxx = $this->set("count", $cnt);
	parent::show("usage");
}

// ***********************************************************
// collect info
// ***********************************************************
private function items($fil, $lng) {
	$dic = new dicWriter();
	$xxx = $dic->read($fil);
	return $dic->getKeys("dic.$lng");
}

private function showSel($arr) {
	$box = new dropNav("menu2");
	$key = $box->getKey("dic.item", $arr);
	$xxx = $box->show();
	return $key;
}

private function showEdit($key) {
	$lgs = LNG::get(); $out = array();

	foreach ($lgs as $lng) {
		$val = DIC::get($key, $lng);

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
	$fls = FSO::fTree($dir); $cnt = 0;

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
