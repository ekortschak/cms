<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for editing common text files

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/editText.php");

$edt = new editText();
$edt->save($file);
$edt->edit($file);
$edt->suit($variant);
$edt->show();
*/

incCls("menus/dropBox.php");
incCls("editor/tidyPage.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class editText extends tpl {
	protected $file = false;
	protected $ful = false;

function __construct() {
	parent::__construct();

	$this->load("editor/edit.text.tpl");
	$this->register();
}

// ***********************************************************
// methods
// ***********************************************************
public function grab($file) {
	$this->ful  = APP::file($file);
	$this->file = APP::relPath($file);

	OID::set($this->oid, "orgName", $this->file);

	$this->chkLocal();
}

public function suit($variant) {
	$tpl = "editor/edit.$variant.tpl";
	$chk = FSO::join(LOC_TPL, $tpl);

	if (! APP::file($chk)) return;
	$this->load($tpl);
}

public function edit() {
	$htm = $this->getContent();
	$xxx = $this->process($htm);
}

protected function process($htm) {
	$rws = STR::count($htm, "\n") + 30;
	$rws = CHK::range($rws, 30, 7);

	parent::set("file",  $this->file);
	parent::set("snips", $this->getSnips());
	parent::set("content", $htm);
	parent::set("rows", $rws);
	parent::show();
}

// ***********************************************************
// providing and updating externally edited files
// ***********************************************************
// automatic updates by class savePage !!!
// else: provide a method for saving in calling module.

// ***********************************************************
// reading info
// ***********************************************************
protected function getContent() {
	return APP::read($this->file);
}

protected function getSnips() {
	$arr = CFG::iniGroup("snips:html");
	$arr = VEC::flip($arr);

	$box = new dropBox("script");
	$box->getCode("snip", $arr);
	return $box->gc();
}

protected function chkLocal() {
	$ful = APP::file($this->file);
	$chk = STR::contains($ful, APP_FBK); if (! $chk) return;
	$this->copy("drop.cms", "drop.file");
	$this->copy("save.cms", "save.file");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
