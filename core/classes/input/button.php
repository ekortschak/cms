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
public function show($btn = "view") {
	echo $this->gc($btn);
}

public function gc($btn = "view") {
	$ref = $this->get("tip");
	$pic = $this->get("pic");

	$tpl = new tpl();
	$tpl->load("menus/buttons.tpl");
	$tpl->merge($this->vls);

	if ($pic) {
		$tpl->set("pic", $tpl->getSection("pic"));
	}
	$sec = "button"; if ($ref) $sec = "button.tip";
	$out = $tpl->gc($sec);
	$out = STR::replace($out, "MY_VAL", $this->get("qid", "X"));
	$out = CFG::apply($out);
	return $out;
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
	$sel = HTM::php_cond($sel);
	$sel = ($sel) ? "selected" : "";

	$this->set("pic",     $this->get("props.pic"));
	$this->set("link",    $this->get("props.url"));
	$this->set("target",  $this->get("props.trg", "_self"));
	$this->set("hilite",  $sel);
	$this->set("caption", $this->lng("caption")); if ($tip)
	$this->set("tip",     $this->lng("tooltip"));
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
