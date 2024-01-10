<?php

DBG::file(__FILE__);

// ***********************************************************
switch (VMODE) {
	case "abstract": $tit = PGE::title(TAB_HOME); break;
	default:         $tit = PGE::title();
}

HTW::tag($tit, "div class='h2'");

// ***********************************************************
// specific tasks
// ***********************************************************
switch (PGE::type()) {
	case "cha": $inc = "chapters"; break;
	default:    return;
}

APP::inc(__DIR__, "$inc.php");

?>
