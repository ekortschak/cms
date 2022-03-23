<?php

if (! DB_CON) return;
if (! ENV::get("opt.feedback")) return;

if (TAB_ROOT == TAB_PATH) return;

$loc = PFS::getLoc();

// ***********************************************************
HTM::tag("Feedback", "h3");
// ***********************************************************
$ini = new ini();
$tit = $ini->getHead();

if (! DB_LOGIN) {
	$tpl = new tpl();
	$tpl->read("design/templates/user/login.tpl");
	$tpl->show();
	return;
}

incCls("dbase/dbQuery.php");
incCls("dbase/recEdit.php");

// ***********************************************************
$dbe = new recEdit(NV, "feedback");
// ***********************************************************
$dbe->findRec("owner='CUR_USER' AND link='$loc' AND topic='content'");
$dbe->setProp("owner",  "fstd", CUR_USER);
$dbe->setProp("topic",  "fstd", "content");
$dbe->setProp("page",   "fstd", $tit);
$dbe->setProp("link",   "fstd", $loc);
$dbe->setProp("rating", "fstd", 0);
$dbe->hide("topic, tstamp, owner, page, link");
$dbe->show();

?>
