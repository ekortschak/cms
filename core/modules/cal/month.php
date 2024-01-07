<?php
# props.date required in page inifile
$dat = PGE::get("props.cal.date");

// ***********************************************************
incCls("tables/cal_table.php");

$cal = new cal_table("monList");
$cal->setRange($dat);
$cal->show();

?>
