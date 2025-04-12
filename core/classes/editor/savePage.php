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
	$act = $this->get("file.act");

	switch (STR::left($act)) {
		case "sav": $this->savePage(); return;
		case "dro": $this->dropFile(); return;
		case "res": $this->restore();  return;
		case "bac": $this->backup();   return;
		case "imp": $this->import();   return;
		case "det": $this->detach();   return;
	}
}

protected function savePage() {
	$txt = $this->get("content");  if (! $txt) return;
	$old = $this->get("orgName");  if (! $old) return;
	$fil = $this->file("filName"); if (! $fil) $fil = $old;
	$ext = FSO::ext($fil);


	if (STR::features("htm.html", $ext)) {
		$tdy = new tidyPage();
		$txt = $tdy->restore($txt);
	}
	$res = APP::write($fil, $txt);

	if ($res)
	if ($fil != $old) FSO::kill($old);
}

protected function dropFile() {
	$fil = $this->file("fil"); if (! $fil) return;
	FSO::kill($fil);
}

// ***********************************************************
// backup and restore
// ***********************************************************
protected function restore() {
	$fil = $this->get("fil");
	$trg = APP::file($fil); if (! $trg) return;
	$dir = LOC::arcDir(APP_NAME, "sync");
	$src = FSO::join($dir, $fil);
	$res = FSO::copy($src, $trg);
}

protected function backup() {
	$fil = $this->file("fil"); if (! $fil) return;

	$dir = LOC::arcDir(APP_NAME, "sync");
	$ful = FSO::join($dir, $fil);
	$res = FSO::copy($fil, $ful);
}

protected function import() { // import redirected page
	$trg = $this->get("target"); if (! $trg) return;
	$src = $this->get("source"); if (! $src) return; $src = APP::dir($src);
	$arr = FSO::dirs($src);      if (! $arr) return;

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
		$ini->set("props_red.trg", APP::relPath($dir));
		$ini->save($dst);
	}
}

protected function detach() { // import redirected document
	$trg = $this->get("target"); $trg = APP::dir($trg);
	$src = $this->get("source"); $src = APP::dir($src);

	FSO::copyDir($src, $trg);

	$ini = new iniWriter();
	$ini->read($trg);
	$ini->set("props.typ", "include");
	$ini->dropSec("props_red");
	$ini->save();
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function file($prm) {
	$fil = $this->get($prm);
	return APP::file($fil);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
