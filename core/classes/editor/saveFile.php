<?php
/* ***********************************************************
// INFO
// ***********************************************************
web site editor, used to create and manage files

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/saveFile.php");

$obj = new saveFile();
*/

incCls("editor/iniWriter.php");
incCls("editor/tidy.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class saveFile {

function __construct() {
	if (EDITING != "pedit") return;
	$this->exec();
}

// ***********************************************************
// methods
// ***********************************************************
private function exec() {
	$dir = ENV::get("loc");

	if ($this->saveFile())     return;
	if ($this->conv2html())    return;
	if ($this->dropFile($dir)) return;
	if ($this->picProps($dir)) return;
}

private function saveFile() {
	$fil = ENV::getPost("filName"); if (! $fil) return false;
	$old = ENV::getPost("orgName"); if (  $fil != $old) FSO::kill($old);
	$txt = ENV::getPost("content"); if (! $txt) return false;

	$tdy = new tidy();
	$txt = $tdy->get($txt);

	return APP::write($fil, $txt);
}

private function conv2html() {
	$cnv = ENV::getParm("conv", ""); if (! $cnv) return false;
	$fil = ENV::getParm("fil",  ""); if (! $fil) return false;
	$txt = APP::gc($fil);
	$ext = FSO::ext($fil);

	if (STR::contains($txt, "Uncaught Error:")) {
		return HTW::tag($txt, "pre");
	}
	$new = str_replace(".$ext", ".$cnv", $fil);
	return FSO::move($fil, $new);
}

private function dropFile($loc) {
	$act = ENV::getParm("file_act"); if ($act != "drop") return false;
	$fil = ENV::getParm("fil"); if (! $fil) return false;
	return FSO::kill($fil);
}

// ***********************************************************
// pic Opts
// ***********************************************************
private function picProps($dir) { // modify UID and title
	$act = ENV::getPost("pic_act"); if (! $act) return;
	$new = ENV::getPost("pic_new"); if (! $new) return;
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
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
