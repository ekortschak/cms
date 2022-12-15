<?php

$arr = array(
	"add"  => DIC::get("act.add"),
	"drop" => DIC::get("act.drop")
);

$sec = array(
	"bing" => "screen",
	"pdf" => "pdf"
);

// ***********************************************************
// show file selector
// ***********************************************************
incCls("menus/localMenu.php");
incCls("menus/qikSelect.php");

$box = new localMenu();
$ful = $box->files("lookup");
$met = $box->getKey("method", $arr);
$sec = $box->getKey("section", $sec);
$xxx = $box->show();

$arr = CFG::getCfg("tabsets", "index.php");
$arr = VEC::keys($arr);

$box = new qikSelect();
$tab = $box->getKey("apply.to", $arr);
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
incCls("input/confirm.php");

$cnf = new confirm();
$cnf->add($ful);
$cnf->add("&rarr; ".$tab);
$cnf->add("&rarr; ".$met);
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// execute
// ***********************************************************
$arr = FSO::ftree($tab); if (! $arr) return;
$arr = FSO::filter($arr, "php, htm");

incCls("arten.php");
$bng = new arten();
$bng->read("lookup/arten.ini", "species");

foreach ($arr as $fil => $nam) {
	echo "<li>$fil</li>"; set_time_limit(10);

	$txt = $old = file_get_contents($fil);
	$txt = $bng->remove($txt); if ($met == "add")
	$txt = $bng->prepare($txt, $sec);

	if ($txt != $old) {
		APP::write($fil, $txt);
	}
}

?>