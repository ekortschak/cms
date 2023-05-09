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
incCls("editor/tidy.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class editText extends tpl {
	protected $fil = false;
	protected $ful = false;

function __construct() {
	parent::__construct();

	$this->load("editor/edit.text.tpl");
	$this->register();
}

// ***********************************************************
// methods
// ***********************************************************
public function edit($file) {
	$this->ful = $file;
	$this->fil = APP::relPath($file);
}

public function suit($variant) {
	$tpl = "editor/edit.$variant.tpl";
	$chk = FSO::join(LOC_TPL, $tpl);

	if (! APP::file($chk)) return;
	$this->load($tpl);
}

public function show($sec = "main") {
	$htm = $this->getContent();

	parent::set("file",  $this->fil);
	parent::set("snips", $this->getSnips());
	parent::set("content", $htm);
	parent::show($sec);
}

// ***********************************************************
// providing and updating externally edited files
// ***********************************************************
// automatic updates by class saveFile  !!!
// else: provide a method for saving in calling module.

// ***********************************************************
// reading info
// ***********************************************************
protected function getContent() {
	$out = APP::read($this->fil);
	$rws = STR::count($out, "\n") + 3;
	$rws = CHK::range($rws, 35, 7);

	$tdy = new tidy();
	$out = $tdy->phpSecure($out);

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
