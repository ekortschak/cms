<?php

incCls("menus/dropDbo.php");
incCls("dbase/dbAlter.php");

// ***********************************************************
// show menu
// ***********************************************************
$box = new dropDbo();
$dbs = $box->getDbase();
$xxx = $box->show();

// ***********************************************************
HTW::xtag("dbs.drop"); // ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs);
$ddl->db_drop($dbs);

?>
