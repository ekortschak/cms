<?php

incCls("tables/cal_table.php");

// ***********************************************************
$loc = PGE::dir();
$dat = PGE::get("props.cal.date");

$cal = new cal_table("monList");
$cal->setRange($dat);
$mon = $cal->gc();

// ***********************************************************
$kap = new chapter();
$kap->load("xsite/calpage.tpl");
$kap->init($loc);
$kap->set("month", $mon);
$kap->addQR();
$kap->show();

?>
