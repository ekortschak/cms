
<?php

incCls("input/confirm.php");
incCls("dbase/dbQuery.php");
incCls("menus/dropbox.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dbox();
$erg = $box->showDBObjs("B"); extract($erg);

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->add("dbo.analize");
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// execute analysis
// ***********************************************************
$tbs = DBS::tables($dbs);

$dbq = new dbQuery($dbs, "dbobjs");
$dbq->askMe(false);

$arr = array("head", "head.de", "head.en", "input", "mask", "default");

foreach ($tbs as $tbl => $cap) {

	$fds = DBS::fields($dbs, $tbl);
	$vls = array(
		"cat" => "tbl", "spec" => "$tbl", "prop" => "head", "value" => ucfirst($tbl)
	);
	$dbq->replace($vls, "cat='tbl' AND spec='$tbl'");

	foreach ($fds as $fld => $nam) {
		$inf = $dbq->fldProps($tbl, $fld);

		$vls = array(
			"cat" => "fld",	"spec" => "$tbl.$fld"
		);
		foreach ($arr as $prop) {
			$val = VEC::get($inf, $prop, ""); if (! $val) continue;

			if (STR::contains($val, "&copy;")) $val = STR::replace($val, "&copy;", "(CR)");

			$vls["prop"] = $prop;
			$vls["value"] = $val;

			$dbq->replace($vls, "cat='fld' AND spec='$tbl.$fld' AND prop='$prop'");
		}
	}
}

?>
<p>OK</p>
