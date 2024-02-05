<?php

DBG::file(__FILE__);

// ***********************************************************
switch (VMODE) {
	case "abstract": $tit = PGE::title(TAB_HOME); break;
	default:         $tit = PGE::title();
}

// ***********************************************************
$tpl = new tpl();
$tpl->load("modules/chapter.tpl");
$tpl->set("title", $tit);
$tpl->show();

?>
