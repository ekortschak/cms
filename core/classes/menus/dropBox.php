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
	if (! $data) return;
	if (! is_array($data)) $data = array($data => $data);

	$sel = $this->getSel($qid, $data, $selected);
	$cur = VEC::get($data, $sel); if (! $cur)
	$cur = current($data);

	$this->data[$qid]["dat"] = $data;
	$this->data[$qid]["sel"] = $sel;
	$this->data[$qid]["cur"] = $cur;
	$this->data[$qid]["typ"] = "cmb";

	return $sel;
}

// ***********************************************************
protected function getSel($qid, $data, $sel) {
	$key = ENV::find($qid, $sel);

	if ($qid == "pic.file") { // TODO: remove this compromise in favour of editing
		$key = basename($key);
	}
	$key = VEC::find($data, $key);

	if (! $key)
	return ENV::set($qid, array_key_first($data));
	return ENV::set($qid, $key);
}

// ***********************************************************
// show dirs and files
// ***********************************************************
public function folders($dir, $parm = "pic.folder", $selected = false) {
	$arr = APP::folders($dir); if (! $arr) return false;
	return $this->getKey($parm, $arr, $selected);
}
public function files($dir, $parm = "pic.file", $selected = false) {
	$arr = APP::files($dir); if (! $arr) return false;
	$arr = $this->sortFiles($arr);
	return $this->getKey($parm, $arr, $selected);
}
public function pages($dir, $parm = "pic.file", $selected = false) {
	$arr = APP::folders($dir); if (! $arr) return false;

	foreach ($arr as $dir => $nam) {
		$ini = new ini($dir);
		$arr[$dir] = $ini->getHead();
	}
	return $this->getKey($parm, $arr, $selected);
}

// ***********************************************************
protected function sortFiles($arr) {
	$pri = $els = array();

	foreach ($arr as $fil => $nam) { // put htm files first
		switch (FSO::ext($fil)) {
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

	$out = $this->collect($sec); if (! $out)
	$out = "&nbsp;";

	$this->set("items", $out);
    return $this->getSection($sec);
}

// ***********************************************************
protected function collect($sec) {
    $out = "";

    foreach ($this->data as $unq => $vls) { // boxes
		extract ($vls);

		$this->set("parm", $unq);
		$this->set("uniq", DIC::getPfx("unq", $unq));
		$this->set("current", $cur);

		switch ($vls["typ"]) {
			case "cmb": $out.= $this->getCombo($sec, $dat); break;
		}
    }
    return $out;
}

protected function getCombo($sec, $dat) {
	$out = ""; $cnt = count($dat);

	foreach ($dat as $key => $val) { // links
		$this->set("value",   $key);
		$this->set("caption", $val);

		$out.= $this->getSection("link");
	}
	$sec = "$sec.box";
	if ($cnt < 2) $sec = STR::replace($sec, "box", "one");
	if ($cnt < 1) $sec = "empty";

	$this->set("links", $out);

	return $this->getSection($sec);
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
