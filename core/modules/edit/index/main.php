<?php

DBG::file(__FILE__);

incCls("menus/dropNav.php");
incCls("input/checkList.php");
incCls("editor/idxEdit.php");

// ***********************************************************
// retrieving main page
// ***********************************************************
$loc = PGE::dir();
$uid = PGE::UID();

$buk = BBL::bookFile($uid);
$arr = FSO::files($buk, "*.htm");
$cnt = 1;

if (count($arr) < 1) {
	return MSG::now("no.files");
}

foreach ($arr as $dir => $nam) {
	$arr[$dir] = "Kapitel ".$cnt++;
}

// ***********************************************************
// show chapter and verse selector
// ***********************************************************
$box = new dropNav();
$fil = $box->getKey("kap.$uid", $arr);
$kap = $box->decode("kap.$uid", $fil);
$xxx = $box->show();

$htm = APP::read($fil);
$htm = STR::clean($htm, "<xref>", "</xref>");
$arr = STR::find($htm, "<verse>", "</verse>");
$cnt = 1;

foreach ($arr as $key => $val) {
	$arr[$key] = "Vers ".$cnt++;
}

$box = new dropNav();
$txt = $box->getKey("vrs.$uid", $arr);
$vrs = $box->decode("vrs.$uid", $txt);
$xxx = $box->show();

// ***********************************************************
// react to previous editing
// ***********************************************************
$oid = OID::register();
$kap = STR::after($kap, " ");
$vrs = STR::after($vrs, " ");
$ref = "$uid $kap:$vrs";

$idx = new idxEdit();
$idx->register($oid);
$idx->save($ref);

// ***********************************************************
// show verse
// ***********************************************************
$tpl = new tpl();
$tpl->load("editor/index.tpl");
$tpl->set("verse", $txt);
$tpl->show();

// ***********************************************************
// show editor
// ***********************************************************
$drs = FSO::dTree("index");

$sel = new checkList();
$sel->register($oid);

foreach ($drs as $dir => $nam) {
	$sel->addSection($nam);
	$fls = FSO::files($dir);

	foreach ($fls as $fil => $nam) {
		$key = STR::before($nam, ".ini");
		$cap = $idx->title($fil);
		$val = $idx->isIndex($fil, $ref);

		$sel->addItem($key, $cap, $val);
	}
}
$sel->show();

?>
