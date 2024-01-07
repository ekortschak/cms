<?php

DBG::file(__FILE__);

// ***********************************************************
// get calendar
// ***********************************************************
$loc = PGE::$dir;
$hed = PGE::title();
$dat = PGE::get("props.cal.date");

// ***********************************************************
// get text
// ***********************************************************
$htm = APP::gcSys($loc);
$htm = APP::lookup($htm);
$htm = ACR::clean($htm);

// ***********************************************************
// get calendar
// ***********************************************************
incCls("tables/cal_table.php");

$cal = new cal_table("monList");
$cal->setRange($dat);
$mon = $cal->gc();

// ***********************************************************
// write output
// ***********************************************************
$tpl = new tpl();
$tpl->load("pages/calpage.tpl");
$tpl->set("head",  $hed);
$tpl->set("text",  $htm);
$tpl->set("month", $mon);
$tpl->show();

?>
