<?php

switch ($wht) {
	case "S": $arr = ENV::getList(); break;
	case "C": $arr = KONST::getList(); break;
	default:  $arr = array("?" => NV);
}

// ***********************************************************
incCls("tables/htm_table.php");
// ***********************************************************
$tbl = new htm_table();
$tbl->setLines(100);
$tbl->addArray($arr);
$tbl->show();

?>
