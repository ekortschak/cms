<?php

$cur = "add";

// ***********************************************************
HTW::xtag("css.static");
HTW::xtag("css.info", "p");
// ***********************************************************
if ($act = ENV::getParm("static")) {
	incCls("files/css.php");

	$css = new css();
	if ($act == "add") $css->save(); else
	if ($act == "del") $css->drop(); else
	if ($act == "ck4") $css->export("ck4");

	if ($css->isStatic()) $cur = "del";
}

$arr = array(
	"add" => DIC::get("css.add"),
	"del" => DIC::get("css.del")
);

$cap = $arr[$cur];
$lnk = HTM::button("?static=$cur", $cap);
echo $lnk;

// ***********************************************************
HTW::xtag("xtools");
// ***********************************************************
$msg = DIC::get("ck4.update");
HTW::button("?static=ck4", $msg);

?>
