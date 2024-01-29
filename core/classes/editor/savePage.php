<?php

if (VMODE != "pedit") return;

/* ***********************************************************
// INFO
// ***********************************************************
see parent
*/

incCls("editor/tidyPage.php");

new savePage();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class savePage extends saveMany {

function __construct() {
	$this->oid = ENV::getPost("oid");
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
protected function exec() {
	$act = $this->get("file.act"); if (! $act) return;

	if ($this->savePage($act)) return;
	if ($this->dropFile($act)) return;
	if ($this->restore($act))  return;
	if ($this->backup($act))   return;
	if ($this->import($act))   return;
}

private function savePage($act) {
	if ($act != "save") return false;

	$txt = $this->get("content");  if (! $txt) return false;
	$old = $this->get("orgName");  if (! $old) return false;
	$fil = $this->get("filName");  if (! $fil) $fil = $old;

	$ext = FSO::ext($fil);

	if (STR::features("htm.html", $ext)) {
		$tdy = new tidyPage();
		$txt = $tdy->restore($txt);
	}
	$res = APP::write($fil, $txt);

	if ($res)
	if ($fil != $old) FSO::kill($old);

	return true;
}

private function dropFile($act) {
	if ($act != "drop") return false;
	$fil = $this->get("fil"); if (! $fil) return false;
	FSO::kill($fil);
	return true;
}

// ***********************************************************
// backup and restore
// ***********************************************************
private function restore($act) {
	if ($act != "restore") return false;
	$fil = $this->get("fil"); if (! $fil) return false;

	$dir = LOC::arcDir("sync");
	$ful = FSO::join($dir, $fil);
	$res = FSO::copy($ful, $fil);
	return true;
}

private function backup($act) {
	if ($act != "backup") return false;
	$fil = $this->get("fil"); if (! $fil) return false;

	$dir = LOC::arcDir("sync");
	$ful = FSO::join($dir, $fil);
	$res = FSO::copy($fil, $ful);
	return true;
}

private function import($act) {
	if ($act != "import") return false;

	$trg = $this->get("target"); if (! $trg) return false;
	$src = $this->get("source"); if (! $src) return false;
	$arr = FSO::dirs($src);      if (! $arr) return true;

	$ini = new iniWriter("page.def");
	$ini->read($src);
	$ini->set("props.typ", "include");
	$ini->save($trg);

	foreach ($arr as $dir => $nam) {
		$dst = $dir;
		$dst = STR::after($dir, $src, ""); if (! $dst) continue;
		$dst = FSO::join($trg, $dst);
		$xxx = FSO::force($dst);

		$ini = new iniWriter("page.red.def");
		$ini->read($dir);
		$ini->set("props.typ", "redirect");
		$ini->set("props_red.trg", APP::relPath($dir)); // TODO:: check if APP::url would work better
		$ini->save($dst);
	}
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
