<?php
/* ***********************************************************
// INFO
// ***********************************************************
offers common cal views

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("tables/cal_table.php");

$few = new cal_table();
$few->setRange($from, $to);
$few->show();

*/

incCls("system/DAT.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class cal_table extends tpl {

function __construct($suit = "monBlock") {
	parent::__construct();
	$now = DAT::now();

	$this->suit($suit);
	$this->readIni("files/2024.ini");

	$this->setTitle($now);
	$this->set("first", $now);
	$this->set("last",  $now);
}

// ***********************************************************
// display variants
// ***********************************************************
private function suit($mode) {
	$mds = "monList";
	$tpl = "modules/cal.$mode.tpl"; if (! STR::features($mds, $mode))
	$tpl = "modules/cal.monBlock.tpl";

	$this->load($tpl);
}

public function show($sec = "main") {
	parent::show($sec);
}

public function gc($sec = "main") {
	$fst = $this->get("first"); $out = "";
	$cnt = $this->get("count");

	for ($i = 0; $i < $cnt; $i++) {
		$dat = DAT::calc($fst, $i);
		$wkd = DAT::getDay($dat);
		$chk = DAT::get($dat);

		$this->set("weekday", DAT::getDay($dat));
		$this->set("class", $this->getType($dat));
		$this->set("info",  $this->getInfo($dat));
		$this->set("numday", $i + 1);

		$out.= parent::gc("dayx");
	}
	$this->set("items", $out);
	return parent::gc($sec);
}

// ***********************************************************
// set vars
// ***********************************************************
public function setRange($date, $end = "EOM") {
	switch ($end) {
		case "EOW": $lst = 7; break;
		default:    $lst = DAT::lastOfMonth($date);
	}
	$this->setTitle($date);
	$this->set("first", DAT::firstOfMonth($date));
	$this->set("count", $lst);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function setTitle($dat) {
	$yir = DAT::get($dat, "Y");
	$mon = DAT::getMonth($dat, "long");

	$this->set("caption", "$mon $yir");
}

private function getType($dat) {
	$wkd = DAT::weekday($dat);

	if ($wkd == 7) return "sun";
	if ($this->isHoliday($dat)) return "sun";

	if ($wkd == 6) return "sat";
	return "wday";
}

private function getInfo($dat) {
	$dat = DAT::get($dat, "d.m.");
	$out = $this->get("holidays.$dat"); if ($out) return $out;
	return $this->get("other.$dat");
}

private function isHoliday($dat) {
	$dat = DAT::get($dat, "d.m.");
	return $this->isVar("holidays.$dat");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
