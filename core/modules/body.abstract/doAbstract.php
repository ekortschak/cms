<?php

$fil = TAB_HOME;

// ***********************************************************
// show description
// ***********************************************************
$txt = APP::gc($fil); if (! $txt)
$txt = DIC::get("tpc.nodesc");

HTW::tag($txt, "div");

?>
