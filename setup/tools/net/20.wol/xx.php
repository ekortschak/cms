<?php

if (! IS_LOCAL) return MSG::now("edit.deny");

incCls("input/selector.php");
incCls("input/confirm.php");

// ***********************************************************
$sel = new selector();
// ***********************************************************
$qid = $sel->input("IP", "10.0.0.51");
$mac = $sel->input("MAC", "00:1e:8c:20:0d:c1");
$sel->show();

// ***********************************************************
$cnf = new confirm();
// ***********************************************************
$cnf->add("Wake $qid ($mac)");
$cnf->show();

if (!$cnf->act()) return;

wakeOnLan($mac, $qid);
return;

// ***********************************************************
// functions
// ***********************************************************
function wakeOnLan($mac, $ipa) {
	$msg = str_repeat(chr(255), 6);
	$arr = explode(':', $mac);
	$trg = '';

	if (count($arr) != 6) {
		ERR::msg("net.mac error", $mac);
		return;
	}
	for ($i = 0; $i < 6; $i++) { $trg.= chr(hexdec($arr[$i])); }
	for ($i = 1; $i <= 16; $i++) { $msg.= $trg;	}

	$soc = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
	$opt = socket_set_option($soc, 1, 6, TRUE);
	$snd = socket_sendto($soc, $msg, strlen($msg), 0, $ipa, 2050);
	socket_close($soc);

	if ($snd) return true;
	return ERR::assist("net", "socket", "$ipa &rarr; $mac");
}

?>
