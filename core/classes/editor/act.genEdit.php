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

	$out = $this->saveFile();     if ($out) return;
	$out = $this->conv2html();    if ($out) return;
	$out = $this->dropFile($dir); if ($out) return;
}

private function saveFile() {
	$act = VEC::get($_POST, "file_act"); if ($act != "save")
	$act = VEC::get($_GET,  "file_act"); if ($act != "save") return false;

	$old = VEC::get($_POST, "orgName", "");	if (! $old) return false;
	$fil = VEC::get($_POST, "filName", "");	if (! $fil) return false;
	$txt = VEC::get($_POST, "content");

	if ($txt) { // prepare for storage
		$txt = STR::replace($txt, "¶", "");
		$txt = PRG::replace($txt, "(\s*?)<br>", "<br>");
		$txt = PRG::replace($txt, "(\s*?)</p>", "</p>");
		$txt = PRG::replace($txt, "<br></p>", "</p>");
		$txt = STR::replace($txt, "<table border=\"1\">", "<table>");
		$txt = PRG::replace($txt, "<p>(\s*?)</p>", "");
		$txt = PRG::replace($txt, "<php>", "<?php ");
		$txt = PRG::replace($txt, "</php>", " ?>");
		$txt = PRG::replace($txt, "\n(\s*?)", "\n");

		$erg = APP::write($old, $txt);
	}
	if ($old != $fil) FSO::move($old, $fil);
	return true;
}

private function conv2html() {
	$cnv = VEC::get($_GET, "conv", ""); if (! $cnv) return false;
	$fil = VEC::get($_GET, "fil",  ""); if (! $fil) return false;
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
	$act = VEC::get($_GET, "file_act"); if ($act != "drop") return false;
	$fil = VEC::get($_GET, "fil"); if (! $fil) return false;
	$erg = FSO::kill($fil);
	return true;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
