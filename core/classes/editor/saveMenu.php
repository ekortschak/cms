<?php

if (VMODE != "medit") return;

/* ***********************************************************
// INFO
// ***********************************************************
see parent
*/

incCls("editor/tabEdit.php");

new saveMenu();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveMenu extends saveMany {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// methods
// ***********************************************************
protected function exec() {
	$dir = ENV::get("curDir"); if (! is_dir($dir)) return;
	$act = $this->env("btn.menu");

	switch ($act) {
		case "F": return $this->fileOpts($dir);
		case "U": return $this->userOpts($dir);
#		case "A": // effected by module body/upload

		case "D": $this->nodeOpts($dir); break;
		case "P": $this->pageOpts($dir); break;
		case "R": $this->sortOpts($dir); break;
		case "C": $this->clipOpts($dir); break;
		default:  return;
	}
	SSV::set("reload", true, "pfs");
}

protected function exec_2() {
	$dir = ENV::get("curDir");  if (! is_dir($dir)) return;
	$act = $this->env("btn.menu"); if ($act != "F") return;
	$cmd = $this->get("file.act"); if (! $cmd) return;

	switch(STR::left($cmd)) {
		case "dro": return $this->fileDelete($dir); // delete a file
		case "hid": return $this->fileToggle($dir); // hide and unhide a file
	}
}

// ***********************************************************
// node Opts
// ***********************************************************
private function nodeOpts($dir) {
	$cmd = $this->get("node.act"); if (! $cmd) return;

	switch (STR::left($cmd)) {
		case "ren": return $this->nodeRename($dir); // rename directory
		case "hid": return $this->nodeHide($dir);   // hide node
		case "dro": return $this->nodeDrop($dir);   // drop node
		case "uid": return $this->nodeCheck($dir);  // verify UIDs
		case "out": return $this->nodeOut($dir);    // move out in hierarchy
		case "min": return $this->nodeIn($dir);     // move in in hierarchy
		case "sub": return $this->nodeAdd($dir);    // add a subnode
	}
}

// ***********************************************************
private function nodeRename($dir) { // rename directory
	$dst = $this->get("ren.dir"); if (! $dst) return;
	$par = dirname($dir);
	$dst = "$par/$dst";

	if (is_dir($dst)) return ERR::msg("dir.exists", $dir); $res = rename($dir, $dst);
    if (! $res) return ERR::assist("dir", "no.write", $dir);

    ENV::setPage($dst);
}

// ***********************************************************
private function nodeHide($dir) { // hide or remove node
	$dst = FSO::toggleVis($dir);
	ENV::setPage($dst);
}
private function nodeDrop($dir) {
	FSO::rmDir($dir);
}

// ***********************************************************
// moving nodes
// ***********************************************************
private function nodeOut($dir) { // move out in hierarchy
	$dst = dirname(dirname($dir));
	$chk = FSO::level($dst); if ($chk < 1) return;
	$dst = FSO::join($dst, basename($dir));

	FSO::mvDir($dir, $dst);
	ENV::setPage($dst);
}
private function nodeIn($dir) { // move in in hierarchy
	$dst = FSO::getPrev($dir);
	$dst = FSO::join($dst, basename($dir));
	$lev = FSO::level($dir);
	$chk = FSO::level($dst); if ($chk < $lev) return;

	FSO::mvDir($dir, $dst);
	ENV::setPage($dst);
}

// ***********************************************************
// acting on whole tree
// ***********************************************************
private function nodeCheck() { // add UID to page.ini recursively
	$arr = FSO::dTree(TAB_HOME); unset($arr[0]);

	foreach ($arr as $dir => $nam) {
		$ini = new iniWriter();
		$ini->read($dir);
		$ini->checkIni();
	}
	MSG::add("Check UIDs - OK");
}

// ***********************************************************
// acting on subnodes
// ***********************************************************
private function nodeAdd($dir) {
	$dst = $this->get("sub.dir"); if (! $dst) return;
	$ovr = $this->env("opt.overwrite");
	$dst = STR::toArray($dst);

	foreach ($dst as $sub) {
		$itm = FSO::join($dir, $sub);
		$itm = FSO::force($itm); if (! $itm) return ERR::assist("dir", "no.write", $dir);
		$this->saveStdIni($itm, $ovr, $sub);
	}
}

// ***********************************************************
// sorting entries
// ***********************************************************
private function sortOpts($dir) { // sort node entries
	$cmd = $this->get("sort.act");  if (! $cmd) return;
	$lst = $this->get("sort.list"); $cnt = 10; // start at #
	$lst = STR::split($lst, ";"); $inc =  1;

	foreach ($lst as $itm) {
		$itm = basename($itm); if (! $itm) continue;

		$num = sprintf("%03d", $cnt); $cnt+= $inc; // increment
		$new = $num.".".ltrim($itm, "0..9.");
		$new = FSO::join($dir, $new);
		$old = FSO::join($dir, $itm); if ($old == $new) continue;

		rename($old, $new);
	}
}

// ***********************************************************
// file Opts
// ***********************************************************
private function fileOpts($dir) {
	$cmd = $this->get("file.act"); if (! $cmd) return;

	switch(STR::left($cmd)) {
		case "ini": return $this->fileAddIni($dir); // add page.ini
		case "sys": return $this->fileAddSys($dir); // add language files, e.g. de.htm
		case "prj": return $this->fileAddPrj($dir); // add project file
		case "any": return $this->fileAddAny($dir); // add any new file
		case "dro": return $this->fileDelete($dir); // delete a file
		case "hid": return $this->fileToggle($dir); // hide and unhide a file
	}
}

// ***********************************************************
private function fileAddIni($dir) { // add page.ini (recursively)
	$all = $this->get("ini.rec", false);
	$ovr = $this->env("opt.overwrite");

	$this->saveStdIni($dir, $ovr);

	switch ($all) {
		case true: $arr = FSO::dTree(TAB_HOME); unset($arr[0]); break;
		default:   $arr = FSO::dTree($dir);
	}
	foreach ($arr as $dir => $nam) {
		$this->saveStdIni($dir, $ovr);
	}
}

private function fileAddSys($dir) { // add empty language file, e.g. de.htm
	$nam = $this->env("sys.file");
	$lng = $this->env("sys.lang");
	$ext = $this->env("sys.ext");
	$ovr = $this->env("opt.overwrite");

	$fil = FSO::join($dir, "$nam.$lng.$ext");
	$txt = ""; if ($ext == "php") $txt = "<?php\n?>";

	APP::writeTell($fil, $txt, $ovr);
}

private function fileAddPrj($dir) { // add a project file
	$src = $this->env("prj.file");
	$ovr = $this->env("opt.overwrite");

	$fil = FSO::join($dir, basename($src));
	$txt = APP::read($src);

	APP::writeTell($fil, $txt, $ovr);
}

private function fileAddAny($dir) { // create any file
	$nam = $this->get("any.name");
	$ovr = $this->env("opt.overwrite");
	$fil = FSO::join($dir, $nam);
	$res = APP::writeTell($fil, "", $ovr);
}

private function fileToggle($dir) { // toggle hidden files
	$fil = $this->get("fil"); if (! $fil) return;
	$fil = FSO::join($dir, $fil);
	$res = FSO::toggleVis($fil);
}
private function fileDelete($dir) { // delete a files
	$fil = $this->get("fil"); if (! $fil) return;
	$fil = FSO::join($dir, $fil);
	$res = FSO::kill($fil);
}

// ***********************************************************
// ini opts
// ***********************************************************
private function pageOpts($dir) {
	if ($this->pageDefault($dir)) return; // set startup page
	if ($this->pageProps($dir))   return; // save page props
}

// ***********************************************************
private function pageProps($dir) { // change uid, display type
	$cmd = $this->get("props"); if (! $cmd) return false;
	$typ = STR::left($cmd["typ"]);

	$ini = new iniWriter($typ);
	$ini->read($dir);
	$ini->savePost();

	ENV::setPage($ini->getUID());
	return true;
}

private function pageDefault($dir) { // mark node as default
	$cmd = $this->get("default"); if (! $cmd) return false;
	$tpl = FSO::join(TAB_HOME, "tab.ini");

	$ini = new iniWriter(); // update page.ini - if necessary
	$xxx = $ini->read($dir);
	$uid = $ini->getUID();
	$xxx = $ini->set("uid", $uid);
	$ini->save();

	$edt = new tabEdit($tpl); // update tab.ini
	$edt->set("props.std", $uid);
	$edt->save();

	return true;
}

// ***********************************************************
// user Opts
// ***********************************************************
private function userOpts($dir) {
	$chk = $this->get("perms.act"); if (! $chk) return;

	$ful = FSO::join($dir, "perms.ini");
	$arr = OID::getLast(); unset($arr["perms_act"]);
	$out = array();

	foreach ($arr as $key => $val) {
		if ($val != "i") $out[$key] = $val;
	}
	if (! $out) FSO::kill($ful);
	else {
		$ini = new iniWriter();
		$ini->read($ful);
		$ini->replace("perms", $out);
		$ini->save();
	}
}

// ***********************************************************
// clipboard options
// ***********************************************************
private function clipOpts($cur) {
	$chk = $this->get("clip.act"); if (! $chk) return false;

	switch (STR::left($chk)) {
		case "cop": $this->clipCopy ($cur); break; // copy to clipboard
		case "dup": $this->clipDupe ($cur); break; // duplicate menu item in situ
		case "cut": $this->clipMove ($cur); break; // move to clipboard
		case "pas": $this->clipPaste($cur); break; // restore as menu item
		case "del": $this->clipDrop (    ); break; // drop from clipboard
	}
	return true;
}

private function clipCopy($cur) { // copy to clipboard
	$dir = LOC::tempDir("clipboard");
	$dst = FSO::join($dir, basename($cur));
	return FSO::copyDir($cur, $dst);
}

private function clipDupe($cur) { // duplicate in situ
	$uid = $this->get("clip.uid"); if (! $uid) return false;

	$dir = dirname($cur);
	$dst = FSO::join($dir, $uid);
	$res = FSO::copyDir($cur, $dst);

	$ini = new iniWriter();
	$ini->read($dst);
	$ini->set("props.uid", $uid);
	$ini->save();

    ENV::setPage($dst);
}

private function clipMove($cur) { // move to clipboard
	$dir = LOC::tempDir("clipboard");
	$dst = FSO::join($dir, basename($cur));
	$xxx = ENV::setPage(dirname($cur));
	return FSO::mvDir($cur, $dst);
}

private function clipPaste($cur) { // copy to project
	$src = $this->get("clip.src");
	$dst = FSO::join($cur, basename($src));
	return FSO::mvDir($src, $dst);
}

private function clipDrop() { // drop from clipboard
	$src = $this->get("clip.src");
	return FSO::rmDir($src);
}

// ***********************************************************
// write to ini files
// ***********************************************************
private function saveStdIni($dir, $ovr = false) { // rewrite ini-file
	$fil = FSO::join($dir, "page.ini"); if (is_file($fil) && ! $ovr) return;

	$ini = new iniWriter("inc");
	$ini->read($fil);
	$ini->save($fil);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
