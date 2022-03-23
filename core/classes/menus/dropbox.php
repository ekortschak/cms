<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/dropbox.php");

$box = new dbox();
$box->setSpaces($before, $after);
$box->getKey($qid, $values, $selected);
$box->getVal($qid, $values, $selected);
$box->show();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dbox extends tpl {
	protected $data = array();
	protected $type = "button";
	protected $ctx = false;

function __construct($context = false) {
	parent::__construct();

	$this->setOID();
    $this->read("design/templates/menus/dropbox.tpl");
    $this->ctx = $context;
}

public function reset() {
	$this->data = array();
}

public function setSpaces($before, $after) {
	$this->set("tspace", $before); // top space
	$this->set("bspace", $after); // bottom space
}

// ***********************************************************
// setting data
// ***********************************************************
public function getCode($qid, $data, $selected = false) {
	$arr = array();

	foreach ($data as $key => $val) {
		$key = STR::replace($key, '"',  "@DQ@");
		$arr[$key] = $val;
	}
	return $this->getKey($qid, $arr, $selected);
}

public function getVal($qid, $data, $selected = false) {
	$out = $this->getKey($qid, $data, $selected);
	return $this->decode($qid, $out);
}

public function getKey($qid, $data, $selected = false) {
	if (! $data) $data = array();
	if (! is_array($data)) $data = array($data => $data);

	$sel = $selected;
	$new = $this->newSelect($qid, $sel);

	switch ($new) {
		case true: $sel = ENV::set($qid, $sel); break;
		default:   $sel = ENV::setIf($qid, $sel);
	}
	$sel = $this->getSel($qid, $data, $sel);
	$cur = VEC::get($data, $sel);

	$this->data[$qid]["dat"] = $data;
	$this->data[$qid]["sel"] = $sel;
	$this->data[$qid]["cur"] = $cur;
	$this->data[$qid]["typ"] = "cmb";
	return $sel;
}

private function getSel($qid, $data, $sel) {
	$ctx = $this->getOidVar("context");
	$sel = $this->chkContext($ctx, $qid, $sel);
	$sel = ENV::setIf($qid, $sel);
	$fil = APP::file($sel); if ($fil) $sel = basename($fil);
	return VEC::find($data, $sel, $sel);
}

private function newSelect($qid, $sel) {
	$chk = $sel;
	if ($chk != NV) $chk = ENV::get("$qid.sel", NV);
	if ($chk != NV) return ($chk != $sel);

	$chk = ENV::set("$qid.sel", $sel);
	return true;
}

private function chkContext($ctx, $qid, $sel) {
	if ($ctx == $this->ctx) return ENV::set($qid, $sel);
	$sel = ENV::get($qid, $sel);
	$out = ENV::set($qid, $sel);
	return $out;
}

public function getInput($qid, $value) {
	$sel = ENV::get($qid, $value);

	$this->data[$qid]["cap"] = DIC::check("box", $qid);
	$this->data[$qid]["dat"] = array($sel => $sel);;
	$this->data[$qid]["sel"] = $sel;
	$this->data[$qid]["cur"] = $sel;
	$this->data[$qid]["typ"] = "txt";
	return $sel;
}

// ***********************************************************
// show dirs and files
// ***********************************************************
public function folders($dir, $parm = "dir", $selected = false) {
	$arr = APP::folders($dir); if (! $arr) return;
	return $this->getKey($parm, $arr, $selected);
}
public function files($dir, $parm = "pic.file", $selected = false) {
	$arr = APP::files($dir); if (! $arr) return;
	$arr = $this->sortFiles($arr);
	return $this->getKey($parm, $arr, $selected);
}

public function anyfiles($dir, $parm = "pic.file", $selected = false) {
	$arr = APP::files($dir, false, false); if (! $arr) return;
	$arr = $this->sortFiles($arr);
	return $this->getKey($parm, $arr, $selected);
}

private function sortFiles($arr) {
	$pri = $els = array();

	foreach ($arr as $fil => $nam) { // put htm files first
		$ext = FSO::ext($fil);
		switch ($ext) {
			case "htm": case "php": $pri[$fil] = $nam; break;
			default:                $els[$fil] = $nam;
		}
	}
	return array_merge($pri, $els);
}

// ***********************************************************
// show db tables and fields
// ***********************************************************
public function showDbObjs($what = "BTF", $key = true) { // dbs will be assumed anyway
	$dbs = "";
	$val = DIC::get("dbs.new"); if (STR::contains($what, "B")) $val = DBS::dbases();
	$dbs = $this->getKey("pic.dbase", $val);

	$tbl = $val = "";
	if (STR::contains($what, "T")) $val = DBS::tables($dbs);
	if (STR::contains($what, "N")) $val = DIC::get("tbl.new");
	if ($val) $tbl = $this->getKey("pic.table", $val);

	$fld = $val = "";
	if (STR::contains($what, "F")) $val = DBS::fields($dbs, $tbl, $key);
	if (STR::contains($what, "C")) $val = DIC::get("fld.new");
	if ($val) $fld = $this->getKey("db.field", $val);

	$this->show("menu");
	return array("dbs" => $dbs, "tbl" => $tbl, "fld" => $fld);
}

// ***********************************************************
// display boxes
// ***********************************************************
public function show($sec = "combo") {
	echo $this->gc($sec);
}
public function gc($sec = "combo") {
	if (! $this->data) return "";

	$this->setOidVar("context", $this->ctx);
	$this->set("items", $this->collect($sec));
    return $this->getSection($sec);
}

// ***********************************************************
private function collect($type) {
    $out = "";

    foreach ($this->data as $unq => $vls) { // boxes
		extract ($vls);

		$this->set("parm", $unq); $tmp = ""; $cnt = 0;
		$this->set("uniq", DIC::check("unq", $unq));
		$this->set("current", $cur);

		foreach ($dat as $key => $val) { // links
			$this->set("value",   $key); $cnt++;
			$this->set("caption", $val);

#			if ($key == $sel) continue;
			$tmp.= $this->getSection("link");
		}
		if ($typ == "cmb") {
			$sec = "$type.box"; if ($cnt < 2)
			$sec = "$type.one";
		}
		else {
			$sec = "table.text";
		}
		$this->set("links", $tmp);

		$out.= $this->getSection($sec);
    }
   	$this->reset();
    return $out;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
public function decode($qid, $find, $default = false) {
	foreach ($this->data[$qid]["dat"] as $key => $val) {
		if ($key == $find) return $val;
		if ($val == $find) return $key;
	}
	return $default;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
