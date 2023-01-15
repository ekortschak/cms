<?php

incCls("menus/dropDbo.php");
incCls("editor/iniEdit.php");
incCls("editor/dboEdit.php");
incCls("dbase/dbInfo.php");

// ***********************************************************
// react to previous commands
// ***********************************************************
$dbo = new dboEdit();

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$xxx = $box->show();

// ***********************************************************
HTW::xtag("fields.available");
// ***********************************************************
$dbi = new dbInfo($dbs, $tbl);
$inf = $dbi->tblProps($tbl);
$fds = $dbi->fields($tbl);

foreach ($fds as $key => $val) {
	echo "<button>$key</button>&ensp;";
}

// ***********************************************************
// read field props
// ***********************************************************
$ini = new ini("LOC_CFG/db.tables.ini");
$arr = $ini->getSecs($ini);
$lng = CUR_LANG;

// ***********************************************************
HTW::xtag("props");
// ***********************************************************
$sel = new iniEdit();
$sel->hidden("dbo", "dboEdit");
$sel->hidden("dbs", "$dbs");
$sel->hidden("tbl", "$tbl");
$sel->hidden("chk", "tcProps");

foreach ($arr as $prp) {
	$dat = $ini->getValues($prp);

	$cap = VEC::lng(CUR_LANG, $dat, "head", $prp);
	$val = VEC::get($dat, "default");
	$vls = VEC::get($dat, "values");
	$hnt = VEC::get($dat, "hint");

	$val = VEC::get($inf, $prp, $val);

	$sel->addInput("prop[$prp]", $vls, $val);
	$sel->setProp("title", $cap);
	$sel->setProp("hint", $hnt);
}
$sel->show();

// ***********************************************************
HTW::xtag("lang.props");
// ***********************************************************
$sel = new iniEdit();
$sel->hidden("dbo", "dboEdit");
$sel->hidden("dbs", "$dbs");
$sel->hidden("tbl", "$tbl");
$sel->hidden("chk", "tlProps");

foreach (LNG::get() as $lng) {
	$tit = VEC::lng($lng, $inf, "head", $tbl);
	$flg = HTM::flag($lng);

	$sel->input("head[$lng]", $tit);
	$sel->setProp("title", $flg);
}
$sel->show();

?>
