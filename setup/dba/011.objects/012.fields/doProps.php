<?php

incCls("menus/dropbox.php");
incCls("editor/iniEdit.php");
incCls("dbase/dbInfo.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$ret = $box->showDBObjs("BTF", false); extract($ret);

$dbi = new dbInfo($dbs, $tbl);
$inf = $dbi->fldProps($tbl, $fld);

// ***********************************************************
// read field props
// ***********************************************************
$ini = new ini("design/config/db.fields.ini");
$arr = $ini->getSecs();
$lng = CUR_LANG;

// ***********************************************************
HTM::Tag("props");
// ***********************************************************
$sel = new iniEdit(TAB_ROOT);
$sel->forget();
$sel->hidden("dbo", "dboEdit");
$sel->hidden("dbs", "$dbs");
$sel->hidden("fld", "$tbl.$fld");
$sel->hidden("chk", "fcProps");

foreach ($arr as $prp) {
	$dat = $ini->getValues($prp);
	$cap = VEC::get($dat, "head", $prp); $cap = VEC::get($dat, "head.$lng", $cap);
	$val = VEC::get($dat, "default");    $val = VEC::get($inf, $prp, $val);
	$vls = VEC::get($dat, "values");
	$hnt = VEC::get($dat, "hint");

	$sel->addByDefault("prop[$prp]", $vls, $val);
	$sel->setProp("title", $cap);
	$sel->setProp("hint", $hnt);
}
$sel->show();

// ***********************************************************
HTM::Tag("lang.props");
// ***********************************************************
$sel = new iniEdit(TAB_ROOT);
$sel->forget();
$sel->hidden("dbo", "dboEdit");
$sel->hidden("dbs", "$dbs");
$sel->hidden("fld", "$tbl.$fld");
$sel->hidden("chk", "flProps");

foreach (LNG::get() as $lng) {
	$tit = VEC::get($inf, "head", $fld);
	$tit = VEC::get($inf, "head.$lng", $tit);

	$sel->setLang($lng);
	$sel->input("head[$lng]", $tit);
	$sel->setProp("title", "<img src='core/icons/flags/$lng.gif' class='flag' />");
}
$sel->show();

?>
