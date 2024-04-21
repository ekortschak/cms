<?php

DBG::file(__FILE__);

// ***********************************************************
// check if applicable
// ***********************************************************
if (! ENV::get("opt.feedback")) return;

incCls("dbase/dbQuery.php");
incCls("dbase/recEdit.php");

// ***********************************************************
HTW::xtag("Feedback", "h3");
// ***********************************************************
$dbe = new recEdit("default", "feedback");
$loc = PGE::$dir;

$dbe->setDefault("topic", "content");
$dbe->setDefault("page",   PGE::title());
$dbe->setDefault("owner",  CUR_USER);
$dbe->setDefault("link",   $loc);
$dbe->setDefault("rating", 0);

$dbe->hide("topic, tstamp, owner, page, link");

$dbe->findRec("owner='CUR_USER' AND link='$loc' AND topic='content'");
$dbe->show();

?>
