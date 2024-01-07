<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for handling templates, ini files, dics ...
i.e. files with sections and vars

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("files/code.php");

$code = new code();
$txt = $code->read($file);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class iniCfg extends objects {
	protected $sec = array(); // sections
	protected $vrs = array(); // variables

function __construct($file) {
	$txt = $this->getContent($file); if (! $txt) return false;

	$this->sections($txt);
	$this->setProps();
	return true;
}

// ***********************************************************
protected function getContent($file) {
	$txt = APP::read($file); if (! $txt) return "";
	$txt = STR::dropComments($txt);
	$txt = STR::dropSpaces($txt);
	$txt = STR::clear($txt, "\r");
	return STR::replace($txt, "\#", "#");
}

// ***********************************************************
// fill arrays
// ***********************************************************
protected function sections($txt) {
	$arr = STR::find("\n".$txt, "\n[", "]");

	foreach ($arr as $sec) {
		$key = STR::norm($sec, true);
		$val = STR::between($txt, "[$sec]", "\n[");
		$this->sec[$key] = $val;
	}
	}

protected function setProps() {
	foreach ($this->sec as $sec => $txt) {
		$arr = $this->split($txt);

		foreach ($arr as $key => $val) {
			$this->set("$sec.$key", $val);
		}
	}
}

// ***********************************************************
// splitting sections
// ***********************************************************
protected function split($txt, $pfx = "\n", $lfd = "\n", $del = "=") {
	$arr = $txt; if (! is_array($txt))
	$arr = STR::split($pfx.$txt, $lfd); $out = array();

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
