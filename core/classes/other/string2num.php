<?php
/* ***********************************************************
// INFO
// ***********************************************************
used to convert numbers in text from verbal representation to digital
e.g. fünfhundertdrei => 503

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/string2num.php");

$obj = new string2num();
$txt = $obj->conv($txt);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class string2num {
	private $card = array();
	private $ord = array();

function __construct() {
	$ini = new ini("files/num.ini");
	$this->card = $ini->getValues("card");
	$this->ord = $ini->getValues("ord");
}

// ***********************************************************
// methods
// ***********************************************************
public function conv($text) {
	$txt = $text;

	$txt = $this->clrWords($txt);
	$txt = $this->repOrd($txt);
	$txt = $this->repCard($txt);
	$txt = $this->rep100($txt);
	$txt = $this->rep1000($txt);
	$txt = $this->clrSymbols($txt);

	return $txt;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function clrWords($txt) {
	$txt = STR::replace($txt, "Eintausend", "-T-");
	$txt = STR::replace($txt, "eintausend", "-t-");
	$txt = STR::replace($txt, "Tausend", "-T-");
	$txt = STR::replace($txt, "tausend", "-t-");

	$txt = STR::replace($txt, "Einhundert", "-H-");
	$txt = STR::replace($txt, "einhundert", "-h-");
	$txt = STR::replace($txt, "Hundert", "-H-");
	$txt = STR::replace($txt, "hundert", "-h-");
	$txt = STR::replace($txt, "-und", "-");

	$txt = STR::replace($txt, "dreissig", "dreißig");
	return $txt;
}

private function clrSymbols($txt) {
	$txt = $this->repZeros($txt);

	$txt = STR::replace($txt, "-H-", "Hundert");
	$txt = STR::replace($txt, "-h-", "hundert");

	$txt = STR::replace($txt, "-T-", "Tausend");
	$txt = STR::replace($txt, "-t-", "tausend");
	return $txt;
}

// ***********************************************************
// replace numbers
// ***********************************************************
private function rep100($txt) {
	$txt = PRG::replace($txt, "(\d+)(\d+)-h-(\d+)(\d+)(\b|$)", "$1.$2$3$4", "i");
	$txt = PRG::replace($txt, "(\d+)(\d+)-h-(\d+)(\b|$)", "$1.$2_1_$3", "i");

	$txt = PRG::replace($txt, "(\d+)-h-(\d+)(\d+)(\b|$)", "$1$2$3");
	$txt = PRG::replace($txt, "(\d+)-h-(\d+)(\b|$)", "$1_1_$2");

	$txt = PRG::replace($txt, "(\d+)(\d+)-h--t-", "$1.$2_2_-t-", "i");
	$txt = PRG::replace($txt, "(\d+)-h--t-", "$1_2_-t-", "i");
	$txt = STR::replace($txt, "-h--t-", "100-t-");

	$txt = PRG::replace($txt, "(\d+)-h-(\b|)", "$1_2_", "i");

	$txt = PRG::replace($txt, "-h-(\d+)(\d+)(\b|$)", "1$1$2", "i");
	$txt = PRG::replace($txt, "-h-(\d+)(\b|$)", "10$1", "i");

	$txt = PRG::replace($txt, "\B-h-(\B)", "100", "i");
	$txt = $this->repZeros($txt);
	return $txt;
}

private function rep1000($txt) {
 	$txt = PRG::replace($txt, "(\d+)-t-(\d+)(\d+)(\d+)(\b|$)", "$1.$2$3$4", "i");
	$txt = PRG::replace($txt, "(\d+)-t-(\d+)(\d+)(\b|$)", "$1._1_$2$3", "i");
	$txt = PRG::replace($txt, "(\d+)-t-(\d+)(\b|$)", "$1._2_$2", "i");
	$txt = $this->repZeros($txt);

	$txt = PRG::replace($txt, "(\d+)-t-(\b|$|)", "$1.000", "i");
	$txt = PRG::replace($txt, "(\d+)-t-", "$1.", "i");

	$txt = PRG::replace($txt, "\B-t-(\B)", "1.000", "i");
	return $txt;
}

// ***********************************************************
// known numbers
// ***********************************************************
private function repCard($txt) {
	foreach ($this->card as $val => $key) {
		$txt = PRG::replace($txt, "\b$key(\b|$)", $val);
#		$txt = PRG::replace($txt, "$key(\b|$)", $val);
		$txt = PRG::replace($txt, "\b$key", $val);
	}
	return $txt;
}
private function repOrd($txt) {
	foreach ($this->ord as $val => $key) {
		$txt = PRG::replace($txt, "\b$key([nrs]?)(\b|$)", $val);
		$txt = PRG::replace($txt, "\b$key(ns)(\b|$)", $val);
	}
	return $txt;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function repZeros($txt) {
	$txt = STR::replace($txt, "-5-", "00.000");
	$txt = STR::replace($txt, "_2_", "00");
	$txt = STR::replace($txt, "_1_", "0");
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
