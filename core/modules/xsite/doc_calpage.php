<?php

incCls("tables/cal_table.php");

// ***********************************************************
$dat = PGE::get("props_cal.date");

$cal = new cal_table("monList");
$cal->setRange($dat);
$mon = $cal->gc();

// ***********************************************************
// create output
// ***********************************************************

?>

<div class="flex">
<div>
<?php
include "core/modules/body/head/main.php";
include "core/modules/body/main.php";
?>
</div>

<div style="padding-left: 15px;">
<?php
echo $mon;
?>
</div>

</div>
