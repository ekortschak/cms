<?php

if (! ENV::get("opt.feedback")) return;

$loc = PFS::getLoc();

// ***********************************************************
HTW::xtag("Feedback", "h3");
// ***********************************************************
$ini = new ini();
$tit = $ini->getHead();

incCls("dbase/dbQuery.php");
incCls("dbase/recEdit.php");

// ***********************************************************
$dbe = new recEdit(NV, "feedback");
// ***********************************************************
$dbe->setDefault("owner",  CUR_USER);
$dbe->setDefault("topic", "content");
$dbe->setDefault("page",   $tit);
$dbe->setDefault("link",   $loc);
$dbe->setDefault("rating", 0);

$dbe->hide("topic, tstamp, owner, page, link");

$dbe->findRec("owner='CUR_USER' AND link='$loc' AND topic='content'");
$dbe->show();

?>
