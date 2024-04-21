<?php
/* ***********************************************************
// INFO
// ***********************************************************
page related functionality
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class prn extends tpl {

function __construct() {
	$this->load("xsite/prn.tpl");
}

// ***********************************************************
// handling ToC
// ***********************************************************
public function toc() {
	$its = PGE::getToc(); if (! $its) return "Empty ToC ...";
	$out = array(); $cnt = 1;

	foreach ($its as $key => $val) {
		$lev = STR::before($val, ":");
		$cap = STR::after($val, ":");

		$cnt = $this->getNum($key, $cnt);
		$sec = $this->format($lev);

		$xxx = $this->set("cap", $cap);
		$xxx = $this->set("page", $cnt++);
		$val = $this->gc($sec);

		$out[$key] = $val;
	}
	$this->set("topic", "Das Glaubensbekenntnis");
	$this->set("topic", "Glaubst du wirklich, was du sagst?");
	$this->set("items", implode("\n", $out));
	return $this->gc("main.toc");
}

// ***********************************************************
private function format($lev) {
	if ($lev < 1) return "toc.lev0";
	if ($lev < 2) return "toc.lev1";
	if ($lev < 3) return "toc.lev2";
	return "toc.levx";
}

private function getNum($kap, $cnt) {
	$ini = new ini("files/toc.ini");
	$vls = $ini->values("toc"); if (! $vls) $ini->addSec("toc");
	$pge = VEC::get($vls, $kap, "¬");

	if ($pge == "¬") $pge = $cnt;
	if ($pge > $cnt) $cnt = $pge;

	PGE::addToc($kap, $pge);
	return $cnt;
}

// ***********************************************************
// handling footnotes
// ***********************************************************
public function fnotes() {
	$its = PGE::getNotes(); if (! $its) return "";
	$out = array(); $cnt = 1;

	foreach ($its as $key => $val) {
		$this->set("idx", $cnt++);
		$this->set("key", $key);
		$this->set("val", $val);
		$out[$key] = $this->gc("fnote");
	}
	$this->set("items", implode("<br>\n", $out));
	return $this->gc("main.fnote");
}

// ***********************************************************
public function stripNotes($htm) {
	$arr = STR::find ($htm, "<refbox>", "</refbox>");  // find refboxes

	foreach ($arr as $itm) {
		$key = STR::before( $itm, "<refbody>");
		$val = STR::between($itm, "<refbody>", "</refbody>");
		$idx = PGE::getIndex($key, $val);
		$htm = PRG::replace($htm, $itm, "$key<sup><fnote>$idx</fnote></sup>");
	}
	return $htm;
}

public function stripSections($htm) {
	$fnd = "</h(\d+)>(\s+)</section>(\s+)<section(.*?)>";
	return PRG::replace($htm, $fnd, "</h$1>");
}

private function getIndex($key, $val) {
	$idx = PGE::getIndex($key, $val);

	$this->$nts[$key] = $val;
	return count($this->$nts);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
