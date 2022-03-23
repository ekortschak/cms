<?php
/* ***********************************************************
// INFO
// ***********************************************************
Handles survey questions, answers and their storage in a db.

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("other/survey.php");

$mnu = new survey();
*/

incCls("input/selector.php");
incCls("dbase/dbQuery.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class survey extends objects {
	private $inf = array();
	private $rec = array();

function __construct() {
	$this->setOID("gen.survey");

	$this->rec = array(
		"survey" => 1,
		"who" => ENV::get("survey.who", uniqid()),
		"ip" => $_SERVER["REMOTE_ADDR"]
	);
}

private function setRec($dir) {
	$ini = new ini($dir);
	$this->rec["survey"] = $ini->getUID();
}

// ***********************************************************
// methods
// ***********************************************************
public function show($dir) {
	return $this->doIt("showSurvey", $dir);
}
public function results($dir) {
	return $this->doIt("showResult", $dir);
}

private function doIt($fnc, $dir) {
	$xxx = $this->setRec($dir);
	$arr = $this->getOIDs();

	$drs = FSO::folders("$dir/*"); if (! $drs) return;
	$drs = array_keys($drs);
	$max = count($drs);

	$num = $this->getCurrent($max);
	$dir = $drs[$num];

	$opt = $this->readOpts($dir);
	$xxx = $this->setQ($dir);

	return $this->$fnc($dir, $opt);
}

private function readOpts($dir) {
	$ini = new ini("$dir/opts.ini");
	$inf = $ini->getValues();
	$out = $ini->getValues(CUR_LANG); if (! $out) return array();

	$this->merge($inf);
	return $out;
}

// ***********************************************************
public function reset($dir) {
	$loc = ENV::get("survey.loc");

	ENV::forget("gen.survey");
	ENV::set("survey.who", uniqid());
	ENV::set("survey.loc", $loc);
#	ENV::set("survey.cur", 0);
	ENV::set("survey.done", false);
}

// ***********************************************************
// saving data
// ***********************************************************
public function save($dir) {
	$arr = $this->getOIDs(); if (! $arr) return;
	$xxx = $this->setRec($dir);

	$qiz = ENV::get("survey.ID");
	$who = ENV::get("survey.who");

	$this->storeInfo($who);

	foreach ($arr as $key => $val) {
		switch (is_array($val)) {
			case true: $this->multi($qiz, $key, $val, $who); break;
			default:   $this->store($qiz, $key, $val, $who);
		}
	}
	ENV::set("survey.who", uniqid());
}

private function multi($qiz, $key, $val, $who) {
	$arr = $val;
	$this->clear($qiz, $key, $who);

	foreach ($arr as $val => $tmp) {
		if (! $tmp) continue;
		$this->store($qiz, $key, $val, $who);
	}
}

private function storeInfo($who) {
	$flt = "who='$who'";
	$vls = array(
		"who" => $who,
		"plz" => ENV::get("survey.loc", "roundtrip"),
		"age" => ENV::get("survey.age", 0),
		"bg"  => ENV::get("survey.bgr", NV)
	);
	$dbq = new dbQuery(NV, "survey_info");
	$dbq->askMe(false);
	$dbq->replace($vls, $flt);
}

private function store($qiz, $key, $val, $who) {
	$flt = "survey='$qiz' AND question='$key' AND answer='$val' AND who='$who'";
	$vls = $this->rec;
	$vls["question"] = $key;
	$vls["answer"] = $val;

	$dbq = new dbQuery(NV, "survey");
	$dbq->askMe(false);
	$dbq->replace($vls, $flt);
}

private function clear($qiz, $key, $who) {
	$flt = "survey='$qiz' AND question='$key' AND who='$who'";

	$dbq = new dbQuery(NV, "survey");
	$dbq->askMe(false);
	$dbq->delete($flt);
}

// ***********************************************************
// display
// ***********************************************************
private function showSurvey($dir, $opt) {
	$tit = $this->get("title");
	$typ = $this->get("props.input", "radio");

	$nav = $this->getFooter();

	$sel = new selector();
	$sel->setOID("gen.survey");
	$sel->read("design/templates/modules/survey.tpl");
	$sel->set("sep", "<br/>");
	$sel->substitute("btn.ok", "btn.$nav");
	$sel->substitute("done.ok", "done.$nav");
	$sel->merge($this->vls);
	$sel->$typ($tit, $opt);
	$sel->show();
}

// ***********************************************************
private function showResult($dir, $opt) {
	$tit = $this->get("title");
	$nav = $this->getFooter();

	$tpl = new tpl(); $out = "";
	$tpl->read("design/templates/modules/survey.tpl");
	$tpl->substitute("btn.ok", "btn.$nav");
	$tpl->substitute("done.ok", "done.$nav");
	$tpl->merge($this->vls);

	$cnt = $this->getAnz();

	foreach ($opt as $key => $val) {
		$tpl->set("option", $val);
		$tpl->set("count", $cnt);
		$tpl->set("width", $this->getPerc($key));
		$out.= $tpl->getSection("result");
	}
	$tpl->set("head", $tit);
	$tpl->set("items", $out);
	$tpl->show("results");

	$fil = APP::find($dir);	if (! $fil) return;
	include $fil;
}

private function getAnz() {
	$qiz = $this->rec["survey"];
	$ask = $this->get("ask");
	$ask = ENV::norm($ask);

	$dbo = new dbBasics(NV, "gim");
	$out = $dbo->fetch1st("SELECT count(DISTINCT who) FROM survey WHERE survey='$qiz' AND question='$ask'");
	return ($out) ? current($out) : 0;
}

private function getPerc($key) {
	$qiz = $this->rec["survey"];
	$ask = $this->get("ask");
	$ask = ENV::norm($ask);

	$dbo = new dbBasics(NV, "gim");
	$all = $dbo->fetch1st("SELECT count(ID) FROM survey WHERE survey='$qiz' AND question='$ask'");
	$cnt = $dbo->fetch1st("SELECT count(ID) FROM survey WHERE survey='$qiz' AND question='$ask' AND answer='$key'");

	if (! $all) return 0; $all = current($all); if (! $all) return 0;
	if (! $cnt) return 0; $cnt = current($cnt); if (! $cnt) return 0;

	return intval($cnt * 100 / $all);
}

// ***********************************************************
// retrieving content
// ***********************************************************
private function getCurrent($max) { // navigation through questions
	$btn = ENV::getPost("nav", "0");
	$num = ENV::get("survey.cur", "0");

	switch ($btn) {
		case "▸": $num++; break;
		case "◂": $num--; break;
	}
	$num = CHK::range($num, $max - 1, 0);
	$xxx = ENV::set("survey.cur", $num);

	$this->set("cur", $num);
	$this->set("fst", $num + 1);
	$this->set("lst", $max);
	return $num;
}

// ***********************************************************
private function getFooter() {
	$fst = $this->get("fst"); if ($fst < 2)     return "fst";
	$lst = $this->get("lst"); if ($fst >= $lst) return "lst";
	return "ok";
}

// ***********************************************************
// Q&A
// ***********************************************************
private function setQ($dir) { // read question related info
	$ini = new ini($dir); $lng = CUR_LANG;

	$this->set("title", $ini->getTitle());
	$this->set("ask",   $ini->getTitle());
	$this->set("head",  $ini->getHead());
	$this->set("info",  $ini->get("$lng.info"));
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
