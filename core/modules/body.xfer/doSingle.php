<?php

incCls("input/qikOption.php");
incCls("input/confirm.php");

// ***********************************************************
$tit = PGE::getTitle();
$dir = APP::tempDir("single page");
$fil = FSO::join($dir, "$tit.htm");

// ***********************************************************
// preview ?
// ***********************************************************
$qik = new qikOption();
$dbg = $qik->getVal("opt.debug", 1);
$prv = $qik->gc();

ENV::set("xsite.dbg", $dbg);

// ***********************************************************
// show info
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/xsite.tpl");
$tpl->show();

// ***********************************************************
// ask for confirmation
// ***********************************************************
$dst = DIC::get("output.screen");

$cnf = new confirm();
$cnf->set("link", "?dmode=xsite&fil=$fil");
$cnf->head("Merge selected branch into single file!");
$cnf->dic("scope", $tit);
$cnf->add("&rarr; $dst");
$cnf->add("<hr>");
$cnf->add($prv);
$cnf->show();

# if (! $cnf->act()) return;

// ***********************************************************
// show module xsite
// ***********************************************************
# output handled by the module body.xsite itself

?>
