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

incCls("menus/dropBox.php");

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
	$tpl = "editor/edit.$variant.tpl";
	$chk = FSO::join(LOC_TPL, $tpl);
	if (! APP::file($chk)) return;

	$this->tpl = $tpl;
}

public function show() {
	$htm = $this->getContent();

	$tpl = new tpl();
	$tpl->load($this->tpl);
	$tpl->merge($this->vls);
	$tpl->set("file", $this->fil);
	$tpl->set("snips", $this->getSnips());
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

	$out = STR::replace($out, "<?php", "<php>");
	$out = PRG::replace($out, "<php>(\s+)", "<php>");
	$out = STR::replace($out, "?>", "</php>");
	$out = PRG::replace($out, "(\s+)</php>", "</php>");

	$this->set("rows", $rws);
	return $out;
}

protected function getSnips() {
	$snp = new ini("config/snips.ini");
	$arr = $snp->getValues("html");
	$arr = VEC::flip($arr);

	$box = new dropBox("script");
	$box->getCode("snip", $arr);
	return $box->gc();
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
