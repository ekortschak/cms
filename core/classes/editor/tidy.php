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

	$txt = PRG::replace($txt, "<([^/]*?)> ", " <$1>");
	$txt = PRG::replace($txt, " </(.*?)>", "</$1> ");

	$txt = $this->clearUselessTags($txt);
	$txt = $this->clearEmptyTags($txt);
	$txt = $this->clearBlanks($txt);

	$txt = $this->addLFs($txt);
	$txt = $this->addLF($txt, "bblRef");
	$txt = $this->addLF($txt, "bblShow");

	$txt = $this->clearBr($txt);
	return trim($txt);
}

// ***********************************************************
private function addLFs($txt) {
	$arr = array(); $cnt = 1;
	$arr[] = "<div.<p.<br.<ul.<ol.<li.</ul.</ol.<dl.<dd.<dt.</dl.</table.<tr.</tr.<th.<td"; // single lf
	$arr[] = "<h1.<h2.<h3.<h4.<h5.<h6.<hr.<table.<blockquote"; // double lf

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
// clean up html code
// ***********************************************************
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
	$txt = PRG::replace($txt, "(\s*?)<br>(\s*?)", "<br>");
	$txt = PRG::replace($txt, "(\s*?)<br>(\s*?)</", "</");
	return $txt;
}

// ***********************************************************
// php methods
// ***********************************************************
public function phpSecure($txt) { // do not act outside of php code
	$arr = STR::find($txt, "<?php", "?>"); if (! $arr) return $txt;

	$txt = STR::replace($txt, "<?php ",  "<php>");
	$txt = STR::replace($txt, "<?php\n", "<php>\n");
	$txt = STR::replace($txt, ";?>",   " </php>");
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

public function phpRestore($txt) { // do not act outside of php code
	return $txt;
	$arr = STR::find($txt, "<php>", "</php>"); if (! $arr) return $txt;

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
} // END OF CLASS
// ***********************************************************
?>
