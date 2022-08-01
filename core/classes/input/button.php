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
	$vis = $this->getVis(); if ($vis < 1) return "";
	$ref = $this->get("tip");
	$pic = $this->get("pic");

	$tpl = new tpl();
	$tpl->read("design/templates/menus/buttons.tpl");
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
public function read($btn = "view") {
	$fil = APP::file($btn); if (! is_file($fil))
	$fil = FSO::join("design/buttons", "$btn.ini");

	$cod = new code();
	$cod->read($fil);
	$this->merge($cod->getValues());

	$this->set("link",    $cod->getProp("url"));
	$this->set("target",  $cod->getProp("trg"));
	$this->set("caption", $cod->getProp("caption"));
	$this->set("tip",     $cod->getInfo());
	$this->set("pic",     $cod->getProp("pic"));
	$this->set("class",  "icon");
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function getVis() {
	$prp = $this->get("props.if"); if (! $prp) return true;
	return CFG::getVar("mods", $prp, true);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
