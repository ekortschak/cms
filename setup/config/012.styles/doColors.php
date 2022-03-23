<?php

$dir = "design/colors";

// ***********************************************************
// select a color set
// ***********************************************************
incCls("menus/dropbox.php");

$box = new dbox();
$ful = $box->files($dir, "color.set", COLORS.".ini");
$xxx = $box->show("menu");

// ***********************************************************
// write data
// ***********************************************************
if (ENV::getPost("colEdit")) {
	$arr = $_POST; unset($arr["colEdit"]);
	$txt = file_get_contents($ful);

	foreach ($arr as $key => $val) {
		$itm = STR::between($txt, $key, "\n");
		$val = str_replace("#", "\#", $val);
		$new = "$key = $val";
		$txt = str_replace("$key $itm", $new, $txt);
	}
	APP::write($ful, $txt);
}

// ***********************************************************
// read data
// ***********************************************************
$ini = new ini($ful);
$arr = $ini->getSecs();

// ***********************************************************
// show form
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/editor/cssColors.tpl");
$out = "";

foreach ($arr as $key => $val) {
	$xxx = $tpl->set("title", DIC::get($key));
	$out.= $tpl->gc("section");

	$clr = $ini->getValues($key);
	$lst = array();

	foreach ($clr as $key => $val) {
		$itm = STR::after($key, "_"); if (! $itm) continue;
		$lst[$itm] = $itm;
	}

	foreach ($lst as $itm) {
		$tpl->set("set", $itm);
		$fgc = VEC::get($clr, "FC_$itm", "");
		$bgc = VEC::get($clr, "BC_$itm", "");

		$tpl->set("FCN", $fgc); $tpl->set("FCV", $fgc);
		$tpl->set("BCN", $bgc); $tpl->set("BCV", $bgc);

		$out.= $tpl->gc("item");
	}
}
$tpl->set("items", $out);
$tpl->show();

?>
