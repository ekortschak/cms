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
	$cod = $this->getContent($fil);

	$htm = new tpl();
	$htm->load("other/codeSnip.tpl");
	$htm->merge($this->vls); if ($head)
	$htm->set("headc", $head);
	$htm->set("code", $cod);
	$htm->set("output", APP::gcFile($fil));
	$htm->show($sec);
}

public function text($file, $head = "") {
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
public function markVars($text) {
	$out = str_replace("&lt;!", "<green><b>&lt;!", $text);
	$out = str_replace("!&gt;", "!></b></green>", $out);
	return $out;
}
public function markGroups($text) {
	$out = str_replace("[", "\n<blue><b>[", $text);
	$out = str_replace("]", "]</b></blue>", $out);
	return $out;
}
public function markComments($text) {
	$out = str_replace("#", "<red>#", $text);
	$out = str_replace("\<red>#", "\#", $out);
    $out = preg_replace("~<red>(.*)\n~", "<red>\${1}</red>\n", $out);
    return $out;
}
public function markPHP($text) {
	$out = highlight_string($text, true);
#	$out = STR::clear($out, '<span style="color: #000000">');
#	$out = STR::clear($out, "</span>");
	return $out;
}

private function getContent($fil) {
	$fil = FSO::reroute($fil);

	$cod = file_get_contents($fil);
	$cod = self::markPHP($cod);
	return STR::clear($cod, "\n");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
