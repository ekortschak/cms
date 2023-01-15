<?php

incCls("menus/dropDbo.php");
incCls("editor/iniEdit.php");
incCls("editor/dboEdit.php");
incCls("dbase/dbInfo.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$tbl = $box->getTable($dbs);
$fld = $box->getField($dbs, $tbl);
$xxx = $box->show();

$dbi = new dbInfo($dbs, $tbl);
$inf = $dbi->fldProps($tbl, $fld);

$inf["default"] = $inf["fstd"];

// ***********************************************************
// react to previous commands
// ***********************************************************
$dbo = new dboEdit();

// ***********************************************************
// read field props
// ***********************************************************
$ini = new ini("LOC_CFG/db.fields.ini");
$arr = $ini->getSecs($ini);
$lng = CUR_LANG;

$typ = $inf["dtype"];
$inp = "";

// ***********************************************************
HTW::xtag("props");
// ***********************************************************
$sel = new iniEdit();
$sel->hidden("dbo", "dboEdit");
$sel->hidden("dbs", "$dbs");
$sel->hidden("fld", "$tbl.$fld");
$sel->hidden("chk", "fcProps");

foreach ($arr as $prp) {
	$dat = $ini->getValues($prp);
	$typ = $inf["dtype"];

	$cap = VEC::lng(CUR_LANG, $dat, "head", $prp);
	$vls = VEC::get($dat, "values");
	$hnt = VEC::get($dat, "hint");

	if ($prp == "input") {
		$sel->ronly("fld.type", $typ);

		if (STR::contains(".mem.cur.", $typ)) continue;
	}
	if ($prp == "mask") {
		if (STR::contains(".mem.", $typ)) continue;
	}
	$sel->addInput("prop[$prp]", $vls, "");
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
$sel->hidden("fld", "$tbl.$fld");
$sel->hidden("chk", "flProps");

foreach (LNG::get() as $lng) {
	$tit = VEC::lng($lng, $inf, "head", $fld);
	$flg = HTM::flag($lng);

	$sel->input("head[$lng]", $tit);
	$sel->setProp("title", $flg);
}
$sel->show();

?>

<br>


<h4>Sinnvolle Werte (Entwurf - nicht implementiert)</h4>

<table>
	<tr>
		<th width=50>Typ</th>
		<th>Eingabehilfen</th>
		<th>Anzeigemasken</th>
	</tr>
	<tr>
		<td>int</td>
		<td><ul><li>number <li>range: min - max <li>rating <li>checkbox <li>bool</ul></td>
		<td><ul><li>%d <li>%03d <li>%d pcs</ul></td>
	</tr>
	<tr>
		<td>num</td>
		<td><ul><li>number</ul></td>
		<td><ul><li>%01.2f</ul></td>
	</tr>
	<tr>
		<td>var</td>
		<td><ul><li>text <li>folders: dir <li>files: dir <li>tables <li>fields: tbl <li>dic: ref <li>groups <li>users </ul></td>
		<td><ul><li>&lt;a href="xy">%s&lt;/a> </ul></td>
	</tr>
</table>
