<?php
/* ***********************************************************
// INFO
// ***********************************************************
handling string tasks with preg functions

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/searchstring.php");

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class searchstring {
	private $txt = "";
	private $sep = "|"; // OR operator

function __construct($text) {
	$this->txt = " $text ";
}

// ***********************************************************
// handling search string
// ***********************************************************
public function match($what) { // returns yes or no
	$arr = self::split($what);

	foreach($arr as $itm) {
		if (STR::begins($itm, "-")) {
			if (! $this->findNone($itm)) return false;
			continue;
		}
		if (STR::contains($itm, $this->sep)) {
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
	$fnd = explode($this->sep, $what);
	$cnt = $this->word($fnd);
	return ($cnt > 0);
}
private function findAll($what) { // $what => str1+str2+str3
	$fnd = explode("+", $what); $anz = count($fnd);
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
public function split($what) {
	$lst = self::checkString($what);
	$qts = STR::find($lst, "'", "'");
	$qts = array_values($qts);

	foreach ($qts as $key => $itm) {
		$lst = str_replace("'$itm'", "@q$key", $lst);
	}
	$lst = explode(" ", $lst);
	$out = array();

	foreach ($lst as $sub) {
		if (STR::begins($sub, "@q")) {
			$idx = intval(STR::after($sub, "@q"));
			$sub = $qts[$idx];
		}
		$sub = trim($sub); if (! $sub) continue;
		$out[$sub] = $sub;
	}
	return $out;
}

private function checkString($txt) {
	$sep = str_split(".,;+ ");

	$out = trim($txt);
	$out = str_replace('"', "'", $out);
	$out = str_replace($sep, " ", $out);
	$out = preg_replace("~ (\s+)~", " ", $out);
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
