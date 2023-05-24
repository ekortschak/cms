<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for handling templates, ini files, dics ...
i.e. files with sections and vars

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("files/dicWriter.php");

$dic = new dicWriter();
$txt = $dic->read($file);

*/

incCls("files/code.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class dicWriter extends objects {
	private $fil = "";

function __construct() {}

// ***********************************************************
// read file
// ***********************************************************
public function read($file) { // dic lines
	$fil = $this->checkFile($file); if (! $fil) return false;
	$txt = $this->getContent($fil); if (! $txt) return false;

	$this->sections($txt);
	$this->setProps();
	return true;
}

// ***********************************************************
public function getKeys($pfx = "") { // register dic entries
	$out = $this->getValues($pfx);
	return VEC::keys($out);
}

// ***********************************************************
protected function setProps() { // register dic entries
	foreach ($this->sec as $sec => $txt) {
		if ( ! STR::begins($sec, "dic")) continue;
		$arr = $this->split($txt);

		foreach ($arr as $key => $val) {
			$this->set("$sec.$key", $val);
		}
	}
}

// ***********************************************************
// rewriting content
// ***********************************************************
public function modify($lang, $key, $value) {
	$sec = "dic.$lang";
	$xxx = $this->set("$sec.$key", $value);
	$xxx = DIC::set($key, $value, $lang);
	return $this->save($this->file, $sec, $lang);
}

// ***********************************************************
private function save($ful, $sec, $lang) {
	$arr = $this->getValues($sec); if (! $arr) return;
	$arr = VEC::sort($arr);
	$out = "[$sec]\n";

	foreach ($arr as $key => $val) {
		$key = STR::clear($key, "$sec.");
		$out.= "$key = $val\n";
	}
	return APP::write($ful, $out);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function checkFile($fil) {
	$chk = APP::file($fil); if (! $chk) return false;
	$this->file = $fil;
	return $fil;
}

protected function getContent($fil) {
	return APP::read($fil);
}

protected function sections($txt) {
	$arr = STR::find("\n".$txt, "\n[", "]");

	foreach ($arr as $sec) {
		$val = STR::between($txt, "[$sec]", "\n[");
		$this->sec[$sec] = $val;
	}
}

// ***********************************************************
protected function split($txt, $pfx = "\n", $lfd = "\n", $del = "=") {
	$arr = $txt; if (! is_array($txt))
	$arr = STR::slice($pfx.$txt, $lfd); $out = array();

    foreach ($arr as $itm) {
		$key = STR::before($itm, $del); if (! $key) continue;
		$val = STR::after($itm, $del);
        $out[$key] = $val;
    }
    return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
