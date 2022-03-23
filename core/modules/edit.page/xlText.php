<?php

$arr = LNG::getAll(); unset($arr[CUR_LANG]);
$act = ENV::getPost("act_xlate");

incCls("menus/dropbox.php");
incCls("menus/qikLink.php");
incCls("editor/xlator.php");

// ***********************************************************
// show options
// ***********************************************************
$box = new dbox();
$trg = $box->getKey("lang.target", $arr);
$xxx = $box->show("table");

$ext = FSO::ext($fil);
$ful = FSO::join($loc, "$trg.$ext");

$dst = basename($trg);
$src = basename($fil);
$chk = STR::before($src, ".");

if (STR::contains($dst, $chk)) {
	return MSG::now("Target ($trg) = Source ($src) ?");
}

// ***********************************************************
// show output
// ***********************************************************
$tpl = new tpl();
$tpl->read("design/templates/editor/viewEdit.tpl");
$tpl->set("file", FSO::clearRoot($fil));

if (is_file($ful)) {
	$qik = new qikLink();
	$ovr = $qik->getVal("opt.overwrite");
	$xxx = $qik->show();

	if (! $ovr) return;
}

// ***********************************************************
// show translation
// ***********************************************************
$dic = new xlator();
$htm = $dic->getTags($fil);

if ($act) {
	$rep = ENV::getPost("content");
	$htm = $dic->getRepText($rep);
	$xxx = $dic->save($ful, $htm, $trg);
	$sec = "code.xl";
	$tpl->set("content", $htm);
}
else {
	$sec = "xdic";
	$tpl->set("content", $htm);
}

$tpl->show($sec);

?>

