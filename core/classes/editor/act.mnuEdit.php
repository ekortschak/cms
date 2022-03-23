<?php
/* ***********************************************************
// INFO
// ***********************************************************
web site editor, used to create and manage menu items

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/act.mnuEdit.php");

$obj = new mnuEdit();
*/

incCls("editor/iniWriter.php");
incCls("server/upload.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class mnuEdit {

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function exec() {
	if (EDITING != "medit") return;

	$dir = ENV::get("loc"); if (! is_dir($dir))
	$dir = APP::dir($dir);	if (! $dir) return;

	switch (ENV::get("btn.menu")) {
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
	$cmd = VEC::get($_POST, "node_act"); if (! $cmd) return false;

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
	$dst = VEC::get($_POST, "ren_dir"); if (! $dst) return false;
	$par = dirname($dir);
	$dst = "$par/$dst";

	if (is_dir($dst)) return ERR::msg("dir.exists", $dir); $erg = rename($dir, $dst);
    if (! $erg) return ERR::assist("dir", "no.write", $dir);
	return true;
}

// ***********************************************************
private function nodeHide($dir) { // hide or remove node
	FSO::toggleVis($dir);
}
private function nodeDrop($dir) {
	FSO::rmDir($dir);
}

// ***********************************************************
// moving nodes
// ***********************************************************
private function nodeOut($dir) { // move out in hierarchy
	$dst = dirname(dirname($dir));
	$chk = substr_count($dst, DIR_SEP); if ($chk < 2) return;
	$dst = FSO::join($dst, basename($dir));
	$xxx = FSO::mvDir($dir, $dst);
}
private function nodeIn($dir) { // move in in hierarchy
	$dst = FSO::getPrev($dir);
	$dst = FSO::join($dst, basename($dir));
	$lev = substr_count($dir, DIR_SEP);
	$chk = substr_count($dst, DIR_SEP); if ($chk < $lev) return;
	$xxx = FSO::mvDir($dir, $dst);
}

// ***********************************************************
// acting on whole tree
// ***********************************************************
private function nodeCheck() { // add UID to page.ini recursively
	$arr = FSO::tree(TAB_PATH); unset($arr[0]);
	$hst = array();

	foreach ($arr as $dir => $nam) {
		$ini = new iniWriter($dir);
		$uid = $ini->getUID();
		$uid = STR::before($uid, ":"); // eliminate trailing numbers

		$idx = VEC::get($hst, $uid, 0) + 1;
		$hst[$uid] = $idx; if ($idx < 2) continue;

		$ini->set("props.uid", "$uid:$idx");
		$ini->save();
	}
	MSG::add("Check UIDs - OK");
	return true;
}

// ***********************************************************
// acting on subnodes
// ***********************************************************
private function nodeAdd($dir) {
	$dst = VEC::get($_POST, "sub_dir"); if (! $dst) return false;
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
	$cmd = VEC::get($_POST, "sort_act"); if (! $cmd) return false;
	$lst = VEC::get($_POST, "slist");    $cnt = 10; // start at #
	$lst = VEC::explode($lst, ";");  $inc = 1;

	foreach ($lst as $itm) {
		$itm = basename($itm); if (! $itm) continue;

		$num = sprintf("%03d", $cnt); $cnt+= $inc; // increment
		$new = "$num.".trim($itm, "/0..9.");
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
	$cmd = VEC::get($_POST, "file_act"); if (! $cmd)
	$cmd = VEC::get($_GET, "file_act"); if (! $cmd) return false;

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
	$all = VEC::get($_POST, "ini_rec", false);
	$ovr = ENV::get("opt.overwrite");
	$tab = ENV::get("loc");

	switch ($all) {
		case true: $arr = FSO::tree($tab); unset($arr[0]); break;
		default:   $arr = array($dir => $dir);
	}
	foreach ($arr as $dir => $nam) {
		$this->saveStdIni($dir, $ovr);
	}
}

private function fileAddSys($dir) { // add empty language file, e.g. de.htm
	$nam = VEC::get($_POST, "sys_name");
	$lng = VEC::get($_POST, "sys_lang");
	$ext = VEC::get($_POST, "sys_ext");
	$ovr = ENV::get("opt.overwrite");

	$fil = FSO::join($dir, "$nam.$lng.$ext");
	$fil = str_replace("content.", "", $fil);
	$txt = ""; if ($ext == "php") $txt = "<?php\n?>";

	$erg = APP::writeTell($fil, $txt, $ovr);
}

private function fileAddAny($dir) { // create any file
	$nam = VEC::get($_POST, "any_name");
	$ovr = ENV::get("opt.overwrite");
	$fil = FSO::join($dir, $nam);
	$erg = APP::writeTell($fil, "", $ovr);
}

private function fileToggle($dir) { // toggle hidden files
	$fil = VEC::get($_GET, "fil"); if (! $fil) return;
	$fil = FSO::join($dir, $fil);
	$xxx = FSO::toggleVis($fil);
}
private function fileDelete($dir) { // delete a files
	$fil = VEC::get($_GET, "fil"); if (! $fil) return;
	$fil = FSO::join($dir, $fil);
	$erg = FSO::kill($fil);
	return true;
}

// ***********************************************************
// ini Opts
// ***********************************************************
private function pageOpts($dir) {
	$lng = CUR_LANG;

	if ($cmd = VEC::get($_POST, "val_default")) {
		$this->pageDefault($dir); // set startup page
		return true;
	}
	if ($cmd = VEC::get($_POST, "val_props")) {
		$this->pageProps($dir); // save page props
		return true;
	}
	if (VEC::get($_POST, "pic_act")) {
		$this->picProps($dir); // edit UID and title simultaneously
		return true;
	}
	return false;
}

// ***********************************************************
private function pageProps($dir) { // change uid, display type
	$typ = HTM::pgeProp($dir, "props.typ", "inc");
	$typ = STR::left($typ);

	$tpl = "design/config/page.ini"; if ($typ != "inc")
	$tpl = "design/config/page.$typ.ini";

	$ini = new iniWriter($tpl);
	$ini->read($dir);
	$ini->getPost();
	$ini->save();

	ENV::setPage($ini->get("props.uid"));
}

private function pageDefault($dir) { // mark node as default
	$act = VEC::get($_POST, "val_default"); if (! $act) return false;

	$ini = new iniWriter($dir); // update page.ini - if necessary
	$uid = $ini->getUID();
	$ini->set("props.uid", $uid);
	$ini->save();

	$tpc = ENV::getTopDir();
	$fil = FSO::join($tpc, "tab.ini");

	$ini = new iniWriter("design/config/tabsets.ini");
	$ini->read($fil);
	$ini->set("props.std", $uid);
	$ini->save();
}

// ***********************************************************
// pic Opts
// ***********************************************************
private function picProps($dir) { // modify UID and title
	$act = VEC::get($_POST, "pic_act"); if (! $act) return;
	$tit = VEC::get($_POST, "uid_tit"); if (! $tit) return;
	$arr = LNG::get();

	$uid = strtolower($tit);
	$uid = str_replace(" ", "_", $uid);
	$xxx = ENV::setPage($uid);

	$ini = new iniWriter($dir);
	$ini->set("props.uid", $uid);

	foreach ($arr as $lng) {
		$ini->set("$lng.title", $tit);
	}
	$ini->save();
}

// ***********************************************************
// user Opts
// ***********************************************************
private function userOpts($dir) {
	$chk = VEC::get($_POST, "perms_act"); if (! $chk) return false;
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

	$ini = new iniWriter($dir);
	$ini->save($fil);
}

// ***********************************************************
// clipboard Opts
// ***********************************************************
private function clipOpts($dir) {
	$chk = VEC::get($_POST, "clip_act"); if (! $chk) return false;

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
