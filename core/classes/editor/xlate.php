<?php
/* ***********************************************************
// INFO
// ***********************************************************
This class is used
* to set basic options for translations
* verify pre-existing target files

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/xlate.php");

$xlc = new xlate();
$xlc->setHead("anytext");
$xlc->setLang();
$xlc->setDest($sourcefile);

if (! $xlc->act()) return;

*/

incCls("menus/dropBox.php");
incCls("input/qikOption.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class xlate {
	private $lgs = false;
	private $lng = CUR_LANG;

	private $trg = false; // target language
	private $ovr = false;
	private $dbg = true;

function __construct() {
	$this->setLangs();
}

// ***********************************************************
// setting options
// ***********************************************************
private function setLangs() {
	$this->lgs = LNG::getOthers();
}

public function getLang() {
	return $this->lng;
}

// ***********************************************************
// show options
// ***********************************************************
public function setHead($text) {
	HTW::xtag($text);
}

public function setLang() {
	if (! $this->lgs) return MSG::now("xlate.none");

	$box = new dropBox();
	$trg = $box->getKey("lang.target", $this->lgs);
	$xxx = $box->show();

	$this->lng = $trg;
}

public function setOverwrite($value) {
	$this->ovr = $value;
}
public function setDebug($value) {
	$this->dbg = $value;
}

// ***********************************************************
// check target file
// ***********************************************************
public function setDest($file) {
	if (! $this->lgs) return;
	if (! is_file($file)) return;

	$dir = dirname($file);
	$ext = FSO::ext($file);

	HTM::vspace(12);

	$qik = new qikOption();
	$this->ovr = $qik->getVal("opt.overwrite", $this->ovr);
	$this->dbg = $qik->getVal("opt.preview", $this->dbg);
	$qik->show();

	$this->trg = FSO::join($dir, "$this->lng.$ext");

	if (! is_file($this->trg)) return;
	if ($this->ovr) return;

	$tpl = new tpl(); // file exists
	$tpl->load("editor/xlRef.tpl");
	$tpl->show("protected");
}

// ***********************************************************
// write translated file
// ***********************************************************
public function save($text) {
	$txt = trim(strip_tags($text));

	if (strlen($txt) < 1) return MSG::now("no.data");
	APP::write($this->trg, $text);
}

public function act() {
	if (! is_file($this->trg)) return true;
	if (! $this->ovr) return false;

	return true;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
