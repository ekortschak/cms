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
incCls("other/strProtect.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class xlate {
	private $lgs = false;
	private $lng = CUR_LANG;

	private $trg = false; // target language
	private $ovr = false;

function __construct() {
	$this->setLangs();
}

// ***********************************************************
// setting options
// ***********************************************************
private function setLangs() {
	$arr = LNG::getOthers();
	$arr[CUR_LANG] = CUR_LANG;
	$this->lgs = $arr;
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
	$qik->show();

	$this->trg = LNG::file($file, $this->lng);

	if (! is_file($this->trg)) return;
	if ($this->ovr) return;

	$tpl = new tpl(); // file exists
	$tpl->load("editor/xlRef.tpl");
	$tpl->show("protected");
}

// ***********************************************************
// handle content
// ***********************************************************
public function read($file) { // passing file or text
	$out = $file; if (is_file($file))
	$out = APP::read($file);

	$prt = new strProtect();
	$out = $prt->secure($out, "<?php", "?>");
	$xxx = $prt->store("xlate");
	return $out;
}

// ***********************************************************
// write translated file
// ***********************************************************
public function save($text) {
	$chk = trim(strip_tags($text)); if (! $chk) return MSG::now("no.data");

	$prt = new strProtect();
	$xxx = $prt->recall("xlate");
	$txt = $prt->restore($text);

	APP::write($this->trg, $txt);
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
