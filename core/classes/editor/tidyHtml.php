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

function __construct() {}

// ***********************************************************
// retrieving modified text
// ***********************************************************
public function get($htm) {
#	return $htm;
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
	$sep = "¬¬¬"; $lst = "[A-Za-z0-9]";
	$txt = PRG::replace($txt,  "(\s+)", " ");
	$txt = PRG::replace($txt,  "<($lst*?) ", "$sep+|$1:<$1 " ); // mark html tags
	$txt = PRG::replace($txt,  "<($lst*?)>", "$sep+|$1:<$1>" ); // mark html tags
	$txt = PRG::replace($txt, "</($lst*?)>", "$sep-|$1:");     // mark end tags
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
		$this->close($tag);

		switch ($typ) {
#			case "p": $this->chkPgf($txt, $tag); break;
#			default:  $this->append($txt);
		}
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
	$this->close($tag); // no nesting, close char tags
	$this->append($txt, $tag);
}

private function chkPgf($txt, $tag = false) {
	$txt = trim($txt);
	if ($txt) $this->dat[] = "<$tag>$txt</$tag>";
}

private function doFmts($txt, $tag = false) {
	if ($this->isOpen($tag)) { // avoid duplicate tags
		$txt = STR::after($txt, ">");
	}
	$this->append($txt, $tag);
}

private function close($tag) {
	if (! $this->isOpen($tag)) return;

	while ($this->hst) {
		$itm = array_pop($this->hst); if (! $itm) continue;
		$typ = $this->getType($tag);  if ($typ == "s") continue;

		if ($itm == "@q@") break; $this->dat[] = "</$itm>";
		if ($itm ==  $tag) break;
	}
}

private function isOpen($tag) {
	if ($tag == "all") return true;
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
