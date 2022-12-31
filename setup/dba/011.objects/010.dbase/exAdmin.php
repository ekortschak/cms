<?php

incCls("dbase/dbQuery.php");

// ***********************************************************
HTW::xtag("dbo.check admin", "h5");
// ***********************************************************
$vls = array(
	"uname" => "admin",
	"pwd" => md5("admin"),
	"email" => "nobody@home.at",
	"country" => "EU",
	"status" => "verified"
);

addAdmin($dbs, $vls);

// ***********************************************************
echo "Done";
// ***********************************************************
return;

// ***********************************************************
// auxilliary methods
// ***********************************************************
function addAdmin($dbs, $vls) {
	$dbq = new dbQuery($dbs, "dbusr"); if ($dbq->isRecord($vls)) return;
	$dbq->askMe(false);
	$dbq->insert($vls);
}
