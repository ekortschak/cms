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
	$fil = APP::file($file);

	$cod = new code();
	$cod->read($fil);

	$this->hst = array_merge($this->sec, $cod->getHist());
	$this->sec = array_merge($this->sec, $cod->getSecs());
	$this->set("file", $fil);
	$this->merge($cod->getVars());
}

// ***********************************************************
// handling sections
// ***********************************************************
public function clearSec($sec) { // wipe section content
	$this->setSec($sec);
}
public function setSec($sec, $text = "") { // set section content
	$sec = $this->norm($sec);
	$this->sec[$sec] = trim($text);
}

public function copy($sec, $dest) { // copy sections
	$sec = $this->norm($sec); if (! $this->isSec($sec)) return;
	$txt = $this->getSec($sec);
	$this->setSec($dest, $txt);
}
public function substitute($sec, $src) { // replace sections
	$this->copy($src, $sec);
}

// ***********************************************************
public function getSecs($pfx = "") {
	$pfx = $this->norm($pfx);

	if (! $pfx) {
		$out = array_keys($this->sec);
		return array_combine($out, $out);
	}
	$out = array();

	foreach ($this->sec as $sec => $txt) {
		if (STR::begins($sec, $pfx)) $out[$sec] = $sec;
	}
	return $out;
}

// ***********************************************************
public function isSec($sec) {
	$sec = $this->norm($sec);
	return VEC::isKey($this->sec, $sec);
}

// ***********************************************************
public function getSection($sec = "main") {
    $out = $this->getSec($sec); if (! $out) return "";
    $out = $this->insVars($out, false);
    $out = $this->insSecs($out, $sec);
    $out = DIC::xlate($out);
	return $out;
}

protected function getSec($sec) {
	$sec = $this->norm($sec);
	$out = $this->getLangSec($sec); if (! $out) return "";

	$out = STR::before($out, "<nolf>");
	$out = STR::replace($out, "<dolf>", "\n");
	return $out;
}

private function getLangSec($sec) {
	$out = VEC::get($this->sec, $sec.".".CUR_LANG); if ($out) return $out;
	$out = VEC::get($this->sec, $sec.".".GEN_LANG); if ($out) return $out;
	$out = VEC::get($this->sec, $sec.".xx");        if ($out) return $out;
	$out = VEC::get($this->sec, $sec);              if ($out) return $out;
	return false;
}

// ***********************************************************
private function insSecs($out, $sec) {
	$arr = STR::find($out, "<!SEC:", "!>");

	foreach ($arr as $key) {
		$key = $this->norm($key); if ($key == $sec) continue; // prevent endless loops
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
	$val = trim($val); if (! $val) $this->clearSec($var);
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
public function show($sec = "main") {
	echo $this->gc($sec);
}
public function gc($sec = "main") {
	$fil = end($this->hst);

	$out = "<!-- $fil -->\n";
#	$out.= $this->getHist(); // debug mode only
	$out.= $this->getSection($sec);

	if ($this->isSec($sec)) return $out;
	MSG::add("sec.unknown", $sec);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function norm($sec) {
	return STR::norm($sec, true);
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
} // END OF CLASS
// ***********************************************************
?>
