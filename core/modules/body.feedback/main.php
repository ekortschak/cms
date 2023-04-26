<?php

if (! ENV::get("opt.feedback")) return;

incCls("dbase/dbQuery.php");
incCls("dbase/recEdit.php");

// ***********************************************************
HTW::xtag("Feedback", "h3");
// ***********************************************************
$dbe = new recEdit("default", "feedback");

$dbe->setDefault("topic", "content");
$dbe->setDefault("page",   PGE::getTitle());
$dbe->setDefault("owner",  CUR_USER);
$dbe->setDefault("link",   CUR_PAGE);
$dbe->setDefault("rating", 0);

$dbe->hide("topic, tstamp, owner, page, link");

$dbe->findRec("owner='CUR_USER' AND link='CUR_PAGE' AND topic='content'");
$dbe->show();

?>
