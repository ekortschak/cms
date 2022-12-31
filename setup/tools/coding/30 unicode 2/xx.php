<hr>
<ul>
<li><a href="https://graphemica.com/%F0%9F%93%81" target="symbol">Graphemica</a></li>
</ul>
<hr>

<?php

incCls("input/selector.php");

$cur = ENV::get("next", 128000);

$sel = new selector();
$fst = $sel->number("val.start", $cur);
$sel->show();

$rng = 100;
$prv = $fst - $rng;
$nxt = $fst + $rng;

ENV::set("next", $fst);

HTW::button("?next=$prv", "◂");
HTW::button("?next=$nxt", "▸");

?>

<br><br>
<div style="font-size: 36pt; text-align: center;">

<?php

for ($i = $fst; $i < $nxt; $i++) {
	HTW::href("?next=$i", "&#$i");
}

?>
</div>
</div>
