<?php
/* ***********************************************************
// INFO
// ***********************************************************
Used to create (pseudo) check boxes for immeadiate action

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("menus/qikLink.php");

$qik = new qikLink();
$qik->getVal($qid, $value);
$qik->show();
*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class qikLink extends tpl {
	private $lst = array();

function __construct() {
	parent::__construct();
    $this->load("menus/qikLink.tpl");
}

// ***********************************************************
// methods
// ***********************************************************
public function getVal($key, $value = 0) {
	$xxx = ENV::setIf($key, (bool) $value);
	$val = ENV::get($key);
	$this->lst[$key] = $val;
	return $val;
}

// ***********************************************************
// display check boxes
// ***********************************************************
public function show($sec = "main") {
	echo $this->gc($sec);
}
public function gc($sec = "main") {
	$out = "";

	foreach ($this->lst as $key => $val) {
		$this->set("key", $key);
		$this->set("caption", DIC::getPfx("unq", $key));

		$shw = $sec; if (! $val) $shw = "$sec.no";
		$out.= $this->getSection($shw);
	}
    return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
