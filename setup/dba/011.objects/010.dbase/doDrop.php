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
HTW::xtag("dbs.drop"); // ask for confirmation
// ***********************************************************
$ddl = new dbAlter($dbs);
$ddl->db_drop($dbs);

?>
