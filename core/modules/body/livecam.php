<?php

$ini = new ini();
$url = $ini->get("props.ip", "localhost");

if (! $url) {
	return ERR::msg("no.IP");
}

// ***********************************************************
// show page content
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/modules/livecam.tpl");
$tpl->set("url", $url);
$tpl->show();

?>