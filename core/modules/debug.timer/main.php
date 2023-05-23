<?php

TMR::total("total");

if (! IS_LOCAL) return; $arr = TMR::get();
if (! $arr) return;

?>

<h4>Timer</h4>
<ul>

<?php

foreach ($arr as $key => $val) {
	echo "<li>$key: $val</li>";
}

?>

</ul>
