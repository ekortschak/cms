<?php

DBG::file(__FILE__);

// ***********************************************************
switch (VMODE) {
	case "abstract": $tit = PGE::title(TAB_HOME); break;
	default:         $tit = PGE::title();
}

HTW::tag($tit, "div class='h2'");

?>
