<?php

DBG::file(__FILE__);

$fil = "ebook/calpage.tpl"; if (VMODE == "ebook")
$fil = "pages/include.tpl";

// ***********************************************************
// get calendar
// ***********************************************************
$loc = PGE::$dir;
$hed = PGE::title();
$dat = PGE::get("props_cal.date");

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
$cal->range($dat);
$mon = $cal->gc();

// ***********************************************************
// write output
// ***********************************************************
$tpl = new tpl();
$tpl->load($fil);
$tpl->set("head",  $hed."xx");
$tpl->set("text",  $htm);
$tpl->set("month", $mon);
$tpl->show();

?>
