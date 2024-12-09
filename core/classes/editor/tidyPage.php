<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for cleaning up html code for editing.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/tidyPage.php");

$tdy = new tidyPage();
$tdy->read($file);

*/

incCls("editor/tidyHtml.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tidyPage {

function __construct() {}

// ***********************************************************
// retrieving modified text
// ***********************************************************
public function read($file, $edit = false) {
	$htm = APP::read($file);
	$htm = STR::clear($htm, "\r");

	$htm = $this->phpSecure($htm);
	$htm = $this->checkTags($htm);
	$htm = $this->sweep($htm, $edit);

	if ($htm) return $htm;
	return "<p>¶</p>";
}

public function restore($htm) {
	$htm = STR::replace($htm, "¶", "");

	$htm = $this->phpRestore($htm);
	return $htm;
}

// ***********************************************************
// cleaning html code
// ***********************************************************
private function sweep($txt, $edit = false) {
	$txt = $this->prepare($txt);
	$txt = $this->convPaths($txt);

	$txt = $this->clearBr($txt);
	$txt = $this->clearUselessTags($txt);
	$txt = $this->clearEmptyTags($txt);
	$txt = $this->cleanTags($txt);
	$txt = $this->cleanPunct($txt);

	$txt = $this->protectLFs($txt);

	$txt = $this->addLFs($txt, $edit);
	$txt = $this->addTabs($txt);

	$txt = $this->addLF($txt, "REF::");
	$txt = PRG::replace($txt, "<php>(\s+)REF::", "<php>REF::");

	$txt = $this->restoreLFs($txt);

	if ($edit)
	$txt = $this->addPara($txt);
	return trim($txt);
}

// ***********************************************************
private function prepare($txt) {
	$txt = STR::replace($txt, "¶", "");
	$txt = STR::replace($txt, "&lt;", "<");
	$txt = STR::replace($txt, "&ft;", ">");
	$txt = PRG::replace($txt, "(\s+)", " ");

	$txt = STR::replace($txt, "<table border=\"1\">", "<table>");
	return $txt;
}

// ***********************************************************
private function checkTags($txt) {
	$tdy = new tidyHtml();
	return $tdy->get($txt);
}

// ***********************************************************
private function addPara($txt) {
	$pgf = "&para;";
	$txt = "$pgf$txt\n$pgf";
	$txt = PRG::replace($txt, "$pgf(\s+)$pgf", "$pgf");
#	$txt = STR::replace($txt, "</p>\n\n$pgf", "</p>\n\n");
#	$txt = STR::replace($txt, "</p>\n\n\n$pgf", "</p>\n\n\n");
	return $txt;
}

// ***********************************************************
private function protectLFs($txt, $edit = false) {
	$txt = STR::replace($txt, "( <php>", "(<php>");
	$txt = PRG::replace($txt, "<php>(\s+)REF::link", "<php>REF::link");

	$arr = STR::split("<php>REF::link(.*?)</php>", ".");
	$rep = STR::split("<pxp>REF::link(.*?)</pxp>", ".");

	foreach ($arr as $key => $val) {
		$txt = STR::replace($txt, $val, $rep[$key]);
	}
	return $txt;
}

private function restoreLFs($txt, $edit = false) {
	$txt = STR::replace($txt, "pxp>", "php>");
	return $txt;
}

// ***********************************************************
private function addLFs($txt, $edit = false) {
	$arr = array(); $cnt = 0;
	$arr[] = "</ul.</ol.<li.</dl.<dd.<dt.</table.<tr.</tr.<th.<td.<php"; // single lf
	$arr[] = "<div.<p.<ul.<ol.<dl.<hr.<table.<blockquote"; // double lf
	$arr[] = "<h1.<h2.<h3.<h4.<h5.<h6"; // tripple lf

	foreach ($arr as $tgs) {
 		$its = STR::split($tgs, ".");
		$mrk = ""; if ($edit) if ($cnt) $mrk = "&para;";
		$cnt++;

		foreach ($its as $itm) {
			if (! $itm) continue;
			$txt = $this->addLF($txt, $itm, $cnt, $mrk);
		}
	}
	$txt = STR::replace($txt, "<td>\n", "<td>");
	$txt = STR::replace($txt, "<li>\n", "<li>");
	return $txt;
}

private function addLF($txt, $fnd, $cnt = 1, $mrk = "") {
	$rep = str_repeat("\n", $cnt);
	$txt = PRG::replace($txt, "(\s+)$fnd\b", $fnd);
	return PRG::replace($txt, "$fnd\b", $rep.$mrk.$fnd);
}

// ***********************************************************
private function addTabs($txt) {
	$arr = array(); $cnt = 0;
	$arr[] = "<li.<dd.<dt.<tr.</tr"; // single tab
	$arr[] = "<th.<td"; // double tab

	foreach ($arr as $tgs) {
 		$its = STR::split($tgs, "."); $cnt++;

		foreach ($its as $itm) {
			if (! $itm) continue;
			$txt = $this->addTab($txt, $itm, $cnt);
		}
	}
	return $txt;
}

private function addTab($txt, $fnd, $cnt = 1) {
	$rep = str_repeat("\t", $cnt);
	return STR::replace($txt, $fnd, $rep.$fnd);
}

// ***********************************************************
// clean up html code
// ***********************************************************
private function cleanTags($txt) { // rearrange blanks around tags
	$txt = PRG::replace($txt, "<([A-Za-z]*?)> ", " <$1>");
	$txt = PRG::replace($txt, " </([A-Za-z0-9]*?)>", "</$1> ");
	return $txt;
}

private function cleanPunct($txt) { // spaces around punctuation marks
	$arr = str_split(".,:;?!");

	foreach ($arr as $chr) {
		$txt = STR::replace($txt, " $chr", "$chr ");
		$txt = STR::replace($txt, " $chr",  $chr );
	}
	$txt = PRG::replace($txt, "(\w+)\.\.\.", "$1 ...");
	return $txt;
}

// ***********************************************************
private function clearEmptyTags($txt) { // tags containing blank space at best
	$arr = STR::toArray("p.b.u.i.h1.h2.h3.h4.h5.h6.div", ".");

	foreach ($arr as $tag) {
		$txt = PRG::replace($txt, "<$tag>(\s*?)</$tag>", "");
	}
	return $txt;
}
private function clearUselessTags($txt) { // immediately reopening tags
	$arr = STR::toArray("b.u.i", ".");

	foreach ($arr as $tag) {
		$txt = PRG::replace($txt, "</$tag>(\s*?)<$tag>", " ");
	}
	return $txt;
}

private function clearBr($txt) {
	$txt = STR::replace($txt, "<br />", "<br>");
	$txt = PRG::replace($txt, "(\s?)<br>(\s?)", "<br>");
	$txt = PRG::replace($txt, "<br></([bui]+)>", "</$1><br>");
	$txt = PRG::replace($txt, "<br></", "</");
	return $txt;
}

// ***********************************************************
private function convPaths($txt) {
	$dir = PGE::$dir;
	$txt = STR::replace($txt, $dir, ".");
	return $txt;
}

// ***********************************************************
// php methods
// ***********************************************************
private function phpSecure($txt) { // do not act outside of php code
	if (STR::misses($txt, "<?php")) return $txt;

	$txt = PRG::replace($txt, "<\?php([ ]?)", "<php>");
	$txt = PRG::replace($txt, "([ ]?)\?>",   "</php>");
	$arr = STR::find($txt, "<php>", "</php>", false);

	foreach ($arr as $key => $val) {
		$rep = $val;
		$rep = STR::replace($rep, "->", "&rarr;");
		$rep = STR::replace($rep, "=>", "&rArr;");

		$txt = STR::replace($txt, $val, $rep);
	}
	return $txt;
}

private function phpRestore($txt) { // do not act outside of php code
	$arr = STR::find($txt, "<php>", "</php>", false);
	if (! $arr) return $txt;

	foreach ($arr as $key => $val) {
		$rep = STR::replace($val, "→", "->");
		$rep = STR::replace($rep, "⇒", "=>");
		$txt = STR::replace($txt, $val, $rep);
	}
	$txt = PRG::replace($txt, "<php>([ ]?)", "<?php ");
	$txt = PRG::replace($txt, "([ ]?)</php>", " ?>");
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
