<?php

DBG::file(__FILE__);

// ***********************************************************
$trg = PGE::get("props_red.trg");

if (SEARCH_BOT) return HTW::link("see:", $trg);
if (! APP::isView()) return;

// ***********************************************************
// show linked content
// ***********************************************************
echo "Redirected content: $trg";

?>
