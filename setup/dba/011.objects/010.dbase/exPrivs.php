<?php

incCls("dbase/dbQuery.php");

// ***********************************************************
HTM::tag("dbo.check privs", "h5");
// ***********************************************************
$tbs = DBS::tables($dbs); if (! $tbs) return;

$lst = implode("','", $tbs);
dropEntries($dbs, "cat='tbl' AND spec NOT IN ('$lst')");

foreach ($tbs as $tbl => $nam) {
	echo "&bull; $tbl<br>";
	addEntry($dbs, "tbl", $tbl);

	$fds = DBS::fields($dbs, $tbl);
	$lst = implode("','$tbl.", $fds);
	dropEntries($dbs, "cat='fld' AND spec LIKE '$tbl.%' AND spec NOT IN ('$tbl.$lst')");

	foreach ($fds as $fld) {
		addEntry($dbs, "fld", "$tbl.$fld");
	}
}

// ***********************************************************
echo "Done";
// ***********************************************************
return;

// ***********************************************************
// auxilliary methods
// ***********************************************************
function dropEntries($dbs, $flt) {
	$dbq = new dbQuery($dbs, "dbxs");
	$dbq->askMe(false);
	$dbq->delete($flt);
}

function addEntry($dbs, $cat, $spec) {
	$vls = array("cat" => "$cat", "spec" => "$spec");

	$dbq = new dbQuery($dbs, "dbxs"); if ($dbq->isRecord($vls)) return;
	$dbq->askMe(false);
	$dbq->insert($vls);
}

?>
