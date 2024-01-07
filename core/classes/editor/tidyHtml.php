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

incCls("other/strProtect.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tidyHtml {
	private $php = array(); // list of php code fragments
	private $cmt = array(); // list of comments (might contain tags)
	private $hst = array(); // list of open tags
	private $dat = array();

function __construct() {}

// ***********************************************************
// retrieving modified text
// ***********************************************************
public function get($htm) {
	$prt = new strProtect();
	$htm = $prt->secure($htm, "<!--", "-->");
	$htm = $prt->secure($htm, "<php>", "</php>");
	$htm = $prt->secure($htm, "<a ", "/a>");

	$htm = $this->clearUnwanted($htm);
	$htm = $this->clearSpaces($htm);
	$arr = $this->splitHtm($htm);

	$htm = $this->reshape($arr);
	$htm = $prt->restore($htm);

	$htm = STR::replace($htm, "<!--", "&lt;!--");
	return $htm;
}

// ***********************************************************
// preparing html code for analysis
// ***********************************************************
private function splitHtm($txt) {
	$sep = "¬¬¬"; $fnd = "([^\<]*?)"; // anything but an opening <

	$txt = PRG::replace($txt, "<$fnd>", "$sep<$1>"); // mark html tags
	$txt = PRG::replace($txt, "</$fnd>", "$sep</$1>$sep"); // mark html tags
	$txt = PRG::replace($txt, "$sep(\s+)$sep", $sep);
	$txt = trim($txt, $sep);

	return STR::split($txt, $sep, false);
}

private function clearUnwanted($txt) {
	$tgs = "tbody";
	$arr = STR::toArray($tgs, ".");

	foreach ($arr as $tag) {
		$txt = PRG::replace($txt, "<$tag(.*?)>", "");
		$txt = STR::clear($txt, "</$tag>");
	}
	return $txt;
}

private function clearSpaces($txt) {
	$txt = PRG::replace($txt, "(\s+)", " ");
	$txt = STR::replace($txt, " </p>", "</p>");
	return trim($txt);
}

// ***********************************************************
// transforming code
// ***********************************************************
private function reshape($arr) {
	$this->dat = $this->hst = array();

	foreach ($arr as $itm) {
		if (! trim($itm)) continue;

		$ful = $this->getTag($itm);
		$tag = STR::clear($ful, "/");
		$sgn = STR::contains($ful, "/");

		$typ = $this->getType($tag);
		$mod = $this->getMode($typ, $sgn);

		switch ($mod) {
			case "oz": $this->dat[] = $itm;         break;
			case "op": // paragraphs
			case "on": $this->addPgf($itm, $tag);   break;
			case "of": $this->addFmt($itm, $tag);   break;
			case "cn": // container
			case "cp": $this->closePgf($tag, $itm); break;
			case "cf": $this->closeFmt($tag, $itm); break;
			case "xc": // comments
			case "xz": $this->dat[] = $itm;         break;
		 }
	}
 	$out = implode("", $this->dat);
	return $out;
}

// ***********************************************************
// opening tags
// ***********************************************************
private function append($txt, $tag = false) {
	if (! $txt) return; $this->dat[] = $txt;
	if (! $tag) return; $this->hst[] = $tag;
}

private function addPgf($txt, $tag = false) { // block tags
	$arr = VEC::sort($this->hst, "rsort");

	foreach ($arr as $itm) {
		$typ = $this->getType($itm); if ($typ != "p") continue;
		$this->closePgf($tag, $itm);
	}
	$this->append($txt, $tag);
}

private function addFmt($txt, $tag = false) { // char format tags
	if ($this->isOpen($tag)) { // avoid duplicate tags
		$txt = STR::after($txt, ">");
	}
	$this->append($txt, $tag);
}

// ***********************************************************
// closing tags
// ***********************************************************
private function close($tag) {
	$this->dat[] = "</$tag>";
}

private function closePgf($tag, $txt) {
	if (! $this->isOpen($tag)) return;

	while ($this->hst) {
		$itm = array_pop($this->hst);
		$typ = $this->getType($itm);
		$this->close($itm);

		if (STR::features("p.n", $typ)) break;
		if ($itm == $tag) break;
	}
}

private function closeFmt($tag, $txt) {
	if (! $this->isOpen($tag)) return;

	while ($this->hst) {
		$itm = end($this->hst);
		$typ = $this->getType($itm); if (STR::features("p.n", $typ)) break;

		$itm = array_pop($this->hst);
		$this->close($itm);	if ($itm == $tag) break;
	}
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getTag($itm) {
	if (strpos(trim($itm), "<") > 1) return "";
	$out = STR::between($itm, "<", ">");
	return STR::before($out, " ");
}

private function getMode($typ, $sgn) {
	if (STR::features("n.p.f",  $typ)) {
		if ($sgn) return "c$typ";
		return "o$typ";
	}
	return "x$typ";
}

private function getType($tag) {
	if ($this->isText($tag))    return "z";
	if ($this->mayNest($tag))   return "n";
	if ($this->isPgf($tag))     return "p";
	if ($this->isComment($tag)) return "c";
	return "f";
}

// ***********************************************************
// analizing tags
// ***********************************************************
private function isOpen($tag) {
	return in_array($tag, $this->hst);
}

private function mayNest($tag) { // may contain other pgf tags
	$tgs = "section.div.table.tr.td.ul.ol.dl.blockquote";
	return STR::features($tgs, $tag);
}
private function isPgf($tag) { // container tags
	$tgs = "p.h1.h2.h3.h4.h5.h6.ul.ol.li.dl.dd.dt.table.tr.td";
	return STR::features($tgs, $tag);
}
private function isText($tag) { // no closing tags
	$tgs = "a.php.hr.br.img.input"; if (! $tag) return true;
	return STR::features($tgs, $tag);
}
private function isComment($tag) {
	return (STR::begins($tag, "!--"));
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
