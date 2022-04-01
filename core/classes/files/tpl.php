<?php
/* ***********************************************************
// INFO
// ***********************************************************
contains functions connected to template files

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("files/tpl.php");

$tpl = new tpl();
$tpl->read($template_file);
$tpl->read($other_file);
$tpl->show();

$lin = $tpl->getSection($nam)
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class tpl extends objects {
	protected $sec = array();   // tpl sections
	private   $hst = array();   // list of included files

function __construct() {
	$this->read("design/templates/msgs/no.tpl.tpl");
	$this->read("design/templates/msgs/msgs.tpl");
}

// ***********************************************************
// handling the template
// ***********************************************************
public function read($file) {
	$this->set("file", $file);

	$cod = new code();
	$cod->read($file);

	$this->hst = array_merge($this->sec, $cod->getHist());
	$this->sec = array_merge($this->sec, $cod->getSecs());
	$this->merge($cod->getVars());
}

// ***********************************************************
// handling sections
// ***********************************************************
public function setSec($sec, $text = "") { // set section content
	$sec = $this->norm($sec);
	$this->sec[$sec] = trim($text);
}

public function copy($sec, $dest) { // copy sections
	if (! $this->isSec($sec)) return;
	$this->setSec($dest, $this->sec[$sec]);
}
public function substitute($sec, $src) { // replace sections
	$this->copy($src, $sec);
}

// ***********************************************************
public function getSecs($pfx = "") {
	if (! $pfx) {
		$out = array_keys($this->sec);
		return array_combine($out, $out);
	}
	$arr = $this->sec; $out = array();

	foreach ($this->sec as $sec => $txt) {
		if (STR::begins($sec, $pfx)) $out[$sec] = $sec;
	}
	return $out;
}

// ***********************************************************
public function isSec($sec) {
	$sec = $this->norm($sec); if (! $sec) return false;
	return (isset($this->sec[$sec]));
}

// ***********************************************************
public function getSection($sec = "main") {
    $out = $this->getSec($sec); if (! $out) return "";
    $out = $this->insVars($out, false);
    $out = DIC::xlate($out);
    $out = $this->insSecs($out, $sec);
	return $out;
}

protected function getSec($sec) {
	$sec = $this->norm($sec);
	$out = $this->getLangSec($sec); if (! $out) return "";

	$out = STR::before($out, "<nolf>");
	$out = str_replace("<dolf>", "\n", $out);
	return $out;
}

protected function getLangSec($sec) {
	$out = VEC::get($this->sec, $sec.".".CUR_LANG); if ($out) return $out;
	$out = VEC::get($this->sec, $sec.".".GEN_LANG); if ($out) return $out;
	$out = VEC::get($this->sec, $sec.".xx"); if ($out) return $out;
	$out = VEC::get($this->sec, $sec); if ($out) return $out;
	return false;
}

// ***********************************************************
private function insSecs($out, $sec) {
	$arr = STR::find($out, "<!SEC:", "!>");

	foreach ($arr as $key) {
        if ($key == $sec) continue; // prevent endless loops

        $val = $this->getSection($key);
		$out = str_ireplace("<!SEC:$key!>.lang", "$val.de", $out);
		$out = str_ireplace("<!SEC:$key!>", $val, $out);
	}
	return $out;
}
// ***********************************************************
// handling variables
// ***********************************************************
public function setVar($var, $val) { // suppress section if no content
	$val = trim($val); if (! $val) $this->setSec($var, "");
	else $this->set($var, $val);
}

// ***********************************************************
// handling dics
// ***********************************************************
private function insDics($txt) {
	return DIC::xlate($txt);
}

// ***********************************************************
// output
// ***********************************************************
public function showCond($sec, $text) {
	if (! $text) return; $this->set($sec, $text);
	$this->show($sec);
}

public function show($sec = "main") {
	echo $this->gc($sec);
}
public function gc($sec = "main") {
	$fil = end($this->hst);

	$out = "<!-- $fil -->\n";;
#	$out.= $this->getHist(); // debug mode only
	$out.= $this->getSection($sec);

	if ($this->isSec($sec)) return $out;
	MSG::add("sec.unknown", "$fil &rarr; $sec");
}

// ***********************************************************
// template call stack
// ***********************************************************
public function getHist() {
	if (EDITING != "check") return ""; $out = ""; $cnt = 0;
	$lst = array_reverse($this->hst);

	foreach ($lst as $itm) {
		$sec = "hist.last"; if ($cnt++) $sec = "hist.item";
		$xxx = $this->set("file", $itm);
		$out.= $this->getSection($sec);
	}
	$this->set("qid", uniqid());
	$this->set("items", $out);
	return $this->getSection("history");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
protected function norm($sec) {
	return strtolower(STR::norm($sec));
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
