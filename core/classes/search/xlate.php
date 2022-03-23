<?php

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class arten extends ini {
	private $url = "https://www.bing.com/images/search?q=xxx";
	private $dat = array();

function __construct($fil = "lookup/arten.ini") {
	$this->read($fil);
	$arr = $this->getValues("species");
	$qid = $this->setQid($fil);

	foreach ($arr as $key => $val) {
		$this->dat[$key] = $val;
	}
	krsort($this->dat);
}

private function setQid($fil) {
	$qid = basename($fil);
	$qid = STR::before($qid, ".");

	$this->set("qid", $qid);
	return $qid;
}

public function prepare($txt) {
	foreach ($this->dat as $key => $val) {
		if (! STR::contains($txt, $key))  continue;
		if (  STR::contains($val, "???")) continue;

		$aut = STR::before($val, ";");
		$art = STR::after($val, ";");

		$qid = $this->get("qid");
		$fst = substr($key, 0, 1);
		$rst = substr($key, 1);

		$rep = "<lup_$qid>$fst@!@$rst</lup_$qid>";
		$txt = str_ireplace($key, $rep, $txt);
	}
	$txt = str_replace("@!@", "", $txt);
	return $txt;
}

public function insert($txt) {
	$tpl = new tpl();
	$tpl->read("design/templates/other/lookup.tpl");

	$sec = $this->get("tpl", "lookup");

	foreach ($this->dat as $key => $val) {
		if (! STR::contains($txt, $key))  continue;
		if (  STR::contains($val, "???")) continue;

		$lnk = STR::replace($this->url, "xxx", $key);
		$txt = STR::replace($txt, "($art)", "");

		$tpl->set("caption", $key);
		$tpl->set("art", $art);
		$tpl->set("autor", $aut);
		$tpl->set("link", $lnk);
		$tpl->set("info", $art);

		$rep = $tpl->getSection($sec);
		$txt = str_ireplace($key, $rep, $txt);
	}
	return $txt;
}

public function remove($txt) {
	$arr = STR::find($txt, "<!LUP_$qid:", "!>");
	$qid = $this->get("qid");

	foreach ($arr as $itm) {
		$txt = STR::replace($txt, "<!LUP_$qid:$itm!>", $itm);
	}
	return $txt;
}
public function remove_old($txt) {
	$fnd = PRG::quote("<refbox bing@ANY>@ANY\n@ANY</refbox>");
	$txt = PRG::replace($txt, $fnd, "$2", "s");

	$fnd = PRG::quote("<lookup>@ANY <hint>(@ANY)</lookup>");
	$txt = PRG::replace($txt, $fnd, "$1", "s");
	$txt = STR::replace($txt, "  ", " ");
	return $txt;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
