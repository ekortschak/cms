<h4>Menu-Info</h4>

<?php

$arr = PFS::mnuInfo(CUR_PAGE);

// ***********************************************************
incCls("tables/htm_table.php");
// ***********************************************************
$tbl = new htm_table();
$tbl->addArray($arr);
$tbl->show();

?>
