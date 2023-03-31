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

	switch ($act) {
		case "F": return $this->fileOpts($dir);
		case "U": return $this->userOpts($dir);

		case "D": $this->nodeOpts($dir); break;
		case "P": $this->pageOpts($dir); break;
		case "R": $this->sortOpts($dir); break;
		case "C": $this->clipOpts($dir); break;
		default:  return;
	}
	if (STR::contains("DPRC", $act)) {
		SSV::set("reload", true, "pfs");
	}
}

// ***********************************************************
// node Opts
// ***********************************************************
private function nodeOpts($dir) {
	$cmd = ENV::getPost("node_act"); if (! $cmd) return;

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
	$dst = ENV::getPost("ren_dir"); if (! $dst) return;
	$par = dirname($dir);
	$dst = "$par/$dst";

	if (is_dir($dst)) return ERR::msg("dir.exists", $dir); $erg = rename($dir, $dst);
    if (! $erg) return ERR::assist("dir", "no.write", $dir);

    ENV::setPage($dst);
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
}

// ***********************************************************
// acting on subnodes
// ***********************************************************
private function nodeAdd($dir) {
	$dst = ENV::getPost("sub_dir"); if (! $dst) return;
	$ovr = ENV::get("opt.overwrite");
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
private function sortOpts($dir) { // sort a node
	$cmd = ENV::getPost("sort_act"); if (! $cmd) return;
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
}

// ***********************************************************
// file Opts
// ***********************************************************
private function fileOpts($dir) {
	$cmd = ENV::getPost("file_act"); if (! $cmd)
	$cmd = ENV::getParm("file_act"); if (! $cmd) return;

	switch(STR::left($cmd)) {
		case "ini": return $this->fileAddIni($dir); // add page.ini
		case "sys": return $this->fileAddSys($dir); // add language files, e.g. de.htm
		case "any": return $this->fileAddAny($dir); // add any new file
		case "dro": return $this->fileDelete($dir); // delete a file
		case "hid": return $this->fileToggle($dir); // hide and unhide a file
	}
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
}

// ***********************************************************
// ini Opts
// ***********************************************************
private function pageOpts($dir) {
	if ($this->pageDefault($dir)) return; // set startup page
	if ($this->pageProps($dir))   return; // save page props
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
	$chk = ENV::getPost("perms_act"); if (! $chk) return;
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
}

// ***********************************************************
// write to ini files
// ***********************************************************
private function saveStdIni($dir, $ovr = false, $uid = NV) { // rewrite ini-file
	$fil = FSO::join($dir, "page.ini"); if (is_file($fil) && ! $ovr) return;
	if ($uid === NV) $uid = basename($dir);

	$ini = new iniWriter("LOC_CFG/page.def");
	$ini->set("props.uid", $uid);
	$ini->read($fil);
	$ini->save($fil);
}

// ***********************************************************
// clipboard Opts
// ***********************************************************
private function clipOpts($dir) {
	$chk = ENV::getPost("clip_act"); if (! $chk) return;

	if ($chk == "cut") {
		ENV::setPage(dirname($dir));
	}
	incCls("editor/clipBoard.php");

	$clp = new clipBoard();
	$clp->exec($dir);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
