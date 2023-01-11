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
	self::load("msgs/no.tpl.tpl");
	self::load("msgs/msgs.tpl");

	$this->set("tplfile", NV);
}

// ***********************************************************
// handling the template
// ***********************************************************
public function fetch($dir, $file) {
#	$dir = APP::relPath($dir);
	$ful = FSO::join($dir, $file);
#	$ful = APP::file($fil); if (! $ful) $ful = $file;
	return self::read($ful);
}

public function load($file) {
	return self::read("LOC_TPL/$file");
}

public function read($file) {
	$fil = $this->isFile($file); if (! $fil) return false;

	$cod = new code();
	$cod->read($fil);

	$this->sec = array_merge($this->sec, $cod->getSecs());
	$this->hst = array_merge($this->hst, $cod->getHist());
	$this->merge($cod->getVars());
	return $fil;
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
	$pfx = $this->norm($pfx); if (! $pfx) return VEC::keys($this->sec);
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

	$out = STR::before ($out, "<nolf>");
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
public function xshow($sec = "main") {
	$xxx = $this->setTplInfo($sec);
	$out = $this->getSection("debug");
	$out.= $this->gc($sec);
	echo $out;
}
public function show($sec = "main") {
	echo $this->gc($sec);
}
public function gc($sec = "main") {
	$xxx = $this->setTplInfo($sec);
	$out = $this->getSection($sec);
	$fil = $this->get("tplfile");

	$pfx = "\n<!-- TOF: $fil -->\n";
	$sfx = "\n<!-- EOF: $fil -->\n";
	return $pfx.$out.$sfx;
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function norm($sec) {
	return STR::norm($sec, true);
}

private function isFile($fil) {
	$this->setIf("tplfile", $fil);
	$ful = APP::file($fil);

	switch ($ful) {
		case true: $this->hst[$ful] = 1; break;
		default:   $this->hst[$fil] = 0;
	}
	return $ful;
}

// ***********************************************************
// template call stack
// ***********************************************************
private function setTplInfo($sec) {
	$lst = array_reverse($this->hst); $out = "";
	$sts = $this->isSec($sec);
	$sts = ($sts) ? BOOL_YES : BOOL_NO;

	foreach ($lst as $fil => $val) {
		$xxx = $this->set("tplitem", $fil);
		$out.= $this->getSection("tplitem.$val");
	}
	$this->set("section", $sec);
	$this->set("history", $out);
	$this->set("status",  $sts);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
