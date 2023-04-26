<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create combo boxes containing links for immeadiate action

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/dropBox.php");

$box = new dropBox();
$box->hideDesc();
$box->getKey($qid, $values, $selected);
$box->getVal($qid, $values, $selected);
$box->show();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dropBox extends tpl {
	protected $data = array();
	protected $type = "button";

function __construct($suit = "combo") {
	parent::__construct();
    $this->suit($suit);
}

public function reset() {
	$this->data = array();
}

// ***********************************************************
// display variants
// ***********************************************************
private function suit($mode) {
	switch ($mode) {
		case "table":  $tpl = "menus/dropTable.tpl";  break;
		case "inline": $tpl = "menus/dropInline.tpl"; break;
		case "button": $tpl = "menus/dropButton.tpl"; break;
		case "topics": $tpl = "menus/dropTopics.tpl"; break;
		case "script": $tpl = "menus/dropScript.tpl"; break;
		case "menu":   $tpl = "menus/dropMenu.tpl";   break;
		case "menu2":  $tpl = "menus/dropMenu2.tpl";  break;
		case "icon":   $tpl = "menus/dropIcon.tpl";   break;
		case "dbo":    $tpl = "menus/dropDbo.tpl";    break;
#		case "nav":    $tpl = "menus/dropNav.tpl";    break;
		default: 	   $tpl = "menus/dropBox.tpl";
	}
	$this->load($tpl);
}

public function hideDesc() {
	$this->setSec("uniq", "");
}

// ***********************************************************
// handling properties
// ***********************************************************
public function setProp($prop, $value) {
	$this->set($prop, $value);
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
	if (! $data) return; # $data = array();
	if (! is_array($data)) $data = array($data => $data);

	$sel = $this->getSel($qid, $data, $selected);

	$cur = VEC::get($data, $sel); if (! $cur)
	$cur = current($data);

	$this->data[$qid]["dat"] = $data;
	$this->data[$qid]["sel"] = $sel;
	$this->data[$qid]["cur"] = $cur;

	$this->setType($qid, "cmb");
	return $sel;
}

public function setType($qid, $type) {
#	$chk = ".table.combo.inline.icon.beam.topic.menu.button.";
	$this->data[$qid]["typ"] = $type;
}

public function focus($qid, $value, $default) {
	$chk = ENV::getParm($qid); if ($chk) return $default;

	$key = VEC::find($this->data[$qid]["dat"], $value); if (! $key) return $default;
	$val = VEC::get( $this->data[$qid]["dat"], $key);

	$this->data[$qid]["sel"] = $key;
	$this->data[$qid]["cur"] = $val;
	return ENV::set($qid, $key);
}

// ***********************************************************
protected function getSel($qid, $data, $sel) {
	$sel = ENV::get($qid, $sel);
	$chk = VEC::isKey($data, $sel);

	if (! $chk) $sel = false;
	if (! $sel)
	return ENV::set($qid, array_key_first($data));
	return ENV::setIf($qid, $sel);
}

// ***********************************************************
public function getInput($qid, $value) {
	$sel = ENV::get($qid, $value);

	$this->data[$qid]["cap"] = DIC::getPfx("unq", $qid);
	$this->data[$qid]["dat"] = array($sel => $sel);
	$this->data[$qid]["sel"] = $sel;
	$this->data[$qid]["cur"] = $sel;
	$this->data[$qid]["typ"] = "txt";
	return $sel;
}

// ***********************************************************
// show dirs and files
// ***********************************************************
public function folders($dir, $parm = "pic.folder", $selected = false) {
	$arr = APP::folders($dir); if (! $arr) return false;
	$sel = VEC::find($arr, $selected);
	return $this->getKey($parm, $arr, $sel);
}
public function files($dir, $parm = "pic.file", $selected = false) {
	$arr = APP::files($dir); if (! $arr) return false;
	$sel = VEC::find($arr, $selected);
	$arr = $this->sortFiles($arr);
	return $this->getKey($parm, $arr, $sel);
}
public function pages($dir, $parm = "pic.file", $selected = false) {
	$arr = APP::folders($dir); if (! $arr) return false;

	foreach ($arr as $dir => $nam) {
		$ini = new ini($dir);
		$arr[$dir] = $ini->getHead();
	}
	return $this->getKey($parm, $arr, $sel);
}

// ***********************************************************
protected function sortFiles($arr) {
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
// display boxes
// ***********************************************************
public function show($sec = "main") {
	echo $this->gc($sec);
}
public function gc($sec = "main") {
	if (! $this->isSec($sec)) $sec = "main";
	if (! $this->data) $sec = "empty";

	$this->set("items", $this->collect($sec));
    return $this->getSection($sec);
}

// ***********************************************************
protected function collect($type) {
    $out = "";

    foreach ($this->data as $unq => $vls) { // boxes
		extract ($vls); if ($typ != "cmb") continue;

		$this->set("parm", $unq); $tmp = ""; $cnt = 0;
		$this->set("uniq", DIC::getPfx("unq", $unq));
		$this->set("current", $cur);

		foreach ($dat as $key => $val) { // links
			$this->set("value",   $key); $cnt++;
			$this->set("caption", $val);

#			if ($key == $sel) continue;
			$tmp.= $this->getSection("link");
		}

		$sec = "$type.box"; if ($cnt < 2)
		$sec = "$type.one"; if ($cnt < 1)
		$sec = "empty";

		$xxx = $this->set("links", $tmp);
		$out.= $this->getSection($sec);
    }
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
