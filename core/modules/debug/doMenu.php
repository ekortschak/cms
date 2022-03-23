<?php

$loc = PFS::getLoc();
$arr = PFS::mnuInfo($loc);

// ***********************************************************
incCls("tables/htm_table.php");
// ***********************************************************
$tbl = new htm_table();
$tbl->setLines(100);
$tbl->addArray($arr);
$tbl->show();

?>
