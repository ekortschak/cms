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
$btn->show($button_name);

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

	$this->set("pic",     $this->get("props.pic"));
	$this->set("link",    $this->get("props.url"));
	$this->set("target",  $this->get("props.trg"));
	$this->set("caption", $this->lng("caption")); if ($tip)
	$this->set("tip",     $this->lng("tooltip"));
	$this->set("class",  "icon");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
