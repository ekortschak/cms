<?php

if (! FS_ADMIN) {
	return APP::mod("msgs/stop");
}

DBG::file(__FILE__);

// ***********************************************************
incCls("menus/buttons.php");
// ***********************************************************
$nav = new buttons("tab", "T", __DIR__);

$nav->space();
$nav->add("T", "topics");
$nav->add("S", "topicSort");
$nav->space();
$nav->link("V", HTM::icon("buttons/view.png"), "?vmode=view");
$nav->show();

?>
