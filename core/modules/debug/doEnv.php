<?php

$arr = SSV::getData($div); ksort($arr);

// ***********************************************************
incCls("tables/htm_table.php");
// ***********************************************************
$tbl = new htm_table();
$tbl->setLines(100);
$tbl->addArray($arr);
$tbl->show();

?>
