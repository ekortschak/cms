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
	protected $dir = false; // destination dir
	protected $ext = false; // destination file
	protected $cfg = false; // destination ini file


function __construct() {
	parent::__construct();

	$this->load("editor/edit.xtern.tpl");
	$this->dir = LOC::tempDir("curedit");

	$lng = CUR_LANG;
	$this->ext = FSO::join($this->dir, "curEdit.$lng.php");
	$this->cfg = FSO::join($this->dir, "extEdit.ini");
}

// ***********************************************************
// methods
// ***********************************************************
public function edit() {
	$htm = APP::read($this->file);
	$this->exec();

	parent::set("path", $this->dir);
	parent::set("file", $this->file);
	parent::set("content", $htm);
	parent::show();
}

// ***********************************************************
// providing and updating externally edited files
// ***********************************************************
protected function exec() {
	switch (ENV::getParm("edit")) {
		case "provide": return $this->provide($this->file);
		case "update":  return $this->update( $this->file);
		case "clear":   return $this->clear();
	}
}

// ***********************************************************
private function provide($file) {
	if (! is_file($file)) return;

	$ini = new iniWriter("xedit.def");
	$ini->read($this->cfg);
	$ini->set("props.file", $file);
	$ini->set("props.time", time());
	$ini->save();

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
