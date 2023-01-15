<?php

incCls("menus/dropDbo.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$xxx = $box->show();

// ***********************************************************
// table info
// ***********************************************************
$dir = APP::bkpDir("", SRV_ROOT, "db.$dbs");
$usr = CFG::getVar("dbase", "dbase.user");

$dmp = FSO::join($dir, "$dbs.sql");
$dmp = "<b>mysqldump</b> --opt -h DB_HOST -u $usr -p xxx $dbs | gzip > $dmp";
$dmp = CFG::insert($dmp);

HTW::tag("Backup using console", "h5");
echo "<code>$dmp</code>";

?>
