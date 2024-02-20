<?php

DBG::file(__FILE__);

// ***********************************************************
switch (TAB_TYPE) {
	case "dia": APP::mod("toc/diary"); break;
	default:    APP::mod("toc/toc");
}

?>
