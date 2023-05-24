<?php

incCls("input/qikOption.php");
incCls("input/confirm.php");
incCls("editor/QED.php");

$loc = PGE::$dir;

// ***********************************************************
// show info
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/xsite.tpl");
$tpl->show("info");

// ***********************************************************
// read ini
// ***********************************************************
$ini = new ini($loc);
$pbr = $ini->get(CUR_LANG.".pbreak");

$top = ENV::get("xsite.top", $loc);
$cur = ENV::get("xsite.cur");

$hpb = QED::hasPbr(); // pbreaks inside doc?

// ***********************************************************
// ask for confirmation
// ***********************************************************
$dir = APP::tempDir("single page");
$fil = FSO::join($dir, "$tit.htm");

$dst = DIC::get("output.screen");
$hed = DIC::get("file.merge");
$tit = PGE::getTitle($top);

$cnf = new confirm();
$cnf->set("link", "?dmode=xsite&fil=$fil");
$cnf->head($hed);
$cnf->dic("scope", $tit);
$cnf->add("&rarr; $dst");
$cnf->show();

// ***********************************************************
// show module xsite
// ***********************************************************
# output handled by the module body.xsite itself

// ***********************************************************
// react to quick edit options
// ***********************************************************
if (PGE::isCurrent($cur)) {
	if (ENV::get("opt.starthere")) {
		ENV::set("xsite.top", $loc); $top = $loc;
	}
	elseif ($top == $loc) {
dbg("why here?");
		ENV::set("xsite.top", TAB_HOME); $top = TAB_HOME;
	}

	$pb4 = ENV::get("opt.pbreak"); if ($pb4 != $pbr) {
		$pbr = QED::setPbr($pb4);
	}

	$pbi = ENV::get("opt.inside"); if ($hpb > $pbi) {
		QED::clearPbr();
		$hpb = false;
	}
}

$chk = ($top == $loc);

// ***********************************************************
// offer quick edit options
// ***********************************************************
HTW::xtag("qik.edit");
ENV::set("xsite.cur", $loc);

$qik = new qikOption();
$qik->forget();

$qik->getVal("opt.starthere", $chk);
$qik->getVal("opt.pbreak", $pbr);
$qik->getVal("opt.inside", $hpb);

$qik->show();

// TODO: Add page breaks in doc

?>
