<?php

$gps = CFG::getCats();

// ***********************************************************
incCls("menus/localMenu.php");
// ***********************************************************
$box = new localMenu();
$grp = $box->getKey("cat", $gps, "user");
$xxx = $box->show();

$arr = CFG::getData($grp);

// ***********************************************************
incCls("tables/htm_table.php");
// ***********************************************************
$tbl = new htm_table();
$tbl->setLines(100);
$tbl->addArray($arr);
$tbl->show();

?>
