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
$few->range($from, $to);
$few->show();

*/

incCls("system/DAT.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class cal_table extends tpl {

function __construct($suit = "monBlock") {
	parent::__construct();

	$this->suit($suit);
}

// ***********************************************************
// display variants
// ***********************************************************
private function suit($mode) {
	switch($mode) {
		case "monList": $tpl = "monList"; break;
		default: $tpl = "monBlock";
	}
	$this->load("modules/cal.$mode.tpl");
}

public function show($sec = "main") {
	parent::show($sec);
}

public function gc($sec = "main") {
	$jhr = $this->get("year"); $out = "";
	$mon = $this->get("month");
	$cnt = $this->get("count");

	for ($i = 1; $i <= $cnt; $i++) {
		$dat = DAT::make($jhr, $mon, $i);

		$this->set("weekday", DAT::getDay($dat));
		$this->set("class", $this->getType($dat));
		$this->set("info",  $this->getInfo($dat));
		$this->set("numday", $i);

		$out.= parent::gc("dayx");
	}
	$this->set("items", $out);
	return parent::gc($sec);
}

// ***********************************************************
// set vars
// ***********************************************************
public function range($date, $end = "EOM") {
	switch ($end) {
		case "EOW":
			$fst = DAT::firstOfWeek($date);
			$lst = 7; break;
			
		default:
			$fst = DAT::firstOfMonth($date);
			$lst = DAT::lastOfMonth($date);
	}
	$jhr = DAT::get($date, "Y");
	$this->readIni("files/$jhr.ini");

	$this->title($date);
	$this->set("first", $fst);
	$this->set("count", $lst);

	$this->set("year",  $jhr);
	$this->set("month", DAT::get($date, "m"));
	$this->set("day",   DAT::get($date, "d"));
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function title($dat) {
	$yir = DAT::get($dat, "Y");
	$mon = DAT::getMonth($dat, "long");

	$this->set("caption", "$mon $yir");
}

private function getType($dat) {
	if ($this->isHoliday($dat)) return "sun";

	$wkd = DAT::weekday($dat);
	if ($wkd == 7) return "sun";
	if ($wkd == 6) return "sat";
	return "wday";
}

private function getInfo($dat) {
	$key = DAT::get($dat, "d.m.");
	$out = $this->get("holidays.$key"); if ($out) return $out;
	return $this->get("other.$key");
}

private function isHoliday($dat) {
	$dat = DAT::get($dat, "d.m.");
	$out = $this->isVar("holidays.$dat");
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
