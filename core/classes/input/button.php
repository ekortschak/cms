<?php
/* ***********************************************************
// INFO
// ***********************************************************
Handles button

2 files required going by the same name
* an include file
* an ini file

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("input/button.php");

$btn = new button();
$btn->read($ini);
$btn->show();

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class button extends objects {

function __construct() {
	parent::__construct();
}

// ***********************************************************
// display button
// ***********************************************************
public function show($sec = "button") {
	echo $this->gc($btn);
}

public function gc($sec = "button") {
	$ref = $this->get("tip");
	$pic = $this->get("pic");

	$tpl = new tpl();
	$tpl->load("menus/buttons.tpl");
	$tpl->merge($this->vls);

	if ($pic) {
		$tpl->set("pic", $tpl->getSection("pic"));
	}
#	if ($ref) $sec = "$sec.tip";
	return $tpl->gc($sec);
}

// ***********************************************************
// setting props
// ***********************************************************
public function read($btn) {
	$fil = APP::file($btn); if (! $fil)
	$fil = FSO::join(LOC_BTN, "$btn.btn");
	$tip = ENV::get("opt.tooltip");

	$cod = new code();
	$cod->read($fil);
	$this->merge($cod->getValues());

	$sel = $this->get("props.hilite", "");
	$sel = $this->chkStatus($sel);
	$sel = ($sel) ? "selected" : "";

	$this->set("pic",     $this->get("props.pic"));
	$this->set("link",    $this->get("props.url"));
	$this->set("target",  $this->get("props.trg", "_self"));
	$this->set("hilite",  $sel);
	$this->set("caption", $this->lng("caption")); if ($tip)
	$this->set("tip",     $this->lng("tooltip"));
}

// ***********************************************************
// handling php snips
// ***********************************************************
private function chkStatus($code) {
	$code = CFG::unescape($code); if (! $code) return;
	eval("\$out = ($code);");
	return $out;
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
