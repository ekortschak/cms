<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for cleaning up html code for editing.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/tidy.php");

$tdy = new tidy();
$tdy->get($htm);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tidy {

function __construct() {}

// ***********************************************************
// retrieving modified text
// ***********************************************************
public function get($htm) {
	$htm = $this->sweep($htm);
	$htm = $this->phpRestore($htm);
	return $htm;
}

// ***********************************************************
// html methods
// ***********************************************************
private function sweep($txt) {
	$txt = STR::replace($txt, "¶", "");
	$txt = STR::replace($txt, "<table border=\"1\">", "<table>");

	$txt = PRG::replace($txt, "\s", " ");
	$txt = PRG::replace($txt, "<([^/]*?)> ", " <$1>");
	$txt = PRG::replace($txt, " </(.*?)>", "</$1> ");
	$txt = PRG::replace($txt, "<br>(\s*?)", "<br>");
	$txt = STR::replace($txt, "<br></p>", "</p>");
	$txt = PRG::replace($txt, "(\s+)", " ");

	$txt = $this->clearEmpty($txt);
	$txt = $this->clearBlanks($txt);

	$txt = $this->addLFs($txt);
	$txt = $this->addLF($txt, "bblRef");
	$txt = $this->addLF($txt, "bblShow");
	return trim($txt);
}

// ***********************************************************
private function addLFs($txt) {
	$arr = array(); $cnt = 1;
	$arr[] = "<div.<p.<br.<ul.<dl.<li.</ul.</dl.</table.<tr.</tr.<td";
	$arr[] = "<h1.<h2.<h3.<h4.<h5.<h6.<hr.<table.<blockquote";

	foreach ($arr as $tgs) {
 		$its = explode(".", $tgs);
		$rep = str_repeat("\n", $cnt++);

		foreach ($its as $fnd) {
			$txt = $this->addLF($txt, $fnd, $rep);
		}
	}
	$txt = PRG::replace($txt, "<td>\n<p>", "<td><p>");
	return $txt;
}

private function addLF($txt, $fnd, $rep = "\n") {
	return STR::replace($txt, $fnd, $rep.$fnd);
}

// ***********************************************************
private function clearEmpty($txt) {
	$arr = STR::split("p.b.u.i.h1.h2.h3.h4.h5.h6.div", ".");

	foreach ($arr as $tag) {
		$txt = PRG::replace($txt, "<$tag>(\s*?)</$tag>", "");
	}
	return $txt;
}

private function clearBlanks($txt) {
	$arr = str_split(".,:;?!");

	foreach ($arr as $chr) {
		$txt = STR::replace($txt, " $chr", $chr);
	}
	return $txt;
}

// ***********************************************************
// php methods
// ***********************************************************
private function phpSecure($txt) {
	$txt = &$this->htm;
	$txt = PRG::replace($txt, "<--?php(\s+)", "<php>");
	$txt = PRG::replace($txt, "<\?php(\s+)", "<php>");
	$txt = STR::replace($txt, "(\s+)--?>", "</php>");
	$txt = STR::replace($txt, "(\s+)?>", "</php>");
	return $txt;
}

private function phpRestore($txt) {
	$txt = STR::replace($txt, "<php>", "<?php ");
	$txt = STR::replace($txt, "</php>", "?>");
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
