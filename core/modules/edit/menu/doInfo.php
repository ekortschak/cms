<h4>Menu-Info</h4>

<?php

$arr = PFS::item(PGE::$dir);

// ***********************************************************
incCls("tables/htm_table.php");
// ***********************************************************
$tbl = new htm_table();
$tbl->addArray($arr);
$tbl->show();

?>
