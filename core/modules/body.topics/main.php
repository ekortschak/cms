<?php

HTM::tag("tpc.list", "h3");

// ***********************************************************
// show topics - if any
// ***********************************************************
incCls("menus/dropnav.php");
incCls("menus/tabs.php");

$tab = new tabs();
$arr = $tab->getTopics();

$box = new dropnav();
$fil = $box->getKey("topic", $arr);
$xxx = $box->show();

// ***********************************************************
// show description
// ***********************************************************
HTM::tag("tpc.desc", "h4");

$txt = APP::gc($fil); if (! $txt)
$txt = DIC::get("tpc.nodesc");

HTM::cap($txt, "div");

// ***********************************************************
// add button
// ***********************************************************
incCls("input/button.php");

$btn = new button();
$btn->set("link", "?vmode=view&tpc=$fil");
$btn->set("caption", DIC::get("act.show"));
$btn->show();

?>
