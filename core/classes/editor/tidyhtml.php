<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for cleaning up html code after editing.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/tidyhtml.php");

$tdy = new tidyhtml();
$tdy->get($htm);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tidyhtml {
	private $php = array();
	private $dat = array();
	private $hst = array();

function __construct() {}

// ***********************************************************
// retrieving modified text
// ***********************************************************
public function get($htm) {
	$htm = $this->securePhp($htm);
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
	$sep = "¬¬¬";
	$txt = PRG::replace($txt, "<([A-Za-z]+)\b", "$sep+|$1:<$1");
	$txt = PRG::replace($txt, "</([A-Za-z]+)>", "$sep-|$1:");
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
	$this->hst = array("@q@");

	foreach ($arr as $itm) {
		$act = STR::before( $itm, "|", false);      if (! $act) continue;
		$tag = STR::between($itm, "|", ":", false); if (! $tag) continue;
		$txt = STR::after(  $itm,      ":", false);

		$typ = $this->getType($tag);

		if ($act == "+") {
			if ($typ == "s") { $this->append($txt);       continue; }
			if ($typ == "n") { $this->append($txt, $tag); continue; }
			if ($typ == "p") { $this->doPgfs($txt, $tag); continue; }
			$this->doFmts($txt, $tag); continue;
		}
		$this->close($tag);
		$this->append($txt);
	}
	$this->close("all");

	return implode("", $this->dat);
}

// ***********************************************************
// tracking tag usage
// ***********************************************************
private function append($txt, $tag = false) {
	if ($txt) $this->dat[] = $txt;
	if ($tag) $this->hst[] = $tag;
}

private function doPgfs($txt, $tag = false) {
	$this->close($tag); // close char tags
	$this->append($txt, $tag);
}

private function doFmts($txt, $tag = false) {
	if ($this->isOpen($tag)) { // avoid duplicate tags
		$this->append(STR::after($txt, ">"));
		return;
	}
	$this->append($txt, $tag);
}

private function pop($tag) {
	if (! $this->isOpen($tag)) return "";
	$out = "";

	while ($this->hst) {
		$itm = array_pop($this->hst);
		if ($itm == "@q@") break; if ($itm) $out.= "</$itm>";
		if ($itm ==  $tag) break;
	}
	return $out;
}

private function close($tag) {
	if (! $this->isOpen($tag)) return;
	$cls = $this->pop($tag);
	$this->append($cls);
}

private function isOpen($tag) {
	return in_array($tag, $this->hst);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getType($tag) {
	if ($this->mayNest($tag))  return "n";
	if ($this->isSingle($tag)) return "s";
	if ($this->isPgf($tag))    return "p";
	return "z";
}

// ***********************************************************
private function mayNest($tag) {
	$tgs = "div.table.ul.ol";
	return STR::contains(".$tgs.", ".$tag.");
}
private function isPgf($tag) { // container tags
	$tgs = "section.p.h1.h2.h3.h4.h5.h6.dl.li.dd.dt.tr.td.blockquote";
	return STR::contains(".$tgs.", ".$tag.");
}
private function isSingle($tag) { // no closing tags
	$tgs = "hr.br.img.input";
	return STR::contains(".$tgs.", ".$tag.");
}

// ***********************************************************
// restore structure
// ***********************************************************
private function securePhp($txt) {
	$this->php = STR::find($txt, "<?php", "?>", false);
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
