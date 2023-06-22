<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for cleaning up html code after editing.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/tidyHtml.php");

$tdy = new tidyHtml();
$tdy->get($htm);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tidyHtml {
	private $php = array();
	private $dat = array();
	private $hst = array();

	private $tag = "@q@";

function __construct() {}

// ***********************************************************
// retrieving modified text
// ***********************************************************
public function get($htm) {
# return $htm;
	$htm = $this->securePhp($htm);
# echo "<textarea>$htm</textarea>";
	$htm = $this->badTags($htm);
	$arr = $this->prepare($htm);
	$htm = $this->analize($arr);

	$htm = $this->restorePhp($htm);
	return $htm;
}

// ***********************************************************
// preparing html code for analysis
// ***********************************************************
private function prepare($txt) {
	$sep = "¬¬¬"; $lst = "[A-Za-z0-9]";
	$txt = PRG::replace($txt,  "<($lst+)>", "$sep+|$1:<$1>"); // mark html tags
	$txt = PRG::replace($txt,  "<($lst+) ", "$sep+|$1:<$1 "); // mark html tags
	$txt = PRG::replace($txt, "</($lst+)>", "$sep-|$1:");     // mark end tags
	$txt = trim($txt);

	if (! STR::begins($txt, $sep)) $txt = "$sep+p:<p>$txt";
	return STR::split($txt, $sep);
}

private function badTags($txt) {
	$tgs = "tbody";
	$arr = STR::toArray($tgs, ".");

	foreach ($arr as $tag) {
		$txt = STR::clear($txt, "<$tag>");
		$txt = STR::clear($txt, "</$tag>");
	}
	return $txt;
}

// ***********************************************************
// transforming code
// ***********************************************************
private function analize($arr) {
	$this->dat = array();
	$this->hst = array($this->tag);

	foreach ($arr as $itm) {
		if (! $itm) continue;
		$act = STR::before( $itm, "|",      false); if (! $act) continue;
		$tag = STR::between($itm, "|", ":", false); if (! $tag) continue;
		$txt = STR::after(  $itm,      ":", false);

		$typ = $this->getType($tag);

		if ($act == "+") {
			switch ($typ) {
				case "s": $this->append($txt);       break;
				case "n": $this->append($txt, $tag); break;
				case "p": $this->doPgfs($txt, $tag); break;
				default:  $this->doFmts($txt, $tag);
			}
			continue;
		}
		$this->closeTags($tag);

		if ($txt) {
			switch ($typ) {
				case "p": $this->dat[] = "<p>$txt</p>"; break;
				default:  $this->dat[] = $txt;
			}
		}
	}
	$this->closeTags($this->tag);

	return implode("", $this->dat);
}

// ***********************************************************
// opening tags
// ***********************************************************
private function append($txt, $tag = false) {
	if ($txt) $this->dat[] = $txt;
	if ($tag) $this->hst[] = $tag;
}

private function doPgfs($txt, $tag = false) {
	$arr = VEC::sort($this->hst, "rsort");

	foreach ($arr as $itm) {
		$typ = $this->getType($itm); if ($typ != "p") continue;
		$this->closeTags($itm);
	}
	$this->append($txt, $tag);
}

private function doFmts($txt, $tag = false) {
	if ($this->isOpen($tag)) { // avoid duplicate tags
		$txt = STR::after($txt, ">");
	}
	$this->append($txt, $tag);
}

// ***********************************************************
// closing tags
// ***********************************************************
private function close($tag, $txt = "") {
	$this->dat[] = "</$tag>"; if ($txt)
	$this->dat[] = $txt;
}

private function closeTags($tag) {
	if (! $this->isOpen($tag)) return;

	while ($this->hst) {
		$itm = array_pop($this->hst);
		$typ = $this->getType($tag); if ($typ == "s") continue;

		if ($itm == $this->tag) break; $this->close($itm);
		if ($itm == $tag) break;
	}
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function isOpen($tag) {
	if ($tag == $this->tag) return true;
	return in_array($tag, $this->hst);
}

private function getType($tag) {
	if ($this->mayNest($tag))  return "n";
	if ($this->isSingle($tag)) return "s";
	if ($this->isPgf($tag))    return "p";
	return "z";
}

// ***********************************************************
// analizing tags
// ***********************************************************
private function mayNest($tag) {
	$tgs = "div.table.ul.ol";
	return STR::features($tgs, $tag);
}
private function isPgf($tag) { // container tags
	$tgs = "section.p.h1.h2.h3.h4.h5.h6.dl.li.dd.dt.tr.td.blockquote";
	return STR::features($tgs, $tag);
}
private function isSingle($tag) { // no closing tags
	$tgs = "hr.br.img.input";
	return STR::features($tgs, $tag);
}

// ***********************************************************
// restore structure
// ***********************************************************
private function securePhp($txt) {
	$this->php = STR::find($txt, "<php>", "</php>", false);
	$cnt = 1;

	foreach ($this->php as $cod) {
		$txt = STR::replace($txt, $cod, "snip:$cnt");
		$cnt++;
	}
	return $txt;
}

private function restorePhp($txt) {
	$cnt = 1;

	foreach ($this->php as $cod) {
		$txt = STR::replace($txt, "snip:$cnt", $cod);
		$cnt++;
	}
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
