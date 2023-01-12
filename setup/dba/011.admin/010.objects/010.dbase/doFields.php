
<?php

incCls("input/confirm.php");
incCls("dbase/dbQuery.php");
incCls("dbase/dbInfo.php");
incCls("menus/dboBox.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$xxx = $box->show();

$dbi = new dbInfo($dbs);

// ***********************************************************
// info
// ***********************************************************
HTW::tag("Check dbo Info integrity");
HTW::tag("This will update stored dbo Info according to db reality.", "p");

// ***********************************************************
// ask for confirmation
// ***********************************************************
$cnf = new confirm();
$cnf->dic("dbo.analize");
$cnf->add("&rarr; $dbs");
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// execute analysis
// ***********************************************************
$tbs = $dbi->tables();

$dbq = new dbQuery($dbs, "dbobjs");
$dbq->askMe(false);

$arr = array("head", "head.de", "head.en", "input", "mask", "default");

foreach ($tbs as $tbl => $cap) {
	$fds = $dbi->fields($tbl);
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
