<?php

#if (STR::contains($fil, "Kap_")) return;

$new = $old = basename($fil);
$new = STR::after($new, "Kap_");
$dst = STR::replace($fil, $old, $new);

echo "<li>$dst";
#rename ($fil, $dst);

?>

