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

$string2num = new string2num();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class string2num {
	private $unq = array();
	private $ein = array();
	private $ten = array();
	private $hun = array();

function __construct() {
	$ini = new ini("files/num.ini");
	$this->unq = $ini->getValues("uniq");
	$this->ein = $ini->getValues("einer");
	$this->ten = $ini->getValues("zehner");
	$this->init();
}

function init() {
	foreach ($this->ten as $kten => $vten) {
		if ($vten < 20) continue;

		foreach ($this->ein as $kein => $vein) {
			if ($vein == 1) $kein = "ein";
			$this->unq[$kein."und".$kten] = $vten + $vein;
		}
		$this->unq[$kten] = $vten;
	}
}

// ***********************************************************
// methods
// ***********************************************************
public function conv($text) {
	$txt = $text;
	$txt = $this->clrWords($txt);
	$txt = $this->rep11($txt);
	$txt = $this->doUniq($txt);
#DBG::text($txt);
	$txt = $this->rep100($txt);
#DBG::text($txt);
	$txt = $this->rep1000($txt);
	$txt = $this->repOrd($txt);
#DBG::text($txt);

	return $txt;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function clrWords($txt) {
	$arr = array("hundert", "tausend");

	foreach ($arr as $wrd) {
		$txt = STR::replace($txt, $wrd."und", $wrd);
		$txt = PRG::replace($txt, "\b$wrd", "ein$wrd");
	}
	return $txt;
}

private function doUniq($txt) {
	foreach ($this->unq as $key => $val) {
		$txt = $this->repUniq($txt, $key, $val);
	}
	foreach ($this->ten as $key => $val) {
		$txt = $this->repUniq($txt, $key, $val);
	}
	return $txt;
}

// ***********************************************************
private function repUniq($txt, $key, $val) {
	$txt = PRG::replace($txt, "\b$key\b", $val);
	$txt = PRG::replace($txt, "\b$key(.+)\b", "$val-$1", "i");
	$txt = STR::replace($txt, "hundert".$key, "hundert".sprintf("%02d", $val));
	$txt = STR::replace($txt, "tausend".$key, ".".sprintf("%03d", $val));
	$txt = STR::replace($txt, $key, $val);
	return $txt;
}

private function rep11($txt) {
	$txt = PRG::replace($txt, "tausendelf", ".011");
	$txt = PRG::replace($txt, "elftausend", "11tausend");

	$txt = PRG::replace($txt, "hundertelf", "hundert11");
	$txt = PRG::replace($txt, "\belfhundert", "1.1hundert");
	return $txt;
}

private function rep100($txt) {
	$wrd = "hundert"; $msk = "%02d";

	foreach ($this->ein as $key => $val) {
		$txt = STR::replace($txt, $wrd.$key, $wrd.sprintf($msk, $val));
	}
	foreach ($this->ein as $key => $val) {
		if ($val < 2) $key = "ein";
		$txt = STR::replace($txt, $key.$wrd, $val.$wrd);
	}
	$txt = PRG::replace($txt, "(\d+)$wrd(\d+)", '$1$2');
	$txt = PRG::replace($txt, "(\d+)$wrd"."tausend", '$1@h@tausend');
	$txt = PRG::replace($txt, "(\d+)$wrd\b", '$1@h@');
	$txt = STR::replace($txt, "@h@", '00');
	$txt = PRG::replace($txt, "([a-zA-Z])$wrd([a-zA-Z])", '$1-100-$2');
	$txt = PRG::replace($txt, "([a-zA-Z])$wrd\b", '$1-100');
	$txt = PRG::replace($txt, "\b$wrd([a-zA-Z])", '100-$1', "i");
	return $txt;
}

private function rep1000($txt) {
	$wrd = "tausend"; $msk = ".%03d"; $plc = "@t@";

	foreach ($this->ein as $key => $val) {
		$txt = STR::replace($txt, $wrd.$key, "@t@".sprintf($msk, $val));
	}
	foreach ($this->ein as $key => $val) {
		if ($val < 2) $key = "ein";
		$txt = STR::replace($txt, $key.$wrd, $val.$wrd);
		$txt = STR::replace($txt, $key.$plc, $val);
	}
	$txt = PRG::replace($txt, "(\d+)$plc", '$1');
	$txt = PRG::replace($txt, "(\d+)tausend(\d+)", '$1.$2');
	$txt = PRG::replace($txt, "(\d+)tausend\b", '$1.000');
	$txt = PRG::replace($txt, "([a-zA-Z])tausend([a-zA-Z])", '$1-1000-$2');
	$txt = PRG::replace($txt, "([a-zA-Z])tausend\b", '$1-1000');
	$txt = PRG::replace($txt, "\btausend([a-zA-Z])", '1000-$1', "i");
	return $txt;
}

private function repOrd($txt) {
	$txt = PRG::replace($txt, "(\d+)-sten", "$1.");

	foreach ($this->ein as $key => $val) {
		if ($val < 2) $key = "ers";
		$txt = STR::replace($txt, $key."ten ", "$val. ");
	}
	return $txt;
}

// ***********************************************************
// debugging
// ***********************************************************
public function test() {
	$this->testH();
	$this->testT();
	$this->testHT();
	$this->testMisc ();
}

public function testH() {
	echo "<h4>100er</h4>";
	$this->dump("hundert");
	$this->dump("hunderteins");
	$this->dump("zweihundert");
	$this->dump("zweihunderteins");
	$this->dump("zweihundertundfünf");
	$this->dump("zweihundertsieben");
	$this->dump("zweihundertzehn");
	$this->dump("zweihundertelf");
	$this->dump("elfhundertelf");
}
public function testT() {
	echo "<h4>1000er</h4>";
	$this->dump("zweitausend");
	$this->dump("zweitausendzwei");
	$this->dump("elftausendzwei");

	$this->dump("zweihundertundfünftausend");
}

public function testHT() {
	echo "<h4>100.000er</h4>";
	$this->dump("zweihunderttausend");
	$this->dump("zweihundertundfünftausendsechshundert");
	$this->dump("zweihundertundfünftausendsechshunderteinunddreissig");
	$this->dump("zweihundertundfünftausendsechshundertvier");
}

public function testMisc() {
	echo "<h4>Misc</h4>";
	$this->dump("Hundertschaft");
	$this->dump("Tausendschaften");
	$this->dump("vieltausendmal");

	$this->dump("abc eins abc");
	$this->dump("abc sieben abc");
	$this->dump("abc hunderttausend abc");
	$this->dump("abc hundertelftausend abc");

	$this->dump("siebzig mal sieben mal");
	$this->dump("siebzigmal");
}

// ***********************************************************
private function dump($txt) {
	DBG::text($this->conv($txt));
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
