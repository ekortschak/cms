<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for external file editing (probably php files)

// ***********************************************************
// HOW TO USE
// ***********************************************************
see parent class
*/

incCls("editor/editText.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class editXtern extends editText {
	protected $tpl = "editor/edit.text.tpl";

	protected $fil = false; // source file

	protected $dir = false; // destination dir
	protected $ext = false; // destination file
	protected $cfg = false; // destination ini file


function __construct() {
	$lng = CUR_LANG;
	
	$this->dir = APP::tempDir("curedit");
	$this->ext = FSO::join($this->dir, "curEdit.$lng.php");
	$this->cfg = FSO::join($this->dir, "extEdit.ini");

	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
public function show() {
	$htm = APP::read($this->fil);
	
	$tpl = new tpl();
	$tpl->load("editor/edit.xtern.tpl");
	$tpl->set("path", $this->dir);
	$tpl->set("file", $this->fil);
	$tpl->set("content", $htm);
	$tpl->show();
}

// ***********************************************************
// providing and updating externally edited files
// ***********************************************************
protected function exec() {
	$act = ENV::getParm("edit"); if (! $act) return;

	if ($act == "provide") return $this->provide($this->fil);
	if ($act == "update")  return $this->update( $this->fil);
	if ($act == "clear")   return $this->clear();
}

// ***********************************************************
private function provide($file) {
	if (! is_file($file)) return;

	$ini = new iniWriter("LOC_CFG/xedit.def");
	$ini->read($this->cfg);
	$ini->set("props.file", $file);
	$ini->set("props.time", time());
	$ini->save($this->cfg);

	FSO::copy($file, $this->ext);
}

// ***********************************************************
private function update($file) {
	if (! is_file($file)) return;
	
	$ini = new ini($this->cfg);
	$chk = $ini->get("props.file");
	
	if ($chk == $file) FSO::copy($this->ext, $file);
	else MSG::add("path.wrong");
}

// ***********************************************************
private function clear() {
	FSO::rmDir($this->dir);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
