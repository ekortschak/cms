<?php

incCls("input/selector.php");
incCls("menus/dropbox.php");

// ***********************************************************
// Choose action
// ***********************************************************
$rng = array(
#	"all" => "Whole Projekt",
	"cur" => "Current Branch",
	"dir" => "Bibel Verzeichnis"
);
$act = array(
	"search"  => "Search",
	"replace" => "Replace"
);

$box = new dbox();
$fnc = $box->getKey("Method", $act);
$rng = $box->getKey("Range", $rng);
$xxx = $box->show("menu");

// ***********************************************************
// get parameters
// ***********************************************************
$lng = CUR_LANG;

$sel = new selector();
$ptn = $sel->input("file.pattern", "$lng.htm");
#$fnd = $sel->input("find", "&(.*?);");
#$rep = $sel->input("replace", "replace by this text");
$act = $sel->show();

if (! $act) return;

switch ($rng) {
	case "all": $dir = APP_DIR; break;
	case "dir": $dir = "/var/www/html/kor/bibel/audio/"; break;
	default:    $dir = PFS::getLoc();
}

$arr = FSO::ftree($dir, $ptn);
$lst = array();

$chk = "Backup";

// ***********************************************************
// replace strings
// ***********************************************************
#$inc = "core/modules/body.xform/doXEditRef.php";
$inc = "core/modules/body.xform/doXEditRen.php";

foreach ($arr as $fil => $nam) {
	if (is_dir($fil)) continue;
	include($inc);
}

?>

