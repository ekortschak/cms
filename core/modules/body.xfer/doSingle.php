<?php

$loc = PFS::getLoc();

$tit = HTM::pgeTitle($loc);
$fil = APP::tempDir("single page", $tit);
$fil.= ".htm";

// ***********************************************************
// preview ?
// ***********************************************************
incCls("menus/qikLink.php");

$qik = new qikLink();
$dbg = $qik->getVal("opt.debug", 1);
#$sav = $qik->getVal("opt.save", 1);
$prv = $qik->gc();

ENV::set("xsite.dbg", $dbg);

// ***********************************************************
// Ask for confirmation
// ***********************************************************
incCls("input/confirm.php");

$cnf = new confirm();
$cnf->set("link", "?dmode=xsite&fil=$fil");
$cnf->head("Merge selected branch into single file!");
$cnf->dic("scope", $tit);
$cnf->add("&rarr; output goes to screen"); // $fil
$cnf->add("<hr>");
$cnf->add($prv);
$cnf->show();

if (! $cnf->act()) return;

// ***********************************************************
// show module xsite
// ***********************************************************
# output handled by the module itself

?>
