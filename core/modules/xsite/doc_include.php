<?php

$lev = PGE::level();

$siz = 25; if ($lev > 1)
$siz = 15; if ($lev > 2)
$siz = 10; if ($lev > 3)
$siz = 7;

#<section style="clear: both; margin-bottom: <?php echo $siz; ? >px;">
?>
<section style="clear: both;">
<?php

PGE::pic();

// ***********************************************************
// create output
// ***********************************************************
include "core/modules/body/head/main.php";
include "core/modules/body/main.php";

?>
</section>
