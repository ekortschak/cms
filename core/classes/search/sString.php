<?php
/* ***********************************************************
// INFO
// ***********************************************************
handling string tasks with preg functions

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/sString.php");

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class sString {
	private $txt = "";

	const SEP = "|"; // OR operator

function __construct($text) {
	$this->txt = " $text ";
}

// ***********************************************************
// handling search string
// ***********************************************************
public function hilite($find) {
	if (STR::contains($this->txt, "<mark")) return $this->txt;

	$fnd = str_replace("|", " ", $find); $cnt = 0;
	$lst = $this->split($fnd);
	$out = $this->txt;

	foreach ($lst as $fnd) {
		$idx = $cnt++ % 5 + 1;
		$fnd = $this->chkNoun($fnd);
		$out = $this->markit($out, $fnd, $idx);
	}
	return $out;
}

public function match($what) { // returns yes or no
	$arr = self::split($what); if (! $arr) return false;

	foreach($arr as $itm) {
		if (STR::begins($itm, "-")) {
			if (! $this->findNone($itm)) return false;
			continue;
		}
		if (STR::contains($itm, self::SEP)) {
			if (! $this->findAny($itm)) return false;
			continue;
		}
		if (! $this->findAll($itm)) return false;
	}
	return true;
}

// ***********************************************************
private function findNone($what) { // $what => -str1|str2|str3
	$fnd = STR::clear($what, "-");
	return (! $this->findAny($fnd));
}
private function findAny($what) { // $what => str1|str2|str3
	$fnd = STR::split($what, self::SEP);
	$cnt = $this->word($fnd);
	return ($cnt > 0);
}
private function findAll($what) { // $what => str1+str2+str3
	$fnd = STR::split($what, "+"); $anz = count($fnd);
	$cnt = $this->word($fnd);
	return ($cnt == $anz);
}

// ***********************************************************
private function word($arr) { // $what => ^str^ oder ^str oder str^ oder str
	$cnt = 0;
	foreach ($arr as $wrd) {
		$cnt += $this->isMatch($wrd);
	}
	return $cnt;
}
private function isMatch($what) {
	$fnd = preg_quote($this->chkNoun($what));
	$fnd = str_replace("\^", "(\W+)", $fnd);
	return preg_match("~$fnd~i", $this->txt);
}
private function chkNoun($what) {
	$fst = substr($what, 0, 1);
	if ($fst >= "A") if ($fst <= "Z") return "^$what";
	return $what;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function split($what) {
	$lst = self::checkString($what);
	$qts = STR::find($lst, "'", "'");
	$qts = array_values($qts);

	foreach ($qts as $key => $itm) {
		$lst = str_replace("'$itm'", "@q$key", $lst);
	}
	$lst = STR::split($lst, " ");
	$out = array();

	foreach ($lst as $sub) {
		if (STR::begins($sub, "@q")) {
			$idx = intval(STR::after($sub, "@q"));
			$sub = $qts[$idx];
		}
		$sub = trim($sub); if (! $sub) continue;
		$out[$sub] = $sub;
	}
	return VEC::sortByLen($out);
}

private function checkString($txt) {
	$sep = str_split(".,;+ ");

	$out = trim($txt);
	$out = str_replace('"', "'", $out);
	$out = str_replace($sep, " ", $out);
	$out = preg_replace("~ (\s+)~", " ", $out);
	return $out;
}

private static function markit(&$haystack, $find, $idx) {
	$fnd = STR::clear($find, "^");
	$beg = STR::begins($find, "^"); if (! $beg) $beg = 0;
	$end = STR::ends($find, "^");   if (! $end) $end = 0;

	switch ($beg.$end) {
		case "11": $rep = "$1<mark$idx>$2</mark$idx>$3"; $fnd = "(\W+)($fnd)(\W+)"; break;
		case "10": $rep = "$1<mark$idx>$2</mark$idx>"  ; $fnd = "(\W+)($fnd)";      break;
		case "01": $rep =   "<mark$idx>$1</mark$idx>$2"; $fnd =      "($fnd)(\W+)"; break;
		default:   $rep =   "<mark$idx>$1</mark$idx>"  ; $fnd =      "($fnd)";
	}
	$out = preg_replace("~$fnd~i", $rep, $haystack);
# TODO: no marking in html-tags
#	$out = preg_replace("~<(.*?)$fnd(.*?)>~i",  "<$1$2>",  $haystack);
#	$out = preg_replace("~</(.*?)$fnd(.*?)>~i", "</$1$2>", $haystack);
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
