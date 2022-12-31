<?php

// ***********************************************************
HTW::xtag("css.static");
// ***********************************************************
HTW::xtag("css.info", "p");

if ($act = ENV::getParm("static")) {
	incCls("files/css.php");

	$css = new css();
	if ($act == "add") $css->save(); else
	if ($act == "del") $css->drop(); else
	if ($act == "ck4") $css->export("ck4");
}

$arr = array(
	"add" => DIC::get("css.add"),
	"del" => DIC::get("css.del")
);
$cur = "add"; if (is_file("design/site.css"))
$cur = "del";

// ***********************************************************
HTW::xtag("ask.confirm");
// ***********************************************************
$cap = $arr[$cur];
$lnk = HTM::button("?static=$cur'>", $cap);
echo $lnk;

// ***********************************************************
HTW::tag("CK4.css");
// ***********************************************************
$msg = DIC::get("ck4.update");
HTW::button("?static=ck4", $msg);

?>
