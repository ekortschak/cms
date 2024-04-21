<?php

DBG::file(__FILE__);

// ***********************************************************
// check if applicable
// ***********************************************************
if (! IS_LOCAL) return; // this excludes SEARCH_BOT as well

$xxx = TMR::total("total");
$arr = TMR::get(); if (! $arr) return;

// ***********************************************************
HTW::xtag("timer", 'div class="h4"');
// ***********************************************************
?>

<ul>

<?php
foreach ($arr as $key => $val) {
	echo "<li>$key: $val</li>";
}
?>

</ul>
