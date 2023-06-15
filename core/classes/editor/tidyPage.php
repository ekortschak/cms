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
$tdy->get($htm);

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
public function get($htm) {
	$htm = $this->restruct($htm);

	$htm = $this->sweep($htm);
	$htm = $this->restore($htm);

	if (! $htm) {
		$htm = "<p>¶</p>";
	}
	return $htm;
}

public function secure($htm) {
	$htm = $this->phpSecure($htm);
	$htm = $this->tplSecure($htm);
	return $htm;
}

public function restore($htm) {
	$htm = $this->phpRestore($htm);
	$htm = $this->tplRestore($htm);
	return $htm;
}

// ***********************************************************
// html methods
// ***********************************************************
private function restruct($txt) {
	$tdy = new tidyHtml();
	return $tdy->get($txt);
}

private function sweep($txt) {
	$txt = STR::replace($txt, "¶", "");
	$txt = STR::replace($txt, "<table border=\"1\">", "<table>");

	$txt = $this->cleanTags($txt);
	$txt = $this->clearUselessTags($txt);
	$txt = $this->clearEmptyTags($txt);
	$txt = $this->clearBlanks($txt);
	$txt = $this->clearPaths($txt);
	$txt = $this->clearBr($txt);

	$txt = $this->addLFs($txt);
	$txt = $this->addLF($txt, "bblRef");
	$txt = $this->addLF($txt, "bblShow");

	return trim($txt);
}

// ***********************************************************
private function addLFs($txt) {
	$arr = array(); $cnt = 0;
	$arr[] = "<div.<p.</ul.</ol.<li.</dl.<dd.<dt.</table.<tr.</tr.<th.<td"; // single lf
	$arr[] = "<ul.<ol.<dl.<hr.<table.<blockquote"; // double lf
	$arr[] = "<h1.<h2.<h3.<h4.<h5.<h6"; // tripple lf

	foreach ($arr as $tgs) {
 		$its = STR::slice($tgs, ".");
 		$cnt++;

		foreach ($its as $fnd) {
			if (! $fnd) continue;
			$txt = $this->addLF($txt, $fnd, $cnt);
		}
	}
	$txt = PRG::replace($txt, "<td>\n<p>", "<td><p>");
	return $txt;
}

private function addLF($txt, $fnd, $cnt = 1) {
	$rep = str_repeat("\n", $cnt);
	$txt = PRG::replace($txt, "(\s+)$fnd\b", $fnd);
	return PRG::replace($txt, "$fnd\b", $rep.$fnd);
}

// ***********************************************************
// clean up html code
// ***********************************************************
private function cleanTags($txt) { // rearrange blanks around tags
	$txt = PRG::replace($txt, "<([A-Za-z]+)>(\s+)", " <$1>");
	$txt = PRG::replace($txt, "(\s+)</([A-Za-z0-9]*?)>", "</$2> ");
	return $txt;
}

private function clearEmptyTags($txt) {
	$arr = STR::toArray("p.b.u.i.h1.h2.h3.h4.h5.h6.div", ".");

	foreach ($arr as $tag) {
		$txt = PRG::replace($txt, "<$tag>(\s*?)</$tag>", " ");
	}
	return $txt;
}
private function clearUselessTags($txt) {
	$arr = STR::toArray("b.u.i", ".");

	foreach ($arr as $tag) {
		$txt = PRG::replace($txt, "</$tag>(\s*?)<$tag>", " ");
	}
	return $txt;
}

// ***********************************************************
private function clearPaths($txt) {
	$dir = ENV::getPage();
	$txt = STR::replace($txt, $dir, ".");
	return $txt;
}

// ***********************************************************
private function clearBlanks($txt) {
	$arr = str_split(".,:;?!");
	$txt = PRG::replace($txt, " ( *?)", " ");

	foreach ($arr as $chr) {
		$txt = STR::replace($txt, " $chr", $chr);
	}
	return $txt;
}

// ***********************************************************
private function clearBr($txt) {
	$txt = STR::replace($txt, "<br />", "<br>");
	$txt = PRG::replace($txt, "(\s+)<br>", "<br>");
	$txt = PRG::replace($txt, "<br>(\s+)", "<br>");
	$txt = PRG::replace($txt, "<br></([bui]+)>", "</$1><br>");
	$txt = PRG::replace($txt, "<br></", "</");
	$txt = STR::replace($txt, "<br>", "<br>\n");
	return $txt;
}

// ***********************************************************
// php methods
// ***********************************************************
private function phpSecure($txt) { // do not act outside of php code
	$arr = STR::find($txt, "<?php", "?>", false); if (! $arr) return $txt;

	$txt = STR::replace($txt, "<?php ",  "<php>");
	$txt = STR::replace($txt, "<?php\n", "<php>\n");
	$txt = STR::replace($txt, ";?>",  "; </php>");
	$txt = STR::replace($txt, " ?>",   " </php>");
	$txt = STR::replace($txt, "\n?>", "\n</php>");

	foreach ($arr as $key => $val) {
		$rep = $val;
		$rep = STR::replace($rep, "->", "&rarr;");
		$rep = STR::replace($rep, "=>", "&rArr;");

		$txt = STR::replace($txt, $val, $rep);
	}
	return $txt;
}

private function phpRestore($txt) { // do not act outside of php code
	$arr = STR::find($txt, "<php>", "</php>", false); if (! $arr) return $txt;

	$txt = STR::replace($txt, "<php>", "<?php ");
	$txt = STR::replace($txt, "</php>", "?>");

	foreach ($arr as $key => $val) {
		$rep = $val;
		$rep = STR::replace($rep, "→", "->");
		$rep = STR::replace($rep, "⇒", "=>");

		$txt = STR::replace($txt, $val, $rep);
	}
	return $txt;
}

// ***********************************************************
// tpl methods
// ***********************************************************
private function tplSecure($txt) {
	$txt = STR::replace($txt, "<!", "<|");
	return $txt;
}

private function tplRestore($txt) {
	$txt = STR::replace($txt, "<|", "<!");
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
