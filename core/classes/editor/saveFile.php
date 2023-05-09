<?php

if (VMODE != "pedit") return;

/* ***********************************************************
// INFO
// ***********************************************************
web site editor, used to create and manage files
* no public methods
*/

incCls("editor/iniWriter.php");
incCls("editor/tidy.php");

new saveFile();

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveFile {

function __construct() {
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
private function exec() {
	$dir = ENV::getPage();

	if ($this->saveFile())     return;
	if ($this->dropFile($dir)) return;
	if ($this->picProps($dir)) return;
}

private function saveFile() {
	$fil = ENV::getPost("filName"); if (! $fil) return false;
	$txt = ENV::getPost("content"); if (! $txt) return false;
	$old = ENV::getPost("orgName");	if ($fil != $old) FSO::kill($old);

	$tdy = new tidy();
	$txt = $tdy->get($txt);

	APP::write($fil, $txt);
	return true;
}

private function dropFile($loc) {
	$act = ENV::getParm("file_act"); if ($act != "drop") return false;
	$fil = ENV::getParm("fil"); if (! $fil) return false;
	$xxx = FSO::kill($fil);
	return true;
}

// ***********************************************************
// pic Opts
// ***********************************************************
private function picProps($dir) { // modify UID and title
	$act = ENV::getPost("pic_act"); if (! $act) return false;
	$new = ENV::getPost("pic_new"); if (! $new) return false;
	$arr = LNG::get();

	FSO::rename($act, $new);

	$uid = basename($new);
	$uid = str_replace(" ", "_", $uid);
	$xxx = ENV::setPage($uid);

	$ini = new iniWriter($dir);
	$ini->set("props.uid", $uid);

	foreach ($arr as $lng) {
		$ini->set("$lng.title", $new);
	}
	$ini->save();
	return true;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
