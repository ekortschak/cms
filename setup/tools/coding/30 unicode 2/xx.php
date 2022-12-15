<ul>
<li><a href="https://graphemica.com/%F0%9F%93%81" target="symbol">Graphemica</a></li>
</ul>

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

echo "<a href='?next=$prv'><button>◂</button></a>";
echo "<a href='?next=$nxt'><button>▸</button></a>";

?>

<br><br>
<div style="font-size: 36pt; text-align: center;">

<?php

for ($i = $fst; $i < $nxt; $i++) {
	echo "<a style='color:black;' href='?next=$i'>&#$i;</a> ";
}

?>
</div>
</div>
