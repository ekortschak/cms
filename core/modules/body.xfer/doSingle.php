<?php

incCls("input/qikOption.php");
incCls("input/confirm.php");
incCls("editor/QED.php");

// ***********************************************************
// show info
// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/xsite.tpl");
$tpl->show("info");

// ***********************************************************
// read ini
// ***********************************************************
$ini = new ini(CUR_PAGE);
$pbr = $ini->get(CUR_LANG.".pbreak");

$top = ENV::get("xsite.top", CUR_PAGE);
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
if ($cur == CUR_PAGE) {
	if (ENV::get("opt.starthere")) {
		ENV::set("xsite.top", CUR_PAGE); $top = CUR_PAGE;
	}
	elseif ($top == CUR_PAGE) {
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

$chk = ($top == CUR_PAGE);

// ***********************************************************
// offer quick edit options
// ***********************************************************
HTW::xtag("qik.edit");
ENV::set("xsite.cur", CUR_PAGE);

$qik = new qikOption();
$qik->forget();

$qik->getVal("opt.starthere", $chk);
$qik->getVal("opt.pbreak", $pbr);
$qik->getVal("opt.inside", $hpb);

$qik->show();

// TODO: Add page breaks in doc

?>
