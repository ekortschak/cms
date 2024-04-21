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
	DBG::cls(__CLASS__);

	$this->load("editor/edit.text.tpl");
	$this->register();
}

// ***********************************************************
// methods
// ***********************************************************
public function grab($file) {
	$this->ful  = APP::file($file);
	$this->file = APP::relPath($file);

	$this->hold("orgName", $this->file);
	$this->chkLocal();
}

public function suit($variant) {
	$tpl = "editor/edit.$variant.tpl";
	$chk = FSO::join(LOC_TPL, $tpl);

	if (! APP::file($chk)) return;
	$this->load($tpl);
}

public function edit() {
	$htm = $this->content();
	$xxx = $this->process($htm);
}

protected function process($htm) {
	$rws = STR::count($htm, "\n") + 30;
	$rws = CHK::range($rws, 30, 7);

	$this->set("file",  $this->file);
	$this->set("snips", $this->snips());
	$this->set("content", $htm);
	$this->set("rows", $rws);
	$this->show();
}

// ***********************************************************
// providing and updating externally edited files
// ***********************************************************
// automatic updates by class savePage !!!
// else: provide a method for saving in calling module.

// ***********************************************************
// reading info
// ***********************************************************
protected function content() {
	return APP::read($this->file);
}

protected function snips() {
	$arr = CFG::iniGroup("snips:html");
	$arr = VEC::flip($arr);

	$box = new dropBox("script");
	$box->getCode("snip", $arr);
	return $box->gc();
}

protected function chkLocal() {
	$ful = APP::file($this->file);
	$chk = STR::contains($ful, FBK_DIR); if (! $chk) return;
	$this->copy("drop.cms", "drop.file");
	$this->copy("save.cms", "save.file");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
