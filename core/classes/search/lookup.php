<?php
/* ***********************************************************
// INFO
// ***********************************************************
Handles lookup values which will pop up on hovering a
defined term explaining its meaning

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("search/lookup.php");

$lup = new lookup();
$lup->addRef($fil);

$txt = $lup->insert($txt);
*/

incCls("search/explain.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class lookup extends tpl {
	protected $lup; // lookup class


function __construct() {}

// ***********************************************************
// methods
// *************************************************** ********
public function addRef($fil) {
	$cls = STR::before(basename($fil), "."); $ful = $this->getClass($cls);
	$cls = STR::before(basename($ful), ".");

	include_once($ful);

	$this->lup = new $cls();
	$this->lup->read($fil);
}

private function getClass($cls) {
	$ful = APP::file("core/classes/$cls.php"); if (! $ful)
	$ful = APP::file("core/classes/search/$cls.php"); if (! $ful)
	$ful = APP::file("core/classes/search/explain.php");
	return $ful;
}


// ***********************************************************
public function insert($txt) {
	return $this->lup->insert($txt);
}

public function insertxxx($txt) {
	$ign = array("@"); $see = DIC::get("siehe");

	foreach ($this->dat as $key => $val) {
		if (STR::begins($key, $ign)) continue;
		if (STR::misses($txt, $key)) continue; if (! $key) continue;
		if (STR::contains($val, $see)) {
			$vgl = STR::after($val, $see);
			$val = VEC::get($this->dat, $vgl); if (! $val) continue;
		}
		$this->ref[$key] = $this->insLFs($val);
		$rep = "QQQ.$key.QQQ";

	 // no lookup in links, find conjugated forms as well ...
		$txt = preg_replace("~<a href(.*?)$key(.*?)</a>~", "<a href$1@KEY@$2</a>", $txt);
		$txt = preg_replace("~(\W+)$key(\W+)~", "$1$rep$2$3$4", $txt);
		$txt = preg_replace("~(\W+)$key([e]+)([nmrs]?)(\W+)~", "$1$rep$2$3$4", $txt);
		$txt = str_replace("@KEY@", $key, $txt);
	}
	foreach ($this->ref as $key => $val) {
		$this->set("caption", $key);
		$this->set("color", $this->col);
		$this->set("info", $val);

		$rep = trim($this->gc("lookup"));
		$fnd = "QQQ.$key.QQQ";
		$txt = str_replace($fnd, $rep, $txt);
	}
	return $txt;
}

protected function insLFs($val) {
	$val = preg_replace("~\&([0-9A-Za-z#]*?)\;~", "&$1@ENT", $val);
	$val = str_replace("; ", ";", $val);
	$val = str_replace(";", ";<br>", $val);
	$val = str_replace("@ENT", ";", $val);
	return $val;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
