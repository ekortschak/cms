<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for cleaning up html code for editing.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/tidy.php");

$tidy = new tidy();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tidy {
	private $htm = "";

function __construct($htm) {
	$this->htm = trim($htm);
}

// ***********************************************************
// retrieving modified text
// ***********************************************************
public function get() {
	$this->sweep();
	return $this->htm;
}

// ***********************************************************
// html methods
// ***********************************************************
public function sweep() {
	$txt = &$this->htm;
	$txt = STR::replace($txt, "¶", "");

	$txt = PRG::replace($txt, "(\s*?)</", "</");
	$txt = PRG::replace($txt, "(\s*?)<br>", "<br>");

	$txt = PRG::replace($txt, "<br></p>", "</p>");
	$txt = PRG::replace($txt, "<br></h([1-9]?)>", "</h$1>");

	$txt = STR::replace($txt, "<table border=\"1\">", "<table>");

	$txt = $this->clearEmpty($txt);
	$txt = PRG::replace($txt, "\n(\s*?)", "\n");
}

private function clearEmpty($txt) {
	$arr = STR::split("p.b.u.i.h1.h2.h3.h4.h5.h6", ".");

	foreach ($arr as $tag) {
		$txt = str_ireplace("<$tag></$tag>", "", $txt);
	}
	return $txt;
}

// ***********************************************************
// php methods
// ***********************************************************
public function phpSecure() {
	$txt = &$this->htm;
	$txt = STR::replace($txt, "<--?php\n", "<php>");
	$txt = STR::replace($txt, "<?php\n", "<php>");
	$txt = STR::replace($txt, "<?php ", "<php>");
	$txt = STR::replace($txt, "--?>", "</php>");
	$txt = STR::replace($txt, "?>", "</php>");
}

public function phpRestore() {
	$txt = &$this->htm;
	$txt = STR::replace($txt, "<php>", "<?php ");
	$txt = STR::replace($txt, "</php>", "?>");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
