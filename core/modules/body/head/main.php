<?php

DBG::file(__FILE__);

// ***********************************************************
switch (VMODE) {
	case "abstract": $tit = PGE::title(TAB_HOME); break;
	default:         $tit = PGE::title();
}
$lev = PGE::level();
$lev = CHK::range($lev, 0, 9);

// ***********************************************************
if (VMODE == "xsite") {
	HTW::tag($tit, "h$lev");
	return;
}

// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/chapter.tpl");
$tpl->set("title", $tit);
$tpl->show();

?>
