<?php

// ***********************************************************
// select a color set
// ***********************************************************
incCls("menus/dropBox.php");

$box = new dropBox("menu");
$rel = $box->files(LOC_CLR, "color.set", COLORS.".ini");
$xxx = $box->show();

$ful = APP::file($rel);
$ful = STR::replace($ful, FBK_DIR, "<red>CMS</red>");
HTW::tag("file = $ful", "hint");

// ***********************************************************
// write data
// ***********************************************************
if (ENV::getPost("colEdit")) {
	$arr = $_POST; unset($arr["colEdit"]);
	$txt = file_get_contents($rel);

	foreach ($arr as $key => $val) {
		$itm = STR::between($txt, $key, "\n");
		$val = STR::replace($val, "#", "\#");
		$val = STR::replace($val, "\\#", "\#");
		$rep = str_pad($key, 8);
		$txt = PRG::replace($txt, "$key(\s*?)$itm", "$rep = $val");
	}
	$xxx = APP::write($rel, $txt);
}

// ***********************************************************
// show form
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/cssColors.tpl");
$out = "";

$ini = new ini($rel);
$arr = $ini->getSecs();

foreach ($arr as $key => $val) {
	$xxx = $tpl->set("title", DIC::get($key));
	$out.= $tpl->gc("section");
	$clr = $ini->values( $key);
	$lst = array();

	foreach ($clr as $key => $val) {
		$itm = STR::after($key, "_"); if (! $itm) continue;
		$lst[$itm] = $itm;
	}

	foreach ($lst as $itm) {
		$tpl->set("set", $itm); $fcn = "FC_$itm"; $bcn = "BC_$itm";
		$tpl->set("FCN", $fcn); $tpl->set("FCV", VEC::get($clr, $fcn, ""));
		$tpl->set("BCN", $bcn);	$tpl->set("BCV", VEC::get($clr, $bcn, ""));

		$out.= $tpl->getSection("item");
	}
}
$tpl->set("items", $out);
$tpl->show();

?>
