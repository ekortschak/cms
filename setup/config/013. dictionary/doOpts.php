<?php

incCls("input/button.php");

$btn = new button();
$btn->set("link", "?act=rewrite");
$btn->set("caption", "ReWrite");
$btn->show();

$act = ENV::getParm("act");

switch($act) {
	case "rewrite": DIC::reWrite(); break;
}

?>
