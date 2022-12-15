<?php

// ***********************************************************
HTM::tag("css.static");
// ***********************************************************
HTM::tag("css.info", "p");

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
HTM::tag("ask.confirm");
// ***********************************************************
echo "<a href='?static=$cur'><button>$arr[$cur]</button></a>";

// ***********************************************************
HTM::cap("CK4.css");
// ***********************************************************
$msg = DIC::get("ck4.update");

echo "<a href='?static=ck4'><button>$msg</button></a>";

?>
