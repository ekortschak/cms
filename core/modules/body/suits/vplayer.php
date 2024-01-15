<?php

DBG::file(__FILE__);

// ***********************************************************
$ipa = PGE::get("props_cam.ip"); if (! $ipa) return;

incCls("files/stream.php");

// ***********************************************************
$stream = new VideoStream($ipa);
$stream->start();

?>
