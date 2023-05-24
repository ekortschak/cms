<?php

incMod("toc/banner.php");
incMod("toc/topics.php");
incMod("toc/current.php");

switch (TAB_TYPE) {
	case "dia": incMod("toc/diary.php"); break;
	default:    incMod("toc/toc.php");
}

incMod("toc/status.php");

?>
