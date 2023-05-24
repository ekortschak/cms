<?php

incCls("menus/dropDate.php");

// ***********************************************************
$box = new dropDate();
$dat = $box->getYmd();
$xxx = $box->show();

// ***********************************************************
$dir = FSO::join(TAB_HOME, $dat);
dbg($dir, "dir");

#$yir = ENV::get("pick.date.year");
#$mon = ENV::get("pick.date.mon");
#$day = substr($dat, 8, 2);

#$old = $yir."_".$mon."_".$day;

#$src = FSO::join(TAB_HOME, $yir, $mon, $old);

#if (is_dir($src))
#FSO::mvDir($src, $dir);



ENV::setPage($dir);

#$yrs = FSO::folders(TAB_HOME);
#$yrs = VEC::sort($yrs, "krsort");
#$yir = $box->getKey("year", $yrs);

#$mns = FSO::folders($yir);
#$mns = VEC::sort($mns, "krsort");
#$mon = $box->getKey("month", $mns);

?>
