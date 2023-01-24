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
$edt->load($file);
$edt->suit($variant);
$edt->show();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class editText extends objects {
	protected $tpl = "editor/edit.text.tpl";
	protected $fil = false;
	protected $ful = false;

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function load($file) {
	$this->ful = $file;
	$this->fil = APP::relPath($file);

	$this->exec();
}

public function suit($variant) {
	$chk = "design/templates/editor/edit.$variant.tpl";
	if (! APP::file($chk)) return;

	$this->tpl = "editor/edit.$variant.tpl";
}

public function show() {
	$htm = $this->getContent();

	$tpl = new tpl();
	$tpl->load($this->tpl);
	$tpl->merge($this->vls);
	$tpl->set("file", $this->fil);
	$tpl->set("content", $htm);
	$tpl->show();
}

// ***********************************************************
// providing and updating externally edited files
// ***********************************************************
protected function exec() {
// exec done by class saveFile
}

// ***********************************************************
// reading info
// ***********************************************************
protected function getContent() {
	$out = APP::read($this->fil);
	$rws = STR::count($out, "\n") + 3;
	$rws = CHK::range($rws, 35, 7);

	$this->set("rows", $rws);
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
