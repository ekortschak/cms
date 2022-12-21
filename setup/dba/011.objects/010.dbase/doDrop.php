<?php

incCls("menus/dboBox.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dboBox();
$dbs = $box->getDbase();
$xxx = $box->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
HTM::tag("dbs.drop");

$ddl = new dbAlter($dbs);
$ddl->db_drop($dbs);

?>
