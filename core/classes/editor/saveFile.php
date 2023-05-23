<?php

if (VMODE != "pedit") return;

/* ***********************************************************
// INFO
// ***********************************************************
see parent
*/

incCls("editor/tidy.php");

new saveFile();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveFile extends saveMany {

function __construct() {
	$this->oid = ENV::getPost("oid");
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
protected function exec() {
	$act = $this->get("file.act"); if (! $act) return;

	if ($this->saveFile($act)) return;
	if ($this->dropFile($act)) return;
	if ($this->restore($act))  return;
	if ($this->backup($act))   return;
}

private function saveFile($act) {
	if ($act != "save") return false;
	$txt = $this->get("content");  if (! $txt) return false;
	$old = $this->get("orgName");  if (! $old) return false;
	$fil = $this->get("filName");  if (! $fil) $fil = $old;

	if ($fil != $old) FSO::kill($old);

	$tdy = new tidy();
	$txt = $tdy->get($txt);

	APP::write($fil, $txt);
	return true;
}

private function dropFile($act) {
	if ($act != "drop") return false;
	$fil = $this->get("fil"); if (! $fil) return false;
	FSO::kill($fil);
	return true;
}

private function restore($act) {
	if ($act != "restore") return false;
	$fil = $this->get("fil"); if (! $fil) return false;

	$dir = APP::arcDir(ARCHIVE, "sync");
	$ful = FSO::join($dir, $fil);
	$xxx = FSO::copy($ful, $fil);
	return true;
}

private function backup($act) {
	if ($act != "backup") return false;
	$fil = $this->get("fil"); if (! $fil) return false;

	$dir = APP::arcDir(ARCHIVE, "sync");
	$ful = FSO::join($dir, $fil);
	$xxx = FSO::copy($fil, $ful);
	return true;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
