<?php
/* ***********************************************************
// INFO
// ***********************************************************
handling string tasks with preg functions

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/lookupAss.php");

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class lookupAss {
	private $prt = array(); // protected tags

	private $mod = "u";
	private $sep = "@X@";
	private $idf = "@Q@";
	private $cnt = 0;

function __construct() {}

// ***********************************************************
public function replace($text, $search, $mask, $mod = "u") {
	if (! STR::contains($text, $search)) return $text;
	if (! $text) return $text;

	$txt = $this->secure($text);
	$rep = STR::replace($mask, $search, "\$1\$2\$3");
	$fnd = PRG::quote($search);

	$arr = $this->split($txt);
	$fnc = $this->getFunc($fnd);
	$out = "";

	foreach ($arr as $pgf) {
		if (! $pgf) continue;
		$out.= self::$fnc($pgf, $fnd, $rep);
	}
	$out = $this->restore($out);
	return $out;
}

// ***********************************************************
// short search strings
// ***********************************************************
private function rep1($txt, $fnd, $rep) {
	return $this->doPreg($txt, "([ ]+)($fnd)([ ,;]+)", $rep);
}
private function rep2($txt, $fnd, $rep) {
	return $this->doPreg($txt, "\b($fnd)\b", $rep);
}

// ***********************************************************
// language specific lookups
// ***********************************************************
private function repDE($txt, $fnd, $rep) {
	$old = $txt;
	$arr = array(
		"\b($fnd)\b",
		"\b($fnd)([e]+)([nmr]?)\b",
		"\b($fnd)([e]?)([s]+)\b"
	);
	foreach ($arr as $ptn) {
		$txt = $this->doPreg($txt, $ptn, $rep);
		if ($txt != $old) return $txt;
	}
	return $txt;
}

private function repXX($txt, $fnd, $rep) {
	return $this->doPreg($txt, "\b($fnd)([s]?)\b", $rep);
}

// ***********************************************************
// replace only 1st occurrence per paragraphe
// ***********************************************************
private function doPreg($txt, $fnd, $rep) {
	return PRG::replace1($txt, $fnd, $rep, $this->mod);
}

private function split($text) {
	$txt = STR::replace($text, "<p>", $this->sep."<p>");
	$arr = STR::split($txt, $this->sep);
	return $arr;
}

private function getFunc($fnd) {
	if (strlen($fnd) < 2) return "rep1";
	if (strlen($fnd) < 3) return "rep2";

	if (CUR_LANG == "de") return "repDE";
	return "repXX";
}

// ***********************************************************
// protect links & co
// ***********************************************************
private function secure($txt) {
	$arr = STR::find($txt, "<lup", "</lup"); if (! $arr) return $txt;
	$cnt = 0;

	foreach ($arr as $itm) {
		$sec = STR::before($itm, ">");
		$txt = STR::replace($txt, "<lup$itm</lup$sec>", $this->idf.$cnt.$this->idf);
		$this->prt[$cnt] = $itm;
		$cnt++;
	}
	return $txt;
}

private function restore($txt) {
	foreach ($this->prt as $key => $itm) {
		$sec = STR::before($itm, ">");
		$txt = STR::replace($txt, $this->idf.$key.$this->idf, "<lup$itm</lup$sec>");
	}
	$txt = STR::clear($txt, $this->sep);
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
