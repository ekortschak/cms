<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to create path hierarchies from strings

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/dirMaker.php");

$btn = new dirMaker();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dirMaker {
	private $dat = array();
	private $num = array();
	private $size = 9;

function __construct($size = 9) {
	$this->dat = array_fill(0, $size, "");
	$this->num = array_fill(0, $size, 0);
	$this->size = $size;
}

// ***********************************************************
// methods
// ***********************************************************
public function set($level, $value) {
	if ($level < 1) return;

	$this->dat[$level - 1] = $this->normValue($value);
	$this->num[$level - 1]+= 1;

	for ($i = $level; $i < $this->size; $i++) {
		$this->dat[$i] = "";
		$this->num[$i] = 0;
	}
}

public function getPath() {
	$out = implode(DIR_SEP, $this->dat);
	$out = FSO::norm($out);
	return $out;
}

public function getNumPath() {
	$out = array();

	for ($i = 0; $i < $this->size; $i++) {
		$num = sprintf("%02d.", $this->num[$i]);
		$itm = $this->dat[$i]; if (strlen($itm) < 1) continue;
		$out[] = $num.$itm;
	}
	return implode(DIR_SEP, $out);
}

private function normValue($val) {
	$val = strip_tags($val);
	$val = STR::before($val, array("(", ".", ",", "/"));
	$val = PRG::replace($val, "(\d+)\. ", "");

	$pos = strpos($val, "."); if ($pos < 3)
	$val = STR::afterX($val, ".");

	$val = $this->pathify($val);
	$arr = STR::toArray($val, " ,-");
	$out = ""; $cnt = 0;

	foreach ($arr as $itm) {
		if ($cnt++ > 2) break;
		$out.= ucfirst(STR::left($itm));
	}
	return substr($out, 0, 30);
}

private function encoding($text) {
	foreach(mb_list_encodings() as $chr){
		$txt = mb_convert_encoding($text, "UTF-8", $chr);
		echo "$chr: $txt<br>";
	}
}

// ***********************************************************
public function pathify($out) {
	$out = STR::replace($out, "Ä", "Ae");
	$out = STR::replace($out, "ä", "ae");
	$out = STR::replace($out, "Ö", "Oe");
	$out = STR::replace($out, "ö", "oe");
	$out = STR::replace($out, "Ü", "Ue");
	$out = STR::replace($out, "ü", "ue");
	$out = STR::replace($out, "ß", "ss");
	return $out;
}

// ***********************************************************
// debugging
// ***********************************************************
private function debug() {
	for ($i = 0; $i < $this->size; $i++) {
		echo "\n<li>".$this->num[$i]." ".$this->dat[$i];
	}
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
