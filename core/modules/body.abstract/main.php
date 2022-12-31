<?php

$fil = TAB_HOME;

// ***********************************************************
// show description
// ***********************************************************
HTW::xtag("tpc.desc", "h3");

$txt = APP::gc($fil); if (! $txt)
$txt = DIC::get("tpc.nodesc");

HTW::tag($txt, "div");

?>
