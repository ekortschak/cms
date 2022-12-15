<?php

$fil = TAB_HOME;

// ***********************************************************
// show description
// ***********************************************************
HTM::tag("tpc.desc", "h3");

$txt = APP::gc($fil); if (! $txt)
$txt = DIC::get("tpc.nodesc");

HTM::cap($txt, "div");

?>
