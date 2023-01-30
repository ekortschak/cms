<?php
/* ***********************************************************
// INFO
// ***********************************************************
web site editor, used to create and manage menu items

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/saveMenu.php");

$obj = new saveMenu();
*/

incCls("editor/iniWriter.php");
incCls("other/uids.php");


// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveMenu {

function __construct() {
	if (EDITING != "medit") return;
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
private function exec() {
	$dir = ENV::get("loc"); if (! is_dir($dir))
	$dir = APP::dir($dir);	if (! $dir) return;
	$act = ENV::get("btn.menu");

	if (STR::contains("DPRC", $act)) {
		ENV::set("pfs.reload", 1);
	}
	switch ($act) {
		case "D": if ($this->nodeOpts($dir)) return;
		case "F": if ($this->fileOpts($dir)) return;
		case "P": if ($this->pageOpts($dir)) return;
		case "R": if ($this->sortOpts($dir)) return;
		case "U": if ($this->userOpts($dir)) return;
		case "C": if ($this->clipOpts($dir)) return;
	}
}

// ***********************************************************
// node Opts
// ***********************************************************
private function nodeOpts($dir) {
	$cmd = ENV::getPost("node_act"); if (! $cmd) return false;

	switch (STR::left($cmd)) {
		case "ren": $this->nodeRename($dir); break; // rename directory
		case "hid": $this->nodeHide($dir);   break; // hide node
		case "dro": $this->nodeDrop($dir);   break; // drop node
		case "uid": $this->nodeCheck($dir);  break; // verify UIDs
		case "out": $this->nodeOut($dir);    break; // move out in hierarchy
		case "min": $this->nodeIn($dir);     break; // move in in hierarchy
		case "sub": $this->nodeAdd($dir);    break; // add a subnode
		default: return false;
	}
	return true;
}

// ***********************************************************
private function nodeRename($dir) { // rename directory
	$dst = ENV::getPost("ren_dir"); if (! $dst) return;
	$par = dirname($dir);
	$dst = "$par/$dst";

	if (is_dir($dst)) return ERR::msg("dir.exists", $dir); $erg = rename($dir, $dst);
    if (! $erg) return ERR::assist("dir", "no.write", $dir);

    ENV::setPage($dst);
	return true;
}

// ***********************************************************
private function nodeHide($dir) { // hide or remove node
	$new = FSO::toggleVis($dir);
	ENV::setPage($new);
}
private function nodeDrop($dir) {
	FSO::rmDir($dir);
}

// ***********************************************************
// moving nodes
// ***********************************************************
private function nodeOut($dir) { // move out in hierarchy
	$dst = dirname(dirname($dir));
	$chk = STR::count($dst, DIR_SEP); if ($chk < 2) return;
	$dst = FSO::join($dst, basename($dir));

	FSO::mvDir($dir, $dst);
	ENV::setPage($dst);
}
private function nodeIn($dir) { // move in in hierarchy
	$dst = FSO::getPrev($dir);
	$dst = FSO::join($dst, basename($dir));
	$lev = STR::count($dir, DIR_SEP);
	$chk = STR::count($dst, DIR_SEP); if ($chk < $lev) return;

	FSO::mvDir($dir, $dst);
	ENV::setPage($dst);
}

// ***********************************************************
// acting on whole tree
// ***********************************************************
private function nodeCheck() { // add UID to page.ini recursively
	$dir = ENV::getPost("root_dir");
	$arr = FSO::tree($dir); unset($arr[0]);
	$ids = new uids();

	foreach ($arr as $dir => $nam) {
		$ini = new iniWriter("LOC_CFG/page.def");
		$ini->read($dir);

		$uid = $ini->getUID();
		$chk = $ids->getUID($uid); if ($uid == $chk) continue;

		MSG::add("$uid => $dir");

		$ini->set("props.uid", $chk);
		$ini->save();
	}
	MSG::add("Check UIDs - OK");
	return true;
}

// ***********************************************************
// acting on subnodes
// ***********************************************************
private function nodeAdd($dir) {
	$dst = ENV::getPost("sub_dir"); if (! $dst) return false;
	$dst = STR::toArray($dst);

	foreach ($dst as $itm) {
		$itm = FSO::join($dir, $itm);
		$itm = FSO::force($itm); if (! $itm) return ERR::assist("dir", "no.write", $dir);
		$this->saveStdIni($itm);
	}
	return true;
}

// ***********************************************************
// sorting entries
// ***********************************************************
private function sortOpts($dir) { // sort a node
	$cmd = ENV::getPost("sort_act"); if (! $cmd) return false;
	$lst = ENV::getPost("slist");    $cnt = 10; // start at #
	$lst = VEC::explode($lst, ";");  $inc =  1;

	foreach ($lst as $itm) {
		$itm = basename($itm); if (! $itm) continue;

		$num = sprintf("%03d", $cnt); $cnt+= $inc; // increment
		$new = $num.".".ltrim($itm, "/0..9.");
		$new = FSO::join($dir, $new);
		$old = FSO::join($dir, $itm); if ($old == $new) continue;

		rename($old, $new);
	}
	return true;
}

// ***********************************************************
// file Opts
// ***********************************************************
private function fileOpts($dir) {
	$cmd = ENV::getPost("file_act"); if (! $cmd)
	$cmd = ENV::getParm("file_act"); if (! $cmd) return false;

	switch(STR::left($cmd)) {
		case "ini": $this->fileAddIni($dir); break; // add page.ini
		case "sys": $this->fileAddSys($dir); break; // add language files, e.g. de.htm
		case "any": $this->fileAddAny($dir); break; // add any new file
		case "dro": $this->fileDelete($dir); break; // delete a file
		case "hid": $this->fileToggle($dir); break; // hide and unhide a file
		default: return false;
	}
	return true;
}

// ***********************************************************
private function fileAddIni($dir) { // add page.ini (recursively)
	$all = ENV::getPost("ini_rec", false);
	$ovr = ENV::get("opt.overwrite");
	$tab = ENV::getTopDir();

	switch ($all) {
		case true: $arr = FSO::tree($tab); unset($arr[0]); break;
		default:   $arr = FSO::tree($dir);
	}
	foreach ($arr as $dir => $nam) {
		$this->saveStdIni($dir, $ovr);
	}
}

private function fileAddSys($dir) { // add empty language file, e.g. de.htm
	$nam = ENV::get("sys.file");
	$lng = ENV::get("sys.lang");
	$ext = ENV::get("sys.ext");
	$ovr = ENV::get("opt.overwrite");

	$fil = FSO::join($dir, "$nam.$lng.$ext");
	$txt = ""; if ($ext == "php") $txt = "<?php\n?>";

	APP::writeTell($fil, $txt, $ovr);
}

private function fileAddAny($dir) { // create any file
	$nam = ENV::getPost("any_name");
	$ovr = ENV::get("opt.overwrite");
	$fil = FSO::join($dir, $nam);
	$erg = APP::writeTell($fil, "", $ovr);
}

private function fileToggle($dir) { // toggle hidden files
	$fil = ENV::getParm("fil"); if (! $fil) return;
	$fil = FSO::join($dir, $fil);
	$xxx = FSO::toggleVis($fil);
}
private function fileDelete($dir) { // delete a files
	$fil = ENV::getParm("fil"); if (! $fil) return;
	$fil = FSO::join($dir, $fil);
	$erg = FSO::kill($fil);
	return true;
}

// ***********************************************************
// ini Opts
// ***********************************************************
private function pageOpts($dir) {
	if ($this->pageDefault($dir)) return true; // set startup page
	if ($this->pageProps($dir))   return true; // save page props
	return false;
}

// ***********************************************************
private function pageProps($dir) { // change uid, display type
	$cmd = ENV::getPost("props"); if (! $cmd) return false;
	$typ = STR::left($cmd["typ"]);

	$tpl = "LOC_CFG/page.def"; if ($typ != "inc")
	$tpl = "LOC_CFG/page.$typ.def";

	$ini = new iniWriter($tpl);
	$ini->read($dir);
	$ini->setPost();
	$ini->save();

	ENV::setPage($ini->get($cmd["uid"]));
	return true;
}

private function pageDefault($dir) { // mark node as default
	$cmd = ENV::getPost("default"); if (! $cmd) return false;

	$ini = new iniWriter($dir); // update page.ini - if necessary
	$uid = $ini->getUID();
	$ini->save();

	$tpc = ENV::getTopDir();
	$fil = FSO::join($tpc, "tab.ini");

	$ini = new iniWriter("LOC_CFG/tab.def"); // update tab.ini
	$ini->read($fil);
	$ini->set("props.std", $uid);
	$ini->save();

	return true;
}

// ***********************************************************
// user Opts
// ***********************************************************
private function userOpts($dir) {
	$chk = ENV::getPost("perms_act"); if (! $chk) return false;
	$ful = FSO::join($dir, "perms.ini");

	$arr = $_POST; unset($arr["perms_act"]);
	$out = array();

	foreach ($arr as $key => $val) {
		if ($val != "i") $out[$key] = $val;
	}
	if (! $out) FSO::kill($ful);
	else {
		$ini = new iniWriter($ful);
		$ini->replace("perms", $out);
		$ini->save();
	}
	return true;
}

// ***********************************************************
// write to ini files
// ***********************************************************
private function saveStdIni($dir, $ovr = false) { // rewrite ini-file
	$fil = FSO::join($dir, "page.ini"); if (is_file($fil) && ! $ovr) return;

	$ini = new iniWriter("LOC_CFG/page.def");
	$ini->read($fil);
	$ini->save($fil);
}

// ***********************************************************
// clipboard Opts
// ***********************************************************
private function clipOpts($dir) {
	$chk = ENV::getPost("clip_act"); if (! $chk) return false;

	if ($chk == "cut") {
		ENV::setPage(dirname($dir));
	}
	incCls("editor/clipBoard.php");

	$clp = new clipBoard();
	return $clp->exec($dir);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
