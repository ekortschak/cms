<?php
/* ***********************************************************
// INFO
// ***********************************************************
web site editor, used to create and manage files

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("editor/genEdit.php");

$obj = new genEdit();
*/

incCls("editor/iniWriter.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class genEdit {

function __construct() {}

// ***********************************************************
// methods
// ***********************************************************
public function exec() {
	if (EDITING != "pedit") return;
	$dir = ENV::get("loc");

	if ($this->saveFile())     return;
	if ($this->conv2html())    return;
	if ($this->dropFile($dir)) return;
	if ($this->picProps($dir)) return;
}

private function saveFile() {
	$act = ENV::getPost("file_act");    if ($act != "save") return false;
	$old = ENV::getPost("orgName", "");	if (! $old) return false;
	$fil = ENV::getPost("filName", "");	if (! $fil) return false;
	$txt = ENV::getPost("content");

	if ($txt) { // prepare for storage
		$txt = STR::replace($txt, "¶", "");
		$txt = PRG::replace($txt, "(\s*?)<br>", "<br>");
		$txt = PRG::replace($txt, "(\s*?)</p>", "</p>");
		$txt = PRG::replace($txt, "<br></p>", "</p>");
		$txt = PRG::replace($txt, "<br></h([1-9]?)>", "</h$1>");
		$txt = STR::replace($txt, "<table border=\"1\">", "<table>");
		$txt = PRG::replace($txt, "<p>(\s*?)</p>", "");
		$txt = PRG::replace($txt, "<php>", "<?php ");
		$txt = PRG::replace($txt, "</php>", " ?>");
		$txt = PRG::replace($txt, "\n(\s*?)", "\n");

		$erg = APP::write($fil, $txt);
	}
#	if ($old != $fil) FSO::move($old, $fil);
	return true;
}

private function conv2html() {
	$cnv = ENV::getParm("conv", ""); if (! $cnv) return false;
	$fil = ENV::getParm("fil",  ""); if (! $fil) return false;
	$txt = APP::getBlock($fil);
	$ext = FSO::ext($fil);

	if (STR::contains($txt, "Uncaught Error:")) {
		echo "<pre>$txt</pre>";
		return;
	}
	$new = str_replace(".$ext", ".$cnv", $fil);
	FSO::move($fil, $new);
	return true;
}

private function dropFile($loc) {
	$act = ENV::getParm("file_act"); if ($act != "drop") return false;
	$fil = ENV::getParm("fil"); if (! $fil) return false;
	$erg = FSO::kill($fil);
	return true;
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
