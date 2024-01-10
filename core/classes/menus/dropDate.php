<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create a date selection menu

// ***********************************************************
// HOW TO USE
// ***********************************************************
see parent class

*/

incCls("menus/dropBox.php");
incCls("system/DAT.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dropDate extends dropBox {

function __construct($suit = "menu") {
	parent::__construct($suit);
	$this->load("menus/dropDate.tpl");
}

// ***********************************************************
// overruled methods
// ***********************************************************
public function getYmd($qid = "pick.date", $selected = false) {
	$sel = DAT::get($selected);
	$sel = $this->getSelected($qid, $sel);
	$dat = DAT::split($sel);

	$yir = $this->getKey("$qid.year", DAT::years(),  $dat["y"]);
	$mon = $this->addMon("$qid.mon",  DAT::months(), $dat["m"]);
	$day = $this->addDay("$qid.day",  DAT::numDays($yir, $mon), $dat["d"]);

	$dat = DAT::make($yir, $mon, $day);
	$xxx = ENV::set($qid, $dat);

	$this->setNav($dat);
	$this->set("dparm", $qid);

	return $dat;
}

protected function getSelected($qid, $sel) {
	$sel = ENV::find($qid, $sel);
	$dat = DAT::split($sel);

	$yir = ENV::getParm("$qid.year", $dat["y"]);
	$mon = ENV::getParm("$qid.mon",  $dat["m"]);
	$day = ENV::getParm("$qid.day",  $dat["d"]);

	$dat = DAT::make($yir, $mon, $day);

	ENV::set( $qid, $dat);
	ENV::set("$qid.year", $yir);
	ENV::set("$qid.mon",  $mon);
	ENV::set("$qid.day",  $day);
	return $dat;
}

protected function addMon($qid, $data, $sel = false) {
	$this->data[$qid]["dat"] = $data;
	$this->data[$qid]["cur"] = $sel;
	$this->data[$qid]["sel"] = $sel;
	$this->data[$qid]["typ"] = "mon";
	return $sel;
}

protected function addDay($qid, $data, $sel = false) {
	$this->data[$qid]["dat"] = $data;
	$this->data[$qid]["cur"] = $sel;
	$this->data[$qid]["sel"] = $sel;
	$this->data[$qid]["typ"] = "day";
	return $sel;
}

// ***********************************************************
// display boxes
// ***********************************************************
protected function setNav($date) {
	$xxx = DAT::calc($date, -1);
	$prv = DAT::calc($date, -1); $this->set("prev", $prv);
	$nxt = DAT::calc($date, +1); $this->set("next", $nxt);

	if (! DAT::checkMax($nxt)) $this->substitute("nav.right", "nav.null");
	if (! DAT::checkMin($prv)) $this->substitute("nav.left",  "nav.null");
}

// ***********************************************************
protected function collect($sec) {
    $out = $cal = "";

    foreach ($this->data as $unq => $vls) { // boxes
		extract ($vls);

		$this->set("parm", $unq);
		$this->set("uniq", DIC::get($unq));
		$this->set("current", $cur);

		switch ($vls["typ"]) {
			case "cmb": $out.= $this->getCombo($sec, $dat); break;
			case "mon":	$out.= $this->comboMon(); break;
			case "day":	$cal = $this->comboDay(); break;
		}
    }
    $this->set("cal", $cal);
    return $out;
}

protected function comboMon() {
	$out = "";

	for ($i = 1; $i <= 12; $i++) {
		$this->set("value", $i);
		$out.= $this->getSection("link.mon");

		if ($i % 3 == 0) $out.= "<br>\n";
	}
	$this->set("links", $out);

	return $this->getSection("combo.mon");
}

protected function comboDay() {
	$qid = $this->get("dparm"); $out = "";

	$cur = ENV::get($qid);
	$yir = DAT::get($cur, "Y");
	$mon = DAT::get($cur, "m");

	$fst = DAT::firstOfMonth($cur);
	$fst = DAT::calc($fst, -1);
	$fst = DAT::firstOfWeek($fst);

	for ($i = 1; $i <= 42; $i++) {
		$dat = DAT::calc($fst, $i - 1);
		$day = DAT::get($dat, "d");
		$chk = DAT::get($dat, "m");

		$val = DAT::make($yir, $chk, $day);

		$this->set("caption", intval($day));
		$this->set("value", $val);
		$this->set("myday", ($mon == $chk) ? "" : "inactive");

		$out.= $this->getSection("link.day");

		if ($i % 7 == 0) $out.= "</tr>\n<tr>";
	}
	$this->set("links", $out);

	return $this->getSection("table.day");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
