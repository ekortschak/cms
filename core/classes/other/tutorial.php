<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for handling editable file contents

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/tutorial.php");

$tutorial = new tutorial();
$txt = $tutorial->gettutorial($file);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tutorial extends objects {

function __construct() {}

// ***********************************************************
// tutorial samples
// ***********************************************************
public function snip($file, $head = "") {
	$this->gc($file, "main", $head);
}
public function sample($file, $head = "") {
	$this->gc($file, "code", $head);
}
public function gc($fil, $sec = "main", $head = "") {
	$fil = $this->getFile($fil);
	$cod = $this->getContent($fil);

	$htm = new tpl();
	$htm->load("other/codeSnip.tpl");
	$htm->merge($this->vls); if ($head)
	$htm->set("headc", $head);
	$htm->set("code", $cod);
	$htm->set("output", APP::gcFil($fil));
	$htm->show($sec);
}

public function text($file, $head = "") {
	$fil = $this->getFile($file);
	$cod = $this->getContent($fil);

	$htm = new tpl();
	$htm->load("other/codeSnip.tpl");
	$htm->set("code", $cod); if ($head)
	$htm->set("headc", $head);
	$htm->show("code");
}
public function pic($file) {
	$htm = new tpl();
	$htm->load("other/codeSnip.tpl");
	$htm->set("file", $file);
	$htm->show("pic");
}

// ***********************************************************
// code marking
// ***********************************************************
public function markVars($tutorial) {
	$out = str_replace("&lt;!", "<green><b>&lt;!", $tutorial);
	$out = str_replace("!&gt;", "!></b></green>", $out);
	return $out;
}
public function markGroups($tutorial) {
	$out = str_replace("[", "\n<blue><b>[", $tutorial);
	$out = str_replace("]", "]</b></blue>", $out);
	return $out;
}
public function markComments($tutorial) {
	$out = str_replace("#", "<red>#", $tutorial);
	$out = str_replace("\<red>#", "\#", $out);
    $out = preg_replace("~<red>(.*)\n~", "<red>\${1}</red>\n", $out);
    return $out;
}
public function markPHP($tutorial) {
	$out = highlight_string($tutorial, true);
#	$out = STR::clear($out, '<span style="color: #000000">');
#	$out = STR::clear($out, "</span>");
	return $out;
}

private function getFile($fil) {
	if (! STR::begins($fil, "./")) return $fil;
	$loc = PFS::getLoc();
	return STR::replace($fil, "./", "$loc/");
}

private function getContent($fil) {
	$cod = file_get_contents($fil);
	$cod = self::markPHP($cod);
	return STR::clear($cod, "\n");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
